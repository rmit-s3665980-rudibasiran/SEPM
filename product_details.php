

<?php
setlocale(LC_MONETARY,"en_AU");
error_reporting(0);
session_start();

include 'inc/lib.php';
include 'inc/head.php';
include 'inc/header.php';


$loginType = stripInput($_SESSION["loginType"]); 
$pCode = stripInput($_SESSION["pCode"]); 
$cart = stripInput($_SESSION["cart"]); 
echo '<h1>pCode=['.$pCode.']</h1>';
echo '<h1>cart=['.$cart.']</h1>';
?>

<?php

    foreach($cart as $x=>$x_value) {
        echo "Key=" . $x . ", Value=" . $x_value;
        echo "<br>";
    }
?>

<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
    font-family: arial;
    font-size: 12px;
}

tr:nth-child(odd) {
    background-color: #FFFFFF;
    font-family: arial;
    font-size: 12px;
}

img {
    border: 0px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    width: 150px;
}

img:hover {
    box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}

.text {
    font-size: 15px;
}

.dollar:before {
    content:'$';
    font-size:13px;
}


</style>


<table>
  <tr>
    <th>Category</th>
    <th>Code</th>
    <th>Name</th>
    <th>Image</th>
    <th>Description</th>
    <th>Price</th>
  </tr>



<?php
$str = $category = $code = $name = $image = $desc = $price = "";

$myfile = fopen("product.txt", "r") or die("Unable to open file!");

$count = 0;

// Output one line until end-of-file
while(!feof($myfile)) {

    $str = "";
  	$str = fgets($myfile);
    $count++;
    if ($count <> 1) {
      list($category, $code, $brand, $name, $image, $desc, $price) = explode(";", $str.";;;;;");
      if ($name <> "") {
        if ($code == $pCode) {
            $image_path = 'images/';
            echo '<div class="text">';
            echo '<tr>';
            echo '<td>' . $category   . '</td>';
            echo '<td>' . $code       . '</td>';
            echo '<td>' . $name       . '</td>';
            echo '<td><a target="_blank" href="' .$image_path.$image .'"><img src="'. $image_path.$image.'" alt="' .$name.'" style="width:150px"></td>';
            echo '<td>'               . $desc       . '</td>';
            echo '<td align="right">' . money_format('%i',$price)      . '</td>';
            echo '</tr>';
            echo '</div>';
        }

      }
      
    }

   
}
  fclose($myfile);
?>
</table>


<?php include('inc/footer.php');?>
<?php include('inc/foot.php');?>

