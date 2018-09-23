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

function  printCart ($data) {
	echo "Contents of Cart: <br>";
	foreach($data as $productCode=>$numOrdered) {
		echo $productCode . "==>" .$numOrdered ."<br>";
	}
}


function isCartEmpty ($data) {
	$str = $category = $code = $name = $image = $desc = $price = "";
	$myfile = fopen("product.txt", "r") or die("Unable to open file!");
	$cartEmpty = true;
	while(!feof($myfile)) {
    	$str = "";
    	$str = fgets($myfile);
    	if (substr($str, 0, 1) <> "#")  {
        	list($category, $code, $brand, $name, $image, $desc, $price) = explode(";", $str.";;;;;");
        	if ($name <> "") {
            	foreach($data as $productCode=>$numOrdered) {
                	if ($code == $productCode) {
                    	$cartEmpty = false;
               		}
           		}
        	}
		}
	}
	
	return $cartEmpty;
}

?>