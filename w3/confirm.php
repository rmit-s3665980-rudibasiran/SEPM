<!DOCTYPE html>
<html>
<head>
	<title>Confirmation</title>
	<style type="text/css">
		html, body {
			font-family: Helvetica, Arial, san-serif;
			background-color: #eee;
		}

		section {
			position: absolute; top: 50%; left: 50%;
			transform: translate(-50%,-50%);
			width: 50%;
		}

		form, table { width: 100%; }

		table { 
			background-color: white; 
			border-spacing: 1px;
			border-color: #eee;
		}

		th, td { padding-left: 10px; padding-right: 10px; height: 50px; }

		th {
			background-color: #111;
			color: #fff; text-align: left;
		}

		form table tbody > tr:last-child td { 
			background-color: tomato; 
			color: #fff;
		}

		input {
			height: 20px; padding: 5px;
		}
	</style>
</head>
<body>
	<?php //var_dump($_POST);?>
	<section>
		<h1>Customer Confirmation</h1>
		<form>
			<table>
				<thead>
					<tr>
						<th>Products</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Subtotal</th>
					</tr>
				</thead>
				<tbody>
					<tr>
					    <td>Product A
					        <input type="hidden" name="ProductA" id="ProductA" value="ProductA" />
					    </td>
					    <td>$10
					        <input type="hidden" name="ProductAprice" id="ProductAprice" value="10" /></td>
					    <td>
					        <?php echo $_POST['ProductAquantity'] ;?>
					    </td>
					    <td>
					        $<span id="ProductAsubtotal"><?php echo $_POST['ProductAtotal'] ;?></span>
					    </td>
					</tr>
					<tr>
					    <td>Product B
					        <input type="hidden" name="ProductB" id="ProductB" value="ProductB" />
					    </td>
					    <td>$15
					        <input type="hidden" name="ProductBprice" id="ProductBprice" value="15" />
					    </td>
					    <td>
					        <?php echo $_POST['ProductBquantity'] ;?>
					    </td>
					    <td>
					        $<span id="ProductBsubtotal"><?php echo $_POST['ProductBtotal'] ;?></span>
					    </td>
					</tr>
					<tr>
					    <td>Product C
					        <input type="hidden" name="ProductC" id="ProductC" value="ProductC" />
					    </td>
					    <td>$20
					        <input type="hidden" name="ProductCprice" id="ProductCprice" value="20" />
					    </td>
					    <td>
					        <?php echo $_POST['ProductCquantity'] ;?>
					    </td>
					    <td>
					        $<span id="ProductCsubtotal"><?php echo $_POST['ProductCtotal'] ;?></span>
					    </td>
					</tr>
					<tr>
					    <td colspan="2">Total</td>
					    <td>
					        <span id="Quantity"><?php echo $_POST['total'] ;?></span>
					    </td>
					    <td>
					        $<span id="Price"><?php echo $_POST['totalPrice'] ;?></span>
					    </td>
					</tr>
				</tbody>
			</table>
		</form>			
	</section>

	<script type="text/javascript">

		var calcSubTotal = function(productName) {

		    var quantity = parseInt(document.getElementById(productName + 'quantity').value);
		    if (quantity > 0) {
		        var price = parseInt(document.getElementById(productName + 'price').value);
		        var subtotal = price * quantity;
		        document.getElementById(productName + "subtotal").innerHTML = subtotal;
		        document.getElementById(productName + "total").value = subtotal;
		        return subtotal;
		    }
		    document.getElementById(productName + "subtotal").innerHTML = 0;
		    document.getElementById(productName + "total").value = 0;
		    return 0;
		}

		function updateCart() {

		    var total = calcSubTotal('ProductA') + calcSubTotal('ProductB') + calcSubTotal('ProductC');

		    var quantity = parseInt(document.getElementById('ProductAquantity').value) + parseInt(document.getElementById('ProductBquantity').value) + parseInt(document.getElementById('ProductCquantity').value);

		    document.getElementById("Quantity").innerHTML = quantity;
		    document.getElementById("totalQuantity").value = quantity;

		    document.getElementById("Price").innerHTML = total;
		    document.getElementById("totalPrice").value = total;

		}

	</script>

	
	</body>
</html>