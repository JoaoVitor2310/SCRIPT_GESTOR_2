<?php
@session_start();

if (isset($_SESSION['SESSION_USER'])) {

  if (isset($_POST)) {

    require_once '../class/Conn.class.php';
    require_once '../class/User.class.php';
    require_once '../class/Revenda.class.php';

    require_once '../class/Conn.class.php';
    $conn = new Conn();
    $pdo = $conn->pdo();

    $user = new User();
    $revenda = new Revenda();

    $cli = $_POST['id']; // quem é deletado
    $userID = $_POST['userID']; // user atual

    // buscar dados do cliente
    $cliente = $revenda->dados_cli($cli); // busca dados de quem será deletado

    // Identificar todos os usuários que são "filhos" do "id" CHECK
    // Mudar o "id_rev" desses "filhos" para o valor de userID CHECK
    // Apagar o "pai" na tabela user CHECK e creditos_rev CHECK

    // Caso exemplo: teste2(avô) deletando o teste6(pai) que possui o teste66(filho), o id_rev do teste66 deve ser igual ao teste2 dps de deletado
    // -na tabela user, buscar todos os id que possuem o id_rev do teste6(3865)

    $query = $pdo->prepare("SELECT id FROM `user` WHERE id_rev = :cli");
    $query->bindParam(':cli', $cli, PDO::PARAM_INT);
    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_ASSOC); // todos os id dos filhos estão aqui em um array de objetos
    // echo json_encode($result[0]['id']);
    $tamanho = count($result);
    
    for ($i = 0; $i < $tamanho; $i++) {//        3859 = 3835          id = 
      $idPai = $result[$i]['id'];
      $query2 = $pdo->prepare("UPDATE user SET id_rev = :userID WHERE id = :idPai");
      $query2->bindParam(':userID', $userID, PDO::PARAM_INT);
      $query2->bindParam(':idPai', $idPai, PDO::PARAM_INT);
      $query2->execute();
      // echo json_encode(3);
    }



    if ($_SESSION['SESSION_USER']['id'] == $cliente->id_rev) {

      $delete = $revenda->delete_user($cli);

      if ($delete) {

        $query3 = $pdo->prepare("DELETE FROM creditos_rev WHERE id_user = :cli "); // DELETE FROM `user` WHERE id='$id' 
        $query3->bindParam(':cli', $cli, PDO::PARAM_INT);
        $query3->execute();
        echo '1';

      } else {

        echo '0';

      }

    } else {

      echo '0';

    }


  } else {

    echo '0';

  }
}


?>