<?php

  require_once '../../class/Conn.class.php';
  require_once '../../class/Gestor.class.php';

  $gestor_class = new Gestor();

?>
<!DOCTYPE html>
<html lang="pt-br">
   <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <meta charset="UTF-8">
      <title>Redirecionando</title>
      <link href="https://<?= $gestor_class->get_options("dominio");?>/img/favicon.ico" rel="shortcut icon" />
	  <link href="https://<?= $gestor_class->get_options("dominio");?>/painel/css/bootstrap.min.css" rel="stylesheet">


   </head>
   <body translate="no">
      <div class="container">


             <div style="margin-top:100px!important;" class="row text-center">

                <div class="col-md-4"></div>

                <div id="body_center" class="col-md-4">

                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/c7/Loading_2.gif" width="200px;" />
                    <br />
                    <h3>Aguarde...</h3>

                </div>

                <div class="col-md-4"></div>
             </div>

      </div>

	  <script>


	     <?php

    	    if(isset($_GET['ref']) || isset($_GET['af'])){

    	        if(isset($_GET['af'])){
    	           echo 'setTimeout(function(){ location.href="https://'.$gestor_class->get_options("dominio").'?af='.$_GET['af'].'"; },4000);';
    	        }else{
    	           echo 'setTimeout(function(){ location.href="https://'.$gestor_class->get_options("dominio").'?ref='.$_GET['ref'].'"; },4000);';
    	        }

    	    }else{
    	        echo 'setTimeout(function(){ location.href="https://'.$gestor_class->get_options("dominio").'"; },4000);';

    	    } ?>



	  </script>

   </body>
</html>
