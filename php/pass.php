<?php
if (strpos($_SERVER['PHP_SELF'], "/var/www/") === 0) { }else{
  if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__)){ header('Location: /404'); }
}
$pass = '123';
$pass1 = '456';
?>
