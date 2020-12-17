<title>Conectando ao servidor...</title>
<meta name="theme-color" content="#000000">
<meta name="msapplication-TileColor" content="#000000">
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="/vendor/bootstrap/css/bootstrap.min.css">
<script data-ad-client="ca-pub-1062888170747622" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<style> body { background: black; } </style>
<?php
$ads = '1';
$debug = "0";
session_start();
$token = $_POST['token'];
if($_COOKIE['token_gerar'] != $token){echo '<script language="javascript" type="text/javascript">alert("Token invalido, tente novemente!"); window.location.replace("/gerar.php");</script>';exit;}
$nomeescolhido = $_POST['loginssh'];
$loginssh = "$nomeescolhido";
$senhassh = $_POST['senhassh'];
$servidor = $_POST['servidor'];
$diretorio = $_POST["diretorio"];
$op = $_POST['op'];
$limite = "1";
$dias = "2";
if(!isset($loginssh) || $loginssh == '' || $loginssh == '0'){echo '<script type="text/javascript">alert("Usuario em branco!");window.location.replace("/gerar.php")</script>'; exit;}
if(!isset($senhassh) || $senhassh == '' || $senhassh == '0'){echo '<script type="text/javascript">alert("Senha em branco!");window.location.replace("/gerar.php")</script>'; exit;}
if(!isset($servidor) || $servidor == '' || $servidor == '0'){echo '<script type="text/javascript">alert("Selecione um servidor!");window.location.replace("/gerar.php")</script>'; exit;}
if($servidor == '99'){echo '<script type="text/javascript">alert("Você não pode gerar um login no servidor premium!");window.location.replace("/gerar.php")</script>'; exit;}
require_once($_SERVER['DOCUMENT_ROOT']."/html/pages/system/seguranca.php");
sql('login', $loginssh);
sql('login', $senhassh);
sql('numeros', $servidor);
sql('numeros', $dias);
sql('numeros', $limite);
sql('login', $op);
if(strlen($loginssh) < 6){
  echo '<script type="text/javascript">alert("Usuario deve ter mais que 6 caracteres!"); window.location.replace("/gerar.php")</script>';
  exit;
}
if(strlen($senhassh) < 6){
  echo '<script type="text/javascript">alert("Senha deve ter mais que 6 caracteres!"); window.location.replace("/gerar.php")</script>';
  exit;
}
$fail = '0';
if($op == "1"){
$host = "localhost"; $db = "painelhkh"; $user = "root";
$con = mysql_pconnect($host, $user, $pass); mysql_select_db($db, $con);
$result = mysql_query("SELECT * FROM usuario_ssh_free WHERE login = '".$nomeescolhido."'", $con);
$num_rows = mysql_num_rows($result);
if($num_rows > "0"){echo '<script type="text/javascript">alert("Ja existe um usuario com este nome!");window.location.replace("/gerar.php")</script>'; exit; }
}
if($loginssh != ""){
echo '
<form form data-toggle="validator" id="formm" action="waitroom2.php" method="POST" role="form">
<input type="hidden" name="check" id="check" class="form-control" value="1"></input>
<input type="hidden" name="loginssh" id="loginssh" class="form-control" value="'.$loginssh.'"></input>
<input type="hidden" name="senhassh" id="senhassh" class="form-control" value="'.$senhassh.'"></input>
<input type="hidden" name="limite" id="limite" class="form-control" value="'.$limite.'"></input>
<input type="hidden" name="servidor" id="servidor" class="form-control" value="'.$servidor.'"></input>
<input type="hidden" name="dias" id="dias" class="form-control" value="'.$dias.'"></input>
<input type="hidden" name="op" id="op" class="form-control" value="'.$op.'"></input>
<input type="hidden" name="token" id="token" class="form-control" value="'.$token.'"></input>
<input type="hidden" name="diretorio" id="diretorio" class="form-control" value="'.$diretorio.'">
</form>';
require($_SERVER['DOCUMENT_ROOT']."/php/ads.php");
require($_SERVER['DOCUMENT_ROOT']."/php/ads.php");
$servidor= "SELECT * from servidor WHERE id_servidor='$servidor'";
$servidor = $conn->prepare($servidor);
$servidor->execute();
$servidor_info = $servidor->fetch();
$servidor_info1 = $servidor->rowCount();
if($servidor_info1 != "1"){
  echo '<script type="text/javascript">alert("Use a opção de gerar uma nova conta para atualizar os dados em cache apos isso você podera usar a opção de renovar/apagar conta!");window.location.replace("/gerar.php")</script>'; exit;
}
if($fp = fsockopen($servidor_info['ip_servidor'], '22', $errCode, $errStr, 5)){
  $fail = '0';
}else{
  $fail = '1';
}
if($fail == "1"){ ?>
  </br>
  <body>
  <div id="1" style="display:none;" class="alert alert-primary"><center><h3><i class="fas fa-user-tie" ></i>DEBUG: CHECANDO O SERVIDOR...AGUARDE...</center></div>
  <div id="2" style="display:none;" class="alert alert-danger"><center><h3><i class="fas fa-user-tie" ></i>FALHA AO SE CONECTAR NO SERVIDOR CONTATE UM ADMINISTRATOR.</center></div>
    <script>
    var myVar = setInterval(myTimer, 200);
    function myTimer(){
    document.getElementById("1").style.display = "block";
    myStopFunction(); }
    function myStopFunction(){ clearInterval(myVar); }
    var myVar1 = setInterval(myTimer1, 5000);
    function myTimer1(){
    document.getElementById("1").style.display = "none";
    document.getElementById("2").style.display = "block";
    myStopFunction1(); }
    function myStopFunction1(){ clearInterval(myVar1); }
    </script>
    </body>
<?php }else{ ?>
</br>
<script src='https://www.google.com/recaptcha/api.js' defer></script>
<script>
    function callValidation(){
        if(grecaptcha.getResponse().length != 0){
          confirma1();
          myStopFunction20();
        }
    }
    var myVar20 = setInterval(myTimer20, 200);
    function myTimer20(){ callValidation(); }
    function myStopFunction20(){ clearInterval(myVar20); }
</script>
<body>
<div id="1" style="display:none;" class="alert alert-primary"><center><h3><i class="fas fa-user-tie" ></i>DEBUG: CHECANDO O SERVIDOR...AGUARDE...</center></div>
<div id="2" style="display:none;" class="alert alert-primary"><center><h3><i class="fas fa-user-tie" ></i>DEBUG: SERVIDOR OK!</center></div>
<div id="3" style="display:none;" class="alert alert-primary"><center><h3><i class="fas fa-user-tie" ></i>DEBUG: ENVIANDO SOLICITAÇÂO...</center></div>
<div id="4" style="display:none;" class="alert alert-primary"><center><h3><i class="fas fa-user-tie" ></i>DEBUG: AGUARDANDO RESPOSTA...</center></div>
<div id="5" style="display:none;" class="alert alert-primary"><center><h3><i class="fas fa-user-tie" ></i>DEBUG: CHECANDO USER...</center></div>
<div id="6" style="display:none;" class="alert alert-primary"><center><h3><i class="fas fa-user-tie" ></i>DEBUG: COLOCANDO SOLICITAÇÃO NA FILA...</center></div>
<div id="7" style="display:none;" class="alert alert-primary"><center><h3><i class="fas fa-user-tie" ></i>RESOLVA O CAPTCHA PARA CONTINUAR!</br><div class="g-recaptcha" data-sitekey="6LeB4MsUAAAAAKUTlUNOn18iAf44mYp_rNKQhEzQ"></div></center></div>
<div id="72" style="display:none;" class="alert alert-primary"><center><h3><i class="fas fa-user-tie" ></i>
  <style>
  button.btn.btn-success {
    margin-top: 15px;
    transform: scale(1.5);
  }
  </style>
  PARA CONTINUAR CONFIRME SUA SOLICITAÇÃO! </br></br>
  <?php if($op == "1"){
    $validade = date('d/m/Y', strtotime("+2 days"));
    echo "CRIAR UMA CONTA NOVA"; echo '</br>';
    echo "IP Servidor: $servidor_info[ip_servidor]"; echo '</br>';
    echo "Validade: $validade"; echo '</br>';
    echo "Usuario: $loginssh"; echo '</br>';
    echo "Senha: $senhassh"; echo '</br>'; echo '</br>';
   } ?>
   <?php if($op == "2"){
     $validade = date('d/m/Y', strtotime("+2 days"));
     echo "RENOVAR CONTA EXISTENTE"; echo '</br>';
     echo "IP Servidor: $servidor_info[ip_servidor]"; echo '</br>';
     echo "Validade: $validade"; echo '</br>';
     echo "Usuario: $loginssh"; echo '</br>';
     echo "Senha: $senhassh"; echo '</br>'; echo '</br>';
    } ?>
    <a onclick="confirma()"><button type="button" class="btn btn-success">Confirmar solicitação</button></a>
  </center></br>
  Your token: <?php echo $token; ?> </div>
<div id="71" style="display:none;" class="alert alert-primary"><center><h3><i class="fas fa-user-tie" ></i>DEBUG: REDIRECIONANDO, AGUARDE...</center></div>
<div id="8" style="display:none;" class="alert alert-danger"><center><h3><i class="fas fa-user-tie" ></i>DEBUG: ISTO ESTA DEMORANDO MAIS QUE O NORMAL...</center></div>
<div id="9" style="display:none;" class="alert alert-danger"><center><h3><i class="fas fa-user-tie" ></i>DEBUG: OCORREU UM ERRO TENTE NOVAMENTE MAIS TARDE!</center></div>
  <script>
  <?php if ($debug != "1") { ?>
  function pass() {document.getElementById("formm").submit();}
  <?php } ?>
  var myVar = setInterval(myTimer, 200);
  function myTimer(){
  document.getElementById("1").style.display = "block";
  myStopFunction(); }
  function myStopFunction(){ clearInterval(myVar); }
  var myVar1 = setInterval(myTimer1, 1500);
  function myTimer1(){
  document.getElementById("1").style.display = "none";
  document.getElementById("2").style.display = "block";
  myStopFunction1(); }
  function myStopFunction1(){ clearInterval(myVar1); }
  var myVar2 = setInterval(myTimer2, 3500);
  function myTimer2(){
  document.getElementById("2").style.display = "none";
  document.getElementById("3").style.display = "block";
  myStopFunction2(); }
  function myStopFunction2(){ clearInterval(myVar2); }
  var myVar3 = setInterval(myTimer3, 5500);
  function myTimer3(){
  document.getElementById("3").style.display = "none";
  document.getElementById("4").style.display = "block";
  myStopFunction3(); }
  function myStopFunction3(){ clearInterval(myVar3); }
  var myVar4 = setInterval(myTimer4, 7500);
  function myTimer4(){
  document.getElementById("4").style.display = "none";
  document.getElementById("5").style.display = "block";
  myStopFunction4(); }
  function myStopFunction4(){ clearInterval(myVar4); }
  var myVar5 = setInterval(myTimer5, 9500);
  function myTimer5(){
  document.getElementById("5").style.display = "none";
  document.getElementById("6").style.display = "block";
  myStopFunction5(); }
  function myStopFunction5(){ clearInterval(myVar5); }
  var myVar6 = setInterval(myTimer6, 11000);
  function myTimer6(){
  document.getElementById("6").style.display = "none";
  document.getElementById("7").style.display = "block";
  myStopFunction6(); }
  function myStopFunction6(){ clearInterval(myVar6); }
  function confirma1(){
    document.getElementById("7").style.display = "none";
    document.getElementById("72").style.display = "block";
  }
  function confirma(){
    <?php if ($debug != "1") { ?> pass(); <?php }?>
    var myVar7 = setInterval(myTimer7, 10);
    function myTimer7(){
    document.getElementById("72").style.display = "none";
    document.getElementById("71").style.display = "block";
    myStopFunction7(); }
    function myStopFunction7(){ clearInterval(myVar7); }
    var myVar9 = setInterval(myTimer9, 60000);
    function myTimer9(){
    document.getElementById("71").style.display = "none";
    document.getElementById("9").style.display = "block";
    myStopFunction9(); }
    function myStopFunction9(){ clearInterval(myVar9); }
  }
  </script>
    <?php require($_SERVER['DOCUMENT_ROOT']."/php/ads.php");
          require($_SERVER['DOCUMENT_ROOT']."/php/ads.php");?>
    </body>
<?php }
 }else{ ?>
  <script type="text/javascript">alert("Preencha todos os campos!");window.location.replace("/gerar.php")</script>
<?php }
if ($debug == "1") {
echo 'DEBUG ATIVO'; echo '</br></br>';
echo "user: $loginssh"; echo '</br>';
echo "senha: $senhassh"; echo '</br>';
echo "servidor: $ipfinal"; echo '</br>';
echo "dias: $dias"; echo '</br>';  }
?>
