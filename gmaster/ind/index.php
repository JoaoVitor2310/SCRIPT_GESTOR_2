<?php

 require_once 'autoload.php';
 require_once 'system.php';

  if($auth == false){
      header('LOCATION: https://'.$gestor_class->get_options("dominio").'/gmaster/403/');
      exit();
  }

?>
