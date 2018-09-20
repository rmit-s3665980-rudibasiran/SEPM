

<?php
setlocale(LC_MONETARY,"en_AU");
error_reporting(0);
session_start();

include 'inc/head.php';
include 'inc/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $msg = "";
    $proceed = TRUE;


	$_SESSION['currentPage'] = $_POST;
	$_SESSION['userEmail'] = $_POST;
	$_SESSION['userName'] = $_POST;
	$_SESSION['cart'] = $_POST;
	$_SESSION['loginType'] = $_POST;
	$_SESSION['pCode'] = $_POST;
	
	$pCode = $_POST["pCode"];
	$currentPage = $_POST["currentPage"];
	
    if ($currentPage == "products" & $pCode <> "") {

        header ("Location: product_details.php"); 
        exit;
	}
	
	if ($currentPage == "products" & $pCode <> "") {
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

        <input type="hidden" id="loginType" name="loginType" value="new">
		<input type="hidden" id="currentPage" name="currentPage" value="products">
		<input type="hidden" id="userEmail" name="userEmail" value="<?php echo $userEmail ;?>">
		<input type="hidden" id="userName" name="userName" value="<?php echo $userName ;?>">
		<?php $cart=array("L101"=>3,"TV101"=>2);?>
		<input type="hidden" id="cart" name="cart" value="<?php echo $cart ;?>">
		
		
		<?php

		$str = $category = $code = $name = $image = $desc = $price = "";
		$myfile = fopen("product.txt", "r") or die("Unable to open file!");
		$count = 0;

		
          
            
       

		// Output one line until end-of-file
			while(!feof($myfile)) {

				$str = "";
			  	$str = fgets($myfile);
			    $count++;
			    if ($count <> 1) { 
			    	list($category, $code, $brand, $name, $image, $desc, $price) = explode(";", $str.";;;;;");

			    	?>

			<!-- start loop -->

			<li class="element-item <?php echo slugify($category);?> col-3">
				<div>
					<div class="image has-image" style="background-image: url(images/<?php echo $image ;?>);">
					<input type="submit" type = "button" id="pCode" name="pCode" value="<?php echo $code; ?>">
					</div>
					<div class="content">
						<h5>
							<small><?php echo $brand ;?></small><br/>
							<?php echo $name ;?>

						</h5>
						<h4><?php echo money_format('%i',$price) ;?></h4>
					</div>
				</div>
			</li>

 			
			<!-- end loop -->
			<?php } } fclose($myfile); ?>
			</form>

		</ul>
	</div>
</section>


<?php
	function slugify ($string) {
    $string = utf8_encode($string);
    $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);   
    $string = preg_replace('/[^a-z0-9- ]/i', '', $string);
    $string = str_replace(' ', '-', $string);
    $string = trim($string, '-');
    $string = strtolower($string);

    if (empty($string)) {
        return 'n-a';
    }

    return $string;
}?>


<?php include('inc/footer.php');?>
<?php include('inc/foot.php');?>