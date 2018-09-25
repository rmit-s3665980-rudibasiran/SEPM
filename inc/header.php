		
<?php
// init global variables | start
$name = $_SESSION['name'];
$cart = $_SESSION['cart'];
// init global variables | end

$showLoginIcon = true;
$showName = false;
if ($name <> "") {
	$showLoginIcon = false;
	$showName = true;
}
?>
		
<header>
	<div class="container h-100">
		<div class="top row h-100 justify-content-between align-items-center">
					
			<div class="left col">
				<a href="index.php">
					<img src="images/logo.svg" id="logo" width="50px" height= "50px" />
				</a>
			</div>
			<nav class="right col d-flex justify-content-end">

			<a href="cart.php" <?php if(!$showCartIcon) {?> style="display:none;" <?php } ?>><i class="fal fa-shopping-cart"></i>
				&nbspCart <?php echo "[". countCart($cart) ."]" ;?>  </a>
			<a href="login.php" <?php if(!$showLoginIcon) {?> style="display:none;" <?php } ?>><i class="fal fa-sign-in"></i>&nbspLogin</a>
			<a href="data.php" <?php if(!$showName) {?> style="display:none;" <?php } ?>><i class="fas fa-user"></i>&nbsp &nbsp<?php echo $name; ?></a>

	
			
			
			</nav>
					
		</div>
	</div>
</header>

		

