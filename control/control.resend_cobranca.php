<?php

@session_start();
set_time_limit(3000);

require_once '../class/Conn.class.php';

require_once '../class/Whatsapi.class.php';
$whatsapi_c = new Whatsapi();

require_once '../class/Planos.class.php';
$planos_c = new Planos();

require_once '../class/Gestor.class.php';
$gestor_c = new Gestor();

require_once '../class/User.class.php';
$user_c = new User();

require_once '../class/Clientes.class.php';
$clientes_c = new Clientes();

if (isset($_POST['id_cli']) && isset($_POST['text_to'])) {

  if ($_POST['text_to'] != "") {

    $id_cli = $_POST['id_cli'];
    $text_to = $_POST['text_to'];
    $data = date('d/m/Y');

    //jay11{
    $idAtual = $_SESSION['SESSION_USER']['id'];

    $conn = new Conn();
    $pdo = $conn->pdo();

    $query = $pdo->prepare("SELECT device_id FROM `whats_api` WHERE id_user = :idAtual LIMIT 1");
    $query->bindParam(':idAtual', $idAtual, PDO::PARAM_INT);
    $query->execute();
    $device_id = $query->fetch(PDO::FETCH_ASSOC);
    $device_id = $device_id['device_id'];

    //}jay11



    $user = $clientes_c->dados($id_cli);

    if ($user) {
      $adm = $user_c->dados($user->id_user);

      if ($whatsapi_c->verifica_fila_lembrete($adm->id)) {

        $plano = $planos_c->plano($user->id_plano);

        //jay11
        // $link_plano = 'https://' . $gestor_c->get_options("dominio") . '/gmaster/p/' . str_replace('=', '', base64_encode($plano->id)); // Link que levava pra pagar o plano
        $link_plano = 'https://cliente.' . $gestor_c->get_options("dominio") . '/clientes_' . $plano->id_user; // Link do vendedor que leva pro cliente logar na sua área.

        $ar1 = array('+', ')', '(', ' ', '-');
        $ar2 = array('', '', '', '', '');
        $phone = str_replace($ar1, $ar2, $user->telefone);

        $dataVencimento = DateTime::createFromFormat('d/m/Y', $user->vencimento);
        $dataAtual = new DateTime();

        // // Calcula a diferença em dias
        $dias_vencimento = $dataAtual->diff($dataVencimento)->days;

        $ar1 = array('{senha_cliente}', '{nome_cliente}', '{primeiro_nome_cliente}', '{email_cliente}', '{telefone_cliente}', '{vencimento_cliente}', '{plano_valor}', '{data_atual}', '{plano_nome}', '{plano_link}', '{dias_vencimento}');
        $ar2 = array($user->senha, $user->nome, explode(' ', $user->nome)[0], $user->email, $user->telefone, $user->vencimento, $plano->valor, date('d/m/Y'), $plano->nome, $link_plano, $dias_vencimento);
        $text = str_replace($ar1, $ar2, $text_to);

        $whatsapi_c->fila($phone, $text, $idAtual, $device_id, 'ZAPI', '0000', '0000');
        echo json_encode(['erro' => false, 'id_cli' => $id_cli]);
        die;
      } else {
        echo json_encode(['erro' => true, 'msg' => 'Você já possui um lembrete na fila de envio. Aguarde alguns minutos para tentar enviar novamente.']);
        die;
      }
    }
  } else {
    echo json_encode(['erro' => true, 'msg' => 'A mensagem não pode ser vazia']);
    die;
  }
}

if (isset($_POST['removeFila'])) {

  $id = trim($_POST['id']);
  $user = $_SESSION['SESSION_USER']['id'];

  if ($whatsapi_c->get_msg_file_by_id($user, $id)) {

    if ($whatsapi_c->delete_fila($id)) {
      echo json_encode(array("erro" => false, "msg" => "A mensagem foi removida da fila"));
    } else {
      echo json_encode(array("erro" => true, "msg" => "Erro. Talvez a mensagem já não esteja mais na fila"));
    }

  } else {
    echo json_encode(array("erro" => true, "msg" => "Erro. Talvez a mensagem já não esteja mais na fila"));
  }

}

?>