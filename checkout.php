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

<div class="sprite">
    <svg>
        <defs>

            <symbol id="visa-icon">
                <g>
                    <path class="st0" d="M126,82H2c-1.1,0-2-0.9-2-2V2c0-1.1,0.9-2,2-2h124c1.1,0,2,0.9,2,2v78C128,81.1,127.1,82,126,82z"/>
                <g>
                <polygon class="st1" points="47.3,56.6 52.6,25.5 61.1,25.5 55.8,56.6        "/>
                <path class="st1" d="M86.5,26.2c-1.7-0.6-4.3-1.3-7.6-1.3c-8.4,0-14.3,4.2-14.3,10.3c0,4.5,4.2,7,7.4,8.5c3.3,1.5,4.4,2.5,4.4,3.9
                c0,2.1-2.6,3-5.1,3c-3.4,0-5.2-0.5-8-1.6l-1.1-0.5l-1.2,7c2,0.9,5.6,1.6,9.4,1.7c8.9,0,14.7-4.2,14.8-10.6c0-3.5-2.2-6.2-7.1-8.5
                c-3-1.4-4.8-2.4-4.8-3.9c0-1.3,1.5-2.7,4.9-2.7c2.8,0,4.8,0.6,6.3,1.2l0.8,0.4L86.5,26.2"/>
                <path class="st1" d="M108.3,25.5h-6.6c-2,0-3.5,0.6-4.4,2.6L84.7,56.6h8.9c0,0,1.5-3.8,1.8-4.7c1,0,9.6,0,10.9,0
                c0.3,1.1,1,4.7,1,4.7h7.9L108.3,25.5 M97.8,45.6c0.7-1.8,3.4-8.7,3.4-8.7c-0.1,0.1,0.7-1.8,1.1-3l0.6,2.7c0,0,1.6,7.4,2,9H97.8z"
                />
                <path class="st1" d="M40.2,25.5l-8.3,21.2L31,42.4c-1.5-5-6.4-10.4-11.7-13.1l7.6,27.2l9,0l13.4-31.1H40.2"/>
                <path class="st2" d="M24.2,25.5H10.5l-0.1,0.6C21,28.7,28.1,34.9,31,42.4l-3-14.3C27.5,26.1,26,25.6,24.2,25.5"/>
                </g>
                </g>
            </symbol>

            <symbol id="mc-icon">
                <g>
                    <path class="st0" d="M126,82H2c-1.1,0-2-0.9-2-2V2c0-1.1,0.9-2,2-2h124c1.1,0,2,0.9,2,2v78C128,81.1,127.1,82,126,82z"/>
                <g>
                    <path class="st1" d="M54.4,41c0-8,3.8-15.1,9.6-19.7C59.8,18,54.4,16,48.6,16c-13.8,0-25,11.2-25,25s11.2,25,25,25
                    c5.8,0,11.2-2,15.4-5.3C58.2,56.1,54.4,49,54.4,41z"/>
                    <path class="st2" d="M79.4,16c-5.8,0-11.2,2-15.4,5.3c5.8,4.6,9.6,11.7,9.6,19.7S69.8,56.1,64,60.7C68.2,64,73.6,66,79.4,66
                    c13.8,0,25-11.2,25-25S93.2,16,79.4,16z"/>
                    <path class="st3" d="M73.6,41c0-8-3.8-15.1-9.6-19.7C58.2,25.9,54.4,33,54.4,41s3.8,15.1,9.6,19.7C69.8,56.1,73.6,49,73.6,41z"/>
                </g>
                </g>
            </symbol>
        </defs>
    </svg>
</div>

 

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


<section id="cart" class="m100b">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12 col-md-8">
                <table id="products" class="table">

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
                            

                        }

                      } 
                    }
                }
                 
                    $totalPrice = calcCart($cart);
                    $tPrice = getFloatFromString($totalPrice);
                    ?>

                    <tr class="total">  
                        <td colspan="8"><b>TOTAL : <?php echo money_format('%i',$tPrice) ?></b></td>
                    </tr>
                    
                </table>
                <div id="shipping" class="checkout m50t">
                    <div class="row m50b">
                        <div class="col-12">
                            <label>Street Address</label>
                            <div class="w-100"></div>
                            <div><?php echo $address; ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Suburb</label>
                            <div class="w-100"></div>
                            <div><?php echo $suburb; ?></div>
                        </div>
                        
                        <div class="col">
                            <label>Postal Code</label>
                            <div class="w-100"></div>
                            <div><?php echo $postal; ?></div>
                        </div>

                        <div class="col">
                            <label>State</label>
                            <div class="w-100"></div>
                            <div><?php echo $state; ?></div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div id="carddeets" class="checkout b-dark t-white">
                    <h4>Card Details</h4>
                    <div class="row">
                        <div class="col">
                            <label>Cardholder Type</label>
                            <div class="w-100"></div>
                            <div class="row" style="margin-top: 0;border: 0;">
                                <div class="col-6">
                                    <span>
                                      <svg id="visa-icon" viewBox="0 0 128 82">
                                      <g>
                                        <g>
                                            <polygon class="st1" points="47.3,56.6 52.6,25.5 61.1,25.5 55.8,56.6        "></polygon>
                                            <path class="st1" d="M86.5,26.2c-1.7-0.6-4.3-1.3-7.6-1.3c-8.4,0-14.3,4.2-14.3,10.3c0,4.5,4.2,7,7.4,8.5c3.3,1.5,4.4,2.5,4.4,3.9
                                                c0,2.1-2.6,3-5.1,3c-3.4,0-5.2-0.5-8-1.6l-1.1-0.5l-1.2,7c2,0.9,5.6,1.6,9.4,1.7c8.9,0,14.7-4.2,14.8-10.6c0-3.5-2.2-6.2-7.1-8.5
                                                c-3-1.4-4.8-2.4-4.8-3.9c0-1.3,1.5-2.7,4.9-2.7c2.8,0,4.8,0.6,6.3,1.2l0.8,0.4L86.5,26.2"></path>
                                            <path class="st1" d="M108.3,25.5h-6.6c-2,0-3.5,0.6-4.4,2.6L84.7,56.6h8.9c0,0,1.5-3.8,1.8-4.7c1,0,9.6,0,10.9,0
                                                c0.3,1.1,1,4.7,1,4.7h7.9L108.3,25.5 M97.8,45.6c0.7-1.8,3.4-8.7,3.4-8.7c-0.1,0.1,0.7-1.8,1.1-3l0.6,2.7c0,0,1.6,7.4,2,9H97.8z"></path>
                                            <path class="st1" d="M40.2,25.5l-8.3,21.2L31,42.4c-1.5-5-6.4-10.4-11.7-13.1l7.6,27.2l9,0l13.4-31.1H40.2"></path>
                                            <path class="st2" d="M24.2,25.5H10.5l-0.1,0.6C21,28.7,28.1,34.9,31,42.4l-3-14.3C27.5,26.1,26,25.6,24.2,25.5"></path>
                                        </g>
                                      </g>
                                          </svg>
                                    </span>
                                </div>
                                <div class="col-6">
                                    <span>
                                            <svg id="mc-icon" viewBox="0 0 128 82">
                                            <g>
                                                <g>
                                                    <path class="st1" d="M54.4,41c0-8,3.8-15.1,9.6-19.7C59.8,18,54.4,16,48.6,16c-13.8,0-25,11.2-25,25s11.2,25,25,25
                                                        c5.8,0,11.2-2,15.4-5.3C58.2,56.1,54.4,49,54.4,41z"></path>
                                                    <path class="st2" d="M79.4,16c-5.8,0-11.2,2-15.4,5.3c5.8,4.6,9.6,11.7,9.6,19.7S69.8,56.1,64,60.7C68.2,64,73.6,66,79.4,66
                                                        c13.8,0,25-11.2,25-25S93.2,16,79.4,16z"></path>
                                                    <path class="st3" d="M73.6,41c0-8-3.8-15.1-9.6-19.7C58.2,25.9,54.4,33,54.4,41s3.8,15.1,9.6,19.7C69.8,56.1,73.6,49,73.6,41z"></path>
                                                </g>
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label>Cardholder Name</label>
                            <div class="w-100"></div>
                            <div><?php echo $recName; ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Card Number</label>
                            <div class="w-100"></div>
                            <div><?php echo $card; ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <label>Card Expiry</label>
                            <div class="w-100"></div>
                            <div><?php echo $cardExpiry; ?></div>
                        </div>
                        <div class="col-4">
                            <label>CVV</label>
                            <div class="w-100"></div>
                            <div><?php echo $cvv; ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="receipt.php" class="ahref solid primary">Confirm Payment</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</section>

<?php include('inc/footer.php');?>
<?php include('inc/foot.php');?>    