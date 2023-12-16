<?php

  @session_start();

  if (isset($_POST['dominio'])){

    if($_POST['dominio'] != "" && $_POST['senha_admin'] != "" && $_POST['user_admin'] != "" && $_POST['keysite'] != ""
    && $_POST['keysecret'] != "" && $_POST['keysite_inv'] != "" && $_POST['keysecret_inv'] != ""){

      $dados['{dominio}']       = str_replace(array("https://", "http://"), array("",""), trim($_POST['dominio']));
      $dados['{senha_admin}']   = trim($_POST['senha_admin']);
      $dados['{user_admin}']    = trim($_POST['user_admin']);
      $dados['{keysite}']       = trim($_POST['keysite']);
      $dados['{keysecret}']     = trim($_POST['keysecret']);
      $dados['{keysite_inv}']   = trim($_POST['keysite_inv']);
      $dados['{keysecret_inv}'] = trim($_POST['keysecret_inv']);

      $_SESSION['dominio'] = $dados['{dominio}'];

      // file 1
      $html = str_replace(array_keys($dados), array_values($dados),file_get_contents('files_model/conf.php'));
      $arquivo = fopen('../system/conf/conf.php','w');
      fwrite($arquivo, $html);
      fclose($arquivo);

      // file 2
      $html = str_replace(array_keys($dados), array_values($dados),file_get_contents('files_model/cliente.login.php'));
      $arquivo = fopen('../login/login.php','w');
      fwrite($arquivo, $html);
      fclose($arquivo);

      // file 3
      $html = str_replace(array_keys($dados), array_values($dados),file_get_contents('files_model/chatbot.js'));
      $arquivo = fopen('../painel/js/chatbot.js','w');
      fwrite($arquivo, $html);
      fclose($arquivo);

      // file 4
      $html = str_replace(array_keys($dados), array_values($dados),file_get_contents('files_model/notify-gestorlite.js'));
      $arquivo = fopen('../notify-gestor/notify-gestorlite.js','w');
      fwrite($arquivo, $html);
      fclose($arquivo);

      // file 5
      $html = str_replace(array_keys($dados), array_values($dados),file_get_contents('files_model/cliente.control.login.php'));
      $arquivo = fopen('../control/control.login.php','w');
      fwrite($arquivo, $html);
      fclose($arquivo);


      try {
        $DOM = $dados['{dominio}'];

        $pdo = new \PDO("mysql:host=".$_SESSION['host'].";dbname=".$_SESSION['banco'], $_SESSION['user'], $_SESSION['senha'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8MB4"));

        if($_SESSION['update'] == 1){
          $pdo->query("UPDATE `options_system` SET value='{$DOM}' WHERE name='dominio' ");
        }else{
          $pdo->query("INSERT INTO `options_system` (name,value) VALUES ('dominio','{$DOM}') ");
        }



        echo '<script>location.href="4";</script>';

      } catch (\Exception $e) {
          echo '<script>alert("Desculpe, ocorreu um erro");</script>';
      }




    }else{
      echo '<script>alert("Preencha todos os campos");</script>';
    }


  }

 ?>

<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Instalação Gestor Master</title>

    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <style media="screen">
       body{
         padding-top:20px;
         margin-bottom: 100px;
       }
    </style>

  </head>
  <body>

    <div class="container">
      <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="text-center alert alert-secondary">
                <h3>Etapa 3</h3>
                <p>Algumas outras configurações</p>
            </div>

            <form class="" action="" method="post">

              <input style="margin-bottom:2px;" type="text" placeholder="Dominio do site (ex: seusite.com)" value="" name="dominio" class="form-control">
              <small class="text-danger" > Apenas seu dominio, sem <b>http:// </b> ou  <b>https://</b> <br /> ( <b>OBS</b> : Se instalou em subdominio adicione também. Ex: seusite.com/site)</small>

              <hr>


              <input style="margin-bottom:2px;cursor:no-drop;" disabled type="text" placeholder="Edereço admin ex: system" value="system" name="admin_uri" id="admin_uri" class="form-control">
              <small class="text-danger" > Qual nome da sua área admin? Depois acesse seusite.com/<b id="name_pasta" >system</b></small>

              <hr>

              <p>Credenciais Login admin</p>
              <input style="margin-bottom:2px;" type="text" placeholder="Usuário" value="" name="user_admin" class="form-control">
              <input style="margin-bottom:2px;" type="text" placeholder="Senha" value="" name="senha_admin" class="form-control">

              <hr>

              <p>Credenciais Google reCAPTCHA v2 (Versão Web - <b>Não sou um robô</b> )</p>
              <input style="margin-bottom:2px;" type="text" placeholder="Key Site" value="" name="keysite" class="form-control">
              <input style="margin-bottom:2px;" type="text" placeholder="Key Secret" value="" name="keysecret" class="form-control">

              <hr>

              <p>Credenciais Google reCAPTCHA v2 (Versão Web - <b>Invisível</b> )</p>
              <input style="margin-bottom:2px;" type="text" placeholder="Key Site" value="" name="keysite_inv" class="form-control">
              <input style="margin-bottom:2px;" type="text" placeholder="Key Secret" value="" name="keysecret_inv" class="form-control">

              <br>

              <button href="2" class="btn btn-success text-white" style="width:100%;" >Próximo</button>

            </form>

          </div>
          <div class="col-md-2"></div>


      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">

      $("#admin_uri").keyup(function(){
        var uri = $("#admin_uri").val();
        $("#name_pasta").html(uri);
      });

    </script>

  </body>
</html>
