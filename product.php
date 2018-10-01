<?php
setlocale(LC_MONETARY,"en_AU");
// error_reporting(0);
session_start();

// init global variables | start
include 'inc/lib.php';
$cart = array ("rudi-wanyi-huani-john-ahdeiah" => 1);
$showCartIcon  = true;
$email = $name = "";
if (isset($_SESSION['cart']) ) 				{ $cart = $_SESSION['cart']; }						
if (isset($_SESSION['email']) ) 			{ $email = $_SESSION['email']; }			
if (isset($_SESSION['name']) ) 				{ $name = $_SESSION['name']; }	
if (isset($_SESSION['showCartIcon']) ) 		{ $showCartIcon = $_SESSION['showCartIcon']; } 

$_SESSION["cart"] = $cart;
$_SESSION["email"] = $email;
$_SESSION["name"] = $name;
// init global variables | end


// page specific
$pCode = stripInput($_SESSION["pCode"]); 
$showCartIcon = true; 
$_SESSION['showCartIcon'] = $showCartIcon;





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

include 'inc/head.php';
include 'inc/header.php';

?>

<style>
#products {
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


.dollar:before {
    content:'$';
    font-size:13px;
}

.productListingBtn {
border-collapse: collapse;
font-size: 12px;
border: none;
background-color: black;
padding: 10px 20px;
cursor: pointer;
display: inline-block;
color: white;
}

.productListingBtn:hover {background-color: red;}

</style>

<?php
$str = $category = $code = $name = $image = $desc = $price = "";

$overallCategory = "";
$myfile = fopen("data/products.txt", "r") or die("Unable to open file!");

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
           
            
            $aPrice = getFloatFromString($price);

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


<section id="title" class="products navcat b-primary p10t p10b">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col">
                <h4 class="heading">
                    <a href="products.php">Products</a>
                    <i class="fal fa-angle-right"></i> 
                    <span><?php echo $category ;?></span>
                    <i class="fal fa-angle-right"></i>
                    <span><?php echo $code ;?></span>
                </h4>
            </div>
        </div>
    </div>
</section>

<section class="products detail p50t p50bt m50b">
    <div class="container h-100">
        <div class="row h-100 justify-content-between align-items-start">

            <div class="left col-12 col-md-4 col-lg-4">
                <div class="product-image">
                    <img class="active" src="<?php echo $image_path, $image ;?>">
                </div>
            </div>
            <div class="right col-12 col-md-7 col-lg-6">
                <div class="content">
                    <div class="name row p10t p10b">
                        <h4 class="col"><?php echo $name ;?></h4>
                    </div>
                    <div class="price row p25t p25b">
                        <h2 class="col"><?php echo money_format('%i',$aPrice) ;?></h2>
                    </div>
                    <div class="desc row">
                        <p class="col">
                            <strong><?php echo $desc ;?></strong>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur tristique a justo eget convallis. Nulla facilisi. Curabitur non mauris vitae quam dignissim fermentum non vel nulla. Fusce dapibus augue nec lorem faucibus, blandit varius lacus cursus. Nunc aliquam orci id ligula hendrerit, in efficitur erat sollicitudin.    
                        </p>
                    </div>
                    <hr/>
                    <div class="cta row p10t p10b">
                        <div class="col-auto">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="cartcta">
                                <input type="hidden" id="actionType" name="actionType" value="Add">
                                <input type="hidden" id="pCode" name="pCode" value="<?php echo $pCode; ?>">
                                <input type="hidden" id="AddNewPCode" name="AddNewPCode" value="<?php echo $code; ?>">
                                <input type="submit" id="" name="" <?php if($disableAddtoCart) {?> disabled="disabled" <?php } ?>  value="&#xf217; Add to Cart">
                            </form>
                        </div>
                        <div class="col-auto">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="cartcta">
                                <input type="hidden" id="actionType" name="actionType" value="Remove">
                                <input type="hidden" id="pCode" name="pCode" value="<?php echo $pCode; ?>">
                                <input type="hidden" id="RemovePCode" name="RemovePCode" value="<?php echo $code; ?>">
                                <input type="submit" id=""  name="" <?php if(!$enableRemovefromCart) {?> disabled="disabled" <?php } ?>  value="&#xf2ed; Remove from Cart">
                            </form>
                        </div>
                    </div>
                </div>
            </div> 
            
            <?php } } } } ?>

        </div>
    </div>
</section>

<hr/>

<section class="global m50t m50b">
    <h2 class="heading col">
        <span>More <?php echo $overallCategory; ?> (s) </span>
    </h2>
</section>

    
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

fclose($myfile);

$myfile = fopen("data/products.txt", "r") or die("Unable to open file!");

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

