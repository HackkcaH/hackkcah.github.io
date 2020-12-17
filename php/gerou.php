<title>Inserindo login na database...</title>
<meta name="theme-color" content="#000000">
<meta name="msapplication-TileColor" content="#000000">
<meta charset="UTF-8">
<script src="../vendor/jquery/jquery-3.4.1.min.js"></script>
<?php
$token = $_POST['token'];

if($_COOKIE['token_gerar'] != $token){
  echo '<script language="javascript" type="text/javascript">alert("Token invalido, tente novemente!"); window.location.replace("/gerar.php");</script>';
  exit;
}

require_once($_SERVER['DOCUMENT_ROOT']."/php/pass.php");
require_once($_SERVER['DOCUMENT_ROOT']."/html/pages/system/seguranca.php");

$host = "localhost";
$db   = "painelhkh";
$user = "root";
$con = mysql_pconnect($host, $user, $pass);
mysql_select_db($db, $con);
session_start();

$debug = "0";

$loginssh = $_POST["loginssh"];
$senhassh = $_POST["senhassh"];
$servidor = $_POST["servidor"];
$op = $_POST["op"];
$dias = $_POST["dias"];
$limite = $_POST["limite"];
$datatual = date('Y-m-d H:i:s');
$validade = date("Y/m/d", strtotime("+$dias days"));
$validadef = date("d/m/Y", strtotime("+$dias days"));
$diretorio = $_POST["diretorio"];

sql('login', $loginssh);
if($op != "3"){ sql('login', $senhassh); } //bugando quando fica sem if
sql('numeros', $servidor);
sql('numeros', $dias);
sql('numeros', $limite);
sql('login', $op);

if($servidor == '99'){echo '<script type="text/javascript">alert("Você não pode gerar um login no servidor premium!");window.location.replace("/gerar.php")</script>'; exit;}

if(!isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
  $ip = $_SERVER['REMOTE_ADDR'];
}else{
  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}

$servidor= "SELECT * from servidor WHERE id_servidor='$servidor'";
$servidor = $conn->prepare($servidor);
$servidor->execute();
$servidor_info = $servidor->fetch();

if($op != "3"){
  $qtdatual = "SELECT status AS qtd FROM servicos WHERE servico = 'contas_geradas'";
  $qtdatual = mysql_query($qtdatual, $con);
  $qtdatual = mysql_fetch_assoc($qtdatual);
  $qtdatual = $qtdatual['qtd'];
  $qtdnovo = $qtdatual + "1";
  $qtdfinal = "UPDATE servicos SET status='$qtdnovo' WHERE servico='contas_geradas'";
  $qtdfinal = mysql_query($qtdfinal, $con);
  $qtdfinal;
}

if($op == "3"){
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            if($name == 'usuariogerado' || $name == 'validade'|| $name == 'token_gerar'|| $name == 'servidor'|| $name == 'senhagerado'|| $name == 'limite'|| $name == 'dias'){
              setcookie($name, '', time()-1000);
              setcookie($name, '', time()-1000, '/');
            }
        }
    }
  $inseremsgDB = "INSERT INTO free_log (data, login, senha, servidor, ip, tipo) VALUES ('".date('Y-m-d H:i:s')."', '$loginssh' , '$senhassh', '$servidor_info[id_servidor]', '$ip', 'del')";
  $inseremsgDB = mysql_query($inseremsgDB, $con);
  $inseremsgDB;
  $insereloginDB = "DELETE FROM usuario_ssh_free WHERE login='$loginssh' and id_servidor='$servidor_info[id_servidor]' ";
  $insereloginDB = mysql_query($insereloginDB, $con);
  $insereloginDB;
  echo '<script async language="javascript" type="text/javascript">window.location.replace("/");</script>';
}

if($op == "2"){
  //3600(1 hr) * 10hrs * dias
  if (isset($_SERVER['HTTP_COOKIE'])) {
      $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
      foreach($cookies as $cookie) {
          $parts = explode('=', $cookie);
          $name = trim($parts[0]);
          setcookie($name, '', time()-1000);
          setcookie($name, '', time()-1000, '/');
      }
  }
  setcookie("usuariogerado", $loginssh, strtotime('tomorrow 23:59'), "/");
  setcookie("senhagerado", $senhassh, strtotime('tomorrow 23:59'), "/");
  setcookie("servidor", $servidor_info['id_servidor'], strtotime('tomorrow 23:59'), "/");
  setcookie("dias", $dias, strtotime('tomorrow 23:59'), "/");
  setcookie("limite", $limite, strtotime('tomorrow 23:59'), "/");
  setcookie("validade", $validadef, strtotime('tomorrow 23:59'), "/");
  $inseremsgDB = "INSERT INTO free_log (data, login, senha, servidor, ip, tipo) VALUES ('".date('Y-m-d H:i:s')."', '$loginssh' , '$senhassh', '$servidor_info[id_servidor]', '$ip', 'renew')";
  $inseremsgDB = mysql_query($inseremsgDB, $con);
  $inseremsgDB;
  $insereloginDB = "UPDATE usuario_ssh_free set data_validade='$validade' WHERE login='$loginssh' and id_servidor='$servidor_info[id_servidor]' ";
  $insereloginDB = mysql_query($insereloginDB, $con);
  $insereloginDB;
  if ($insereloginDB == 1) {
    mysql_close($con);
    echo '<script async language="javascript" type="text/javascript">window.location.replace("/?u=1");</script>';
  }else{
    echo '<b>FALHA AO INSERIR LOGIN NA DATABASE CONTATE-ME NO TELEGRAM <b href="https://t.me/hackkkcah" target="_blank">CLICANDO AQUI</b> PARA OBTER SUPORTE.</b>';
    mysql_close($con);
  }
}

if($op == "1"){
  //3600=1hr 86.400=1dia
  setcookie("usuariogerado", $loginssh, strtotime('tomorrow 23:59'), "/");
  setcookie("senhagerado", $senhassh, strtotime('tomorrow 23:59'), "/");
  setcookie("servidor", $servidor_info['id_servidor'], strtotime('tomorrow 23:59'), "/");
  setcookie("dias", $dias, strtotime('tomorrow 23:59'), "/");
  setcookie("limite", $limite, strtotime('tomorrow 23:59'), "/");
  setcookie("validade", $validadef, strtotime('tomorrow 23:58'), "/");
  $inseremsgDB = "INSERT INTO free_log (data, login, senha, servidor, ip, tipo) VALUES ('".date('Y-m-d H:i:s')."', '$loginssh' , '$senhassh', '$servidor_info[id_servidor]', '$ip', 'new')";
  $inseremsgDB = mysql_query($inseremsgDB, $con);
  $inseremsgDB;
  $insereloginDB = "INSERT INTO usuario_ssh_free (status, id_usuario, id_servidor, login, senha,  data_validade, acesso) VALUES ('1', '1', '$servidor_info[id_servidor]', '".$loginssh."', '".$senhassh."', '".$validade."', '1' )";
  $insereloginDB = mysql_query($insereloginDB, $con);
  $insereloginDB;
  if ($insereloginDB == 1) {
    mysql_close($con);
    echo '<script async language="javascript" type="text/javascript">window.location.replace("/?u=1");</script>';
  }else{
    echo '<b>FALHA AO INSERIR LOGIN NA DATABASE CONTATE-ME NO TELEGRAM <b href="https://t.me/hackkkcah" target="_blank">CLICANDO AQUI</b> PARA OBTER SUPORTE.</b>';
    mysql_close($con);
  }
}

setcookie('token_gerar', '', time()-1000);

echo 'DEBUG:';                                echo '</br></br>';
echo "pagina: gerou";                         echo '</br>';
echo "op: $op";                               echo '</br>';
echo "user: $loginssh";                       echo '</br>';
echo "senha: $senhassh";                      echo '</br>';
echo "servidor: $servidor_info[ip_servidor]"; echo '</br>';
echo "dias: $dias";                           echo '</br>';
echo "valido ate: $validade";                 echo '</br></br></br>';

echo "EM CASO DE ERRO ME MANDE PRINT NO TELEGRAM";
?>
