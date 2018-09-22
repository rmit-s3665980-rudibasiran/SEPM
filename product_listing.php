
<?php
setlocale(LC_MONETARY,"en_AU");
// error_reporting(0);
session_start();

// init global variables | start
$cart = array ("rudi-wanyi-huani-john-ahdeiah" => 1);
$showCartIcon = $showLoginIcon = true;
$userEmail = "";
if (isset($_SESSION['cart']) ) 				{ $cart = $_SESSION['cart']; }						
if (isset($_SESSION['showCartIcon']) ) 		{ $showCartIcon = $_SESSION['showCartIcon']; } 		
if (isset($_SESSION['showLoginIcon']) ) 	{ $showLoginIcon = $_SESSION['showLoginIcon']; }	
if (isset($_SESSION['userEmail']) ) 		{ $userEmail = $_SESSION['userEmail']; }			
// init global variables | end

// page specific
$showCartIcon = true; 
$_SESSION['showCartIcon'] = $showCartIcon;

$showLoginIcon = true; 
$_SESSION['showLoginIcon'] = $showLoginIcon;

include 'inc/head.php';
include 'inc/header.php';
include 'inc/lib.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $msg = "";
    $proceed = TRUE;
	
	$pCode = $_POST["pCode"];
	$_SESSION["pCode"] = $pCode;

	$currentPage = $_POST["currentPage"];
	$_SESSION["currentPage"] = $currentPage;

    if ($currentPage == "products" & $pCode <> "") {
        header ("Location: product_details.php"); 
        exit;
	}
	
	if ($currentPage == "products_cart") {
        header ("Location: cart.php"); 
        exit;
    }
}



?>

<section class="global m50b">
	<h2 class="heading col">
		<span>Products</span>
	</h2>
</section>

<section class="products navcat p10t p10bt m50b">
	<div class="container">
		<div class="row justify-content-center align-items-center">
			<div class="col-auto button-group filters-button-group">
			  	<button class="button is-checked" data-filter="*">ALL</button>
			  	<button class="button" data-filter=".laptops">Laptops</button>
			  	<button class="button" data-filter=".hard-drive">Hard Drive</button>
			  	<button class="button" data-filter=".headphones">Headphones</button>
			  	<button class="button" data-filter=".tv">TV</button>
			</div>
		</div>
	</div>
</section>


<section class="products listing">
	<div class="container">
		<ul class="row grid offour">
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<input type="hidden" id="currentPage" name="currentPage" value="products">
		<input type="hidden" id="userEmail" name="userEmail" value="<?php echo $userEmail ;?>">
		<input type="hidden" id="userName" name="userName" value="<?php echo $userName ;?>">
		<?php

		$str = $category = $code = $name = $image = $desc = $price = "";
		$myfile = fopen("product.txt", "r") or die("Unable to open file!");

		// Output one line until end-of-file
		while(!feof($myfile)) {

			$str = "";
			$str = fgets($myfile);
			if (substr($str, 0, 1) <> "#") { 
			    list($category, $code, $brand, $name, $image, $desc, $price) = explode(";", $str.";;;;;");

		?>

			<!-- start loop -->

			<li class="element-item <?php echo slugify($category);?> col-3">
				<div>
					<div class="image has-image" style="background-image: url(images/<?php echo $image ;?>);">
					<input type="submit" id="pCode" name="pCode"  value="<?php echo $code; ?>">
					</div>
					<div class="content">
						<h5>
							<small><?php echo $brand ;?></small><br/>
							<?php echo $name ;?>

						</h5>
						<?php
						$aPrice = getFloatFromString($price);
						?>
						<h4><?php echo money_format('%i',$aPrice) ;?></h4>
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