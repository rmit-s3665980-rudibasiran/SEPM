<?php
setlocale(LC_MONETARY,"en_AU");
error_reporting(0);
session_start();

include 'inc/head.php';
include 'inc/header.php';

?>

<?php
// notes about arrays
$age=array("Peter"=>"35","Ben"=>"37","Joe"=>"43");
// echo "Peter is " . $age['Peter'] . " years old.";
?>

<?php
$age=array("Peter"=>"35","Ben"=>"37","Joe"=>"43");

foreach($age as $x=>$x_value)
  {
  // echo "Key=" . $x . ", Value=" . $x_value;
  // echo "<br>";
  }
?>


<?php include('inc/footer.php');?>
<?php include('inc/foot.php');?>
