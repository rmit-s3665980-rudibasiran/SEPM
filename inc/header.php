		
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

<style>
.numberCircle {
  border-radius: 50%;
  behavior: url(PIE.htc);
  width: 30px;
  height: 30px;
  padding: 5px;
  background: #fff;
  border: 1px solid #666;
  color: #666;
  text-align: center;
  font: 12px Arial, sans-serif;
}

</style>
<header>
	<div class="container h-100">
		<div class="top row h-100 justify-content-between align-items-center">
					
			<div class="left col">
				<a href="index.php">
					<img src="images/logo.svg" id="logo" width="50px" height= "50px" />
				</a>
			</div>
			<nav class="right col d-flex justify-content-end">

			<?php
				$showCartItemCount = false;
				if ($showCartIcon) {
					if (countCart($cart) > 0) {
						$showCartItemCount = true;
					}
				}
			?>
			
			<a href="" <?php if(!showCartItemCount) {?> style="display:none;" <?php } ?>>
				<div class="numberCircle"><?php echo countCart($cart) ;?></div>
			</a>

			<a href="cart.php" <?php if(!$showCartIcon) {?> style="display:none;" <?php } ?>><i class="fal fa-shopping-cart"></i>
				&nbsp Cart &nbsp &nbsp </a>
			<a href="login.php" <?php if(!$showLoginIcon) {?> style="display:none;" <?php } ?>><i class="fal fa-sign-in"></i>&nbsp Login</a>
			<a href="data.php" <?php if(!$showName) {?> style="display:none;" <?php } ?>><i class="fas fa-user"></i>&nbsp &nbsp<?php echo $name; ?></a>

			
			</nav>
					
		</div>
	</div>
</header>

		

