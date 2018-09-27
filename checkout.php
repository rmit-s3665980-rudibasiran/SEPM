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
$recEmail = $psw = $recName = $dob = $address = $suburb = $postal = $state = $contact = $card = $cvv = $regnDate = $recordEnd = "";
$myfile = fopen("data/users.txt", "r") or die("Unable to open file!");
    while(!feof($myfile)) {
		$str = "";
    	$str = fgets($myfile);
		if (substr($str, 0, 1) <> "#")  {
            #Email;Password;Name;Date of Birth;Address;Suburb;Postal;State;Contact;Card Number;Card Expiry;CVV;Registration Date;End-of-Record
            $delimiter = ";;;;;;;;;;;;;";
            list($recEmail, $psw, $recName, $dob, $address, $suburb, $postal, $state, $contact, $card, $cardExpiry, $cvv, $regnDate, $recordEnd) = explode(";", $str.$delimiter);
			if ($recEmail == $email) {
                $proceed = true;
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $name;
                break;
            }
        }
    }
    fclose($myfile);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $msg = "";
    $proceed = TRUE;
    
 
}

include 'inc/head.php';
include 'inc/header.php';

?>

<style>
.containerItems {
    position: absolute;
    left: 0;
    margin: 20px;
    max-width: 400px;
    padding: 16px;
    background-color: white;
}


.containerCard {
    position: absolute;
    right: 0;
    margin: 20px;
    max-width: 200px;
    padding: 16px;
    background-color: white;
}


.containerAddr {
    position: absolute;
    bottom: 0;
    margin: 20px;
    max-width: 480px;
    padding: 16px;
    background-color: white;
}


</style>

 

<section id="title" class="products navcat b-primary p10t p10b">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col">
                <h4 class="heading">
                    Check Out
                </h4>
            </div>
        </div>
    </div>
</section>


<section class="global m50t m50b">
    <h2 class="heading col">
        <span>Items
        </span>
    </h2>
</section>


<section id="address">
    
    <div class="containerAddr">
    <div class="row">
    <table id="address"  style="widtg=90%">
    <tr><td colspan=3>Address</td></tr>
    <tr><td colspan=3><?php echo $address ?></td></tr>
 
    <tr><td>Suburb</td><td>Postal Code</td> <td>State</td></tr>
    <tr><td><?php echo $suburb; ?></td><td><?php echo $postal; ?></td><td><?php echo $state; ?></td></tr>

    <tr><td colspan=2><a href="products.php" class="ahref solid primary">Go Back</a></td></tr>
    
    </table>
    </div>
    </div>
</section>


<section id="card">
    
    <div class="containerCard">
    <div class="row">
    <table id="card"  >
    <tr><td colspan=2>Card Details</td></tr>
    <tr><td colspan=2>Card Image</td></tr>
    <tr><td colspan=2>Card Details</td></tr>
    <tr><td colspan=2>Card Holder Name</td></tr>
    <tr><td colspan=2><?php echo $recName; ?></td></tr>
    <tr><td colspan=2>Card Number</td></tr>
    <tr><td colspan=2><?php echo $card; ?></td></tr>

    <tr><td>Expiry Date</td><td>CVV</td></tr>
    <tr><td><?php echo $cardExpiry; ?></td><td><?php echo $cvv; ?></td></tr>
    <tr><td colspan=2><a href="receipt.php" class="ahref solid primary">Confirm Payment</a></td></tr>
    
    
    </table>
    </div>
    </div>
</section>

<section id="cart">
    <div class="containerItems">
   
        <div class="row">
           
            <table id="products"  >

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
                
            </table>
        </div>
    </div>
    
</section>

<?php include('inc/footer.php');?>
<?php include('inc/foot.php');?>    