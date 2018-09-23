<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Palm Tech</title>
<style>
body, html {
    height: 100%;
    font-family: Arial, Helvetica, sans-serif;
}

* {
    box-sizing: border-box;
}

.bg-img {
    /* The image used */
    background-image: url("images/abc.jpg");

    min-height: 380px;

    /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    box-shadow: 5px 5px 5px grey;
}

/* Add styles to the form container */
.container {
    position: absolute;
    right: 0;
    margin: 20px;
    max-width: 300px;
    padding: 16px;
    background-color: white;
}

/* Full-width input fields */
input[type=text], input[type=password] {
    width: 100%;
    padding: 15px;
    margin: 5px 0 22px 0;
    border: none;
    background: #f1f1f1;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
}

input[type=text]:focus, input[type=password]:focus {
    background-color: #ddd;
    outline: none;
}

/* Set a style for the submit button */
.btn {
    background-color: black;
    color: white;
    padding: 16px 20px;
    border: none;
    cursor: pointer;
    width: 100%;
    opacity: 1;
    font-family: Arial, Helvetica, sans-serif;
}

.btn:hover {
    opacity: 0.7;
}
</style>
</head>
<body>
    
<?php
session_start();

$msg = "";
$debugMode = TRUE;
if ($debugMode) {
    $msg = $_SESSION["errorMsg"];  
}

?>

<h1 style="font-family: Arial; Color: Coral; text-shadow: 2px 2px 4px #000000;">Palm Tech</h1>

<div class="bg-img">
    <div class="container">
        <h2 style="font-family: Arial; color: Black;font-size: 12px;"><b>Sorry! An error occurred somewhere.</b></h2>
        <h2 style="font-family: Arial; color: Black;font-size: 10px;"><?php echo $msg; ?></h2>
        
        
    </div>
</div>


</body>
</html>

