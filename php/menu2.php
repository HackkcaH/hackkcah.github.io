<?php if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__)){ header('Location: /404'); }
session_start();
$eadmin = "SELECT * FROM admin WHERE login='$_SESSION[usuarioLogin]' and senha='$_SESSION[usuarioSenha]' ";
$eadmin = $conn->prepare($eadmin);
$eadmin->execute();
$eadmin = $eadmin->rowCount(); ?>
<link rel="stylesheet" type="text/css" href="/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="/css/login.css">
<link rel="stylesheet" href="/vendor/CustomScrollBar/jquery.mCustomScrollbar.min.css">
<link rel="stylesheet" href="/css/menu.css">
<script src="/vendor/jquery/jquery-3.4.1.min.js"></script>
<script src="/vendor/CustomScrollBar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/js/login.js"></script>
<script src="/js/menulateral.js"></script>
<script>
function submitadmin(){ window.location.href = "/html/home.php?alternar=admin"; }
function submituser() { window.location.href = "/html/home.php?alternar=user"; }
</script>
<?php
if($eadmin == '1'){
  if(isset($_GET['alternar'])){
    if($_GET['alternar'] == "admin"){
      $_SESSION['tipo'] = "admin";
      header("Location: /html/home.php");
      exit;
    }else{
      $_SESSION['tipo'] = "user";
      header("Location: /html/home.php");
      exit;
    }
  }
}
include($_SERVER['DOCUMENT_ROOT']."/php/funcoes.php");
if (!isset($check) == false) {
  include($_SERVER['DOCUMENT_ROOT']."/php/conecta.php");
  $usuario = "SELECT * FROM usuario WHERE id_usuario = '".$_SESSION['usuarioID']."'";
  $usuario = mysql_query($usuario, $con);
  $usuario = mysql_fetch_assoc($usuario);
  if($usuario['avatar'] == "1" || $usuario['avatar'] == "2" || $usuario['avatar'] == "3" || $usuario['avatar'] == "4" || $usuario['avatar'] == "5"){
    switch($usuario['avatar']){
      case 1:$avatarusu="/html/dist/img/avatar1.png";break;
      case 2:$avatarusu="/html/dist/img/avatar2.png";break;
      case 3:$avatarusu="/html/dist/img/avatar3.png";break;
      case 4:$avatarusu="/html/dist/img/avatar4.png";break;
      case 5:$avatarusu="/html/dist/img/avatar5.png";break;
      default:$avatarusu="/html/dist/img/boxed-bg.png";break; }
  }else{$avatarusu = '/html/uploads/profile_images/'.$usuario['avatar'].'';}
  if($usuario['tipo'] == "revenda"){$rank = 'Revendedor';}
  if($usuario['tipo'] == "vpn"){$rank = 'Usuário VPN';}
  if($usuario['ativo']==2){$rank = "Conta Suspensa";}
  if($usuario['login'] == "testeuser") {$rank = 'Conta Teste';}

  if($_SESSION['tipo'] != "admin"){
    if($usuario['subrevenda'] == "sim"){
      $donorevenda = "SELECT * FROM usuario WHERE id_usuario = '$usuario[id_mestre]' ";
      $donorevenda = mysql_query($donorevenda, $con);
      $donorevenda = mysql_fetch_assoc($donorevenda);
      if($donorevenda['validade_dias'] <= "0"){
        $rank = 'Conta Suspensa';
      }else{
        $rank = 'Sub-revendedor';
      }
    }else{
      if($usuario['validade_dias'] <= "0") {$rank = 'Conta Suspensa';}
    }
  }

  if($eadmin == '1'){
    if($usuario['login'] == "root"){
       $rank = 'Dono';
      }else{
       $rank = 'Admin';
      }
  }
  if ($_SERVER["REQUEST_URI"] == "/html/home.php"){
    $todas_contas_online = "SELECT sum(online) AS online FROM usuarios_online where tipo='premium'";
    $todas_contas_online = $conn->prepare($todas_contas_online);
    $todas_contas_online->execute();
    $todas_contas_online = $todas_contas_online->fetch();
    $todas_contas_online = $todas_contas_online['online'];
    $todas_contas_online = $todas_contas_online + 0;
    $todas_contas_online_free = "SELECT sum(online) AS online FROM usuarios_online where tipo='free'";
    $todas_contas_online_free = $conn->prepare($todas_contas_online_free);
    $todas_contas_online_free->execute();
    $todas_contas_online_free = $todas_contas_online_free->fetch();
    $todas_contas_online_free = $todas_contas_online_free['online'];
    $todas_contas_online_free = $todas_contas_online_free +0;
    $contas_online_total = $todas_contas_online + $todas_contas_online_free;
  }
  if($_SESSION['tipo'] == "admin"){
        $todas_revendedores = "SELECT * FROM usuario";
        $todas_revendedores = $conn->prepare($todas_revendedores);
        $todas_revendedores->execute();
        $todas_revendedores = $todas_revendedores->rowCount();
        $todas_revendedores = $todas_revendedores + 0;
        $contas_criadas2 = "SELECT * FROM usuario_ssh";
        $contas_criadas2 = $conn->prepare($contas_criadas2);
        $contas_criadas2->execute();
        $contas_criadas2 = $contas_criadas2->rowCount();
        $contas_criadas2 = $contas_criadas2 + 0;
        $contas_criadas1 = "SELECT * FROM usuario_ssh_free";
        $contas_criadas1 = $conn->prepare($contas_criadas1);
        $contas_criadas1->execute();
        $contas_criadas1 = $contas_criadas1->rowCount();
        $contas_criadas1 = $contas_criadas1 + 0;
        $contas_criadas = $contas_criadas2 + $contas_criadas1;
        $servidores_alocados = "SELECT * FROM servidor";
        $servidores_alocados = $conn->prepare($servidores_alocados);
        $servidores_alocados->execute();
        $servidores_alocados = $servidores_alocados->rowCount();
        $servidores_alocados = $servidores_alocados + 0;
        $solic_trades = "SELECT * FROM solic_trades";
        $solic_trades = $conn->prepare($solic_trades);
        $solic_trades->execute();
        $solic_trades = $solic_trades->rowCount();
        $solic_trades = $solic_trades + 0;
        $servicos = "SELECT * FROM servicos";
        $servicos = $conn->prepare($servicos);
        $servicos->execute();
        $servicos = $servicos->rowCount();
        $servicos = $servicos + 0;
        $subrevenda = "SELECT * FROM usuario WHERE subrevenda = 'sim'";
        $subrevenda = $conn->prepare($subrevenda);
        $subrevenda->execute();
        $subrevenda = $subrevenda->rowCount();
        $subrevenda = $subrevenda + 0;
      }else{
        if($usuario['subrevenda'] != "sim"){
          $subrevenda = "SELECT * FROM usuario WHERE id_mestre = '$_SESSION[usuarioID]'";
          $subrevenda = $conn->prepare($subrevenda);
          $subrevenda->execute();
          $subrevenda = $subrevenda->rowCount();
          $subrevenda = $subrevenda + 0;
        }
      $solic_trades = "SELECT * FROM solic_trades WHERE id_usuario_para = '$_SESSION[usuarioID]'";
      $solic_trades = $conn->prepare($solic_trades);
      $solic_trades->execute();
      $solic_trades = $solic_trades->rowCount();
      $solic_trades = $solic_trades + 0;
      $contas_criadas = "SELECT * FROM usuario_ssh WHERE id_usuario = '$_SESSION[usuarioID]'";
      $contas_criadas = $conn->prepare($contas_criadas);
      $contas_criadas->execute();
      $contas_criadas = $contas_criadas->rowCount();
      $contas_criadas = $contas_criadas + 0;
      $servidores_alocados = "SELECT * FROM acesso_servidor WHERE id_usuario = '$_SESSION[usuarioID]'";
      $servidores_alocados = $conn->prepare($servidores_alocados);
      $servidores_alocados->execute();
      $servidores_alocados = $servidores_alocados->rowCount();
      $servidores_alocados = $servidores_alocados + 0;
      $contas_online = "SELECT sum(online) AS online FROM usuario_ssh where id_usuario='".$_SESSION['usuarioID']."' ";
      $contas_online = $conn->prepare($contas_online);
      $contas_online->execute();
      $contas_online = $contas_online->fetch();
      $contas_online = $contas_online[online];
      $contas_online = $contas_online + 0;
  }
}?>
<style>
.sidebar-wrapper1 .sidebar-footer {
bottom: -10px;
height: 60px;
}
.sidebar-wrapper1 .sidebar-footer .dropdown-menu {
  bottom: 55px;
}
.sidebar-wrapper1 .sidebar-footer > div {
  line-height: 0px;
}
.dropdown-item {
line-height: 0;
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
                          <img id="circulofoto" src="<?php echo $avatarusu; ?>" alt="">
                      </div>&nbsp &nbsp
                      <div class="user-info">
                          <span class="user-name"><?php echo $nick; ?></span>
                          <span class="user-role"><?php echo $rank; ?></span>
                          <?php
                          if($usuario['validade_dias'] > 1){
                            $validade_texto = "Dias";
                          }else{
                            $validade_texto = "Dia";
                          }
                          if($_SESSION['tipo'] != "admin"){
                            if($usuario['subrevenda'] == "sim"){
                              if($donorevenda['ativo'] == 2){
                                echo '
                                <span class="user-status"><i style="color:red;" class="fa fa-circle"></i><span>Offline</span></br></br>
                                <span class="user-status"><span>Mestre: '.$donorevenda['nome'].'</span>';
                              }else{
                                echo '
                                <span class="user-status"><i class="fa fa-circle"></i><span>Online</span></br></br>
                                <span class="user-status"><span>Mestre: '.$donorevenda['nome'].'</span>';
                              }
                            }else{
                              if($usuario['ativo'] != '2'){echo '
                                <span class="user-status"><i class="fa fa-circle"></i><span>Online</span></br></br>
                                <span class="user-status"><span>Vence em: <z>'.$usuario['validade_dias'].'</z> '.$validade_texto.'</span>';
                              }else{
                                echo '<span class="user-status"><i style="color:red;" class="fa fa-circle"></i><span>Offline</span>';
                              }
                            }
                          }else{
                            echo '<span class="user-status"><i class="fa fa-circle"></i><span>Online</span>';
                          } ?>
                      </div>
                  </div>
                <?php } ?>
                <div class=" sidebar-item sidebar-menu">
                    <ul>
                      <li class="header-menu">
                          <span>Menu painel</span>
                      </li>
                        <li>
                            <a href="/html/home.php">
                                <i class="fas fa-home"></i>
                                <span class="menu-text">Inicio Painel</span>
                            </a>
                        </li>
                        <?php
                        if($eadmin == 1){
                          if($_SESSION['tipo'] == "admin"){ ?>
                          <li>
                              <a onclick="submituser()">
                                  <i class="fas fa-user-tie"></i>
                                  <span class="menu-text">Modo User</span>
                              </a>
                          </li>
                        <?php }else{ ?>
                          <li>
                              <a onclick="submitadmin()">
                                  <i class="fas fa-user-shield"></i>
                                  <span class="menu-text">Modo Admin</span>
                              </a>
                          </li>
                          <?php } } ?>
                        <li class="sidebar-dropdown">
                            <a>
                                <i class="fas fa-greater-than-equal"></i>
                                <span class="menu-text">Contas</span><span class="badge badge-pill badge-primary"><?php echo $contas_criadas; ?></span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                  <?php if($_SESSION['tipo'] == "user"){ ?>
                                  <li><a href="?page=ssh/adicionar"><i class="fas fa-terminal"></i> Criar conta SSH</a></li>
                                  <li><a href="?page=ssh/add_teste"><i class="fas fa-clock"></i> Criar teste SSH</a></li>
                                  <li ><a href="?page=ssh/contas_premium"><i class="fas fa-users"></i> Suas Contas SSH</a></li>
                                  <?php }elseif($_SESSION['tipo'] == "admin"){ ?>
                                  <li ><a href="?page=ssh/contas_free"><i class="fas fa-users"></i> Contas Free</a></li>
                                  <li ><a href="?page=ssh/contas_premium"><i class="fas fa-users"></i> Contas Premium</a></li>
                                  <?php } ?>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-dropdown">
                            <a>
                                <i class="fas fa-server"></i>
                                <span class="menu-text">Servidores</span> <span class="badge badge-pill badge-primary"><?php echo $servidores_alocados; ?></span>
                            </a>
                            <div class="sidebar-submenu">
                              <?php if($_SESSION['tipo'] == "admin"){ ?>
                                    <ul>
                                      <li><a href="?page=servidor/adicionar"><i class="fas fa-list-ul"></i> Adicionar Servidor</a></li>
                                    </ul>
                                <?php } ?>
                                <ul>
                                  <li><a href="?page=servidor/listar"><i class="fas fa-list-ul"></i> Listar Servidores</a></li>
                                </ul>
                            </div>
                        </li>

                        <?php if($_SESSION['tipo'] != "admin"){ ?>
                          <?php if($usuario['subrevenda'] == 'nao'){ ?>
                            <li class="sidebar-dropdown">
                                <a>
                                    <i class="fas fa-user"></i>
                                    <span class="menu-text">Sub-Revenda</span>
                                </a>
                                <div class="sidebar-submenu">
                                  <ul>
                                    <li><a href="?page=subrevenda/add"><i class="fas fa-list-ul"></i> Adicionar Sub-Vendedor</a></li>
                                  </ul>
                                  <ul>
                                    <li><a href="?page=subrevenda/list"><i class="fas fa-list-ul"></i> Meus Sub-Vendedores <i class="badge-pill" style="color: white;"><?php echo $subrevenda; ?></i> </a></li>
                                  </ul>
                                </div>
                            </li>
                          <?php } ?>
                        <?php } ?>

                        <?php if($_SESSION['tipo'] == "admin"){ ?>
                          <li class="sidebar-dropdown">
                              <a>
                                  <i class="fas fa-user"></i>
                                  <span class="menu-text">Vendedores</span>
                              </a>
                              <div class="sidebar-submenu">
                                  <ul>
                                    <li><a href="?page=usuario/add_revendedor"><i class="fas fa-list-ul"></i> Adicionar Vendedor</a></li>
                                  </ul>
                                  <ul>
                                    <li><a href="?page=usuario/revenda"><i class="fas fa-list-ul"></i> Listar Vendedores</a></li>
                                  </ul>
                                  <ul>
                                    <li><a href="?page=usuario/subrevenda"><i class="fas fa-list-ul"></i> Listar SubVendedores</a></li>
                                  </ul>
                              </div>
                          </li>
                          <?php } ?>

                          <li class="sidebar-dropdown">
                              <a>
                                  <i class="fas fa-history"></i>
                                  <span class="menu-text">Historicos</span>
                              </a>
                              <div class="sidebar-submenu">
                                  <?php if($_SESSION['tipo'] == "admin"){ ?>
                                    <ul>
                                      <li><a href="?page=hist/adm"><i class="fas fa-list-ul"></i> ADM Log</a></li>
                                    </ul>
                                    <ul>
                                      <li><a href="?page=hist/free_log"><i class="fas fa-list-ul"></i> Log Contas Free</a></li>
                                    </ul>
                                    <ul>
                                      <li><a href="?page=hist/contasssh"><i class="fas fa-list-ul"></i> Todas ações</a></li>
                                    </ul>
                                    <ul>
                                      <li><a href="?page=hist/ban"><i class="fas fa-list-ul"></i> Hist. ban ip</a></li>
                                    </ul>
                                    <ul>
                                      <li><a href="?page=hist/login"><i class="fas fa-list-ul"></i> Hist. login painel</a></li>
                                    </ul>
                                    <ul>
                                      <li><a href="?page=hist/trade"><i class="fas fa-list-ul"></i> Hist. trocas</a></li>
                                    </ul>
                                    <ul>
                                      <li><a href="?page=hist/bot_servers"><i class="fas fa-list-ul"></i> Hist. bot açoes</a></li>
                                    </ul>
                                  <?php }else{ ?>
                                    <ul>
                                      <li><a href="?page=hist/acoes"><i class="fas fa-list-ul"></i> Minhas ações</a></li>
                                    </ul>
                                  <?php } ?>
                              </div>
                          </li>

                        <!-- <li class="sidebar-dropdown">
                            <a>
                                <i class="fas fa-arrows-alt-h"></i>
                                <span class="menu-text">Trocas</span><?php if($solic_trades != '0'){ ?><span class="badge badge-pill badge-primary"> <?php echo $solic_trades; } ?>
                            </a>
                            <div class="sidebar-submenu">
                              <?php if($_SESSION['tipo'] == "user"){ ?>
                                <ul>
                                  <li><a href="?page=trocas/listar"><i class="fas fa-user-plus"></i> Realizar trocas</a></li>
                                </ul>
                                <ul>
                                  <li><a href="?page=trocas/hist"><i class="fas fa-user-plus"></i> Historico trocas</a></li>
                                </ul>
                              <?php } ?>
                                <ul>
                                  <li><a href="?page=trocas/solicitacoes"><i class="fas fa-user-plus"></i> Pedidos de trocas<?php if($solic_trades != '0'){?><span class="badge badge-pill badge-primary"><?php echo $solic_trades; ?></span><?php } ?></a></li>
                                </ul>
                            </div>
                        </li> -->

                        <li class="sidebar-dropdown">
                            <a>
                                <i class="fas fa-certificate"></i>
                                <span class="menu-text">Outros</span>
                            </a>
                            <div class="sidebar-submenu">
                              <ul>
                                <li><a href="?page=admin/app"><i class="fas fa-mobile"></i> Aplicativo</a></li>
                              </ul>
                                <ul>
                                  <li><a target="_blank" href="https://hackkcah.xyz/arquivos.php"><i class="fas fa-folder"></i> Arquivos</a></li>
                                </ul>
                                <ul>
                                  <li><a href="?page=tutos/calc"><i class="fas fa-calculator"></i> Calculadora custo</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="sidebar-dropdown">
                            <a>
                                <i class="fas fa-cog"></i>
                                <span class="menu-text">Configurações</span>
                            </a>
                            <div class="sidebar-submenu">
                                <?php if($_SESSION['tipo'] == "admin"){ ?>
                                <ul>
                                  <li><a href="?page=servicos/listar"><i class="fab fa-sellsy"></i> <span> Serviços</span></a> </li>
                                </ul>
                                <ul>
                                  <li><a href="?page=servicos/files"><i class="fab fa-sellsy"></i> <span> Arquivos bot</span></a> </li>
                                </ul>
                              <?php }else{ ?>
                                <ul>
                                  <li><a href="?page=admin/dados"><i class="fab fa-sellsy"></i> <span> Minha conta</span></a> </li>
                                </ul>
                                <?php } ?>
                            </div>
                        </li>
                            <ul>
                              <li>
                                  <a href="/html/sair.php">
                                      <i class="fas fa-sign-out-alt"></i>
                                      <span class="menu-text">Deslogar</span>
                                  </a>
                              </li>
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar-footer">
                      <div>
                        <a href="/html/sair.php">
                          <i class="fa fa-power-off"></i>
                        </a>
                      </div>
                        <div class="pinned-footer">
                          <a href="#">
                            <i class="fas fa-ellipsis-h"></i>
                          </a>
                        </div>
                      </div>
                    </nav>
                  </div>
<link href="/html/material/css/style.css" rel="stylesheet">
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
    </svg>
</div>
<style>
  .gif img{
    width: 50px;
  }
  .modal-content{
    text-align: center;
    padding: 5px;
  }
  #loading .modal-dialog{
    transform: translate(0,100%);
  }
</style>
<div class="container">
<div class="modal fade" id="loading" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <p>CONECTANDO AO SERVIDOR, AGUARDE...</p>
      </div>
      <div class="gif">
        <img src="https://hackkcah.xyz/images/loader.gif"></img>
      </div>
    </div>
  </div>
</div>
</div>
