
		
		
		<header>
			<div class="container h-100">
				<div class="row h-100 justify-content-between align-items-center">
					
					<div class="left col">
						<a class="" href="index.php">Logo</a>
					</div>
					<nav class="right col d-flex justify-content-end">

					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

						<a href="#" onClick="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><i class="fal fa-shopping-cart"></i> Cart</a>
					]
					<!--input type="submit" type = "button" id="cartBtn" name="cartBtn" value="Go to Cart" -->
					<input type="hidden" id="currentPage" name="currentPage" value="products_cart">
					<input type="hidden" id="userEmail" name="userEmail" value="<?php echo $userEmail ;?>">
					<input type="hidden" id="userName" name="userName" value="<?php echo $userName ;?>">
					<?php
					$cart = array("L101"=>3,"TV101"=>2);
					?>
					<input type="hidden" name="cart" value="<?php echo base64_encode(serialize($cart)); ?>" />
					</form>
					
						<a href="">
							<i class="fal fa-sign-in"></i> Login
						</a>
					</nav>
				</div>
			</div>
		</header>

