<?php
setlocale(LC_MONETARY,"en_AU");
// error_reporting(0);
session_start();

// init global variables | start
$cart = array ("rudi-wanyi-huani-john-ahdeiah" => 1);
$showCartIcon = $showLoginIcon = true;
$userEmail = "";
if (isset($_SESSION['cart']) ) 				{ $cart = $_SESSION['cart']; }	                    else { $_SESSION['cart'] = $cart;}					
if (isset($_SESSION['showCartIcon']) ) 		{ $showCartIcon = $_SESSION['showCartIcon']; } 		
if (isset($_SESSION['showLoginIcon']) ) 	{ $showLoginIcon = $_SESSION['showLoginIcon']; }	
if (isset($_SESSION['userEmail']) ) 		{ $userEmail = $_SESSION['userEmail']; }			
// init global variables | end

include 'inc/head.php';
include 'inc/header.php';
include 'inc/lib.php';

// page specific
$pCode = stripInput($_SESSION["pCode"]); 
$showCartIcon = true; 
$_SESSION['showCartIcon'] = $showCartIcon;

$showLoginIcon = true; 
$_SESSION['showLoginIcon'] = $showLoginIcon;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $msg = "";
    $proceed = TRUE;
    
    $actionType = $_POST["actionType"];
    $pCode = $_POST["pCode"];
    $_SESSION["pCode"] = $pCode;

    if ($actionType == "Add") {
        $AddNewPCode = $_POST["AddNewPCode"];
        $cart = $_SESSION['cart'];
        $cart += [ $AddNewPCode => 1 ];
        $_SESSION['cart'] = $cart;
    }
    else if ($actionType == "Remove") {
        $RemovePCode = $_POST["RemovePCode"];
        $cart = $_SESSION['cart'];
        unset($cart[$RemovePCode]);
        $_SESSION['cart'] = $cart;
    }
   
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


<br>

<table id="products" align="center">
    <tr>
        <th>Category</th>
        <th>Code</th>
        <th>Name</th>
        <th>Image</th>
        <th>Description</th>
        <th>Price</th>
        <th>Add</th>
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
            
			$aPrice = getFloatFromString($price);
			
            echo '<td align="right">' . money_format('%i',$aPrice)      . '</td>';

            $disableAddtoCart = false;
            $enableRemovefromCart = false;
            $quantity = 0;
            foreach($cart as $productCode=>$numOrdered) {
                if ($code == $productCode) {
                    $quantity = $numOrdered;
                    $disableAddtoCart = true;
                    $enableRemovefromCart = true;
                }
            }
            ?>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" id="actionType" name="actionType" value="Add">
            <input type="hidden" id="pCode" name="pCode" value="<?php echo $pCode; ?>">
            <input type="hidden" id="AddNewPCode" name="AddNewPCode" value="<?php echo $code; ?>">
            <td><input type="submit" id="" name="" <?php if($disableAddtoCart) {?> disabled="disabled" <?php } ?>  value="Add to Cart"></td>
            </form>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" id="actionType" name="actionType" value="Remove">
            <input type="hidden" id="pCode" name="pCode" value="<?php echo $pCode; ?>">
            <input type="hidden" id="RemovePCode" name="RemovePCode" value="<?php echo $code; ?>">
            <td><input type="submit" id=""  name="" <?php if(!$enableRemovefromCart) {?> disabled="disabled" <?php } ?>  value="Remove from Cart"></td>
            </form>

            <?php
            echo '</tr>';
            echo '</div>';
        }

      } 
    }
}
?>


    <tr>
        <th colspan="8">Other Suggestions in the same Category</th>
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
            
			$aPrice = getFloatFromString($price);
						
            echo '<td align="right">' . money_format('%i',$aPrice)      . '</td>';

            $disableAddtoCart = false;
            $enableRemovefromCart = false;
            $quantity = 0;
            foreach($cart as $productCode=>$numOrdered) {
                if ($code == $productCode) {
                    $quantity = $numOrdered;
                    $disableAddtoCart = true;
                    $enableRemovefromCart = true;
                }
            }

            ?>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" id="actionType" name="actionType" value="Add">
            <input type="hidden" id="pCode" name="pCode" value="<?php echo $pCode; ?>">
            <input type="hidden" id="AddNewPCode" name="AddNewPCode" value="<?php echo $code; ?>">
            <td><input type="submit" id="" name="" <?php if($disableAddtoCart) {?> disabled="disabled" <?php } ?>  value="Add to Cart"></td>
            </form>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" id="actionType" name="actionType" value="Remove">
            <input type="hidden" id="pCode" name="pCode" value="<?php echo $pCode; ?>">
            <input type="hidden" id="RemovePCode" name="RemovePCode" value="<?php echo $code; ?>">
            <td><input type="submit" id=""  name="" <?php if(!$enableRemovefromCart) {?> disabled="disabled" <?php } ?>  value="Remove from Cart"></td>
            </form>
            <?php

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

