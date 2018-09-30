<?php
session_start();
include 'inc/lib.php';
include 'inc/head.php';

$proceed = false;
$recEmail = $psw = $name = $dob = $address = $suburb = $postal = $state = $contact = $card = $cardExpiry = $cvv = $regnDate = "";
$msgEmail = $msgName = $msgDOB = $msgAddr = $msgSuburb = $msgPostal = $msgState = $msgContact = $msgCard = $msgCVV = $msgExpiry = $msgPSW = "";
$timestamp = "";
$successfulRegistration = "";
$loginType = $email = $name = "";
if (isset($_SESSION['loginType']) )                 { $loginType = $_SESSION['loginType']; }       
if (isset($_SESSION['email']) )                     { $email = $_SESSION['email']; }  
if (isset($_SESSION['name']) )                      { $name = $_SESSION['name']; }   
if (isset($_SESSION['successfulRegistration']) )    { $successfulRegistration = $_SESSION['successfulRegistration']; }       

if ($loginType == "login") {

    $timestamp = "";
    $readonly = "readonly";
    $recEmail = $psw = $name = $dob = $address = $suburb = $postal = $state = $contact = $card = $cvv = $regnDate = $recordEnd = "";
    
    $proceed = false;

	$myfile = fopen("data/users.txt", "r") or die("Unable to open file!");
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
    $timestamp = "";
    if (isset($_SESSION['timestamp']) )                 { $timestamp = $_SESSION['timestamp']; } 
    $actionType = stripInput($_POST["actionType"]);
    $_SESSION['successfulRegistration'] = "";
    
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
        $proceed = true;
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
        $regnDate = stripInput($_POST["regnDate"]);
        $card = stripInput($_POST["card"]);
        $cardExpiry = stripInput($_POST["cardExpiry"]);

        /* validations | start */
        if (empty($_POST["email"])) {
            $msgEmail = "Please enter an email address";
            $proceed = FALSE;
        } 
        else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $msgEmail = "Invalid email format";
                $proceed = FALSE;
            }
            else if ($loginType == "new") {
                $record = "";
                $record = findUserRecord($psw, $email);
                if ($record == "RecordFound" || $record == "IncorrectCredentials") {
                    $msgEmail = "Email Address [" .$email . "] already exists.";
                    $proceed = false;
                }
            }
        }

        if (empty($_POST["name"])) {
            $msgName = "Please enter your name";
            $proceed = FALSE;
        } 

        if (empty($_POST["dob"])) {
            $msgDOB = "Please enter your date of birth";
            $proceed = FALSE;
        } 

        if (empty($_POST["address"])) {
            $msgAddr = "Please enter your address";
            $proceed = FALSE;
        } 
        
        if (empty($_POST["postal"])) {
            $msgPostal = "Please enter your postal code";
            $proceed = FALSE;
        } 

        if (empty($_POST["suburb"])) {
            $msgSuburb = "Please enter your suburb";
            $proceed = FALSE;
        } 

        if (empty($_POST["state"])) {
            $msgState = "Please enter your state";
            $proceed = FALSE;
        } 

        if (empty($_POST["contact"])) {
            $msgContact = "Please enter your contact number";
            $proceed = FALSE;
        } 

        if (empty($_POST["card"])) {
            $msgCard = "Please enter your credit card number";
            $proceed = FALSE;
        } 

        if (empty($_POST["cvv"])) {
            $msgCVV = "Please enter your credit card CVV";
            $proceed = FALSE;
        } 

        if (empty($_POST["cardExpiry"])) {
            $msgExpiry = "Please enter your credit card expiry date";
            $proceed = FALSE;
        } 
        
        if (empty($_POST["psw"])) {
            $msgPSW = "Please enter password"; 
            $proceed = FALSE;
        }
         /* validations | end */

        if ($proceed && $loginType == "login") {

            // do update
            $txt = $email .";". md5($psw) .";". $name .";". $dob .";". $address .";". $suburb .";". $postal .";". $state .";". 
                        $contact .";". $card .";". $cardExpiry .";". $cvv .";" . $regnDate . ";EOR";
            updateUserRecord ($email, $txt);
            $_SESSION['timestamp'] = getTimeStamp();
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $name;
            $_SESSION['loginType'] = "login";
            $_SESSION['successfulRegistration'] = "";

        } else if ($proceed && $loginType == "new") {
            $readonly = "";
            $regnDate = date("Y-m-d");
            $_SESSION['email'] = "";
            $_SESSION['timestamp'] = "";
            $_SESSION['errorMsg'] = "";  
    
            // do insert
    
            if ($record == "RecordNotFound") {

                if ($proceed) {
                    $txt = $email .";". md5($psw) .";". $name .";". $dob .";". $address .";". $suburb .";". $postal .";". $state .";". 
                        $contact .";". $card .";". $cardExpiry .";". $cvv .";" . $regnDate . ";EOR";
                    writeNewUserRecord($txt);
                    $timestamp = getTimeStamp();
                    $_SESSION['timestamp'] = getTimeStamp();
                    $_SESSION['email'] = $email;
                    $_SESSION['name'] = $name;
                    $_SESSION['loginType'] = "login";
                    $_SESSION['successfulRegistration'] = "Registration Successful!";
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

<header>
    <div class="container h-100">
        <div class="top row h-100 justify-content-between align-items-center">
            <div class="col text-center">
                <a href="index.php">
                    <img src="images/logo.svg" id="logo" width="50px" height= "50px" />
                </a>
            </div>    
        </div>
    </div>
</header>

<section id="title" class="products navcat b-primary p10t p10b">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col">
                <h4 class="heading">
                    Register as Our Member
                </h4>
            </div>
        </div>
    </div>
</section>

<section id="register" class="form m50t m50b">
    <div class="container">
        <div class="row justify-content-left align-items-center">

            <form method="post" class="col-12" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <h2><?php echo $timestamp; ?> </h2>

                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email*</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="email" value="<?php echo $email; ?>"  <?php echo $readonly; ?> >
                        <p class="error"><?php echo $msgEmail; ?></p>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Name*</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="name" value="<?php echo $name; ?>">
                        <p class="error"><?php echo $msgName; ?></p>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="dob" class="col-sm-2 col-form-label">Date of Birth*</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="date" name="dob" value="<?php echo $dob; ?>">
                        <p class="error"><?php echo $msgDOB; ?></p>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label">Address*</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="address" value="<?php echo $address; ?>">
                        <p class="error"><?php echo $msgAddr; ?></p>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="suburb" class="col-sm-2 col-form-label">Suburb*</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="suburb" value="<?php echo $suburb; ?>">
                        <p class="error"><?php echo $msgSuburb; ?></p>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="postal" class="col-sm-2 col-form-label">Postal Code*</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="postal" value="<?php echo $postal; ?>">
                        <p class="error"><?php echo $msgPostal; ?></p>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="state" class="col-sm-2 col-form-label">State*</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="state" value="<?php echo $state; ?>">
                        <p class="error"><?php echo $msgState; ?></p>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="contact" class="col-sm-2 col-form-label">Contact Number*</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="contact" value="<?php echo $contact; ?>">
                        <p class="error"><?php echo $msgContact; ?></p>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="regnDate" class="col-sm-2 col-form-label">Registration Date</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="date" name="regnDate" value="<?php echo $regnDate; ?>"   readonly >
                    </div>
                </div>

                <div class="form-group row">
                    <label for="psw" class="col-sm-2 col-form-label">Credit Card</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="password" name="card" id="card" value="<?php echo $card; ?>" >
                        <p class="error"><?php echo $msgCard; ?></p>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="cvv" class="col-sm-2 col-form-label">CVV*</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="password" name="cvv" id="cvv" value="<?php echo $cvv; ?>"  >
                        <p class="error"><?php echo $msgCVV; ?></p>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="cardExpiry" class="col-sm-2 col-form-label">Expiry Date*</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="cardExpiry" value="<?php echo $cardExpiry; ?>"  >
                        <p class="error"><?php echo $msgExpiry; ?></p>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="psw" class="col-sm-2 col-form-label">Password*</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="psw" id="psw" value="<?php echo $psw; ?>"  <?php echo $readonly; ?> >
                        <p class="error"><?php echo $msgPSW; ?></p>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="showCard" class="col-sm-2 col-form-label">Show Credit Card Information</label>
                    <div class="col-sm-10">
                        <input type="checkbox" class="form-control" name = "showCard" onclick="myFunction()">
                    </div>
                </div>
            </form>
        </div>
        <div class="row justify-content-left align-items-center">

            <h2 style="font-family: Arial; color: White;"></h2>
            <div class="col-12 col-md-3">
                <input type="hidden" id="actionType" name="actionType" value="saveData">
                <button type="submit" class="ahref solid primary" >Save Details</button>
            </div>

            <div class="col-12 col-md-9 d-flex justify-content-end">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" style="margin-right: 5px;">
                    <input type="hidden" class="form-control" id="actionType" name="actionType" value="GoBackProducts">
                    <button type="submit" class="ahref solid dark" >Back to Product Listing</button>
                </form>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"   
                <?php if($loginType <> "login") {?> style="display:none;" <?php } ?>>
                    <input type="hidden" id="actionType" name="actionType" value="Logout">
                    <button type="submit" class="ahref solid dark" >Logout</button>
                </form>
            </div>
        </div>
        <div class="row justify-content-left align-items-center">
            <h4 class="success">
                <?php echo $successfulRegistration ?>
            </h4>
        </div>
    </div>
</section>



</body>
</html>
