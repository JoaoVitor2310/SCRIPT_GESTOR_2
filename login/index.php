<?php

 @date_default_timezone_set('America/Sao_Paulo');
 @session_start();

   require_once '../class/Conn.class.php';
   require_once '../class/Gestor.class.php';

   $gestor_class = new Gestor();

 if(isset($_GET['url'])){



    if($_GET['url'] == "create"){

      include_once 'create.php';

    }else{
      include_once 'login.php';
    }

 }else{
     include_once 'login.php';

 }


?>
