<?php

  @session_start();

  if(isset($_SESSION['SESSION_USER']) && isset($_POST)){

    require_once '../class/Conn.class.php';
    require_once '../class/User.class.php';
    require_once '../class/Gestor.class.php';
    require_once '../class/Revenda.class.php';

    $user    = new User();
    $gestor  = new Gestor();
    $revenda = new Revenda();

    if(isset($_POST['add_cli'])){

        $dados = json_decode($_POST['dados']);


        if($dados){

          if($dados->nome != "" && $dados->email != "" && $dados->ddi != "" && $dados->telefone != "" && $dados->senha != "" && $dados->id_plano != "" && $dados->vencimento != ""){


            // dados do plano gestor
            $plano = $gestor->plano($dados->id_plano);

            if(!$plano){
              echo '{"erro":true,"msg":"Esse plano não está disponível no presente momento."}';
              die;
            }

            // verificar se user pode adicionar o user com a quantidade de créditos atual
            if($revenda->verific_creditos($plano->creditos,$dados->vencimento,$_SESSION['SESSION_USER']['id']) == false){
              echo '{"erro":true,"msg":"Seu saldo não é suficiente para essa compra."}';
              die;
            }


            if($user->verific_email($dados->email)){
              echo '{"erro":true,"msg":"Outro usuário já utiliza esse email."}';
              die;
            }

            if(!isset(explode(' ',$dados->nome)[1])){
              echo '{"erro":true,"msg":"Informe o sobrenome, por favor!"}';
              die;
            }else if(explode(' ',$dados->nome)[1] == ""){
              echo '{"erro":true,"msg":"Informe o sobrenome, por favor!"}';
              die;
            }

            if(strlen($dados->senha)<5 || $dados->senha == "123456" || $dados->senha == "abcdefgh" || $dados->senha == $dados->email){
              echo '{"erro":true,"msg":"Essa senha é fraca."}';
              die;
            }



            $ar_str1 = array(')','(',' ','-','.');
            $ar_str2 = array('','','','','');

            $dados->telefone = str_replace($ar_str1,$ar_str2,$dados->telefone);
            $dados->id_rev = $_SESSION['SESSION_USER']['id'];
            $dados->indicado = 0;

            $timestamp  = strtotime('+'.$dados->vencimento.' months',strtotime(date('d-m-Y')));
            $vencimento = date('d/m/Y', $timestamp);


            $creditos_gasto = ($plano->creditos*$dados->vencimento);

             if($user->create($dados,$vencimento,$dados->id_plano,$dados->id_rev,$dados->indicado)){
               $revenda->creditos_rev_change($_SESSION['SESSION_USER']['id'],$creditos_gasto);
               echo '{"erro":false,"msg":"Criado"}';
               die;
             }

          }else{
            echo '{"erro":true,"msg":"Por favor, preencha todos os campos."}';
            die;
          }

        }else{
          echo '{"erro":true,"msg":"Erro inesperado."}';
          die;
        }

    }






  }


?>
