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

if($_POST["check"] != "1"){
  echo '<script type="text/javascript">alert("Request negada!"); window.location.replace("/gerar.php")</script>';
  exit;
}

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
<form form data-toggle="validator" id="formm" action="gerar.php" method="POST" role="form">
<input type="hidden" name="check1" id="check1" class="form-control" value="1"></input>
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
  <div id="1" style="display:none;" class="alert alert-primary"><center><h3><i class="fas fa-user-tie" ></i>DEBUG: CONECTANDO AO SERVIDOR...AGUARDE...</center></div>
  <div id="2" style="display:none;" class="alert alert-danger"><center><h3><i class="fas fa-user-tie" ></i>FALHA AO SE CONECTAR NO SERVIDOR CONTATE UM ADMINISTRATOR.</center></div>

    <script>
    var myVar = setInterval(myTimer, 200);
    function myTimer(){
      document.getElementById("1").style.display = "block";
      myStopFunction();
    }
    function myStopFunction(){
      clearInterval(myVar);
    }

    var myVar1 = setInterval(myTimer1, 5000);
    function myTimer1(){
      document.getElementById("1").style.display = "none";
      document.getElementById("2").style.display = "block";
      myStopFunction1();
    }
    function myStopFunction1(){
      clearInterval(myVar1);
    }
    </script>

    </body>

<?php }else{ ?>
</br>
<body>

<div id="1" style="display:none;" class="alert alert-primary"><center><h3><i class="fas fa-user-tie" ></i>DEBUG: PASSOU EM TODAS VERIFICAÇÔES, PROSSEGUINDO...</center></div>
<div id="2" style="display:none;" class="alert alert-primary"><center><h3><i class="fas fa-user-tie" ></i>DEBUG: CONECTADO AO SERVIDOR!</center></div>
<div id="3" style="display:none;" class="alert alert-primary"><center><h3><i class="fas fa-user-tie" ></i>DEBUG: PROCESSANDO SUA REQUISIÇÃO...</center></div>

<?php if($op == "1"){ ?>
<div id="4" style="display:none;" class="alert alert-primary"><center><h3><i class="fas fa-user-tie" ></i>DEBUG: INSERINDO NOVO USUARIO NA DATABASE...</center></div>
<?php } ?>

<?php if($op == "2"){ ?>
<div id="4" style="display:none;" class="alert alert-primary"><center><h3><i class="fas fa-user-tie" ></i>DEBUG: RENOVANDO SEU ACESSO...</center></div>
<?php } ?>

<div id="5" style="display:none;" class="alert alert-primary"><center><h3><i class="fas fa-user-tie" ></i>DEBUG: REDIRECIONANDO, AGUARDE...</center></div>

<div id="6" style="display:none;" class="alert alert-danger"><center><h3><i class="fas fa-user-tie" ></i>DEBUG: ISTO ESTA DEMORANDO MAIS QUE O NORMAL...</center></div>
<div id="7" style="display:none;" class="alert alert-danger"><center><h3><i class="fas fa-user-tie" ></i>DEBUG: OCORREU UM ERRO TENTE NOVAMENTE MAIS TARDE!</center></div>

  <script>
  <?php if ($debug != "1") { ?>
  function pass() {
    document.getElementById("formm").submit();
  }
  <?php } ?>

  var myVar = setInterval(myTimer, 100);
  function myTimer(){
    document.getElementById("1").style.display = "block";
    clearInterval(myVar);
  }

  var myVar1 = setInterval(myTimer1, 1500);
  function myTimer1(){
    document.getElementById("1").style.display = "none";
    document.getElementById("2").style.display = "block";
    clearInterval(myVar1);
  }

  var myVar2 = setInterval(myTimer2, 3500);
  function myTimer2(){
    document.getElementById("2").style.display = "none";
    document.getElementById("3").style.display = "block";
    clearInterval(myVar2);
  }

  var myVar3 = setInterval(myTimer3, 5500);
  function myTimer3(){
    document.getElementById("3").style.display = "none";
    document.getElementById("4").style.display = "block";
    clearInterval(myVar3);
  }

  var myVar4 = setInterval(myTimer4, 7500);
  function myTimer4(){
    document.getElementById("4").style.display = "none";
    document.getElementById("5").style.display = "block";
    clearInterval(myVar4);
    pass();
  }

  var myVar5 = setInterval(myTimer5, 30000);
  function myTimer5(){
    document.getElementById("6").style.display = "block";
    clearInterval(myVar5);
  }

  var myVar6 = setInterval(myTimer6, 50000);
  function myTimer6(){
    document.getElementById("5").style.display = "none";
    document.getElementById("6").style.display = "none";
    document.getElementById("7").style.display = "block";
    clearInterval(myVar6);
  }
  </script>

    <?php require($_SERVER['DOCUMENT_ROOT']."/php/ads.php"); require($_SERVER['DOCUMENT_ROOT']."/php/ads.php");?>
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
