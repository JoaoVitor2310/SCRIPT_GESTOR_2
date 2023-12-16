<?php

 if(is_dir("install")){
   header("Location: install");
   die;
 }

 header("Access-Control-Allow-Origin: *");
 @date_default_timezone_set('America/Sao_Paulo');
 session_start();

 if(isset($_GET['af'])){
   $_SESSION['afiliado'] = $_GET['af'];
 }

if(isset($_GET['ref'])){
   $_SESSION['af'] = $_GET['ref'];
 }

 if(isset($_GET['url'])){

    $exurl = explode('/',$_GET['url']);

    if($exurl[0] == "pay"){

      include_once 'libs/pay.php';

    }
    // else if($exurl[0] == "faq"){

    //   include_once 'pages/faq.php';

    // }
    else if($exurl[0] == "contato"){

      include_once 'pages/contato.php';

    }else if($exurl[0] == "novogestor"){

      include_once 'pages/home1.php';

    }else if($exurl[0] == "b2c"){

      include_once 'pages/b2c.php';

    }else{
        include_once 'pages/404.php';
    }



 }else{
   include_once 'pages/home.php';
 }


?>
