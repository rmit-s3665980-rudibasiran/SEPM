<?php
setlocale(LC_MONETARY,"en_AU");
// error_reporting(0);
session_start();

// init global variables | start
include 'inc/lib.php';
$cart = array ("rudi-wanyi-huani-john-ahdeiah" => 1);
$showCartIcon  = true;
$email = $name = "";
if (isset($_SESSION['cart']) )              { $cart = $_SESSION['cart']; }                      
if (isset($_SESSION['email']) )             { $email = $_SESSION['email']; }            
if (isset($_SESSION['name']) )              { $name = $_SESSION['name']; }  
if (isset($_SESSION['showCartIcon']) )      { $showCartIcon = $_SESSION['showCartIcon']; } 

$_SESSION["cart"] = $cart;
$_SESSION["email"] = $email;
$_SESSION["name"] = $name;
// init global variables | end

// page specific
$showCartIcon = false; 
$_SESSION['showCartIcon'] = $showCartIcon;

$showCheckOut = true;
if ($email == "") {
    $showCheckOut = false;
}


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


<section id="title" class="products navcat b-primary p10t p10b">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col">
                <h4 class="heading">
                    Shopping Cart
                </h4>
            </div>
        </div>
    </div>
</section>

<section class="global m50t m50b">
    <h2 class="heading col">
        <span>ITEMS</span>
    </h2>
</section>


<section id="cart">
    
    <div class="container">
        <div class="row">

            <table id="productListingCartEmpty" <?php if(!isCartEmpty($cart)) {?> style="display:none;" <?php } ?>>
                 <tr align="middle">
                 <td colspan="8"><a href="product_listing.php">
                    Your cart is empty. Let's look at some of our best-sellers.</button></a></td>
                </tr>
            </table>

            <table id="products" class="table table-striped" <?php if(isCartEmpty($cart)) {?> style="display:none;" <?php } ?>>

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
                        echo '<td width="50px"><a target="_blank" href="' .$image_path.$image .'"><img src="'. $image_path.$image.'" alt="' .$name.'" style="width:50px"></td>';
                        echo '<td><strong>' . $name       . '</strong></td>';
               
                        
                        

                        $aPrice = getFloatFromString($price);
                        ?>
                        
                        <td align="center">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                <input type="hidden" id="actionType" name="actionType" value="DecrementQuantity">
                                <input type="hidden" id="pCode" name="pCode" value="<?php echo $pCode; ?>">
                                <input type="hidden" id="currCode" name="currCode" value="<?php echo $code; ?>">
                                <input type="hidden" id="currQuantity" name="currQuantity" value="<?php echo $quantity; ?>">
                                <input type="submit" id="" name="" class="ahref solid primary" <?php if($quantity == 1) {?> disabled="disabled" <?php } ?>  value="-">
                            </form>
                        </td>

                        <td align="center"><?php echo $quantity; ?></td>

                        <td align="center">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                <input type="hidden" id="actionType" name="actionType" value="IncrementQuantity">
                                <input type="hidden" id="pCode" name="pCode" value="<?php echo $pCode; ?>">
                                <input type="hidden" id="currCode" name="currCode" value="<?php echo $code; ?>">
                                <input type="hidden" id="currQuantity" name="currQuantity" value="<?php echo $quantity; ?>">
                                <input type="submit" id="" name=""  class="ahref solid primary" value="+">
                            </form>
                        </td>
                        

                        <td>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="cartcta">
                                <input type="hidden" id="actionType" name="actionType" value="Remove">
                                <input type="hidden" id="pCode" name="pCode" value="<?php echo $pCode; ?>">
                                <input type="hidden" id="RemovePCode" name="RemovePCode" value="<?php echo $code; ?>">
                                <i class="far fa-trash-alt"></i>
                                <input type="submit" id=""  name="" class="ahref solid primary" <?php if(!$enableRemovefromCart) {?> disabled="disabled" <?php } ?>  value="">
                            </form>
                        </td>

                        <td><strong><?php echo money_format('%i',$aPrice);?></strong></td>

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

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="2"><b>TOTAL : <?php echo money_format('%i',$tPrice) ?></b></td>
                </tr>
                <tr>
                    <td><a href="product_listing.php" class="ahref solid primary">Continue Shopping</a></td>
                    <td><a href="checkout.php" class="ahref solid primary" <?php if(!$showCheckOut) {?> style="display:none;" <?php } ?>>Checkout</a></td>
                </tr>
            </table>
        </div>
    </div>
</section>


<table id="productListing" <?php if(isCartEmpty($cart)) {?> style="display:none;" <?php } ?>>
     <tr align="right">
        <td colspan="8">
        
        </td>
    </tr>
</table>

<?php include('inc/footer.php');?>
<?php include('inc/foot.php');?>    