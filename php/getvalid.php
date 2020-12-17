<?php
if(isset($_GET['user'])){
include_once($_SERVER['DOCUMENT_ROOT']."/html/pages/system/seguranca.php");

$frases = array(
"Você e muito gostosa",
"Você e muito linda",
"Te amo muito meu amor",
"😘🍑",
"O meu amor por você aumenta a cada dia que passa. Eu posso não dizer vezes suficientes mas nunca se esqueça: você é a pessoa mais importante da minha vida!",
"Eu prefiro passar uma vida com você do que enfrentar uma eternidade sozinho. Te amo!",
"Você me acalma quando estou precisando de paz e enche a minha alma de energia quando eu preciso de forças! Te amo, você é a melhor do mundo!",
"Meu status de relacionamento permanente: comprometido para sempre com a mulher mais linda do universo!",
"A maior luz que ilumina o meu caminho é o amor e a mudança que você trouxe para minha vida. Obrigado, meu amor!",
"Você faz as nuvens cinzentas desaparecerem e ilumina o céu com o sol do seu amor. Eu te amo mais do que tudo!",
"O verdadeiro amor nunca se desgasta. Quanto mais se dá mais se tem.",
"Eu te amo no presente do indicativo.",
"Você é a mulher perfeita para mim, foi enviada por Deus para me fazer feliz!",
"Você me ama ao cubo, eu te amo ao quadrado. Não posso dar menos do que você merece!",
"Se você fosse uma música seria as melhores notas.",
"Eu amo você e esse é o começo e o fim de tudo.",
"Acordo feliz todas as manhãs por ver o seu rosto lindo do meu lado e saber que você é o amor da minha vida.",
"Se o amor é fantasia, eu me encontro ultimamente em pleno carnaval.",
"A sua doçura e a sua força interior me inspiram todos os dias! Obrigado por me amar tanto e tão bem!",
"Sonhei que você era minha mulher e depois acordei sorrindo porque percebi que não era um sonho. Te amo!",
"Eu prometo dizer 'eu te amo todas as noites' e provar isso todos os dias.",
"Adoro ver você feliz e o seu sorriso é a minha maior recompensa!",
"Você é a mulher com a qual eu sempre sonhei. A mulher que gerou a nossa linda família e deu sentido à minha vida!",
"No dia em que eu conheci você, percebi que tinha encontrado a minha princesa e o nosso final feliz. Te amo!",
"Quando vejo o brilho dos seus olhos, sinto a mesma paixão e o mesmo entusiasmo que senti no primeiro dia. O tempo só aumenta o nosso sentimento e fortalece os nossos laços!"
);

  if(isset($_GET['tipo'])){
    if($_GET['tipo'] == 'free'){
      $tipo = "usuario_ssh_free";
    }else{
      if (strpos($_GET['user'], "testeuser") === 0) {
        $tipo = "usuario_ssh_teste";
      }else{
        $tipo = "usuario_ssh";
      }
    }
  }else{
    echo "fail";
    exit;
  }

  $user = $_GET['user'];

  sql('login', $user);
  sql('login', $tipo);

  if($user == "root"){
    echo "Nunca";
    exit;

  }if($user == "mozao"){
    srand ((float)microtime()*1000000);
    shuffle ($frases);
    echo "Nunca </> <br><br><font color='red'>$frases[0]";
    exit;

  }else{
    $arquivo= "SELECT * from $tipo WHERE login='$user' ";
    $arquivo = $conn->prepare($arquivo);
    $arquivo->execute();
    $arquivo1 = $arquivo->rowCount();
    $arquivo = $arquivo->fetch();
    if($arquivo1 == 1){
      if (strpos($_GET['user'], "testeuser") === 0) {
        echo $arquivo['duracao_teste'];
      }else{
        echo $arquivo['data_validade'];
      }
    }else{
      echo "fail";
    }
  }
  exit;

}else{
  echo "fail";
  exit;
}
