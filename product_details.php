<?php
setlocale(LC_MONETARY,"en_AU");
error_reporting(0);
session_start();

include 'inc/lib.php';
include 'inc/head.php';
include 'inc/header.php';


$loginType = stripInput($_SESSION["loginType"]); 
$pCode = stripInput($_SESSION["pCode"]); 

?>

<style>
#products {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    font-size: 12px;
    width: 90%;
}

#products td, #products th {
    border: 1px solid #ddd;
    padding: 8px;
}

#products tr:nth-child(even){background-color: #f2f2f2;}

#products tr:hover {background-color: #ddd;}

#products th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: black;
    color: white;
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
    font-size: 12px;
}

.dollar:before {
    content:'$';
    font-size:13px;
}


</style>


<br><br><br>

<table id="products" align="center">
    <tr>
        <th>Category</th>
        <th>Code</th>
        <th>Name</th>
        <th>Image</th>
        <th>Description</th>
        <th>Price</th>
        <th>Add</th>
        <th>Quantity</th>
        <th>Remove</th>
    </tr>



<?php
$str = $category = $code = $name = $image = $desc = $price = "";

$overallCategory = "";
$myfile = fopen("product.txt", "r") or die("Unable to open file!");

// Output one line until end-of-file for selected items
while(!feof($myfile)) {

    $str = "";
  	$str = fgets($myfile);
    if (substr($str, 0, 1) <> "#")  {
      list($category, $code, $brand, $name, $image, $desc, $price) = explode(";", $str.";;;;;");
      if ($name <> "") {
        if ($code == $pCode) {
            $overallCategory = $category;
            $image_path = 'images/';
            echo '<div class="text">';
            echo '<tr>';
            echo '<td>' . $category   . '</td>';
            echo '<td>' . $code       . '</td>';
            echo '<td>' . $name       . '</td>';
            echo '<td><a target="_blank" href="' .$image_path.$image .'"><img src="'. $image_path.$image.'" alt="' .$name.'" style="width:150px"></td>';
            echo '<td>'               . $desc       . '</td>';
            echo '<td align="right">' . money_format('%i',$price)      . '</td>';
            echo '<td> Add Button </td>';
            echo '<td> Quantity </td>';
            echo '<td> Remove Button </td>';
            echo '</tr>';
            echo '</div>';
        }

      } 
    }
}
?>


    <tr>
        <th colspan="9">Other Suggestions in the same Category</th>
    </tr>

<?php
$str = $category = $code = $name = $image = $desc = $price = "";

fclose($myfile);

$myfile = fopen("product.txt", "r") or die("Unable to open file!");

// Output one line until end-of-file for selected items
while(!feof($myfile)) {

    $str = "";
  	$str = fgets($myfile);
    if (substr($str, 0, 1) <> "#")  {
      list($category, $code, $brand, $name, $image, $desc, $price) = explode(";", $str.";;;;;");
      if ($name <> "") {
        if ($overallCategory == $category && $pCode <> $code) {
            $image_path = 'images/';
            echo '<div class="text">';
            echo '<tr>';
            echo '<td>' . $category   . '</td>';
            echo '<td>' . $code       . '</td>';
            echo '<td>' . $name       . '</td>';
            echo '<td><a target="_blank" href="' .$image_path.$image .'"><img src="'. $image_path.$image.'" alt="' .$name.'" style="width:150px"></td>';
            echo '<td>'               . $desc       . '</td>';
            echo '<td align="right">' . money_format('%i',$price)      . '</td>';
            echo '<td> Add Button </td>';
            echo '<td> Quantity </td>';
            echo '<td> Remove Button </td>';
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

