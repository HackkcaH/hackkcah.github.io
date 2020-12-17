<title>Gerando login...</title>
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

require_once($_SERVER['DOCUMENT_ROOT']."/html/pages/system/classe.ssh.php");
require_once($_SERVER['DOCUMENT_ROOT']."/php/ips.php");
require_once($_SERVER['DOCUMENT_ROOT']."/php/pass.php");
require_once($_SERVER['DOCUMENT_ROOT']."/html/pages/system/seguranca.php");
session_start();

$nomeescolhido = $_POST['loginssh'];
$loginssh = "$nomeescolhido";
$senhassh = $_POST['senhassh'];
$servidor = $_POST['servidor'];
$op = $_POST['op'];
$diretorio = $_POST["diretorio"];
// $dias = $_POST['dias'];
// $limite = $_POST['limite'];
$dias = "2";
$limite = "1";
$validade = date("Y/m/d", strtotime("+$dias days"));
$loginantigo = $_COOKIE['usuariogerado'];
$servidorantigo = $_COOKIE['servidor'];

if($op != 3){
  if($_POST["check1"] != "1"){
    echo '<script type="text/javascript">alert("Request negada!"); window.location.replace("/gerar.php")</script>';
    exit;
  }
}

sql('login', $loginssh);
sql('login', $senhassh);
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
$debug = "0";
?>
<script>
function usuariojaexiste() {alert("Este usuário já existe. Crie um usuário com outro nome"); <?php if ($debug == "0") { echo 'window.location.replace("/gerar.php");'; } ?> }
function nomeusuarioinvalido() {alert("Você digitou um nome de usuário inválido! Use apenas letras, números, pontos e traços."); <?php if ($debug == "0") { echo 'window.location.replace("/gerar.php");'; } ?>}
function nomeususariocurto() {alert("Você digitou um nome de usuário muito curto use no mínimo 6 caracteres!"); <?php if ($debug == "0") { echo 'window.location.replace("/gerar.php");'; } ?>}
function nomeusuariolongo() {alert("Você digitou um nome de usuário muito grande use no máximo 32 caracteres!"); <?php if ($debug == "0") { echo 'window.location.replace("/gerar.php");'; } ?>}
function nomeusuarioembranco() {alert("Você digitou um nome de usuário vazio!"); <?php if ($debug == "0") { echo 'window.location.replace("/gerar.php");'; } ?>}
function senhavazia() {alert("Você digitou uma senha vazia!"); <?php if ($debug == "0") { echo 'window.location.replace("/gerar.php");'; } ?>}
function senhacurta() {alert("Você digitou uma senha muito curta! Para manter o usuário seguro use no mínimo 6 caracteres."); <?php if ($debug == "0") { echo 'window.location.replace("/gerar.php");'; } ?>}
function diasinvalido() {alert("Você digitou um número de dias inválido!"); <?php if ($debug == "0") { echo 'window.location.replace("/gerar.php");'; } ?>}
function diasvazio() {alert("Você deixou o número de dias para a conta expirar vazio!"); <?php if ($debug == "0") { echo 'window.location.replace("/gerar.php");'; } ?>}
function diascurto() {alert("Você deve digitar um número de dias maior que zero!"); <?php if ($debug == "0") { echo 'window.location.replace("/gerar.php");'; } ?>}
function numerosdeconexaologin() {alert("Você digitou um número de conexões inválido!"); <?php if ($debug == "0") { echo 'window.location.replace("/gerar.php");'; } ?>}
function numerodeconxaovazio() {alert("Você deixou o número de conexões simultâneas vazio!"); <?php if ($debug == "0") { echo 'window.location.replace("/gerar.php");'; } ?>}
function numeroconexaomaiorquezero() {alert("Você deve digitar um número de conexões simultâneas maior que zero!"); <?php if ($debug == "0") { echo 'window.location.replace("/gerar.php");'; } ?>}
function criadocomsucesso() {document.getElementById("formm").submit();}
</script>
<?php if ($debug == "0") { echo '
<form form data-toggle="validator" id="formm" action="/php/gerou.php" method="POST" role="form">
<input type="hidden" name="loginssh" id="loginssh" class="form-control" value="'.$loginssh.'"></input>
<input type="hidden" name="senhassh" id="senhassh" class="form-control" value="'.$senhassh.'"></input>
<input type="hidden" name="servidor" id="servidor" class="form-control" value="'.$servidor.'"></input>
<input type="hidden" name="limite" id="limite" class="form-control" value="'.$limite.'"></input>
<input type="hidden" name="dias" id="dias" class="form-control" value="'.$dias.'"></input>
<input type="hidden" name="op" id="op" class="form-control" value="'.$op.'"></input>
<input type="hidden" name="token" id="token" class="form-control" value="'.$token.'"></input>
<input type="hidden" name="diretorio" id="diretorio" class="form-control" value="'.$diretorio.'">
</form> '; }

$servidor= "SELECT * from servidor WHERE id_servidor='$servidor'";
$servidor = $conn->prepare($servidor);
$servidor->execute();
$servidor_info = $servidor->fetch();

$ip_servidorSSH = $servidor_info['ip_servidor'];
$loginserver = $servidor_info['login_server'];
$senhaserver = $servidor_info['senha'];
$ssh = new SSH2($ip_servidorSSH);
$ssh->auth($loginserver,$senhaserver);

if($op == "1"){
  if(isset($loginantigo)){
    $host = "localhost";
    $db   = "painelhkh";
    $user = "root";
    $con = mysql_pconnect($host, $user, $pass);
    mysql_select_db($db, $con);
    $deleta = "DELETE FROM usuario_ssh_free WHERE login = '".$loginantigo."'";
    $deleta = mysql_query($deleta, $con);
    $deleta;
    $ssh->exec("./remover.sh ".$loginantigo."");
    $ssh->output();
    $inseremsgDB = "INSERT INTO free_log (data, login, senha, servidor, ip, tipo) VALUES ('".date('Y-m-d H:i:s')."', '$loginantigo' , '$senhassh', '$servidor_info[id_servidor]', '$ip', 'del')";
    $inseremsgDB = mysql_query($inseremsgDB, $con);
    $inseremsgDB;
  }
  $ssh->exec("./criarusuario.sh ".$loginssh." ".$senhassh." ".$dias." ".$limite."");
  $resultado = (string) $ssh->output();
}

if ($op == "2"){
  $connection = ssh2_connect($servidor_info['ip_servidor'], 22);
  if (ssh2_auth_password($connection, $loginssh, $senhassh)) {
    $teste_login = 'pass';
    $ssh->exec("./alterardata.sh ".$loginssh." ".$dias."");
    $resultado = (string) $ssh->output();
  }else{
    $teste_login = 'erro';
    $ssh->exec("./criarusuario.sh ".$loginssh." ".$senhassh." ".$dias." ".$limite."");
    $resultado = (string) $ssh->output();
  }
}

if ($op == "3"){
  $ssh->exec("pkill -u ".$loginssh."");
  $ssh->output();
  $ssh->exec("./remover.sh ".$loginssh."");
  $ssh->output();
  $resultado = "20";
}

if ($resultado == 0) {echo '<script language="javascript" type="text/javascript">usuariojaexiste();</script>'; }
if ($resultado == 1) {echo '<script language="javascript" type="text/javascript">nomeusuarioinvalido();</script>'; }
if ($resultado == 2) {echo '<script language="javascript" type="text/javascript">nomeususariocurto();</script>';}
if ($resultado == 3) {echo '<script language="javascript" type="text/javascript">nomeusuariolongo();</script>';}
if ($resultado == 4) {echo '<script language="javascript" type="text/javascript">nomeusuarioembranco();</script>';}
if ($resultado == 5) {echo '<script language="javascript" type="text/javascript">senhavazia();</script>';}
if ($resultado == 6) {echo '<script language="javascript" type="text/javascript">senhacurta();</script>';}
if ($resultado == 7) {echo '<script language="javascript" type="text/javascript">diasinvalido();</script>';}
if ($resultado == 8) {echo '<script language="javascript" type="text/javascript">diasvazio();</script>';}
if ($resultado == 9) {echo '<script language="javascript" type="text/javascript">diascurto();</script>';}
if ($resultado == 10) {echo '<script language="javascript" type="text/javascript">numerosdeconexaologin();</script>';}
if ($resultado == 11) {echo '<script language="javascript" type="text/javascript">numerodeconxaovazio();</script>';}
if ($resultado == 12) {echo '<script language="javascript" type="text/javascript">numeroconexaomaiorquezero();</script>';}
if ($resultado == 13) {echo '<script language="javascript" type="text/javascript">criadocomsucesso();</script>';}
if ($resultado == 20) {echo '<script language="javascript" type="text/javascript">criadocomsucesso();</script>';}
if ($resultado == 30) {echo '<script language="javascript" type="text/javascript">criadocomsucesso();</script>';}
if ($resultado == 31) {echo '<script language="javascript" type="text/javascript">criadocomsucesso();</script>';}

echo 'DEBUG:';                                  echo '</br></br>';
echo "pagina: gerar";                           echo '</br>';
echo "op: $op";                                 echo '</br>';
echo "user: $loginssh";                         echo '</br>';
echo "senha: $senhassh";                        echo '</br>';
echo "servidor: $servidor_info[ip_servidor]";   echo '</br>';
echo "dias: $dias";                             echo '</br>';
echo "valido ate: $validade";                   echo '</br>';
echo "teste r: $teste_login";                   echo '</br>';
echo "resposta sv: $resultado";                 echo '</br></br></br>';

echo "EM CASO DE ERRO ME MANDE PRINT NO TELEGRAM";
?>
