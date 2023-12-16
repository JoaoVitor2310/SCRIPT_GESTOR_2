<?php
// CONTROL LOAD ADMIN


@session_start();

if (isset($_SESSION['SESSION_USER'])) {

  $return = new stdClass();

  require_once '../../class/Conn.class.php';
  require_once '../../class/Whatsapi.class.php';
  require_once '../../class/User.class.php';
  require_once '../../class/Gestor.class.php';

  $conn = new Conn();
  $pdo = $conn->pdo();


  $wsapi = new Whatsapi();
  $user = new User();
  $gestor = new Gestor();

  $endpoint = $gestor->get_options("api_zap_address");

  $dados_u = 'admin';
//   var_dump($dados_u);

  $api = 'ZAPI';
  $key = substr(sha1(rand()), 0, 20);
  $user_id = $dados_u;
  $situ = 1;

  $keyantiga = trim($_POST['keydevice_zapi']);

  $v_device = $wsapi->verific_device($dados_u, $api);


  if (isset($_POST['remove'])) {

    file_get_contents("62.72.11.236:3333/close?sessionName=" . $keyantiga);

    $query = "DELETE FROM `whats_api` WHERE id_user='$user_id' AND api='$api' ";
    $pdo->query($query);

    if (isset($_SESSION['time_whatsapp_status'])) {
      unset($_SESSION['time_whatsapp_status']['time']);
      unset($_SESSION['time_whatsapp_status']['session']);
      unset($_SESSION['time_whatsapp_status']);
    }

  }


  if (isset($_POST['load'])) {
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint . '/close?sessionName=' . $keyantiga);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    // echo json_encode(['erro' => true, 'msg' => 'CHEGOU O POST']);
    // die;
    
    $query = "DELETE FROM `whats_api` WHERE id_user='$user_id' AND api='$api' ";
    $pdo->query($query);


    function qrcode($endpoint, $key)
    {
      file_get_contents($endpoint."/start?sessionName=".$key);
      sleep(18); // wppconnect
      $file = file_get_contents($endpoint."/qrcode?sessionName=".$key); // ."&image=true"

      if ($file) {
        if (json_decode($file)) {
          $return = json_decode($file);
          if (isset($return->qrcode)) {

            //$qrC = QRcode::png($return->qrcode);

            if (isset($_SESSION['time_whatsapp_status'])) {
              unset($_SESSION['time_whatsapp_status']['time']);
              unset($_SESSION['time_whatsapp_status']['session']);
              unset($_SESSION['time_whatsapp_status']);
            }

            echo json_encode(['erro' => false, 'qrcode' => $return->qrcode, 'key' => $key]);
            die;
          } else {
            echo json_encode(['erro' => true, 'msg' => 'Desculpe tente mais tarde']);
            die;
          }
        } else {
          echo json_encode(['erro' => true, 'msg' => 'Desculpe tente mais tarde']);
          die;
        }
      } else {
        echo json_encode(['erro' => true, 'msg' => 'Desculpe tente mais tarde']);
        die;
      }
    }

    if ($v_device) {
      // update key

      file_get_contents("62.72.11.236:3333/close?sessionName=" . $keyantiga);

      if ($situ == 1) {

        $api_ativa = $wsapi->verific_device_situ($dados_u);

        if ($api_ativa) {
          if ($api_ativa->api != $api) {
            $return->erro = true;
            $return->msg = "Você já possui outra API ativa, desative-a para ativar está.";
            echo json_encode($return);
            die;
          }
        }
      }


      $query = "UPDATE `whats_api` SET device_id='$key', situ='1' WHERE id_user='$user_id' AND api='$api' ";
      if ($pdo->query($query)) {


        qrcode($endpoint, $key);


      } else {
        $return->erro = true;
        $return->msg = "Erro ao alterar API " . strtoupper($api) . ", entre em contato com o suporte.";
        echo json_encode($return);
      }

    } else {


      if ($situ == 1) {

        $api_ativa = $wsapi->verific_device_situ($dados_u);

        if ($api_ativa) {
          if ($api_ativa->api != $api) {
            $return->erro = true;
            $return->msg = "Você já possui outra API ativa, desative-a para ativar está.";
            echo json_encode($return);
            die;
          }
        }
      }

      //add key
      $query = "INSERT INTO `whats_api` (device_id,id_user,api,situ) VALUES ('$key','$user_id','$api','$situ') ";

      try {
        if ($pdo->query($query)) {

          qrcode($endpoint, $key);

        } else {
          $return->erro = true;
          $return->msg = "Erro ao adicionar API " . strtoupper($api) . "";
          echo json_encode($return);
        }
      } catch (Exception $e) {
        echo $e;
      }

    }
  }
}
?>