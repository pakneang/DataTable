const ctx = document.getElementById('myChart').getContext('2d');

const cache = new Map();
let width = null;
let height = null;

/*** Gradient ***/
const gradient1 = [
    {percent: '0', value: 'rgba(255, 99, 132,1)'},
    {percent: '1', value: 'rgba(25,14,250,0.5)'}
]
const gradient2 = [
    {percent: 0.04, value: 'rgba(225, 181, 89,1)'},
    {percent: 0.93, value: 'rgba(63, 251, 220,1)'}
];
const gradient3 = [
    {percent: '0', value: 'rgba(34,193,195,1)'},
    {percent: '0.8', value: 'rgba(205,188,78,1)'},
    {percent: '1', value:  'rgba(253,187,45,1)'}
];

let colorsList = [gradient1, gradient3, gradient2];
/*************/

function getGradiantColor(context, colors) {
    const chartArea = context.chart.chartArea;
    if (!chartArea) {
        // This case happens on initial chart load
        return;
    }

    const chartWidth = chartArea.right - chartArea.left;
    const chartHeight = chartArea.bottom - chartArea.top;
    if (width !== chartWidth || height !== chartHeight) {
        cache.clear();
    }

    var colorTemp = "";
    colors.forEach(function(color){ colorTemp = colorTemp + color.value});
    let gradient = cache.get(colorTemp);
    if (!gradient) {
        // Create the gradient because this is either the first render
        // or the size of the chart has changed
        width = chartWidth;
        height = chartHeight;
        const centerX = (chartArea.left + chartArea.right) / 2;
        const centerY = (chartArea.top + chartArea.bottom) / 2;
        const r = Math.min(
            (chartArea.right - chartArea.left) / 2,
            (chartArea.bottom - chartArea.top) / 2
        );
        const ctx = context.chart.ctx;
        gradient = ctx.createRadialGradient(centerX, centerY, 0, centerX, centerY, r);
        colors.forEach( function(color, index) {
            gradient.addColorStop(color.percent, color.value);
        });
        cache.set(colorTemp, gradient);
    }
    return gradient

}
// counter plugin block
const counter = {
    id: 'counter',
    beforeDraw( chart, args, options ) {
        const { ctx, chartArea: { top, right, bottom, left, width, height}} = chart;
        const textheight = width / 13;
        ctx.save();
        ctx.fillStyle ='rgb(255, 193, 7)';
        ctx.font = textheight+'px Arial';
        ctx.textAlign = 'center'
        ctx.fillText('1 OZTG = 1.57$', width/2, top + (height/2) + textheight/2);
    }
}

//data
const data = {
    labels: ['Plank Price','Potential Plank Price Growth ', 'Variable Part'],
    datasets: [{
        label: ' Amount in $ on every OZTG coin',
        data: [0.137, (0.199-0.137), (1.57-0.199)],
        borderWidth: 3,
        cutout: '60%',
    }]
};
//config
const config = {
    type: 'doughnut',
    data,
    options: {
        plugins: {
            legend: {
                display: false
            },
            datalabels: {
                align: 'center',
                color: ['#FFCE56', 'black', 'black'],
                borderColor: ['#FFCE56', 'black', 'black'],
                borderWidth: 2,
                borderRadius: 4,
                font: {
                    weight: 'bolder'
                },
                formatter: function(value, context ){
                    const dataPoint = context.chart.data.datasets[0].data;
                    function totalSum(total, datapoint) {
                        return total + datapoint;
                    }
                    const totalValue = dataPoint.reduce(totalSum, 0);
                    const percentageValue = (value*100/totalValue).toFixed(1);
                    const display = [`${value} $`, `${percentageValue} %`]
                    return display;
                }
            }
        },
        elements: {
            arc:{
                backgroundColor:
                    function(context) {
                        // fox each element in Data, this array is listed
                        let grd = colorsList[context.dataIndex];
                        return getGradiantColor(context, grd );}
            }
        }
    },
    plugins: [counter, ChartDataLabels]
};
//render init
const myChart = new Chart(ctx,
    config,
);
