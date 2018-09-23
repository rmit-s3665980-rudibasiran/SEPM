		
<?php
// init global variables | start
$showCartIcon = $_SESSION['showCartIcon']; 
$name = $_SESSION['name'];
// init global variables | end

$showName = false;
if ($name <> "@" && $name <> "") {
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

			<a href="cart.php" <?php if(!$showCartIcon) {?> style="display:none;" <?php } ?>><i class="fal fa-shopping-cart"></i>&nbspCart</a>
			<a href="login.php" <?php if(!$showLoginIcon) {?> style="display:none;" <?php } ?>><i class="fal fa-sign-in"></i>&nbspLogin</a>
			<a href="data.php" <?php if(!$showName) {?> style="display:none;" <?php } ?>><i class="fas fa-user"></i>&nbsp<?php echo $name; ?></a>

	
			
			
			</nav>
					
		</div>
	</div>
</header>

		

