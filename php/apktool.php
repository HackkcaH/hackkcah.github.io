<?php
include_once($_SERVER['DOCUMENT_ROOT']."/html/pages/system/seguranca.php");
include_once($_SERVER['DOCUMENT_ROOT']."/html/pages/system/config.php");
include_once($_SERVER['DOCUMENT_ROOT']."/html/pages/system/classe.class.php");

protegePagina("user");
session_start();

shell_exec("bash /root/teste3.sh ".$_SESSION['usuarioID']." ".$pass."");

echo '<script type="text/javascript">';
echo 'alert("APK GERADO");';
echo 'window.location="'.$_POST['diretorio'].'";';
echo '</script>';
exit;
?>
