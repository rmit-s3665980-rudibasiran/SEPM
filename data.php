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
input[type=text], input[type=password], input[type=date] {
    width: 100%;
    padding: 15px;
    margin: 5px 0 22px 0;
    border: none;
    background: #f1f1f1;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
}

input[type=text]:focus, input[type=password]:focus, input[type=date]:focus {
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

$proceed = false;
$recEmail = $psw = $name = $date_of_birth = $address = $suburb = $postal = $state = $contact = $card = $cvv = "";
$timestamp = "";

$loginType = stripInput($_SESSION["loginType"]); 
$email = stripInput($_SESSION["email"]);
$name = stripInput($_SESSION["name"]);
$timestamp = stripInput($_SESSION["timestamp"]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $email = stripInput($_POST["email"]);
    $name = stripInput($_POST["name"]);
    $dob = $_POST["dob"];
    $address = stripInput($_POST["address"]);
    $postal = stripInput($_POST["postal"]);
    $suburb = stripInput($_POST["suburb"]);
    $state = stripInput($_POST["state"]);
    $contact = stripInput($_POST["contact"]);
    $psw = stripInput($_POST["psw"]);
    
    if ($loginType == "new") {
        $readonly = "";
        $_SESSION['email'] = "";
        $_SESSION['timestamp'] = "";
        $_SESSION['errorMsg'] = $sql;  

        // do insert
        $record = findUserRecord($psw, $email);
        if ($record = "RecordNotFound") {
            $myfile = fopen("user.txt", "a") or die("Unable to open file!");
            $txt = $email .";". $name .";". $dob .";". $address .";". $postal .";". $suburb .";". $state .";". $contact .";". $psw .";";
            fwrite($myfile, $txt);
            fclose($myfile);
            $proceed = true;
            $timestamp = getTimeStamp();
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $name;
        }
        else {
            $proceed = false;
        }
        if ($proceed) {
            $_SESSION['errorMsg'] = "Email Address [" .$email . "] already exists.";
            header ("Location: error.php"); 
            exit;
        }
    }
    else if ($loginType = "login") {
        
        // do update
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
        $_SESSION['errorMsg'] = "Update Error";
        $proceed = TRUE;
    }
    
}

if ($loginType == "login") {

    $timestamp = "";
    $readonly = "readonly";
    $recEmail = $psw = $name = $date_of_birth = $address = $suburb = $postal = $state = $contact = $card = $cvv = "";
    $dob = "";
	$myfile = fopen("user.txt", "r") or die("Unable to open file!");

    $proceed = false;
	while(!feof($myfile)) {
		$str = "";
    	$str = fgets($myfile);
		if (substr($str, 0, 1) <> "#")  {
			list($recEmail, $psw, $name, $date_of_birth, $address, $suburb, $postal, $state, $contact, $card, $cvv) = explode(";", $str.";;;;;;;;;;");
			if ($recEmail == $email) {
                $dob = $date_of_birth;
                $proceed = true;
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $name;
                break;
            }
        }
    }
    fclose($myfile);

    if (!$proceed) {
        $_SESSION['errorMsg'] = "Data not found for " . $email . ".";
        header ("Location: error.php"); 
        exit;
    }
}
else if ($loginType == "new") {
    $readonly = "";
    $_SESSION['email'] = "";
    $_SESSION['timestamp'] = "";
}
else {
    $_SESSION['errorMsg'] = "Error 404";
    header ("Location: error.php"); 
    exit;
}

?>

<script>
function myFunction() {
    var x = document.getElementById("myPSW");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>

<table>
<tr>

<td>

<div class="bg-img">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="container">
            <h2 style="font-family: Arial; color: Black;font-size: 20px;">MEMBER DETAILS</h2>
            <h2 style="font-family: Arial; color: Black;font-size: 10px;"><?php echo $timestamp; ?> </h2>

            <label style="font-family: Arial; color: Black;font-size: 12px;" for="email"><b>Email</b></label>
            <input type="text" name="email" value="<?php echo $email; ?>"  <?php echo $readonly; ?> >
    
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="name"><b>Name</b></label>
            <input type="text" name="name" value="<?php echo $name; ?>">

            <label style="font-family: Arial; color: Black;font-size: 12px;" for="dob"><b>Date of Birth</b></label>
            <input type="date" name="dob" value="<?php echo $dob; ?>">

            <label style="font-family: Arial; color: Black;font-size: 12px;" for="address"><b>Address</b></label>
            <input type="text" name="address" value="<?php echo $address; ?>">            
            
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="suburb"><b>Suburb</b></label>
            <input type="text" name="suburb" value="<?php echo $suburb; ?>">

            <label style="font-family: Arial; color: Black;font-size: 12px;" for="postal"><b>Postal Code</b></label>
            <input type="text" name="postal" value="<?php echo $postal; ?>">
            
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="state"><b>State</b></label>
            <input type="text" name="state" value="<?php echo $state; ?>">
            
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="contact"><b>Contact Number</b></label>
            <input type="text" name="contact" value="<?php echo $contact; ?>">
            
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="psw"><b>Password</label>
            <input type="password" name="psw" id="myPSW" value="<?php echo $psw; ?>" <?php echo $readonly; ?> >
            
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="show_psw"><b>Show Password</b></label>
            <input type="checkbox" name = "show_psw" onclick="myFunction()">
      
            <h2 style="font-family: Arial; color: White;"></h2>
            <button type="submit" class="btn" >Save</button>
        </div>
    </form>
    
</div>
</td>



<td>
<div class="bg-img">
    <div class="container2">
        <a href="index.php"><img src="images/palmtechlogo.png"></a>
        <a href="product_listing.php"><button class="btn">Back to Product Listing</button></a>
    </div>
</div>
</td>

<tr>
</table>

</body>
</html>

