<?php

// require 'vendor/autoload.php'; // Certifique-se de incluir o autoload do PhpSpreadsheet. QUEBRADO
@session_start();
header('Content-Type: application/json');



$json = new stdClass();


// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_SESSION['SESSION_USER'])) {

  require_once '../class/Conn.class.php';
  require_once '../class/Clientes.class.php';
  require_once '../class/Logs.class.php';

  $clientes = new Clientes();
  $logs = new Logs();
  $type = $_POST['type_export'];


  if (isset($_GET['example'])) { // Fazer download da planilha de exemplo
    $example = $_GET['example'];

    header('Content-disposition: attachment; filename=exemplo_planilha_gestor.json');
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    // Criar uma nova planilha
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Adicionar dados à planilha
    $sheet->setCellValue('A1', 'nome');
    $sheet->setCellValue('B1', 'email');
    $sheet->setCellValue('C1', 'telefone');
    $sheet->setCellValue('D1', 'vencimento');

    // Dados do cliente
    $cliente = [
      'nome' => 'Cliente 1',
      'email' => 'cliente@gmail.com',
      'telefone' => 'whatsapp cliente 
        (colocar 55 antes do número,
        pois 55 é o DDI do Brasil. 
        Depois colocar o DDD e o número)',
      'vencimento' => '12/11/2023
        Dia/Mês/Ano
        Ano deve conter 4
        dígitos (ex:2023)',
    ];

    // Preencher os dados do cliente na planilha
    $sheet->setCellValue('A2', $cliente['nome']);
    $sheet->setCellValue('B2', $cliente['email']);
    $sheet->setCellValue('C2', $cliente['telefone']);
    $sheet->setCellValue('D2', $cliente['vencimento']);

    // Configurar o cabeçalho para download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="exemplo_planilha.xlsx"');
    header('Cache-Control: max-age=0');

    // Criar um objeto Writer e salvar a planilha
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');


  } else if ($type == 'json') { // Exportar clientes
    $clientes_list = $clientes->list_export($_SESSION['SESSION_USER']['id']);
    
    if ($clientes_list) {
      
      $logs->log($_SESSION['SESSION_USER']['id'], "Exportou os clientes");
      
      header('Content-disposition: attachment; filename=usuarios_gestor_master.json');
      header('Content-type: application/json');
      
      echo json_encode($clientes_list);
      
    } else {
      
      $json->erro = true;
      $json->msg = "Erro ao listar seus clientes, talvez você não tenha clientes";
      echo json_encode($json);
      
    }
  } else { // Exportar em excel
    // echo 'XLSX!';
    $clientes_list = $clientes->list_export($_SESSION['SESSION_USER']['id']);

    require_once 'import-xlsx/src/SimpleXLSX.php';
    require_once '../class/Conn.class.php';

    if ($clientes_list) {
      // json_encode($clientes_list);
      // var_dump($clientes_list);

      $arquivo = 'clientes_gestor_master.xls';

      $html = '';
      $html .= '<meta charset="UTF-8">';
      $html .= '<table border="1">';
      $html .= '<tr>';
      $html .= '<td colspan="7"><center>Clientes - Gestor Master</center></td>';
      $html .= '</tr>';

      $html .= '<tr>';
      $html .= '<td><b>nome</b></td>';
      $html .= '<td><b>email</b></td>';
      $html .= '<td><b>telefone</b></td>';
      $html .= '<td><b>vencimento</b></td>';
      $html .= '<td><b>id_plano</b></td>';
      $html .= '<td><b>notas</b></td>';
      $html .= '<td><b>senha</b></td>';
      $html .= '</tr>';

      // $html .= '<tr>';
      // $html .= '<td colspan="7"></td>';
      // $html .= '</tr>';

      foreach ($clientes_list as $key => $value) {

        $tipo = $value->tipo == 1 ? "Entrada" : "Saida";


        $html .= '<tr>';
        $html .= '<td>' . $value->nome. '</td>';
        $html .= '<td>' . $value->email . '</td>';
        $html .= '<td>' . $value->telefone . '</td>';
        $html .= '<td>' . $value->vencimento . '</td>';
        $html .= '<td>' . $value->id_plano . '</td>';
        $html .= '<td>' . $value->notas . '</td>';
        $html .= '<td>' . $value->senha . '</td>';
        $html .= '</tr>';


      }

      $html .= "</table>";

      header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
      header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
      header("Cache-Control: no-cache, must-revalidate");
      header("Pragma: no-cache");
      header("Content-type: application/x-msexcel; charset=Windows-1252");
      header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
      header("Content-Description: PHP Generated Data");

      echo $html;
      exit;


    } 
    else {

      $json->erro = true;
      $json->msg = "Erro ao listar seus clientes, talvez você não tenha clientes";
      echo json_encode($json);
    }

  }



} else {

  $json->erro = true;
  $json->msg = "Não autorizado";
  echo json_encode($json);

}



?>