		
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


<style>


.numberCircle {
  border-radius: 50%;
  behavior: url(PIE.htc);
  width: 25px;
  height: 25px;
  padding: 5px;
  background: #fff;
  border: 1px solid #666;
  color: #666;
  text-align: center;
  font: 12px Arial, sans-serif; 
  
}

#myCart {
    width: 50%;
    height: 50%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    padding: 50px 0;
    text-align: left;
	background-color: $primary
	border: 1px solid #666;
    margin-top: 10px;
	margin-left: 200px;
	opacity: 1;
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

			<a href="#" onclick="myFunction();" <?php if($hideCartItemCount) {?> style="display:none;" <?php } ?>>
				<div class="numberCircle"><?php echo countCart($cart) ;?></div>
			</a>

			<a href="cart.php" <?php if(!$showCartIcon) {?> style="display:none;" <?php } ?>><i class="fal fa-shopping-cart"></i>
				&nbsp Cart &nbsp &nbsp </a>
			<a href="login.php" <?php if(!$showLoginIcon) {?> style="display:none;" <?php } ?>><i class="fal fa-sign-in"></i>&nbsp Login</a>
			<a href="data.php" <?php if(!$showName) {?> style="display:none;" <?php } ?>><i class="fas fa-user"></i>&nbsp &nbsp<?php echo $name; ?></a>

			
			</nav>
					
		</div>

			

	</div>

	<div id="myCart" style="display:none;">
	<table id="miniCart">
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
                    echo '<td>' . $name . '</td>';
           
                    $aPrice = getFloatFromString($price);
                    
					echo '<td>' . money_format('%i',$aPrice);
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
    echo '<td> Total: </td>';
    echo '<td>' . money_format('%i',$total). '</td>';
	echo '</tr>';
					
	?>
	</table>
	
	</div>
</header>



		

