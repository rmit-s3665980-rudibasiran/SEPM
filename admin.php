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

* {
    box-sizing: border-box;
}

.bg-img {
    /* The image used */
    background-image: url("images/background.png");

    min-height: 380px; 

    /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    background-size: 100% 100%;
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

.container2 {
    position: absolute;
    left: 0;
    margin: 20px;
    max-width: 300px;
    padding: 16px;
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

include 'inc/lib.php';


$msg = $adminEmail = $psw = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $msg = "";
    $proceed = TRUE;
    
    $adminLoginType = $_POST["adminLoginType"];
    
    if ($adminLoginType == "login") {

        if (empty($_POST["adminEmail"])) {
            $msg = "Please enter an email address";
            $proceed = FALSE;
        } 
        else {
            $adminEmail = stripInput($_POST["adminEmail"]);
            if (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
                $msg = "Invalid email format";
                $proceed = FALSE;
            }
        }
        
        if ($proceed) {
            if (!empty($_POST["psw"])) {
                $psw =  stripInput($_POST["psw"]);
            }
            else {
                $msg = "Please enter password"; 
                $proceed = FALSE;
            }
        }
   
        if($proceed) {

            $record = "";
            $record = findAdminRecord($psw, $adminEmail);
       
            if ($adminLoginType == "login") {
                if ($record == "RecordNotFound") {
                    $msg = "Record not found for " . $adminEmail; 
                
                }
                else if ($record == "IncorrectCredentials") {
                    $msg = "Incorrect credentials for " . $adminEmail; 
                }
                else if ($record == "PasswordCorrect") {
                    $_SESSION['adminLoginType'] = $adminLoginType;
                    $_SESSION['adminEmail'] = $adminEmail;
                    $_SESSION['timestamp'] = "";
           
                    header ("Location: admindata.php"); 
                    exit;
                
                }
            }
        }
    }
}

?>

<table>
<tr>

<td>
<div class="bg-img">
    <div class="container2">
        <a href="index.php"><img src="images/palmtechlogo.png"></a>
    </div>
</div>
</td>

<td>


<div class="bg-img">
    <div class="container">
    
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
       
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="adminEmail"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="adminEmail" value="<?php echo $adminEmail; ?>">

            <label style="font-family: Arial; color: Black;font-size: 12px;" for="psw"><b>Password</label>
            <input type="password" placeholder="Enter Password" name="psw" value="<?php echo $psw; ?>">
            <input type="hidden" id="adminLoginType" name="adminLoginType" value="login">
            <button type="submit" name ="submit" value="login" class="btn">Login</button>
            
        </form>
        
       <h1 style="font-family: Arial; color: Red;font-size: 12px;"><b> </b></h1>
        
        <h1 style="font-family: Arial; color: Red;font-size: 12px;"><b><?php echo $msg; ?></b></h1>
    </div>
</div>
</td>

</tr>
</table>
