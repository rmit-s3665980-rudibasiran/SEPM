<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Palm Tech</title>
<style>
body, html {
    height: 100%;
    font-family: Arial, Helvetica, sans-serif;
    background-image: url("images/background.png");
}

#error {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    font-size: 12px;
    width: 90%;
    
}

#error td, #error th {
    border: 1px solid #ddd;
    padding: 8px;
    color: white;
}

</style>
</head>
<body>
    
<?php
setlocale(LC_MONETARY,"en_AU");
// error_reporting(0);
session_start();
include 'inc/lib.php';
include 'inc/head.php';
include 'inc/header.php';


$msg = "";
$debugMode = TRUE;
if ($debugMode) {
    $msg = $_SESSION["errorMsg"];  
}

?>


<table id="error" align="center">
<tr><td>

<h2 style="font-family: Arial; color: Black;font-size: 12px;color:white;"><b>Sorry! An error occurred somewhere.</b></h2>
<h2 style="font-family: Arial; color: Black;font-size: 10px;color:white;"><?php echo $msg; ?></h2>
</td></tr>
</table>

</body>
</html>

