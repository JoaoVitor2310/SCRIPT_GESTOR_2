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

if (isset($_POST['text'])) {

    if ($_POST['text'] != "") {

        $text = $_POST['text'];

        //jay11{
        $idAtual = $_SESSION['SESSION_USER']['id'];

        $conn = new Conn();
        $pdo = $conn->pdo();

        // Coleta o deviceId do usuário atual
        $query = $pdo->prepare("SELECT device_id FROM `whats_api` WHERE id_user = :idAtual LIMIT 1");
        $query->bindParam(':idAtual', $idAtual, PDO::PARAM_INT);
        $query->execute();
        $device_id = $query->fetch(PDO::FETCH_ASSOC);
        $device_id = $device_id['device_id'];

        if ($device_id) {


            // Busca por todos os seus clientes que estão inadimplentes
            $query = $pdo->prepare("SELECT * FROM `clientes` WHERE id_user = :idAtual");
            $query->bindParam(':idAtual', $idAtual, PDO::PARAM_INT);
            $query->execute();
            $listaVencidos = $query->fetchAll(PDO::FETCH_ASSOC);


            // $plano = $planos_c->plano(9509);
            // echo json_encode(['erro' => false, 'plano' => $plano]);
            // die;

            // echo json_encode(['erro' => false, 'listaVencidos' => $listaVencidos]);
            // die;
            
            $data = date('d/m/Y');
            $data_timestamp = strtotime(str_replace('/', '-', $data));
            
            if (!empty($listaVencidos)) {
                foreach ($listaVencidos as $item) {
                    $vencimento_timestamp = strtotime(str_replace('/', '-', $item["vencimento"]));
                    
                    
                    
                    $user = $clientes_c->dados($item["id"]);
                    $plano = $planos_c->plano($user->id_plano);
                    $link_plano = 'https://cliente.' . $gestor_c->get_options("dominio") . '/clientes_' . $plano->id_user; // Link do vendedor que leva pro cliente logar na sua área.
                    
                    $dataVencimento = DateTime::createFromFormat('d/m/Y', $user->vencimento);
                    $dataAtual = new DateTime();
                    $dias_vencimento = $dataAtual->diff($dataVencimento)->days;
                    
                    $ar1 = array('{senha_cliente}', '{nome_cliente}', '{primeiro_nome_cliente}', '{email_cliente}', '{telefone_cliente}', '{vencimento_cliente}', '{plano_valor}', '{data_atual}', '{plano_nome}', '{plano_link}', '{dias_vencimento}');
                    $ar2 = array($user->senha, $user->nome, explode(' ', $user->nome)[0], $user->email, $user->telefone, $user->vencimento, $plano->valor, date('d/m/Y'), $plano->nome, $link_plano, $dias_vencimento);
                    $texto = str_replace($ar1, $ar2, $text);

                    if ($data_timestamp > $vencimento_timestamp) {
                        
                        $telefone_sem_formatacao = str_replace([' ', '(', ')', '-'], '', $item["telefone"]);
                        $phone = $telefone_sem_formatacao;
                        
                        
                        $whatsapi_c->fila($phone, $texto, $idAtual, $device_id, 'ZAPI', '0000', '0000');
                        echo json_encode(['erro' => false, 'msg' => 'Enviado']);
                        die;

                    }
                }
            } else {
                echo json_encode(['erro' => true, 'msg' => 'A lista de vencidos está vazia.']);
                die;
            }

        } else {
            echo json_encode(['erro' => true, 'msg' => 'Você não está conectado na API do WhatsApp.']);
            die;
        }

        //}jay11
    } else {
        echo json_encode(['erro' => true, 'msg' => 'A mensagem não pode ser vazia']);
        die;
    }
}

?>