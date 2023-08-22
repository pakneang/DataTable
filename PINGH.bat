REM Enter the PHP folder first by using 'CD' command to make absulute path inside php file working

REM Modify the path of PHPing and php folder location if not same with your environment

@echo off
CD /D "C:\xampp\htdocs\DataTable\"
"C:\xampp\php\php.exe" -f ping.php
