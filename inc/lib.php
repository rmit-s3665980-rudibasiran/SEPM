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

function slugify ($string) {
  $string = utf8_encode($string);
  $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);   
  $string = preg_replace('/[^a-z0-9- ]/i', '', $string);
  $string = str_replace(' ', '-', $string);
  $string = trim($string, '-');
  $string = strtolower($string);

  if (empty($string)) {
    return 'n-a';
  }

  return $string;
}

?>