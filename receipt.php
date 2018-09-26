<?php
session_start();
$showReceipt = true;
$_SESSION["showReceipt"] = $showReceipt;
$receiptNo = "1234";
$_SESSION["receiptNo"] = $receiptNo;

header ("Location: cart.php"); 
exit;

?>
