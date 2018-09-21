		
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
	background-color: red;
	border: 1px;
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

					<a href="cart.php"><i class="fal fa-shopping-cart"></i>Cart</a>
					<a href="login.php" <?php if(!$showLogin) {?> style="display:none;" <?php } ?> ><i class="fal fa-sign-in"></i>Login</a>
					
					</nav>
				</div>
			</div>
		</header>

