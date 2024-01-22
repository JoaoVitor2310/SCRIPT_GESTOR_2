<?php

echo "Cron disconnect_vencidos <br>";

$dataAtual = date("d/m/Y");
echo "Hoje é dia: " . $dataAtual . "<br>";

require_once 'autoload.php';

set_time_limit(3000);

$user_class = new User();
$whatsapi_class = new Whatsapi();
$clientes_class = new Clientes();
$planos_class = new Planos();


$list_users = $user_class->list_users();

if ($list_users) {
  $text_not_pareado = $whatsapi_class->get_template_not_pareado();

  while ($user = $list_users->fetch(PDO::FETCH_OBJ)) {

    $ar12 = array('+', ')', '(', ' ', '-');
    $ar22 = array('', '', '', '', '');
    $phone2 = $user->ddi . str_replace($ar12, $ar22, $user->telefone);


    // listar seus clientes
    $list = $clientes_class->list_clientes($user->id, false);

    $device = $whatsapi_class->verific_device_situ($user->id);

    if ($device == false) {
      echo "Device é falso: {$user->id} <br>";

    } else {
      echo "Device é true: {$user->id} <br>";
    }

    if ($list) {

      $dadosUser = $user_class->dados($user->id);
      $vencimento = $dadosUser->vencimento;

      echo "Vencimento é : {$vencimento} <br>";
      
      // Obtém timestamps das datas
      $timestampAtual = strtotime(date("Y-m-d")); // Converte a data atual para timestamp
      // echo "timestampAtual é : {$timestampAtual} <br>";
      
      
      $dataObj = DateTime::createFromFormat('d/m/Y', $vencimento);
      $novaDataFormatada = $dataObj->format('Y-m-d');
      $timestampVencimento = strtotime($novaDataFormatada); // Converte a data de vencimento para timestamp
      // echo "timestampVencimento é : {$timestampVencimento} <br>";

      // Compara os timestamps
      if ($timestampAtual > $timestampVencimento) {
        echo "Vencido. <br>";

        $v_device_zapi = $whatsapi_class->verific_device($user->id, 'ZAPI'); // Descobre o deviceId do usuário
        $keydevice_zapi = $v_device_zapi->device_id;
        echo "keydevice_zapi: {$keydevice_zapi} <br>";

        $user_id = $user->id;

        // Faz o post para o control load remover a sessão desse usuário
        $url = 'https://gestormaster.top/control/api-zapi/control.load_qr.php';

        $data = array(
          'remove' => true,
          'keydevice_zapi' => $keydevice_zapi,
          'user_id' => $user_id,
        );

        // Inicializa a sessão cURL
        $ch = curl_init();

        // Configura as opções da requisição cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);

        // Verifica por erros
        if (curl_errno($ch)) {
          echo 'Erro na requisição cURL: ' . curl_error($ch) . '<br>';
        }

        // Pode verificar a resposta se necessário
        echo "response: {$response} <br>";

        // Fecha a sessão cURL
        curl_close($ch);
      } else {
        echo "Não passou do vencimento. <br>";
      }
    }
  }
}


?>