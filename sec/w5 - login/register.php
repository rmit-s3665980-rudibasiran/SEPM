<!DOCTYPE html>
<html>
	<head>
		<title>Lab 5 Register Confirm</title>
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

			input[type="submit"] { 
				height: 30px; padding: 8px 30px;
				display: inline-block; float: right; 
				border: 0; border-radius: 0;
				background-color: green; color: #fff;
			}
		</style>
	</head>
	<body>

		<section>
		<?php
			
			//Receive input from clint side
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			//check if the input exist
			$exist = 0;

			//read the file line by line
			foreach(file('users.txt') as $line) {
				//compare the content of the input and the line
				if($line == $username . "," . $password ."\n"){
					$exist = 1;
					break;
				}
			}
			
			if($exist == 1){
				echo "<h3>Error: Input Invalid/Exist.<br/><br/>Try again <a href='register.html'>here</a>.</h3>";
			}else{
				//open a file named "users.txt"
				$file = fopen("users.txt","a");
				//insert this input (plus a newline) into the users.txt
				fwrite($file, $username . "," . $password . "\n");
				//close the "$file"
				fclose($file);
				echo "<h3>Registration success!<br/><br/>Try again <a href='register.html'>here</a>.</h3>";
			}
		?>
		</section>

	</body>
</html>
