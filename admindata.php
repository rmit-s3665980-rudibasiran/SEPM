<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Palm Tech</title>

<div class="container h-100">
    <div class="top row h-100 justify-content-between align-items-center">
        <div class="left col">
        <a href="index.php">
            <img src="images/logo.svg" id="logo" width="50px" height= "50px" />
        </a>
        </div>
    </div>
</div>


<?php
session_start();
include 'inc/lib.php';
$adminLoginType = $adminEmail = $errorMsg = "";

if (isset($_SESSION['adminLoginType']) )              { $adminLoginType = $_SESSION['adminLoginType']; }     
if (isset($_SESSION['adminEmail']) )                  { $adminEmail = $_SESSION['adminEmail']; }     

if ($adminLoginType == "adminLogin" && $adminEmail <> "") {
    $recEmail = $recPSW = $name = $dateOfBirth = $address = $suburb = $postal = $state = $contact = $card = $cardExpiry = $cvv = $regnDate = $recordEnd = "";
	$myfile = fopen("data/users.txt", "r") or die("Unable to open file!");

    $dates = array("2000-12-31");
    $count = -1;
	while(!feof($myfile)) {
		$str = "";
    	$str = fgets($myfile);
		if (substr($str, 0, 1) <> "#")  {
			$delimiter = ";;;;;;;;;;;;;";
            list($recEmail, $recPSW, $name, $dob, $address, $suburb, $postal, $state, $contact, $card, $cardExpiry, $cvv, $regnDate, $recordEnd) = explode(";", $str.$delimiter);
     
            $dateExists = false;
            if ($count >= 0) {
                $clength = count($dates);
                for($x = 0; $x < $clength; $x++) {
                    if ($dates[$x] == $regnDate) {
                        $dateExists = true;
                    }
                }
            }
            if (!$dateExists) {
                $count++;
                $dates[$count] = $regnDate;
            }
        }
            
	}
	fclose($myfile);
    sort($dates);

   
    $clength = count($dates);
    for($x = 0; $x < $clength; $x++) {
        echo "<br>".$dates[$x];
        $myfile = fopen("data/users.txt", "r") or die("Unable to open file!");
        while(!feof($myfile)) {
            $str = "";
            $str = fgets($myfile);
            if (substr($str, 0, 1) <> "#")  {
                $delimiter = ";;;;;;;;;;;;;";
                list($recEmail, $recPSW, $name, $dob, $address, $suburb, $postal, $state, $contact, $card, $cardExpiry, $cvv, $regnDate, $recordEnd) = explode(";", $str.$delimiter);
                if ($dates[$x] == $regnDate) {
                    echo "<br>" . $name;
                }
            }
        }
        fclose($myfile);
        echo "<br>";
    }
}
else {
    $_SESSION['errorMsg'] = "You attempted to go to this page directly";
    header ("Location: error.php"); 
    exit;
}

?>


