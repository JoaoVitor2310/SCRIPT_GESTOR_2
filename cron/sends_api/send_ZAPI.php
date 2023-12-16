<?php
echo "<br><br> /sends_api/send_ZAPI <br>";
// echo "DESCOBRIR COMO ELE IDENTIFICA QUEM ENVIA A MENSAGEM E ARRUMAR UM JEITO DE CADASTRAR O ADMIN<br>";
// echo "Os outros crons dependem dos crons dessa pasta<br>";
if ($fila_lock->id_user != '0') {
  echo "<br>Entrou no if fila_lock->id_user <br>";
  // var_dump($fila_lock);
  echo "<br>";

  echo "{$adm->id_plano}<br>";
  if (isset($adm->id_plano)) {
    echo "<br>1-Entrou no if adm->id_plano<br>";
    if ($adm->id_plano != 7) {
      echo "<br>2- Entrou no if adm->id_plano != 7<br>";
      $copy = "\n\n" . $gestor_class->get_options("dominio");
    } else {
      echo "<br>3-NÃO ENTROU Entrou no if adm->id_plano != 7<br>";
      $copy = "";
    }
  } else {
    $copy = "";
  }

  echo "adm->id_plano: {$adm->id_plano} <br>";
  // Send Message
  $device = trim($fila_lock->device_id);
  if($device === "ZAPI"){ // A MENSAGEM É DO GESTOR PARA OS REVENDEDORES
    $remetente = $whatsapi_class->verific_device_situ('0'); // O adm sempre terá o id 0
    $device = $remetente->device_id;
  }
  $destination = $fila_lock->destino;
  $message = $fila_lock->msg;
  echo "device: {$device}, destination: {$destination} <br>";

  $curl = curl_init();

  $dados['sessionName'] = $device; // AQUI QUE DETERMINA QUEM ENVIA A MENSAGEM
  $dados['number'] = $destination;
  $dados['text'] = $message . $copy;

  curl_setopt_array($curl, array(
    CURLOPT_URL => $gestor_class->get_options("api_zap_address") . '/sendText',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($dados),
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
      'Accept: application/json',
    ),
  )
  );

  $response = curl_exec($curl);
  curl_close($curl);

  $whatsapi_class->insert_disparo($fila_lock->id_user, $destination, $message);





} else {
  echo "<br>NÃO Entrou no if fila_lock->id_user <br>";

  $device = trim($fila_lock->device_id);
  $destination = $fila_lock->destino;
  $message = $fila_lock->msg;

  $dados['sessionName'] = $device;
  $dados['number'] = $destination;
  $dados['text'] = $message . $copy;

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $gestor_class->get_options("api_zap_address") . '/sendText',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($dados),
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
      'Accept: application/json',
    ),
  )
  );

  $response = curl_exec($curl);
  curl_close($curl);

  $ch = curl_init();
  $timeout = 1;

  curl_setopt($ch, CURLOPT_URL, $api_url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

  $result = curl_exec($ch);
  curl_close($ch);

  $my_result_object = json_decode($result);


}




?>