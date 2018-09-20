<?php

function stripInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function getTimeStamp() {
    $x = "Last Saved : " . date("D j M Y G:i T");
    return $x;
}

?>