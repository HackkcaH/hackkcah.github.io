<?php
include_once($_SERVER['DOCUMENT_ROOT']."/html/pages/system/seguranca.php");

if($_GET['a'] == null){
  if($_GET['premium'] == 1){
    $app = '2';
  }else{
    $app = '1';
  }
}

$id = $_GET['i'];
if($id == null){
  $id = '0';
}

$arquivo= "SELECT last_id_file from files WHERE id='$app' and app='99' ";
$arquivo = $conn->prepare($arquivo);
$arquivo->execute();
$arquivo = $arquivo->fetch();
$arquivo = explode(';', $arquivo['last_id_file']);

$text = $arquivo[$id];

$newtext = wordwrap($text, 2500, "</br>", true);
$newtext1 = explode('</br>', $newtext);
shell_exec("rm -f /var/www/php/break1 && touch /var/www/php/break1");
$n = 0;
while($newtext1[$n] != null){
  if($_GET['premium'] == 1){
    $final = 'public static String d1'.$n.' = "'.$newtext1[$n].'";';
  }else{
    $final = 'public static String d'.$n.' = "'.$newtext1[$n].'";';
  }
  shell_exec('echo '.$final.' >> /var/www/php/break1');
  echo "$final</br>\n";
  $n++;
}
?>
