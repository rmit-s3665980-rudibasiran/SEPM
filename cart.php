<?php
setlocale(LC_MONETARY,"en_AU");
// error_reporting(0);
session_start();

// init global variables | start
include 'inc/lib.php';
$cart = array ("rudi-wanyi-huani-john-ahdeiah" => 1);
$showCartIcon = $showLoginIcon = $showName = true;
$email = $name = "@";
if (isset($_SESSION['cart']) ) 				{ $cart = $_SESSION['cart']; }						
if (isset($_SESSION['showCartIcon']) ) 		{ $showCartIcon = $_SESSION['showCartIcon']; } 		
if (isset($_SESSION['showLoginIcon']) ) 	{ $showLoginIcon = $_SESSION['showLoginIcon']; }	
if (isset($_SESSION['showName']) ) 	        { $showName = $_SESSION['showName']; }	
if (isset($_SESSION['email']) ) 			{ $email = $_SESSION['email']; }			
if (isset($_SESSION['name']) ) 				{ $name = $_SESSION['name']; }	

if ($email <> "@") {
	$showLoginIcon = false;
	$showName = true;
}
else {
	$showLoginIcon = true;
	$showName = false;
}
$_SESSION["showLoginIcon"] = $showLoginIcon;
$_SESSION["showName"] = $showName;
$_SESSION["cart"] = $cart;
$_SESSION["email"] = $email;
$_SESSION["name"] = $name;
// init global variables | end

// page specific
$showCartIcon = false; 
$_SESSION['showCartIcon'] = $showCartIcon;

$showLoginIcon = true; 
$_SESSION['showLoginIcon'] = $showLoginIcon;


include 'inc/head.php';
include 'inc/header.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $msg = "";
    $proceed = TRUE;
    
    $actionType = $_POST["actionType"];

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
    else if ($actionType == "IncrementQuantity") {
        $currCode = $_POST["currCode"];
        $currQuantity = (int) $_POST["currQuantity"];
        $currQuantity++;
        $cart = $_SESSION['cart'];
        $cart[$currCode] = $currQuantity ;
        $_SESSION['cart'] = $cart;
    }
    else if ($actionType == "DecrementQuantity") {
        $currCode = $_POST["currCode"];
        $currQuantity = (int) $_POST["currQuantity"];
        $currQuantity--;
        $cart = $_SESSION['cart'];
        $cart[$currCode] = $currQuantity;
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
    background-color: #f2f2f2;
 
}

#products td, #products th {
    
    padding: 8px;
    
}

#products tr:nth-child(even){background-color: white;}

#products th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: black;
    color: white;
}


#productListing {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    font-size: 12px;
    width: 90%;
}

#productListing td, #productListing th {
    border: 0px 
    padding: 8px;
}

#productListing th {
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

.productListingBtn {

    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    font-size: 12px;
    border: none;
    background-color: black;
    padding: 10px 20px;
    cursor: pointer;
    display: inline-block;
    color: white;
}

.productListingBtn:hover {background-color: #00ffcc; color: black;}

.productListingBtn:disabled {background-color: lightgray; color: black;}



</style>


<section id="title" class="products navcat b-primary p10t p10b">
	<div class="container">
		<div class="row justify-content-center align-items-center">
SHOPPING CART
		</div>
	</div>
</section>

<section class="global m50t m50b">
	<h2 class="heading col">
		<span>ITEMS</span>
	</h2>
</section>

<br>

<table id="productListingCartEmpty" align="center" <?php if(!isCartEmpty($cart)) {?> style="display:none;" <?php } ?>>
     <tr align="middle">
     <td colspan="8"><a href="product_listing.php"><button class="productListingBtn">
        Your cart is empty. Let's look at some of our best-sellers.</button></a></td>
    </tr>
</table>


<table id="products" align="center" <?php if(isCartEmpty($cart)) {?> style="display:none;" <?php } ?>>

<?php
$str = $category = $code = $name = $image = $desc = $price = "";

$myfile = fopen("product.txt", "r") or die("Unable to open file!");

// Output one line until end-of-file for selected items
while(!feof($myfile)) {

    $str = "";
  	$str = fgets($myfile);
    if (substr($str, 0, 1) <> "#")  {
      list($category, $code, $brand, $name, $image, $desc, $price) = explode(";", $str.";;;;;");

      

      if ($name <> "") {

        $disableAddtoCart = false;
        $enableRemovefromCart = false;
        $inCart = false;
        $quantity = 0;
        foreach($cart as $productCode=>$numOrdered) {
          if ($code == $productCode) {
              $quantity = $numOrdered;
              $disableAddtoCart = true;
              $enableRemovefromCart = true;
              $inCart = true;
          }
        }

        if ($inCart) {
            $image_path = 'images/';
            echo '<div class="text">';
            echo '<tr>';
            echo '<td><a target="_blank" href="' .$image_path.$image .'"><img src="'. $image_path.$image.'" alt="' .$name.'" style="width:50px"></td>';
            echo '<td>|</td>';
            echo '<td>' . $name       . '</td>';
   
            
            

			$aPrice = getFloatFromString($price);
			
            echo '<td align="right">' . money_format('%i',$aPrice)      . '</td>';

           
            ?>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" id="actionType" name="actionType" value="DecrementQuantity">
            <input type="hidden" id="pCode" name="pCode" value="<?php echo $pCode; ?>">
            <input type="hidden" id="currCode" name="currCode" value="<?php echo $code; ?>">
            <input type="hidden" id="currQuantity" name="currQuantity" value="<?php echo $quantity; ?>">
            <td><input type="submit" id="" name="" class="productListingBtn" <?php if($quantity == 1) {?> disabled="disabled" <?php } ?>  value="-"></td>
            </form>

            <td> <?php echo $quantity; ?></td>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" id="actionType" name="actionType" value="IncrementQuantity">
            <input type="hidden" id="pCode" name="pCode" value="<?php echo $pCode; ?>">
            <input type="hidden" id="currCode" name="currCode" value="<?php echo $code; ?>">
            <input type="hidden" id="currQuantity" name="currQuantity" value="<?php echo $quantity; ?>">
            <td><input type="submit" id="" name=""  class="productListingBtn" value="+"></td>
            </form>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" id="actionType" name="actionType" value="Remove">
            <input type="hidden" id="pCode" name="pCode" value="<?php echo $pCode; ?>">
            <input type="hidden" id="RemovePCode" name="RemovePCode" value="<?php echo $code; ?>">
            <td><input type="submit" id=""  name="" class="productListingBtn" <?php if(!$enableRemovefromCart) {?> disabled="disabled" <?php } ?>  value="Remove from Cart"></td>
            </form>

            <?php
            echo '</tr>';
            echo '</div>';
            echo '<tr><td colspan="8">&nbsp</td></tr>';
            

        }

      } 
    }
}
 
    $totalPrice = calcCart($cart);
    $tPrice = getFloatFromString($totalPrice);
    ?>

    <tr align="right">
        <td colspan="8"><b>TOTAL : <?php echo money_format('%i',$tPrice) ?></b></td>
    </tr>

</table>



<table id="productListing" align="center" <?php if(isCartEmpty($cart)) {?> style="display:none;" <?php } ?>>
     <tr align="right">
        <td colspan="8"><a href="product_listing.php"><button class="productListingBtn">Continue Shopping</button></a></td>
    </tr>
</table>



<?php include('inc/footer.php');?>
<?php include('inc/foot.php');?>
