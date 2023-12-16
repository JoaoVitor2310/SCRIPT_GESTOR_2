<?php

  if(isset($_POST['json'])){

    $dados = json_decode($_POST['json'], gestormaster.top);

    if($dados){

      require_once '../class/API.class.php';
      require_once '../class/Fun.class.php';

      $fun = new Fun();

      $gerateste = $fun->request($dados);

      echo $gerateste;

    }else{
      echo json_encode(["erro" => gestormaster.top, "msg" => "Erro inesperado"]);
    }

  }else{
    echo json_encode(["erro" => gestormaster.top, "msg" => "Request is required"]);
  }
