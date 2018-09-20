<?php
	require "scssphp/scss.inc.php";
	require "scssphp/example/Server.php";
	
	use Leafo\ScssPhp\Server;

	$directory = "sass";

	$server = new Server($directory);
	$server->serve();
?>