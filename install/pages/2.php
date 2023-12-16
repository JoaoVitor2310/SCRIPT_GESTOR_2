<?php

  @session_start();

  if(isset($_POST['host'])){

    if($_POST['user'] != "" && $_POST['host'] != "" && $_POST['banco'] != ""){

      $host  = trim($_POST['host']);
      $user  = trim($_POST['user']);
      $banco = trim($_POST['banco']);
      $senha = trim($_POST['senha']);

      $dados['{new_host}']  = $host;
      $dados['{new_user}']  = $user;
      $dados['{new_banco}'] = $banco;
      $dados['{new_senha}'] = $senha;

      $_SESSION['host']  = $host;
      $_SESSION['user']  = $user;
      $_SESSION['banco'] = $banco;
      $_SESSION['senha'] = $senha;
      $_SESSION['update'] = $_POST['update'];

      try{
        $pdo = new \PDO("mysql:host=$host;dbname=$banco", $user, $senha, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8MB4"));
        $pdo = null;

        // file 1
        $html = str_replace(array_keys($dados), array_values($dados),file_get_contents('files_model/Conn.class.php'));
        $arquivo = fopen('../class/Conn.class.php','w');
        fwrite($arquivo, $html);
        fclose($arquivo);

        // files post
        for ($i=1; $i < 4; $i++) {

          $id_file =  $i == 1 ? "" : $i;

          $html = str_replace(array_keys($dados), array_values($dados),file_get_contents('files_model/post'.$id_file.'.php'));
          $arquivo = fopen('../system/scripts/post'.$id_file.'.php','w');
          fwrite($arquivo, $html);
          fclose($arquivo);

          if($i>3){
            break;
          }


        }

        if($_POST['update'] == 1){

          // upload sql
          $sql_file = file_get_contents('files_model/options_system.sql');
          $link = mysqli_connect($host, $user, $senha, $banco);
          if (mysqli_multi_query($link, $sql_file)) {
             echo '<!DOCTYPE html>
             <html lang="pt-br" dir="ltr">
               <head>
                 <meta charset="utf-8">
                 <title>Instalação Gestor Master</title>

                 <link rel="stylesheet" href="../css/bootstrap.min.css">

                 <style media="screen">
                    body{
                      padding-top:100px;
                    }
                 </style>

               </head>
               <body>

                <center>
                 <img src="files_model/load.gif" />
                </center>

               <script>setTimeout(function(){
                 location.href="3";
               },5000);</script>


               </body>
              </html>';
              die;
          }

        }else{

          // upload sql
          $sql_file = file_get_contents('files_model/BASE_DE_DADOS.sql');
          $link = mysqli_connect($host, $user, $senha, $banco);
          if (mysqli_multi_query($link, $sql_file)) {
             echo '<!DOCTYPE html>
             <html lang="pt-br" dir="ltr">
               <head>
                 <meta charset="utf-8">
                 <title>Instalação Gestor Master</title>

                 <link rel="stylesheet" href="../css/bootstrap.min.css">

                 <style media="screen">
                    body{
                      padding-top:100px;
                    }
                 </style>

               </head>
               <body>

                <center>
                 <img src="files_model/load.gif" />
                </center>

               <script>setTimeout(function(){
                 location.href="3";
               },5000);</script>


               </body>
              </html>';
              die;
          }

        }




      }catch(PDOException $e){
        echo '<script>alert("Não foi possivel conectar");</script>';
      }

    }else{
      echo '<script>alert("Preencha os dados");</script>';
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
         padding-top:100px;
       }
    </style>

  </head>
  <body>

    <div class="container">
      <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="text-center alert alert-secondary">
                <h3>Etapa 2</h3>
                <p>Configurar banco de dados</p>
                <p>Preencha o formulário abaixo</p>
            </div>

            <div class="form-group">

              <form class="" action="" method="post">

                <select class="form-control" name="update" id="update" >
                  <option value="0">Instalação completa</option>
                  <option value="1">Apenas Atualização</option>
                </select>
                <small  style="margin-letf:10px;" class="text-danger" >É a primeira vez que está instalando?</small>
                <br>
                <br>
                <input style="margin-bottom:2px;" type="text" placeholder="Hostanem" value="localhost" name="host" class="form-control">
                <input style="margin-bottom:2px;" type="text" placeholder="Username" value="root" name="user" class="form-control">
                <input style="margin-bottom:2px;" type="text" placeholder="Senha" value="" name="senha" class="form-control">
                <input style="margin-bottom:2px;" type="text" placeholder="Banco de dados" value="gestor" name="banco" class="form-control">

                <button href="2" class="btn btn-success text-white" style="width:100%;" >Próximo</button>

              </form>

            </div>

          </div>
          <div class="col-md-2"></div>


      </div>
    </div>

  </body>
</html>
