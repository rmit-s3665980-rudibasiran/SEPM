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

$msg = $email = $psw = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $msg = "";
    $proceed = TRUE;
    
    $loginType = $_POST["loginType"];
    
    if ($loginType == "new") {
        $_SESSION['loginType'] = $loginType;
        $_SESSION['email'] = "";
        $_SESSION['timestamp'] = "";
        header ("Location: data.php"); 
        exit;
    }
    else if ($loginType == "login") {

        if (empty($_POST["email"])) {
            $msg = "Please enter an email address";
            $proceed = FALSE;
        } 
        else {
            $email = stripInput($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
            $record = findUserRecord($psw, $email);
       
            if ($loginType == "login") {
                if ($record == "RecordNotFound") {
                    $msg = "Record not found for " . $email; 
                
                }
                else if ($record == "IncorrectCredentials") {
                    $msg = "Incorrect credentials for " . $email; 
                }
                else if ($record == "PasswordCorrect") {
                    $_SESSION['loginType'] = $loginType;
                    $_SESSION['email'] = $email;
                    $_SESSION['timestamp'] = "";
           
                    header ("Location: data.php"); 
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
       
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" value="<?php echo $email; ?>">

            <label style="font-family: Arial; color: Black;font-size: 12px;" for="psw"><b>Password</label>
            <input type="password" placeholder="Enter Password" name="psw" value="<?php echo $psw; ?>">
            <input type="hidden" id="loginType" name="loginType" value="login">
            <button type="submit" name ="submit" value="login" class="btn">Login</button>
            
        </form>
        
       <h1 style="font-family: Arial; color: Red;font-size: 12px;"><b> </b></h1>
       
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" id="loginType" name="loginType" value="new">
            <button type="submit" name ="register" value="register" class="btn">Register</button>
        </form>
        
        <h1 style="font-family: Arial; color: Red;font-size: 12px;"><b><?php echo $msg; ?></b></h1>
    </div>
</div>
</td>

</tr>
</table>
