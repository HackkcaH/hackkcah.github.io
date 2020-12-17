<?php if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__)){ header('Location: /404'); }
require_once($_SERVER['DOCUMENT_ROOT']."/php/ips.php");
require_once($_SERVER['DOCUMENT_ROOT']."/html/pages/system/seguranca.php");


if(isset($_COOKIE['usuariogerado'])){
$loginssh = $_COOKIE['usuariogerado'];
$senhassh = $_COOKIE['senhagerado'];
$validade = $_COOKIE['validade'];
$limite = $_COOKIE['limite'];
$dias = $_COOKIE['dias'];
$sv = $_COOKIE['servidor'];
if ($loginssh != ""){echo '<a style="font-size: 18px;" onclick="mostrarconta()"><ul id=menucontajagerada><li>VOCE JA TEM UMA CONTA GERADA </br> CLIQUE AQUI PARA VER</li></ul>­</a>';}
$servidor= "SELECT * from servidor WHERE id_servidor='$sv'";
$servidor = $conn->prepare($servidor);
$servidor->execute();
$servidor_info = $servidor->fetch(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
<script>
const clipboard = new ClipboardJS('.copiar')
clipboard.on('success', function(e) { alert("Copiado com sucesso") });
clipboard.on('error', function(e) { alert("Falha ao copiar") });
</script>
<div id="bannercontagerada">
  <div id="adonsitebf">
    <div id="whitebf-content">
	<div id="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-15 p-b-15">
				<div style="font-size: 18px; color: black; padding: 30px;">
          <div class="text-center"></b></b>
						<span class="txt1">IP: </span>
            <?php	echo '<b>'.$servidor_info['ip_servidor'].'</b>'; ?>
              <button title="Copiar ip" class="copiar" data-clipboard-text="<?php echo $servidor_info['ip_servidor']; ?>"><i class="far fa-copy"></i></button>
					</div>
          <div class="text-center">
            <span class="txt1">Login: </span>
            <b> <?php echo $loginssh; ?></b>
            <button title="Copiar usuario" class="copiar" data-clipboard-text="<?php echo $loginssh;?>"><i class="far fa-copy"></i></button>
          </div>
          <div class="text-center">
            <span class="txt1">Senha: </span>
            <b><?php echo $senhassh; ?></b>
            <button title="Copiar senha" class="copiar" data-clipboard-text="<?php echo $senhassh;?>"><i class="far fa-copy"></i></button>
          </div>
          <div class="text-center">
            <span class="txt1">Valido até: </span>
            <b title="Validade"><?php echo $validade;?></b>
          </div>
          <div class="text-center">
            <span class="txt1">Limite usuarios simultanios: </span><b><?php echo $limite; ?></b><p>
              <?php if ($sv == "1") {echo '<span style="font-size: 0.8em;">Squid: 80 &nbsp; &nbsp; SSL:443</span><p>'; } ?>
            <span style="font-size: 0.9em;" href="/"><b style="color: red;">Voce pode baixar arquivos pre configurados clicando <a href="/arquivos.php">AQUI</a></b> </span><br/>
            <a onclick="ocultatudo()" style="font-size: 0.8em;" >Para fechar clique fora do quadrado branco ou aqui.</a>
          </div>
			   </div>
		  	</div>
  	   <div onclick="ocultatudo()" id="overlaybf"></div>
     </div>
  	</div>
   </div>
  </div>
 </div>
<?php }else{ ?>
  <div id="bannercontagerada">
    <div id="adonsitebf">
      <div id="whitebf-content">
  	<div id="limiter">
  		<div class="container-login100">
  			<div class="wrap-login100 p-l-55 p-r-55 p-t-15 p-b-15">
  				<div style="font-size: 18px; color: black; padding: 30px;">
            <div class="text-center">
              <b> Você ainda não tem uma conta gerada!</b></br>
              <a style="color:red;" href="/gerar.php"><b> Clique aqui para gerar uma.</b></a></br></br></br>
              <a onclick="ocultatudo()" style="font-size: 0.8em;" >Para fechar clique fora do quadrado branco ou aqui.</a>
            </div>
  			   </div>
  		  	</div>
    	   <div onclick="ocultatudo()" id="overlaybf"></div>
       </div>
    	</div>
     </div>
    </div>
   </div>
  <?php } ?>

<div id="bannerrec">
  <div id="adonsitebf">
    <div id="whitebf-content">
      <div id="limiter">
         <div class="container-login100">
     <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
         <span style="margin:20px;" class="login100-form-title p-b-33">Recuperação de conta</span>
         <div id="recuperandologin" style="padding: 30px;">
         <div class="wrap-input100 validate-input" data-validate = "Usuario em branco">
           <input class="input100" required="" type="text" name="login" id="login" placeholder="Digite seu login">
           <span class="focus-input100-1"></span>
           <span class="focus-input100-2"></span>
         </div>
         <div class="container-login100-form-btn m-t-20">
           <button onclick="getlogin()" class="login100-form-btn">ENVIAR</button>
         </div>
       </div>
       <div id="recuperandoemail" style="padding: 30px; display:none;">
         <div class="wrap-input100 rs1 validate-input" data-validate="Email em branco">
           <input class="input100" required="" type="text" name="email" id="email" placeholder="Digite seu email">
           <span class="focus-input100-1"></span>
           <span class="focus-input100-2"></span>
         </div>
         <div id="salvalogin" name="salvalogin" style="display: none;"></div>
         <div class="container-login100-form-btn m-t-20">
           <button onclick="getemail()" class="login100-form-btn">ENVIAR</button>
         </div>
         </div>
         <div class="text-center p-t-45 p-b-4">
           <span class="txt1"></span>
           <a href="#" class="txt2 hov1"></a></div>
         <div class="text-center">
           <span class="txt1"></span><p><p>
            <a style="font-size: 0.8em;" onclick="ocultatudo()">Para fechar clique fora do quadrado branco ou aqui.</a>
         </div>
     </div>
     </div>
    <div onclick="ocultatudo()" id="overlaybf"></div>
   </div>
 </div>
 </div>
</div>

  <div id="cadastro">
    <div id="adonsitebf">
      <div id="whitebf-content">
        <div id="limiter">
           <div class="container-login100">
       <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
         <form style="padding: 30px;" data-toggle="validator" action="/php/cadastro.php" method="POST" role="form">
           <span class="login100-form-title p-b-33">Cadastrar</span>
           <div class="wrap-input100 validate-input" data-validate = "Nome em branco">
             <input class="input100" required="" type="text" name="nome" placeholder="Digite o nome do usuario">
             <span class="focus-input100-1"></span>
             <span class="focus-input100-2"></span>
           </div>
           <div class="wrap-input100 validate-input" data-validate = "Usuario em branco">
             <input class="input100" required="" type="text" name="login" placeholder="Digite um login">
             <span class="focus-input100-1"></span>
             <span class="focus-input100-2"></span>
           </div>
           <div class="wrap-input100 rs1 validate-input" data-validate="Senha em branco">
             <input class="input100" required="" type="password" name="senha" placeholder="Digite uma senha">
             <span class="focus-input100-1"></span>
             <span class="focus-input100-2"></span>
           </div>
           <div class="container-login100-form-btn m-t-20">
             <button class="login100-form-btn">CRIAR</button>
           </div>
           <div class="text-center p-t-45 p-b-4">
             <span class="txt1"></span>
             <a href="#" class="txt2 hov1"></a></div>
           <div class="text-center"><div id="teste">
              <a style="font-size: 0.8em;" onclick="ocultatudo()">Para fechar clique fora do quadrado branco ou aqui.</a>
           </div>
         </form>
       </div>
       </div>
      <div onclick="ocultatudo()" id="overlaybf"></div>
     </div>
   </div>
   </div>
  </div>
</div>

<div id="bannerlogin">
  <div id="adonsitebf">
    <div id="whitebf-content">
      <div id="limiter">
         <div class="container-login100">
     <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
       <form style="padding: 30px;" data-toggle="validator" action="/html/validacao.php" method="POST" role="form">
         <span class="login100-form-title p-b-33">Login</span>
         <div class="wrap-input100 validate-input" data-validate = "Usuario em branco">
           <input class="input100" required="" type="text" name="login" placeholder="Digite seu login">
           <span class="focus-input100-1"></span>
           <span class="focus-input100-2"></span>
         </div>
         <div class="wrap-input100 rs1 validate-input" data-validate="Senha em branco">
           <input class="input100" required="" type="password" name="senha" placeholder="Digite sua senha">
           <span class="focus-input100-1"></span>
           <span class="focus-input100-2"></span>
         </div>
         <div class="container-login100-form-btn m-t-20">
           <button class="login100-form-btn">ENTRAR</button>
         </div>
         <div class="text-center p-t-45 p-b-4">
           <span class="txt1"></span>
           <a href="#" class="txt2 hov1"></a></div>
         <div class="text-center"><div id="teste">
           <div class="form-check">
               <input type="checkbox" id="conf" name="conf">
               <label for="conf">MANTER LOGADO</label>
           </div>
            <!-- <span class="txt1" style="color:black;">Logando como: Revendedor </br><a onclick="mostrarloginadmin()">TROCAR</a></span></br></br> -->
            <span class="txt1" style="color:black;">Esqueceu a senha? <a style="color:blue;" onclick="mostrarrec()">Clique aqui</a></span></br>
            <a style="font-size: 0.8em;" onclick="ocultatudo()">Para fechar clique fora do quadrado branco ou aqui.</a>
         </div>
         <input type="hidden" name="tipo" id="tipo" value="1">
       </form>
     </div>
     </div>
    <div onclick="ocultatudo()" id="overlaybf"></div>
   </div>
 </div>
 </div>
</div>
</div>

<div id="bannerlogin2">
  <div id="adonsitebf">
    <div id="whitebf-content">
      <div id="limiter">
         <div class="container-login100">
     <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
       <form style="padding: 30px;" data-toggle="validator" action="/html/validacao.php" method="POST" role="form">
         <span class="login100-form-title p-b-33">Login</span>
         <div class="wrap-input100 validate-input" data-validate = "Usuario em branco">
           <input class="input100" required="" type="text" name="login" placeholder="Digite seu login">
           <span class="focus-input100-1"></span>
           <span class="focus-input100-2"></span>
         </div>
         <div class="wrap-input100 rs1 validate-input" data-validate="Senha em branco">
           <input class="input100" required="" type="password" name="senha" placeholder="Digite sua senha">
           <span class="focus-input100-1"></span>
           <span class="focus-input100-2"></span>
         </div>
         <div class="container-login100-form-btn m-t-20">
           <button class="login100-form-btn">ENTRAR</button>
         </div>
         <div class="text-center p-t-45 p-b-4">
           <span class="txt1"></span>
           <a href="#" class="txt2 hov1"></a></div>
         <div class="text-center"><div id="teste1">
           <div class="form-check">
             <input type="checkbox" id="conf" name="conf">
             <label for="conf">MANTER LOGADO</label>
           </div>
            <!-- <span class="txt1" style="color:black;">Logando como: Revendedor </br><a onclick="mostrarloginadmin()">TROCAR</a></span></br></br> -->
            <span class="txt1" style="color:black;">Esqueceu a senha? <a style="color:blue;" onclick="mostrarrec()">Clique aqui</a></span></br>
            <a style="font-size: 0.8em;" onclick="ocultatudo()">Para fechar clique fora do quadrado branco ou aqui.</a>
         </div>
         <input type="hidden" name="tipo" id="tipo" value="2">
       </form>
     </div>
     </div>
    <div onclick="ocultatudo()" id="overlaybf"></div>
   </div>
 </div>
 </div>
</div>
</div>

<div id="bannerloginadmin">
  <div id="adonsitebf">
    <div id="whitebf-content">
      <div id="limiter">
         <div class="container-login100">
     <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
       <form style="padding: 30px;" data-toggle="validator" action="/html/validacao.php" method="POST" role="form">
         <span class="login100-form-title p-b-33">Login</span>
         <div class="wrap-input100 validate-input" data-validate = "Usuario em branco">
           <input class="input100" required="" type="text" name="login" placeholder="Digite seu login">
           <span class="focus-input100-1"></span>
           <span class="focus-input100-2"></span>
         </div>
         <div class="wrap-input100 rs1 validate-input" data-validate="Senha em branco">
           <input class="input100" required="" type="password" name="senha" placeholder="Digite sua senha">
           <span class="focus-input100-1"></span>
           <span class="focus-input100-2"></span>
         </div>
         <div class="container-login100-form-btn m-t-20">
           <button class="login100-form-btn">ENTRAR</button>
         </div>
         <div class="text-center p-t-45 p-b-4">
           <span class="txt1"></span>
           <a href="#" class="txt2 hov1"></a></div>
         <div class="text-center"><div id="teste">
           <div class="form-check">
             <input type="checkbox" id="conf" name="conf">
             <label for="conf">MANTER LOGADO</label>
           </div>
            <!-- <span class="txt1" style="color:black;">Logando como: Administrador </br><a onclick="mostrarlogin2()">TROCAR</a></span></br></br> -->
            <span class="txt1" style="color:black;">Esqueceu a senha? <a style="color:blue;" onclick="mostrarrec()">Clique aqui</a></span></br>
            <a style="font-size: 0.8em;" onclick="ocultatudo()">Para fechar clique fora do quadrado branco ou aqui.</a>
         </div>
         <input type="hidden" name="tipo" id="tipo" value="3">
       </form>
     </div>
     </div>
    <div onclick="ocultatudo()" id="overlaybf"></div>
   </div>
 </div>
 </div>
</div>
</div>


<style>
.modal-header {
  display: block !important;
}
.modal-backdrop.show {
  z-index: 0;
}
.modal-open .modal {
  margin-top: 50px;
  margin-bottom: 50px;
}
.modal-card, .modal-content {
    margin: 0 0px;
}
</style>
<div class="container">
<div class="modal fade" id="parceiros" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Parceiros</h4>
      </div>

      <div class="modal-body">
        <p>Marcelo APK
          <ul>
            <li><a href="https://www.marceloapk.club/"><i class="fab fa-internet-explorer" style="background: none;"></i> Site</a></li>
            <li><a href="https://www.youtube.com/channel/UCJxT6bC6N1b0sweO0exZ2MA"><i class="fab fa-youtube-square" style="background: none;"></i> Canal no Youtube</a></li>
            <li><a href="https://t.me/tlspremium"><i class="fab fa-telegram-plane" style="background: none;"></i> Canal do Telegram</a></li>
            <li><a href="https://t.me/parceirosdanetfree"><i class="fab fa-telegram-plane" style="background: none;"></i> Grupo do Telegram</a></li>
          </ul>
      </div><hr>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
</div>


<div class="container">
<div class="modal fade" id="aviso" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Aviso</h4>
      </div>

      <div class="modal-body">

        <p>ATUALMENTE O SERVIDOR BRA NÃO É BR E NAO ESTA RODANDO JOGO ELE ESTA ATIVO APENAS PARA QUE NÃO FIQUEM SEM INTERNET NÂO DERRUBEM ❤</br></br>

        <p>Se vc vende conta Azure me chame no telegram <a style="color: red;" href="https://t.me/hackkkcah">@hackkkcah</a> </br>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
</div>
