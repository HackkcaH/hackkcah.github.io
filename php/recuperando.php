<?php if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__)){ header('Location: /404'); }
require_once($_SERVER['DOCUMENT_ROOT']."/php/conecta.php");
require_once($_SERVER['DOCUMENT_ROOT']."/html/pages/system/seguranca.php");
$login = sql("", $_GET["login"]);
$email = sql("", $_GET["email"]);
$teste = "1";
if($_GET["tipo"] == "1"){
if (isset($_GET["login"])) {
    $server = "localhost";
    $user = "root";
    $base = "painelhkh";
    $conexao = mysql_connect($server, $user, $pass) or die("Erro na conexão!");
    mysql_select_db($base);
    $SQLverifica = "SELECT * FROM usuario WHERE login='$login'";
    $SQLverifica = mysql_query($SQLverifica, $con);
    $login = mysql_num_rows($SQLverifica);
    echo $login;
}}
if($_GET["tipo"] == "2"){
if (isset($_GET["email"])) {
    $server = "localhost";
    $user = "root";
    $base = "painelhkh";
    $conexao = mysql_connect($server, $user, $pass) or die("Erro na conexão!");
    mysql_select_db($base);
    $SQLverifica = "SELECT * FROM usuario WHERE login='$login' and email='$email'";
    $SQLverifica = mysql_query($SQLverifica, $con);
    $login = mysql_num_rows($SQLverifica);
    $dadosuser = mysql_fetch_assoc($SQLverifica);
    $login;
        if($login == '0'){
          // echo 'nada encontrado';
          exit;
        }
        if($login == '1'){
          include($_SERVER['DOCUMENT_ROOT']."/php/conecta.php");
          include($_SERVER['DOCUMENT_ROOT']."/php/class.phpmailer.php");
          include($_SERVER['DOCUMENT_ROOT']."/php/class.smtp.php");
        $mail = new PHPMailer();
        $smtp = "SELECT * FROM smtp";
        $smtp = mysql_query($smtp, $con);
        $smtp = mysql_fetch_assoc($smtp);
        $data_envio = date('d/m/Y');
        $hora_envio = date('H:i:s');
        $empresanome = "HackkcaH VPN";
        $empresaemail = "suporte@hackkcah.xyz";
        $login = $dadosuser['login'];
        $senha = $dadosuser['senha'];
          if(isset($login)==false){ echo '<script type="text/javascript">alert("Digite um login!");</script>'; exit; }
          if(isset($senha)==false){ echo '<script type="text/javascript">alert("Digite uma senha!");</script>'; exit; }
          $assunto="Recuperação Conta";
          $corpo = "
          </br><b>Recuperação de Acesso Painel SSH</b> - <b><i>$empresanome</i></b></br>
          <b>Seus Dados de Login</b>:
          </br></br>
          <b>Email</b>: $email </br>
          <b>Login</b>: $login </br>
          <b>Senha</b>: $senha </br>
            </br></br>
            <b>1.</b>Duvidas e Suporte Entre em Contato com <a href='$empresaemail'>$empresaemail.</a><br />
            <b>2.</b>Caso não tenha Feito esta solicitação entre em contato imediatamente com nosso suporte<br />
            <hr></br>
            Este e-mail foi enviado em <b>$data_envio</b> &agrave;s <b>$hora_envio ";
        $de=explode("@",$email);
        $destinatario=strtoupper($de[0]);
        $mail->IsSMTP();
        $mail->SMTPSecure = $smtp['ssl_secure'];
        $mail->Host = $smtp['servidor'];
        $mail->Port = $smtp['porta'];
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->Username = $smtp['email'];
        $mail->Password = $smtp['senha'];
        $mail->From = $smtp['email']; # Seu e-mail
        $mail->FromName = $empresaname; // Seu nome
        $assunto="$assunto - $empresanome";
        $mail->Subject = $assunto; # Assunto da mensagem
        $mail->AddAddress($email,$destinatario);
        $mail->IsHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Body = $corpo;
        if (!$mail->send()) {
            // echo 'Mailer Error: '. $mail->ErrorInfo;
            echo 'falha';
        } else {
            // echo 'Message sent!';
            echo 'enviado';
        }
      }
    }
  }
?>
