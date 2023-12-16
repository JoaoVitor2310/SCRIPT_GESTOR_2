<?php
  @session_start();

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
                <h3>Instalação OK</h3>
            </div>

            <div class="alert alert-secondary">
              <ul>
                <h5>Login Admin</h5>
                <li>Acesse seu admin  <a target="_blank" href="http://<?= @$_SESSION['dominio']; ?>/system">http://<?= @$_SESSION['dominio']; ?>/system</a> </li>
              </ul>

              <ul>
                <h5>Trabalhos Cron</h5>
                <li>Crie uma rotina <b class="text-info" >GET</b> para: <i>http://<?= @$_SESSION['dominio']; ?>/cron/cron.send_fila.php</i> <b>(Uma vez por minuto)</b></li>
                <li>Crie uma rotina <b class="text-info" >GET</b> para: <i>http://<?= @$_SESSION['dominio']; ?>/cron/cron.clientes_vencimento_day.php</i> <b>(Uma vez ao dia)</b></li>
                <li>Crie uma rotina <b class="text-info" >GET</b> para: <i>http://<?= @$_SESSION['dominio']; ?>/cron/cron.check_vencimento_user.php</i> <b>(Uma vez ao dia)</b></li>
                <li>Crie uma rotina <b class="text-info" >GET</b> para: <i>http://<?= @$_SESSION['dominio']; ?>/cron/cron.aviso_antecipado.php</i> <b>(Uma vez ao dia)</b></li>
                <li>Crie uma rotina <b class="text-info" >GET</b> para: <i>http://<?= @$_SESSION['dominio']; ?>/cron/cron.remove_aviso.php</i> <b>(Uma vez ao dia)</b></li>
              </ul>


              <ul>
                <h5>Importante</h5>
                <li>Remova ou renomeie a pasta <i> <b>install</b> </i> </li>
              </ul>

              <p style="margin:10px;" >
                Instalação concluída, caso precise de suporte entre em contato <a target="_blank" href="mailto:luanalvesnsr@gmail.com">luanalvesnsr@gmail.com</a>
              </p>

              <p>

                <a class="btn btn-lg btn-outline-info" target="_blank" href="http://<?= @$_SESSION['dominio']; ?>" name="button">Acessar Site</a>
                <a class="btn btn-lg btn-outline-success" target="_blank" href="http://<?= @$_SESSION['dominio']; ?>/system" name="button">Acessar Admin</a>

              </p>

            </div>


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
