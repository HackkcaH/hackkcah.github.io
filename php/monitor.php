<?php if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__)){ header('Location: /404'); }
// Build request:
$request = 'api_key=' . $api_key . '&format=json&logs=1&log_types=1&logs_limit=1&all_time_uptime_ratio=1';
// Access API via cURL:
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.uptimerobot.com/v2/getMonitors',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $request,
    CURLOPT_HTTPHEADER => array(
        'cache-control: no-cache',
        'content-type: application/x-www-form-urlencoded'
    ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
// Decode JSON response and get only the data needed:
$response = json_decode($response);
$response = $response->monitors[0];
// Website details:
$website_name = $response->friendly_name;
$website_url = $response->url;
// Date monitor was created:
$monitor_started = $response->create_datetime;
$monitor_started = date('jS F Y', $monitor_started);
// Overall uptime percentage:
$monitor_uptime = $response->all_time_uptime_ratio;
$monitor_uptime = number_format($monitor_uptime, 2);
// Overall downtime percentage:
$monitor_downtime = 100 - $monitor_uptime;
$monitor_downtime = number_format($monitor_downtime, 2);
// Data to be passed to chart. Hide downtime if there is none:
if ($monitor_downtime == 0) {
    $data = $monitor_uptime;
    $background_colour = '\'#13B132\'';
    $border_colour = '\'#13B132\'';
    $labels = '\'Uptime\'';
} else {
    $data = $monitor_uptime . ', ' . $monitor_downtime;
    $background_colour = '\'#13B132\', \'#F42121\'';
    $border_colour = '\'#13B132\', \'#F42121\'';
    $labels = '\'Uptime\', \'Downtime\'';
}
// Current website status:
$monitor_status = $response->status;
$statuscolor = $monitor_status;
// Change content to be displayed based on current website status:
if ($monitor_status == 0) { // Monitor is paused:
    $monitor_status = 'O monitor esta pausado. Este site/servidor pode estar em manutenção ou passando por update';
    $monitor_info = 'Por favor, verifique novamente mais tarde para um relatório de status atualizado';
} elseif ($monitor_status == 2) { // Website is up:
    $monitor_status = 'O serviço esta funcionando' .
    '<span class="icon is-large has-text-success"><i class="fas fa-lg fa-check"></i></span>';
    // Check if there has been any recorded downtime:
    if (empty($response->logs)) { // Downtime recorded:
        $monitor_info = 'O servidor ainda não esteve offline';
    } else { // No downtime recorded:
        // Get date of last downtime:
        $monitor_last_downtime = $response->logs[0]->datetime;
        $monitor_last_downtime = date('jS F Y', $monitor_last_downtime);
        // Get time since last downtime in hours:
        $time_downtime = strtotime($monitor_last_downtime);
        $time_current = time();
        $time_since_downtime = $time_current - $time_downtime;
        $time_since_downtime = floor($time_since_downtime / 3600);
        $monitor_info = 'Passou ' . $time_since_downtime . ' horas (' . $monitor_last_downtime . ') deste a ultima vez que o servidor esteve offline';
    }
} elseif ($monitor_status == 9) { // Website is down:
    $monitor_status = 'O serviço nao estao funcionando' .
    '<span class="icon is-large has-text-danger"><i class="fas fa-lg fa-times"></i></span>';
    // Get length of current downtime in hours:
    $monitor_downtime_seconds = $response->logs[0]->duration; // Seconds
    $monitor_downtime_hours = floor($monitor_downtime_seconds / 3600); // Hours
    $monitor_info = 'O serviço esta offline faz ' . $monitor_downtime_hours . ' horas';
} ?>

<section id="main" class="wrapper">
  <div class="0">
   </br></br>
    <div id="fundocontainer">
     <section class=0>

       <?php
       if ($statuscolor == 9) {
         $color = "danger";
       }else{
         $color = "success";
       } ?>

      <section class="hero is-<?php echo $color; ?> is-bold">

          <div class="hero-body">
              <div class="0">
                <h1 class="subtitle">Status do serviço: </h1>
                 <h2 class="title"> <?= $website_name; ?> </a>
                  </h2>
              </div>
          </div>
      </section>
      <div class="0">
          <div class="section">
              <div>
                  <div>
                      <h3 style="color: white;" class="subtitle">Informações:</h3>
                          <div style="color: white;" class="content">
                            <?php
                            include_once($_SERVER['DOCUMENT_ROOT']."/php/pass.php");
                            $host = "localhost";
                            $db   = "painelhkh";
                            $user = "root";
                            $con = mysql_pconnect($host, $user, $pass);
                            mysql_select_db($db, $con);

                            $userson = "SELECT SUM(online) AS online FROM usuarios_online WHERE id_servidor = '".$sv."'";
                            $userson = mysql_query($userson, $con);
                            $userson = mysql_fetch_assoc($userson);
                            $userson = $userson['online']; ?>

                              <p>O monitoramento começou em: <?= $monitor_started; ?></p>
                              <p>Status atual: <?= $monitor_status; ?></p>
                              <p>Usuarios Online: <?php echo $userson; ?></p>
                              <p>Ping: <?= $ping; ?></p>
                              <p><?= $monitor_info; ?></p>
                              <p>Contato para suporte: <a style="color: blue;" href="mailto:suporte@hackkcah.xyz?subject=ServiceDown" title="">suporte@hackkcah.xyz</a>
                                  <span class="icon is-large">
                                      <a href="#" class="has-text-success">
                                          <i class="fas fa-lg fa-envelope"></i>
                                      </a>
                                  </span>
                              </p>
                          </div>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
    </section>
  </div>
</div>
</section>
