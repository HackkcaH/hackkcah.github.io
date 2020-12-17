<?php

if($_GET["Estouhackeando"] != 0 || $_GET["Estouhackeando"] == null){
  echo '<input disabled value="Não me hackeia sou do bem fiz nada de errado 🥺" style="color: pink; background-color: white;" class="form-control"></input>';
  exit;
}

require($_SERVER['DOCUMENT_ROOT']."/html/pages/system/seguranca.php");
require($_SERVER['DOCUMENT_ROOT']."/html/pages/system/classe.ssh.php");
require($_SERVER['DOCUMENT_ROOT']."/html/pages/system/config.php");

$name = $_GET["name"];
$senha = $_GET["senha"];
$premium = $_GET["premium"];

sql('login', $name);
sql('login', $senha);

if($name == null || $senha == null){
  echo '<input disabled value="Não foi possivel concluir sua solicitação" style="color: red; background-color: white;" class="form-control"></input>';
  exit;
}

if($premium == 1){
  $SQLServidor1 = "SELECT * FROM usuario_ssh where login='$name' and senha='$senha' ";
}else{
  $SQLServidor1 = "SELECT * FROM usuario_ssh_free where login='$name' and senha='$senha' ";
}
$SQLServidor1 = $conn->prepare($SQLServidor1);
$SQLServidor1->execute();
$row1 = $SQLServidor1->fetch();

$SQLServidor = "SELECT * FROM servidor where id_servidor='$row1[id_servidor]' ";
$SQLServidor = $conn->prepare($SQLServidor);
$SQLServidor->execute();
$row = $SQLServidor->fetch();

$connection = ssh2_connect($row['ip_servidor'], 22);
if($premium == 1){
  if (ssh2_auth_password($connection, $name, $senha)) {
    echo '<input disabled value="O usuario esta funcionando." style="color: green;" class="form-control"></input>';
  }else{
    echo '<input disabled value="O usuario esta com problema tente renovar para corrigir." style="color: red;" class="form-control"></input>';
  }
}else{
  if (ssh2_auth_password($connection, $name, $senha)) {
    echo '<input disabled value="O usuario esta funcionando." style="color: green; background-color: white;" class="form-control"></input>';
  }else{
    echo '<input disabled value="O usuario esta com problema tente renovar para corrigir." style="color: red; background-color: white;" class="form-control"></input>';
  }
}
