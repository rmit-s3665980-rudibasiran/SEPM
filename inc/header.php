		
<?php
include 'inc/global.php';
?>

<style>
.btn {
    background-color: black;
    color: white;
    padding: 8px 35px;
    border: none;
    cursor: pointer;
    width: 100%;
    opacity: 1;
	text-align: center;
	font-size: 16px;
	margin: 4px 2px;
    font-family: Arial, Helvetica, sans-serif;
}

.btn:hover {
    opacity: 0.7;
}
</style>
		
		<header>
			<div class="container h-100">
				<div class="row h-100 justify-content-between align-items-center">
					
					<div class="left col">
						<a href="index.php"><img src="images/logo.jpg" style="width:50px" /></a>
					</div>
					<nav class="right col d-flex justify-content-end">

					
					<!--
					<a href=""><i class="fal fa-shopping-cart"></i>Cart</a>
					-->
					
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<input type="submit" type = "button" id="cartBtn" name="cartBtn" class="btn" value="Go to Cart">
					<input type="hidden" id="currentPage" name="currentPage" value="products_cart">
					<input type="hidden" id="userEmail" name="userEmail" value="<?php echo $userEmail ;?>">
					<input type="hidden" id="userName" name="userName" value="<?php echo $userName ;?>">
					<?php
					$cart = array("L101"=>3,"TV101"=>2);
					?>
					<input type="hidden" name="cart" value="<?php echo base64_encode(serialize($cart)); ?>" />
					</form>
					&nbsp
					<!--
					<a href=""><i class="fal fa-sign-in"></i>Login</a>
					-->
					
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<input type="submit" type = "button" id="loginBtn"  <?php if(!$showLogin) {?> style="display:none;" <?php } ?>  
						name="loginBtn" class="btn" value="Login">
					<input type="hidden" id="currentPage" name="currentPage" value="products_login">
					<input type="hidden" id="userEmail" name="userEmail" value="<?php echo $userEmail ;?>">
					<input type="hidden" id="userName" name="userName" value="<?php echo $userName ;?>">
					<?php
					$cart = array("L101"=>3,"TV101"=>2);
					?>
					<?php
					$GLOBALS['showLogin'] = true;
					?>
					<input type="hidden" name="cart" value="<?php echo base64_encode(serialize($cart)); ?>" />
					</form>

					</nav>
				</div>
			</div>
		</header>

