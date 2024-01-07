<?php
// Feito pelo jay11 xD
@session_start();

if (isset($_SESSION['SESSION_USER']) && isset($_POST)) {

  require_once '../class/Conn.class.php';

  $conn = new Conn();
  $pdo = $conn->pdo();

  $creditos = trim($_POST['creditos']); // saldo atual do vendedor
  $credToAdd = trim($_POST['credToAdd']); // qtd que quer adicionar
  $userID = trim($_POST['userID']); // id do vendedor
  $cli = trim($_POST['cli']); // id do revendedor

  $daysToAdd = $credToAdd * 3; // Quantidade de dias que o revendedor irá "ganhar" no seu vencimento qnd compra créditos


  $queryVencimentoAntigo = $pdo->prepare("SELECT vencimento FROM `user` WHERE id = :cli LIMIT 1");
  $queryVencimentoAntigo->bindParam(':cli', $cli, PDO::PARAM_INT);
  $queryVencimentoAntigo->execute();
  $vencimentoAntigo = $queryVencimentoAntigo->fetch(PDO::FETCH_ASSOC);
  $vencimentoAntigo = $vencimentoAntigo['vencimento'];

  $dataVencimento = DateTime::createFromFormat('d/m/Y', $vencimentoAntigo);

  // Adicionando os dias desejados
  $dataVencimento->add(new DateInterval('P' . $daysToAdd . 'D'));

  // Obtendo a nova data formatada
  $novaData = $dataVencimento->format('d/m/Y');

  
  
  
  
  // // Ir na tabela "clientes" e add o novaData no vencimento do id igual ao $cli
  $queryDaysToAdd = $pdo->prepare("UPDATE user SET vencimento = :novaData WHERE id = :cli");
  $queryDaysToAdd->bindParam(':novaData', $novaData, PDO::PARAM_STR);
  $queryDaysToAdd->bindParam(':cli', $cli, PDO::PARAM_INT);
  $queryDaysToAdd->execute();
  
  // Ir no banco de dados creditos_rev e ver quantos créditos o revendedor tem através do id dele
  $query = $pdo->prepare("SELECT qtd FROM `creditos_rev` WHERE id_user = :cli LIMIT 1");
  $query->bindParam(':cli', $cli, PDO::PARAM_INT);
  $query->execute();

  $result = $query->fetch(PDO::FETCH_ASSOC);

  // Ir no banco de dados creditos_rev e adicionar os créditos para o revendedor através do id
  $saldoRev = $result['qtd'];
  $novoSaldo = $saldoRev + $credToAdd;

  $query2 = $pdo->prepare("UPDATE creditos_rev SET qtd = :novoSaldo WHERE id_user = :cli");
  // $query2 = $pdo->prepare("INSERT INTO `creditos_rev` ('qtd') VALUES :novoSaldo = :cli ");
  $query2->bindParam(':cli', $cli, PDO::PARAM_INT);
  $query2->bindParam(':novoSaldo', $novoSaldo, PDO::PARAM_INT);

  if($query2->execute()){
      $saldoVendedor = $creditos - $credToAdd;        

      $query3 = $pdo->prepare("UPDATE creditos_rev SET qtd = :saldoVendedor WHERE id_user = :userID");
      $query3->bindParam(':saldoVendedor', $saldoVendedor, PDO::PARAM_INT);
      $query3->bindParam(':userID', $userID, PDO::PARAM_INT);
      $query3->execute();
      $result = $query3->fetch(PDO::FETCH_ASSOC);

      echo '{"erro":false,"msg":"Adicionado"}';
  }else{
    echo '{"erro":true,"msg":"Houve algum erro ao adicionar os créditos, tente novamente."}';
  }

}


?>