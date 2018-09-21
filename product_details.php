<?php
setlocale(LC_MONETARY,"en_AU");
error_reporting(0);
session_start();

include 'inc/lib.php';
include 'inc/head.php';
include 'inc/header.php';


$loginType = stripInput($_SESSION["loginType"]); 
$pCode = stripInput($_SESSION["pCode"]); 


$GLOBALS['cart'] = $_SESSION['cart']; 
if (!isset($GLOBALS['cart']) ) {
	$cart = array("rudi"=>1, "huani"=>2, "wanyi"=>3, "john"=>4, "Ahdeiah"=>5);
}
$_SESSION['cart'] = $cart;



$cart = $_SESSION['cart'];
$GLOBALS['cart']  = $cart;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $msg = "";
    $proceed = TRUE;
	
    $AddNewPCode = $_POST["AddNewPCode"];
    $cart = $_SESSION['cart'];
    $GLOBALS['cart'] += [ $AddNewPCode => 1 ];
    $_SESSION['cart'] = $cart;

    $pCode = $_POST["pCode"];
    $_SESSION["pCode"] = $pCode;
    
    // header ("Location: product_details.php"); 
    // exit;
   
}

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

            $disableAddtoCart = false;
            foreach($cart as $x=>$x_value) {  
                if ($code == $x) {
                    $disableAddtoCart = true;
                }
            }
            ?>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" id="pCode" name="pCode" value="<?php echo $pCode; ?>">
            <input type="hidden" id="AddNewPCode" name="AddNewPCode" value="<?php echo $code; ?>">
            <td><input type="submit" id="" name="" <?php if($disableAddtoCart) {?> disabled="disabled" <?php } ?>  value="Add to Cart"></td>
            </form>

            <?php

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

            $disableAddtoCart = false;
            foreach($cart as $x=>$x_value) {
                
                if ($code == $x) {
                    $disableAddtoCart = true;
                }
            }

            ?>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" id="AddNewPCode" name="AddNewPCode" value="<?php echo $code; ?>">
            <input type="hidden" id="pCode" name="pCode" value="<?php echo $pCode; ?>">
            <td><input type="submit" id="" name="" <?php if($disableAddtoCart) {?> disabled="disabled" <?php } ?>  value="Add to Cart"></td>
            </form>
            <?php

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

