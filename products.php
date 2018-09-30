
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
$showCartIcon = true; 
$_SESSION['showCartIcon'] = $showCartIcon;

include 'inc/head.php';
include 'inc/header.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $msg = "";
    $proceed = TRUE;
	
	$pCode = $_POST["pCode"];
	$_SESSION["pCode"] = $pCode;

	$currentPage = $_POST["currentPage"];
	$_SESSION["currentPage"] = $currentPage;

    if ($currentPage == "products" & $pCode <> "") {
        header ("Location: product.php"); 
        exit;
	}
	
	if ($currentPage == "products_cart") {
        header ("Location: cart.php"); 
        exit;
    }
}



?>


<section id="title" class="products navcat b-primary p10t p10b">
	<div class="container">
		<div class="row justify-content-center align-items-center">
			<div class="col-auto button-group filters-button-group">
			  	<button class="button is-checked" data-filter="*">ALL</button>
			  	<button class="button" data-filter=".laptop">Laptop</button>
			  	<button class="button" data-filter=".hard-drive">Hard Drive</button>
			  	<button class="button" data-filter=".headphones">Headphones</button>
			  	<button class="button" data-filter=".tv">TV</button>
			</div>
		</div>
	</div>
</section>

<section class="global m50t m50b">
	<h2 class="heading col">
		<span>Products</span>
	</h2>
</section>


<section class="products listing">
	<div class="container">
		<ul class="row grid offour">
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<input type="hidden" id="currentPage" name="currentPage" value="products">
		<input type="hidden" id="email" name="email" value="<?php echo $email ;?>">
		<input type="hidden" id="userName" name="userName" value="<?php echo $userName ;?>">
		<?php

		$str = $category = $code = $name = $image = $desc = $price = "";
		$myfile = fopen("data/products.txt", "r") or die("Unable to open file!");

		// Output one line until end-of-file
		while(!feof($myfile)) {

			$str = "";
			$str = fgets($myfile);
			if (substr($str, 0, 1) <> "#") { 
			    list($category, $code, $brand, $name, $image, $desc, $price) = explode(";", $str.";;;;;");

		?>

			<!-- start loop -->

			<li class="element-item <?php echo slugify($category);?> col-12 col-md-6 col-lg-3">
				<div>
					<input type="submit" id="pCode" name="pCode" value="<?php echo $code; ?>">
					<div class="image has-image" style="background-image: url(images/<?php echo $image ;?>);">
					</div>
					<div class="content row justify-content-between align-items-center">
						<div class="col-6">
							<h6><?php echo $name ;?></h6>
						</div>
						<div class="col-6">
							<small><?php echo $brand ;?></small>
							<?php $aPrice = getFloatFromString($price); ?>
							<p class="price"><?php echo money_format('%i',$aPrice) ;?></p>
						</div>
						
					</div>
				</div>
			</li>

 			
			<!-- end loop -->
			<?php } } fclose($myfile); ?>
			</form>

		</ul>
	</div>
</section>


<?php include('inc/footer.php');?>
<?php include('inc/foot.php');?>