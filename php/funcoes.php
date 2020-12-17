<?php if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__)){ header('Location: /404'); }
include($_SERVER['DOCUMENT_ROOT']."/php/conecta.php");

//puxa users online premium
$userspremium = "SELECT sum(online) AS totalpremium FROM usuarios_online WHERE tipo='premium' ";
$userspremium = mysql_query($userspremium, $con);
$userspremium = mysql_fetch_assoc($userspremium);

//puxa users online free
$usersfree = "SELECT sum(online) AS totalfree FROM usuarios_online WHERE tipo='free' ";
$usersfree = mysql_query($usersfree, $con);
$usersfree = mysql_fetch_assoc($usersfree);

//servidores indivuduais
$sv1 = "SELECT online AS sv1 FROM usuarios_online WHERE id_servidor = 1";
$sv1 = mysql_query($sv1, $con);
$sv1 = mysql_fetch_assoc($sv1);

$sv3 = "SELECT online AS sv3 FROM usuarios_online WHERE id_servidor = 3";
$sv3 = mysql_query($sv3, $con);
$sv3 = mysql_fetch_assoc($sv3);

//puxa/checa nome user
if(isset($_SESSION['usuarioID'])){
  $usuario = "SELECT nome AS nickuser FROM usuario WHERE id_usuario = '".$_SESSION[usuarioID]."'";
  $usuario = mysql_query($usuario, $con);
  $usuario = mysql_fetch_assoc($usuario);
  $usuario = $usuario['nickuser'];
  $nick = substr ("$usuario", 0, 10);
  $check = $_SESSION['usuarioID'];
}

//simplifica strings
$sv1 = $sv1['sv1'];
$sv3 = $sv3['sv3'];
$userspremium = $userspremium['totalpremium'];
$usersfree = $usersfree['totalfree'];
$total = $usersfree + $userspremium;

mysql_close($con);
?>
