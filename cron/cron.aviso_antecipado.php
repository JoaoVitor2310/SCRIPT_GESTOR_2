<?php

echo "Cron aviso_antecipado <br>";

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
    
    if($device  == false){
      echo "Device é falso: {$user->id} <br>";

    }else{
      echo "Device é true: {$user->id} <br>";
    }

    if ($list) {

      while ($cliente = $list->fetch(PDO::FETCH_OBJ)) {
        echo "Cliente: {$cliente->nome} <br>";

        $data_format = str_replace('/', '-', $cliente->vencimento);

        // calcular data baseado no user
        $data = date('d/m/Y', strtotime('-' . $user->dias_aviso_antecipado . ' days', strtotime($data_format)));
        echo "Data que assinou: {$data} <br>";
        if ($data == date('d/m/Y')) {
          echo "Entrou no if da data <br>";
          
          
          echo "cliente->id_plano {$cliente->id_plano} <br>";
          $plano = $planos_class->plano($cliente->id_plano);
          
          
          if ($user->gera_fat_cli == 1) {
            echo "Entrou no if da data user->gera_fat_cli == 1 <br>";
            
            $new_fat_cli = array();
            $new_fat_cli['id_plano'] = $plano->id;
            $new_fat_cli['valor'] = str_replace('R$', '', str_replace(' ', '', $plano->valor));
            $new_fat_cli['data'] = date('d/m/Y');
            $new_fat_cli['status'] = 'Pendente';
            $new_fat_cli['id_cli'] = $cliente->id;
            $new_fat_cli['ref'] = sha1(date('d/m/Y H:i:s'));
            
            $clientes_class->create_fat((object) $new_fat_cli);
            
            
          }
          
          $link_plano = 'https://gestormaster.top/gmaster/p/' . str_replace('=', '', base64_encode($plano->id));
          // $link_plano = 'https://cliente.' . $gestor_c->get_options("dominio") . '/clientes_' . $plano->id_user;
          
          
          $ar1 = array('{senha_cliente}', '{nome_cliente}', '{primeiro_nome_cliente}', '{email_cliente}', '{telefone_cliente}', '{vencimento_cliente}', '{plano_valor}', '{data_atual}', '{plano_nome}', '{plano_link}');
          $ar2 = array($cliente->senha, $cliente->nome, explode(' ', $cliente->nome)[0], $cliente->email, $cliente->telefone, $cliente->vencimento, $plano->valor, date('d/m/Y'), $plano->nome, $link_plano);
          $text = str_replace($ar1, $ar2, $plano->template_zap);
          
          $ar1 = array('+', ')', '(', ' ', '-');
          $ar2 = array('', '', '', '', '');
          $phone = str_replace($ar1, $ar2, $cliente->telefone);

          $device_id = "000";
          $codigo = "000";
          $api = "000";
          

          if (strlen($phone) > 10) {
            echo "Entrou no if do telefone <br>";
            if ($device) {
              echo "Entrou no if do device <br>";
              
              $api = $device->api;
              
              if ($device->api == "chatpro") {
                $device_id = explode('@@@@', $device->device_id)[0];
                $codigo = explode('@@@@', $device->device_id)[1];
              } else {
                $device_id = $device->device_id;
                $codigo = "null";
              }
            }
            
            if ($plano) {
              echo "Entrou no if do plano <br>";

              if ($plano->template_zap != "") {
                echo " Dados para fila: {$phone}, {$text}, {$user->id}, {$device_id}, API: {$api}, {$codigo}, {$cliente->id} <br>";
      
                $whatsapi_class->fila($phone, $text, $user->id, $device_id, $api, $codigo, $cliente->id, "aviso_antecipado");
              }
            }
          }
        }
      }
    }
  }
}


?>