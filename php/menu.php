<?php if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__)){ header('Location: /404'); }
include($_SERVER['DOCUMENT_ROOT']."/php/pass.php");
include($_SERVER['DOCUMENT_ROOT']."/php/conecta.php");

if(isset($_SESSION['usuarioLogin'])){
  $eadmin = "SELECT * FROM admin WHERE login='$_SESSION[usuarioLogin]' and senha='$_SESSION[usuarioSenha]' ";
  $eadmin = mysql_query($eadmin, $con);
  $eadmin = mysql_num_rows($eadmin);
}else{
  $eadmin = 0;
}

if(isset($_COOKIE['usuariogerado'])){
  $loginexiste = "SELECT * from usuario_ssh_free WHERE login='$_COOKIE[usuariogerado]' and senha='$_COOKIE[senhagerado]' and id_servidor='$_COOKIE[servidor]' ";
  $loginexiste = mysql_query($loginexiste, $con);
  $loginexiste = mysql_num_rows($loginexiste);
  if($loginexiste != 1){
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
   echo '<script async language="javascript" type="text/javascript">alert("Sua conta gerada não foi encontrada ou foi deletada por um moderador!"); window.location.replace("/");</script>';
  }
}
if (!isset($check) == false) {
if($_SESSION['usuarioID'] == "1" and $_SESSION['usuarioLogin'] == "root" and $_SESSION['usuarioSenha'] == $pass){ $_SESSION['tipo'] = 'admin'; }
$usuario = "SELECT * FROM usuario WHERE id_usuario = '".$_SESSION['usuarioID']."'";
$usuario = mysql_query($usuario, $con);
$usuario = mysql_fetch_assoc($usuario);
$solic_trades = "SELECT * FROM solic_trades WHERE id_usuario_para = '$_SESSION[usuarioID]'";
$solic_trades = mysql_query($solic_trades, $con);
$solic_trades = mysql_num_rows($solic_trades);
$solic_trades = 0 + $solic_trades;
if($usuario['avatar'] == "1" || $usuario['avatar'] == "2" || $usuario['avatar'] == "3" || $usuario['avatar'] == "4" || $usuario['avatar'] == "5"){
  switch($usuario['avatar']){
    case 1:$avatarusu="/html/dist/img/avatar1.png";break;
    case 2:$avatarusu="/html/dist/img/avatar2.png";break;
    case 3:$avatarusu="/html/dist/img/avatar3.png";break;
    case 4:$avatarusu="/html/dist/img/avatar4.png";break;
    case 5:$avatarusu="/html/dist/img/avatar5.png";break;
    default:$avatarusu="/html/dist/img/boxed-bg.png";break; }
}else{ $avatarusu = '/html/uploads/profile_images/'.$usuario['avatar'].'';}
if($usuario['tipo'] == "revenda"){$rank = 'Revendedor';}
if($usuario['tipo'] == "vpn"){$rank = 'Usuário VPN';}
if($usuario['ativo'] == '2'){$rank = "Conta Suspensa";}
if($usuario['login'] == "testeuser") {$rank = 'Conta Teste';}
if($_SESSION['tipo'] != "admin"){
  if($usuario['validade_dias'] <= "0") {$rank = 'Conta Suspensa';}
}
if($eadmin == '1'){
  if($usuario['login'] == "root"){
     $rank = 'Dono';
    }else{
     $rank = 'Admin';
    }
}
}else{
$avatarusu="/html/dist/img/avatar1.png";
} ?>
<style>
.dropdown-item {
    font-size: 18px;
}
.sidebar-wrapper1 {
    font-size: 17px;
}
#nomelogo{
  background: linear-gradient(180deg, black, black, black, black, black, transparent);
  -webkit-box-shadow: 1px 0 5px rgba(0, 0, 0, 0.1);
  box-shadow: 1px 0 5px rgba(0, 0, 0, 0.1);
}
div#toggle-sidebar {
    height: 42px;
}
.user-status span z {
    font-weight: 900;
}
</style>
<ul id=nomelogo><p><li><a style="color: white;" href="/">HackkcaH VPN­</a></li></ul>
<div id="fundomenu"> </div>
<input type="checkbox" id="navicon">
<div id="toggle-sidebar" class="nav-toggle1"><label for="navicon" class="hamburger1"><span></span><span></span><span></span></label></div>
    <div class="page-wrapper default-theme sidebar-bg bg1">
        <nav id="sidebar" class="sidebar-wrapper1">
            <div class="sidebar-content">
                <div class="sidebar-item sidebar-brand">
                    <a href="#">HackkcaH VPN</a>
                </div>
                <?php if (!isset($check) == false) { ?>
                  <div class="sidebar-item sidebar-header d-flex flex-nowrap">
                      <div>
                          <img id="circulofoto" src="<?php echo "$avatarusu"; ?>" alt="">
                      </div>&nbsp &nbsp
                      <div class="user-info">
                          <span class="user-name"><?php echo "$nick"; ?></span>
                          <span class="user-role"><?php echo "$rank"; ?></span>
                          <?php
                          if($usuario['validade_dias'] > 1){
                            $validade_texto = "Dias";
                          }else{
                            $validade_texto = "Dia";
                          }
                          if($_SESSION['tipo'] != "admin"){
                            if($usuario['ativo'] != '2'){echo '
                              <span class="user-status"><i class="fa fa-circle"></i><span>Online</span></br></br>
                              <span class="user-status"><span>Vence em: <z>'.$usuario['validade_dias'].'</z> '.$validade_texto.'</span>';
                            }else{
                              echo '<span class="user-status"><i style="color:red;" class="fa fa-circle"></i><span>Offline</span>';
                            }
                          }else{
                            echo '<span class="user-status"><i class="fa fa-circle"></i><span>Online</span>';
                          } ?>
                          </span>
                      </div>
                  </div>
                  <div class=" sidebar-item sidebar-menu">
                      <ul>
                        <li>
                            <a href="/html/sair.php">
                                <i class="fas fa-sign-out-alt"></i>
                                <span class="menu-text">Deslogar</span>
                            </a>
                        </li>
                      </div>
                <?php }else{ ?>
                  <div class="sidebar-item sidebar-header d-flex flex-nowrap">
                    <div>
                        <img id="circulofoto" src="/images/profile_placeholder.gif" alt="">
                    </div>&nbsp &nbsp
                      <div class="user-info">
                          <span class="user-name">Guest</span>
                        </br></br>
                      </div>
                  </div>
                  <div class=" sidebar-item sidebar-menu">
                      <ul>
                        <li>
                            <a onclick="mostrarlogin()">
                                <i class="fas fa-sign-in-alt"></i>
                                <span class="menu-text">Fazer login</span>
                            </a>
                        </li>
                        </div>
                <?php } ?>
                <div class=" sidebar-item sidebar-menu">
                    <ul>
                        <li class="header-menu">
                            <span>Menu</span>
                        </li>
                        <li>
                            <a href="/">
                                <i class="fas fa-home"></i>
                                <span class="menu-text">Pagina Inicial</span>
                            </a>
                        </li>
                        <li>
                            <a href="/index.php#two">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="menu-text">Comprar login premium</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown">
                            <a>
                                <i class="fas fa-info-circle"></i>
                                <span class="menu-text">Status Serviços</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                  <li><a href="/status.php?s=1">Servidores premium</a></li>
                                  <li><a href="/status.php?s=2">Servidores free</a></li>
                                  <li><a href="/status.php?s=3">Outros serviços</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-dropdown">
                            <a>
                                <i class="fas fa-user-shield"></i>
                                <span class="menu-text">Admin Menu</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                  <li><a href="/html/phpmyadmin">PHP My Admin</a></li>
                                  <li><a target="_blank" href="https://webmail.umbler.com">Mail server</a></li>
                                  <li><a href="/webmin/">WebMin</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-dropdown">
                            <a>
                                <i class="fas fa-user"></i>
                                <span class="menu-text">Users Menu</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                  <li><a href="/arquivos.php">Arquivos</a></li>
                                  <li><a href="/forum" target="_blank">Forum <span class="badge badge-pill badge-primary">Beta</span></a></li>
                                  <li><a href="/gerar.php">Gerar Conta</a></li>
                                  <?php if (!isset($check) == false) { ?>
                                  <li><a href="/html/home.php">Painel SSH</a></li>
                                  <?php }else{ ?>
                                  <li><a onclick="mostrarlogin2()">Painel SSH</a></li>
                                  <?php } ?>
                                </ul>
                            </div>
                        </li>

                        <li>
                            <a data-toggle="modal" data-target="#parceiros" onclick="ocultatudo()">
                                <i class="far fa-handshake"></i>
                                <span class="menu-text">Parceiros</span>
                            </a>
                        </li>

                        <li>
                            <a href="/speedtest.php">
                                <i class="fas fa-tachometer-alt"></i>
                                <span class="menu-text">SpeedTest</span>
                            </a>
                        </li>

                        <li>
                            <a target="_blank" href="https://hackkcah.github.io/">
                                <i class="far fa-address-card"></i>
                                <span class="menu-text">Sobre Min</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php if (!isset($check) == false) { ?>
            <div class="sidebar-footer">
                <div>
                    <a href="/html/sair.php">
                        <i style="font-size: 18px;" class="fa fa-power-off"></i>
                    </a>
                </div>
                <div class="pinned-footer">
                    <a href="#">
                        <i class="fas fa-ellipsis-h"></i>
                    </a>
                </div>
            </div>
          <?php }else{ ?>
            <div class="sidebar-footer">
                <div><a href="#"></a></div>
                <div class="pinned-footer"><a href="#"><i class="fas fa-ellipsis-h"></i></a></div>
            </div>
          <?php } ?>
        </nav>
    </div>
