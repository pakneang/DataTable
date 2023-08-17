<html lang="en">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div id="statusModal">
        <input type="date" name="startDate" class="startDate" id="startDate" />
        <input type="date" name="endDate" class="endDate" id="endDate" />
        <select name="status" class="status" id="status">
            <option>Draft</option>
            <option>Unpublish</option>
            <option>Publish</option>
        </select>
        <br /><br />
        <button type="button" class="alertbox" id="alertbox" name="alertbox">alertbox</button>
        <br /><br />
        <div id="result"></div>
    </div>
    </form>


<script>
    $(document).ready(function() {

        load_status();

        $('#alertbox').click(function() {
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            if (startDate != '' && endDate != '') {
                $.ajax({
                    url: "testcontroller/fetch_dat",
                    method: "POST",
                    data: {
                        startDate: startDate,
                        endDate: endDate
                    },
                    success: function(data) {
                        $('#result').html(data)
                    }
                })
            } else {
                alert("Please enter a date");
            }
        })

        function load_status(status) {
            $.ajax({
                url: "testcontroller/fetch_stat",
                method: "POST",
                data: {
                    status: status
                },
                success: function(data) {
                    $('#result').html(data)
                }
            })
        }

        $('#status').click(function() {
            var search = $(this).val();
            if (search != '') {
                load_status(search);
            } else {
                load_status();
            }
        })
    })
</script>
</body>

</html>