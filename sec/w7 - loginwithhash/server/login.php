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
		<?php

			//Receive user input from clint side
			$username = $_POST['username'];
			$password = $_POST['password'];

			//check if the input exist
			$exist = 0;

			//read the file line by line
			foreach(file('../database/users.txt') as $line) {
				//compare the content of the input and the line
				if($line == $username . "," . $password ."\n"){
					$exist = 1;
					break;
				}
			}
			
			if($exist == 1){
				echo "<h3>Login success!<br/><br/>Try again <a href='../client/login.html'>here</a>.</h3>";
			}else{
				echo "<h3>Username/password incorrect.<br/><br/>Try again <a href='../client/login.html'>here</a>.</h3>";
			}
		?>
	</body>
</html>
