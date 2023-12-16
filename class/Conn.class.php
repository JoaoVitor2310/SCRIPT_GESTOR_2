<?php

 @date_default_timezone_set('America/Sao_Paulo');
 @session_start();

 class Conn{

   private $host;
   private $user;
   private $senha;
   private $bd;

  public function pdo(){

    $host   = "localhost";
    $user   = "u114732214_gestorMaster";
    $senha  = "9D^FQC/[53ie";
    $bd     = "u114732214_GestorMaster";
    try{
      $pdo = new \PDO("mysql:host=$host;dbname=$bd", $user, $senha, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8MB4"));

      if(isset($_SESSION['SEND_MAIL_ERRO'])){
        unset($_SESSION['SEND_MAIL_ERRO']);
      }

      return $pdo;
      $pdo = null;
    }catch(PDOException $e){
      echo "<div style='margin-top:100px;text-align:center;font-family:arial;'><h1 >Manutenção</h1><p>Retornaremos em breve</p><div>";

      die;
    }
  }

 }

 ?>
