<html>
	<head>
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

			form table tbody > tr.green td { 
				background-color: tomato; 
				color: #fff;
			}

			input {
				-webkit-appearance: none;
				box-shadow: none;
				height: 30px; width: 100%;
				border: 1px solid #aaa;
				outline: none;
			}

			button[type="submit"] { 
				height: 30px; padding: 8px 30px;
				display: inline-block; float: right; 
				border: 0; border-radius: 0;
				background-color: green; color: #fff;
			}
		</style>
	</head>
	<body>
		<section>
			<h1>Lab 7: DES Encryption with PHP</h1>
			<?php

				// STEP 1 receive user input from clint side
				$key = $_POST['key'];
				$message = $_POST['message'];

				// STEP 2 include des.php
				include 'des.php';

				// STEP 3 des.php performs encryption function
				$ciphertext = php_des_encryption($key, $message);

				// STEP 4 des.php performs decryption function
				$recovered_message = php_des_decryption($key, $ciphertext);

				//check if the input exist
				$exist = 0;

				//read the file line by line
				foreach(file('../database/database.txt') as $line) {
					//compare the content of the input and the line
					if($line == $recovered_message ."\n"){
						$exist = 1;
						break;
					}
				}
				
				if($exist == 1){
					echo "<h3>Error: Input Invalid/Exist.<br/><br/>Try again <a href='../client/client.html'>here</a>.</h3>";
				}else{
					//open a file named "database.txt"
					$file = fopen("../database/database.txt","a");
					//insert this input (plus a newline) into the users.txt
					fwrite($file, $recovered_message . "\n");
					//close the "$file"
					fclose($file);
					echo "<h3>Success!<br/><br/>Try again <a href='../client/client.html'>here</a>.</h3>";
				}

			?>

			<table>
				<tbody>
					<tr>
						<td>Secret Key: <?php echo $key;?></td>
						<td>Secret Message: <?php echo $message;?></td>
					</tr>
					<tr>
						<td colspan="2">DES encrypted message: <?php echo $ciphertext;?></td>
					</tr>
					<tr>
						<td colspan="2">DES decrypted message: <?php echo $recovered_message;?></td>
					</tr>
				</tbody>
			</table>
		</section>
	</body>
</html>
