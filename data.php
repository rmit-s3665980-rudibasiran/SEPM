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
$recEmail = $psw = $name = $dob = $address = $suburb = $postal = $state = $contact = $card = $cardExpiry = $cvv = $regnDate = "";
$msgEmail = $msgName = "";
$timestamp = "";

$loginType = $email = $name = "";
if (isset($_SESSION['loginType']) )             { $loginType = $_SESSION['loginType']; }       
if (isset($_SESSION['email']) )                 { $email = $_SESSION['email']; }  
if (isset($_SESSION['name']) )                  { $name = $_SESSION['name']; }   

if ($loginType == "login") {

    $timestamp = "";
    $readonly = "readonly";
    $recEmail = $psw = $name = $dob = $address = $suburb = $postal = $state = $contact = $card = $cvv = $regnDate = $recordEnd = "";
    $dob = "";
	$myfile = fopen("data/users.txt", "r") or die("Unable to open file!");

    $proceed = false;
	while(!feof($myfile)) {
		$str = "";
    	$str = fgets($myfile);
		if (substr($str, 0, 1) <> "#")  {
            #Email;Password;Name;Date of Birth;Address;Suburb;Postal;State;Contact;Card Number;Card Expiry;CVV;Registration Date;End-of-Record
            $delimiter = ";;;;;;;;;;;;;";
            list($recEmail, $psw, $name, $dob, $address, $suburb, $postal, $state, $contact, $card, $cardExpiry, $cvv, $regnDate, $recordEnd) = explode(";", $str.$delimiter);
			if ($recEmail == $email) {
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
} else if ($loginType == "new") {
    $readonly = "";
    $regnDate = date("Y-m-d");
    $_SESSION['email'] = "";
    $_SESSION['timestamp'] = "";
}
else {
    $_SESSION['errorMsg'] = "You attempted to go to this page directly";
    header ("Location: error.php"); 
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $actionType = stripInput($_POST["actionType"]);
    
    if ($actionType == "Logout") {
        $_SESSION['email'] = "";
        $_SESSION['name'] = "";
        header ("Location: products.php"); 
        exit;

    }
    else if ($actionType == "GoBackProducts") {
        header ("Location: products.php"); 
        exit;
    }
    else {
        $email = stripInput($_POST["email"]);
        $psw = stripInput($_POST["psw"]);

        $name = stripInput($_POST["name"]);
        $dob = $_POST["dob"];
        $address = stripInput($_POST["address"]);
        $postal = stripInput($_POST["postal"]);
        $suburb = stripInput($_POST["suburb"]);
        $state = stripInput($_POST["state"]);
        $contact = stripInput($_POST["contact"]);

        $cvv = stripInput($_POST["cvv"]);
        $card = stripInput($_POST["card"]);
        $cardExpiry = stripInput($_POST["cardExpiry"]);

        /* validations */
        if (empty($_POST["email"])) {
            $msgEmail = "Please enter an email address";
            $proceed = FALSE;
        } 
        else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $msgEmail = "Invalid email format";
                $proceed = FALSE;
            }
        }

        if (empty($_POST["name"])) {
            $msgName = "Please enter your name";
            $proceed = FALSE;
        } 
        
        if (!empty($_POST["psw"])) {
            $msgPSW = "Please enter password"; 
            $proceed = FALSE;
        }
        

        if ($proceed && $loginType == "new") {
            $readonly = "";
            $regnDate = date("Y-m-d");
            $_SESSION['email'] = "";
            $_SESSION['timestamp'] = "";
            $_SESSION['errorMsg'] = "";  
    
            // do insert
            
            $record = "";
            $record = findUserRecord($psw, $email);
    
            if ($record == "RecordNotFound") {

                if ($proceed) {
                    #Email;Password;Name;Date of Birth;Address;Suburb;Postal;State;Contact;Card Number;Card Expiry; CVV;Registration Date;End-of-Record
                    $myfile = fopen("data/users.txt", "a") or die("Unable to open file!");
                    $txt = "\n".$email .";". md5($psw) .";". $name .";". $dob .";". $address .";". $suburb .";". $postal .";". $state .";". 
                    $contact .";". $card .";". $cardExpiry .";". $cvv .";" . $regnDate . ";EOR";
                    fwrite($myfile, $txt);
                    fclose($myfile);
                    $proceed = true;
                    $timestamp = getTimeStamp();
                    $_SESSION['email'] = $email;
                    $_SESSION['name'] = $name;
                    $_SESSION['loginType'] = "login";
                }
            }
            else if ($record == "RecordFound" || $record == "IncorrectCredentials") {
                $msgEmail = "Email Address [" .$email . "] already exists.";
                $proceed = false;
            }
            else {
                $_SESSION['errorMsg'] = "Unknown error occurred; please try again later.";
                header ("Location: error.php"); 
                exit;
            }
        }
    }
}


?>

<script>
function myFunction() {
    var x = document.getElementById("card");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }


    var x = document.getElementById("cvv");
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
            <h1 style="font-family: Arial; color: Red;font-size: 12px;"><b><?php echo $msgEmail; ?></b></h1>
    
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="name"><b>Name</b></label>
            <input type="text" name="name" value="<?php echo $name; ?>">
            <h1 style="font-family: Arial; color: Red;font-size: 12px;"><b><?php echo $msgName; ?></b></h1>

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

            <label style="font-family: Arial; color: Black;font-size: 12px;" for="regnDate"><b>Registration Date</b></label>
            <input type="date" name="regnDate" value="<?php echo $regnDate; ?>"   readonly >
            
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="psw"><b>Credit Card</label>
            <input type="password" name="card" id="card" value="<?php echo $card; ?>" >

            <label style="font-family: Arial; color: Black;font-size: 12px;" for="cvv"><b>CVV</label>
            <input type="password" name="cvv" id="cvv" value="<?php echo $cvv; ?>"  >

            <label style="font-family: Arial; color: Black;font-size: 12px;" for="cardExpiry"><b>Expiry Date</b></label>
            <input type="date" name="cardExpiry" value="<?php echo $cardExpiry; ?>"  >

            <label style="font-family: Arial; color: Black;font-size: 12px;" for="psw"><b>Password</label>
            <input type="password" name="psw" id="psw" value="<?php echo $psw; ?>"  <?php echo $readonly; ?> >
            <h1 style="font-family: Arial; color: Red;font-size: 12px;"><b><?php echo $msgPSW; ?></b></h1>
            
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="showCard"><b>Show Credit Card Information</b></label>
            <input type="checkbox" name = "showCard" onclick="myFunction()">
      
            <h2 style="font-family: Arial; color: White;"></h2>
            <input type="hidden" id="actionType" name="actionType" value="saveData">
            <button type="submit" class="btn" >Save</button>
        </div>
    </form>
    
</div>
</td>



<td>
<div class="bg-img">
    <div class="container2">
        <a href="index.php"><img src="images/palmtechlogo.png"></a>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" id="actionType" name="actionType" value="GoBackProducts">
        <button type="submit" class="btn" >Back to Product Listing</button>
        </form>
        <br>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" id="actionType" name="actionType" value="Logout">
        <button type="submit" class="btn" >Logout</button>
        </form>

         </div>
</div>
</td>

<tr>
</table>

</body>
</html>

