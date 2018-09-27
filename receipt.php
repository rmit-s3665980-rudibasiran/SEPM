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

$receiptNo = "1234";
if (isset($_SESSION['receiptNo']) )              { $receiptNo = $_SESSION['receiptNo']; } 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $msg = "";
    $proceed = TRUE;
    
 
}

include 'inc/head.php';
include 'inc/header.php';

?>

<section id="title" class="products navcat b-primary p10t p10b">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col">
                <h4 class="heading">
                    Order Confirmed
                </h4>
            </div>
        </div>
    </div>
</section>


<section class="global m50t m50b">
    <h2 class="heading col">
        <span>Receipt # <?php echo $receiptNo; ?>
        </span>
    </h2>
</section>


<section id="cart">
    
    <div class="container">
        <div class="row">
            <div class="row justify-content-center align-items-center">
                <div id="divCartEmpty" <?php if (countCart($cart) > 0) {?> style="display:none;" <?php } ?> >
                    <a href="products.php" class="ahref m20t">Your cart is empty. Let's look at some of our best-sellers.</a>
                </div>
            </div>

            <table id="products" class="table table-striped" <?php if(countCart($cart) == 0) {?> style="display:none;" <?php } ?>>

            <?php
            $str = $category = $code = $name = $image = $desc = $price = "";

            $myfile = fopen("data/products.txt", "r") or die("Unable to open file!");

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
                       
                        <td align="center"><?php echo $quantity; ?></td>
                       
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
                    <td colspan="2"><b>TOTAL : <?php echo money_format('%i',$tPrice) ?></b></td>
                </tr>
                <tr>
                    
                    <td></td>
                    <td></td>
                    <td colspan="2">
                    <a href="products.php" class="ahref solid primary">Continue Shopping</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</section>

<?php include('inc/footer.php');?>
<?php include('inc/foot.php');?>    