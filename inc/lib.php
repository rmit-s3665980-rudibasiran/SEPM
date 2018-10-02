<?php

function stripInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
}

function getTimeStamp() {
    $x = "Last Saved : " . date("D j M Y G:i T");
  	return $x;
}


function slugify ($string) {
	$string = utf8_encode($string);
	$string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);   
	$string = preg_replace('/[^a-z0-9- ]/i', '', $string);
	$string = str_replace(' ', '-', $string);
	$string = trim($string, '-');
	$string = strtolower($string);
  
	if (empty($string)) {
	  	return 'n-a';
	}
  
	  	return $string;
}

function getFloatFromString($string) {
			return (float) preg_replace('/[^0-9.]/', '', $string);
}

function  calcCart ($data) {
	$str = $category = $code = $name = $image = $desc = $price = "";
	$myfile = fopen("data/products.txt", "r") or die("Unable to open file!");
	$total = 0;
	while(!feof($myfile)) {
    	$str = "";
    	$str = fgets($myfile);
    	if (substr($str, 0, 1) <> "#")  {
        	list($category, $code, $brand, $name, $image, $desc, $price) = explode(";", $str.";;;;;");
        	if ($name <> "") {
            	foreach($data as $productCode=>$numOrdered) {
                	if ($code == $productCode) {
                    	$total = $total + ($price * $numOrdered);
               		}
           		}
        	}
		}
	}
	
	return $total;
}

function  printCart ($data) {
	echo "Contents of Cart | Start: <br>";
	foreach($data as $productCode=>$numOrdered) {
		echo $productCode . "==>" .$numOrdered ."<br>";
	}
	echo "Contents of Cart | End<br>";
}

function countCart ($data) {
	$str = $category = $code = $name = $image = $desc = $price = "";
	$myfile = fopen("data/products.txt", "r") or die("Unable to open file!");
	$count = 0;
	while(!feof($myfile)) {
    	$str = "";
    	$str = fgets($myfile);
    	if (substr($str, 0, 1) <> "#")  {
        	list($category, $code, $brand, $name, $image, $desc, $price) = explode(";", $str.";;;;;");
        	if ($name <> "") {
            	foreach($data as $productCode=>$numOrdered) {
                	if ($code == $productCode) {
                    	$count++;
               		}
           		}
        	}
		}
	}
	
	return $count;
}

function writeNewUserRecord($data) {

	#Email;Password;Name;Date of Birth;Address;Suburb;Postal;State;Contact;Card Number;Card Expiry; CVV;Registration Date;End-of-Record
	$myfile = fopen("data/users.txt", "a") or die("Unable to open file!");
	fwrite($myfile, "\n".$data);
	fclose($myfile);
}

function updateUserRecord($email, $newData) {

	$myfile = fopen("data/users.txt", "r") or die("Unable to open file!");
	while(!feof($myfile)) {
		$str = "";
		$oldData = "";
    	$str = fgets($myfile);
		if (substr($str, 0, 1) <> "#")  {
			$delimiter = ";;;;;;;;;;;;;";
            list($recEmail, $recPSW, $name, $dob, $address, $suburb, $postal, $state, $contact, $card, $cardExpiry, $cvv, $regnDate, $recordEnd) = explode(";", $str.$delimiter);
			if ($recEmail == $email) {
				$oldData = $str;
				break;
			}
		}
	}
	fclose($myfile);

 	$data = file("data/users.txt");
	$out = array();

	foreach($data as $line) {
     	if(trim($line) != trim($oldData)) {
         	$out[] = $line;
		}
	}
	

	$fp = fopen("data/users.txt", "w+");
 	flock($fp, LOCK_EX);
 	foreach($out as $line) {
		if ($line <> "") {
			fwrite($fp, $line);
		}
    	
	}
 	flock($fp, LOCK_UN);
	fclose($fp);  
	writeNewUserRecord($newData);
}

function findAdminRecord($psw, $email) {

	#Email;Password;Name;End-of-Record

    $record = "RecordNotFound"; // not found
    $recEmail = $recPSW = $name =  $recordEnd = "";
	$myfile = fopen("data/admin.txt", "r") or die("Unable to open file!");

	while(!feof($myfile)) {
		$str = "";
    	$str = fgets($myfile);
		if (substr($str, 0, 1) <> "#")  {
			$delimiter = ";;;";
            list($recEmail, $recPSW, $name, $recordEnd) = explode(";", $str.$delimiter);
			if ($recEmail == $email) {
				$record = "RecordFound";
				if ($recPSW == md5($psw)) {
					$record = "PasswordCorrect"; // found
				}
				else {
					$record = "IncorrectCredentials"; // found but incorrect password
				}
			}
		}
	}
	fclose($myfile);
	return $record;
	

}
function findUserRecord($psw, $email) {

	#Email;Password;Name;Date of Birth;Address;Suburb;Postal;State;Contact;Card Number;Card Expiry;CVV;Registration Date;End-of-Record

    $record = "RecordNotFound"; // not found
    $recEmail = $recPSW = $name = $dateOfBirth = $address = $suburb = $postal = $state = $contact = $card = $cardExpiry = $cvv = $regnDate = $recordEnd = "";
	$myfile = fopen("data/users.txt", "r") or die("Unable to open file!");

	while(!feof($myfile)) {
		$str = "";
    	$str = fgets($myfile);
		if (substr($str, 0, 1) <> "#")  {
			$delimiter = ";;;;;;;;;;;;;";
            list($recEmail, $recPSW, $name, $dob, $address, $suburb, $postal, $state, $contact, $card, $cardExpiry, $cvv, $regnDate, $recordEnd) = explode(";", $str.$delimiter);
			if ($recEmail == $email) {
				$record = "RecordFound";
				if ($recPSW == md5($psw)) {
					$record = "PasswordCorrect"; // found
				}
				else {
					$record = "IncorrectCredentials"; // found but incorrect password
				}
			}
		}
	}
	fclose($myfile);
    return $record;
}

?>