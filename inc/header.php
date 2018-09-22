		
<?php
// init global variables | start
$showCartIcon = $_SESSION['showCartIcon']; 
$showLoginIcon = $_SESSION['showLoginIcon'];
// init global variables | end
?>
		
		<header>
			<div class="container h-100">
				<div class="top row h-100 justify-content-between align-items-center">
					
					<div class="left col">
						<a href="index.php">
							<img src="images/logo.svg" id="logo" />
						</a>
					</div>
					<nav class="right col d-flex justify-content-end">

					<a href="cart.php" <?php if(!$showCartIcon) {?> style="display:none;" <?php } ?>><i class="fal fa-shopping-cart"></i>Cart</a>
					<a href="login.php" <?php if(!$showLoginIcon) {?> style="display:none;" <?php } ?> ><i class="fal fa-sign-in"></i>Login</a>
					
					</nav>
				</div>
			</div>
		</header>

		

