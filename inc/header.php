		
<?php
// init global variables | start
$cart = array ("rudi-wanyi-huani-john-ahdeiah" => 1);
$showCartIcon  = true;
$email = $name = "";
if (isset($_SESSION['name']) )              { $name = $_SESSION['name']; }     
if (isset($_SESSION['email']) )              { $email = $_SESSION['email']; }     
if (isset($_SESSION['cart']) )              { $cart = $_SESSION['cart']; }     
if (isset($_SESSION['showCartIcon']) )      { $showCartIcon = $_SESSION['showCartIcon']; }     

// init global variables | end

$showLoginIcon = true;

$showName = false;
if ($name <> "") {
	$showLoginIcon = false;
	$showName = true;
}

$hideCartItemCount = true;
if ($showCartIcon) {
	if (countCart($cart) > 0) {
		$hideCartItemCount = false;
	}
}

?>


<script>
function myFunction() {
    var x = document.getElementById("myCart");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
</script>


<header>
	<div class="container h-100">
		<div class="top row h-100 justify-content-between align-items-center">
					
			<div class="left col">
				<a href="index.php">
					<img src="images/logo.svg" id="logo" width="50px" height= "50px" />
				</a>
			</div>
			<nav class="right col d-flex justify-content-end">

			<a href="#" onclick="myFunction();" <?php if($hideCartItemCount) {?> style="display:none;" <?php } ?>>
				<div class="numberCircle"><?php echo countCart($cart) ;?>
					<div id="myCart" style="display:none;">
						<table id="miniCart" class="table table-bordered">
							<thead>
								<tr>
									<td align="left">Product</td>
									<td align="right">Price ($)</td>
								</tr>
							</thead>
							<tbody>
							<?php
							$cart = $_SESSION['cart'];
							$str = $category = $code = $name = $image = $desc = $price = "";
							$myfile = fopen("data/products.txt", "r") or die("Unable to open file!");
							$total = 0;
							while(!feof($myfile)) {
						    	$str = "";
						    	$str = fgets($myfile);
						    	if (substr($str, 0, 1) <> "#")  {
						      		list($category, $code, $brand, $name, $image, $desc, $price) = explode(";", $str.";;;;;");
						    
						        	if ($name <> "") {
						            	$quantity = 0;
						            	$inCart = false;
						            	foreach($cart as $productCode=>$numOrdered) {
						                	if ($code == $productCode) {
												$quantity = $numOrdered;
												$total = $total + ($quantity * getFloatFromString($price));
						                    	$inCart = true;
						                	}

						                	
										}
										if ($inCart) {
						                    echo '<tr>';
						                    echo '<td align="left">' . $name . '</td>';
						           
						                    $aPrice = getFloatFromString($price);
						                    
											echo '<td align="right">' . money_format('%i',$aPrice);
											if ($quantity > 1) {
												echo ' x ' . $quantity;
											}
											echo '</td>';
						                    echo '</tr>';
						                }
						        	}
						    	}
							}

							echo '<tr>';
						    echo '<td align="left"> Total: </td>';
						    echo '<td>' . money_format('%i',$total). '</td>';
							echo '</tr>';
											
							?>
							</tbody>
						</table>
						
					</div>
				</div>
			</a>

			<a href="cart.php" <?php if(!$showCartIcon) {?> style="display:none;" <?php } ?>><i class="fal fa-shopping-cart"></i> Cart</a>
			<a href="login.php" <?php if(!$showLoginIcon) {?> style="display:none;" <?php } ?>><i class="fal fa-sign-in"></i> Login</a>
			<a href="data.php" <?php if(!$showName) {?> style="display:none;" <?php } ?>><i class="fas fa-user"></i>&nbsp <?php echo $_SESSION['name']; ?></a>


			
			</nav>
					
		</div>

			

	</div>
</header>





		

