<?php
require_once($_SERVER['DOCUMENT_ROOT']."/html/pages/system/seguranca.php");
require_once($_SERVER['DOCUMENT_ROOT']."/html/pages/system/config.php");
$_POST["tipo"] = "revenda";
$_POST["celular"] = "(11) 99999-9999";
$login = sql("login", $_POST["login"]);
$senha = sql("login", $_POST["senha"]);
$nome = sql("login", $_POST["nome"]);
$_POST["email"] = "$nome@hackkcah.xyz";
	function geraToken(){
    $salt = "123456ABCDER";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = 0;
    while($i <= 7){
      $num = rand() % 10;
			$tmp = substr($salt, $num, 1);
			$pass = $pass . $tmp;
		 	 $i++;
			}
		return $pass;
	}
	$data =  date("Y-m-d H:i:s");
	$token = geraToken();
  if((isset($_POST["login"])) and (isset($_POST["nome"])) and (isset($_POST["senha"]))  and (isset($_POST["tipo"]))  and (isset($_POST["celular"])) ){
    $SQLUsuario = "SELECT * from usuario WHERE login = '".$_POST['login']."' ";
    $SQLUsuario = $conn->prepare($SQLUsuario);
    $SQLUsuario->execute();
    if(($SQLUsuario->rowCount()) > 0){
    echo '<script type="text/javascript">';
    echo 	'alert("O usuario '.$_POST['login'].' ja existe!");';
    echo	'window.location="/?u=5";';
    echo '</script>';
    }else{
      $owner = $_SESSION['usuarioID'];
      $msg="Conta revendedor <small><b>".$_POST[login]."</b></small> criada via cadastro!";
      $insere_notif = "INSERT INTO notificacoes (usuario_id,data,tipo,linkfatura,mensagem,info_outros) values ('0','".date('Y-m-d H:i:s')."','conta','n/d','".$msg."','Conta Criada')";
      $insere_notif = $conn->prepare($insere_notif);
      $insere_notif->execute();
      $SQLUsuario = "INSERT INTO usuario (atualiza_dados, email, login, senha, data_cadastro, tipo, nome, celular, token_user, avatar, validade) VALUES ('1', '".$_POST['email']."', '".$_POST['login']."', '".$_POST['senha']."',  '$data', '".$_POST['tipo']."', '".$_POST['nome']."', '".$_POST['celular']."', '{$token}', '".rand(1, 4)."', '0' )";
      $SQLUsuario = $conn->prepare($SQLUsuario);
      $SQLUsuario->execute();
			$SQLUsuario = "SELECT id_usuario from usuario WHERE login = '".$_POST['login']."' ";
	    $SQLUsuario = $conn->prepare($SQLUsuario);
	    $SQLUsuario->execute();
			$SQLUsuario = $SQLUsuario->fetch();
			$idusuario = $SQLUsuario['id_usuario'];
			$online = 		 	 "0;0;0;0;0;0;0;0;0;0;-1";
			$criados = 		   "0;0;0;0;0;0;0;0;0;0;-1";
			$servidores =  	 "0;0;0;0;0;0;0;0;0;0;-1";
			$solic_trocas =  "0;0;0;0;0;0;0;0;0;0;-1";
			$addinfo = "INSERT INTO graficos (id_usuario, online, criadas, servidores, trocas) VALUES ('$idusuario', '$online', '$criados', '$servidores', '$solic_trocas')";
			$addinfo = $conn->prepare($addinfo);
			$addinfo->execute();
			echo '<script language="javascript" type="text/javascript">alert("O usuario '.$_POST['login'].' foi criado com sucesso!"); window.location.replace("/?u=3");</script>';exit;
    }
  }else{
		echo '<script language="javascript" type="text/javascript">alert("Preencha todos os campos!"); window.location.replace("/?u=5");</script>';exit;
  } ?>
