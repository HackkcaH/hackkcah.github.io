<?php
include_once($_SERVER['DOCUMENT_ROOT']."/html/pages/system/seguranca.php");

$vendedor = $_GET['vendedor'];

if($vendedor != null){
  sql('numeros', $vendedor);
  $arquivo= "SELECT * from infos_app WHERE id_vendedor='$vendedor' ";
  $arquivo = $conn->prepare($arquivo);
  $arquivo->execute();
  $dados = $arquivo->fetch();
  if($dados[dados] != null){
    echo "$dados[dados]";
  }else{
    echo "Nenhuma informação encontrada;https://google.com;Nenhuma informação encontrada;Nenhuma informação encontrada;Nenhuma informação encontrada";
  }
  exit;
}else{
  echo "Nenhuma informação encontrada;https://google.com;Nenhuma informação encontrada;Nenhuma informação encontrada;Nenhuma informação encontrada";
  exit;
}

// msg
// link
// preços
// pq comprar
// texto sobre
