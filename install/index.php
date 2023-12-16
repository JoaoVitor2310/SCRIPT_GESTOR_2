<?php

  if(isset($_GET['url'])){

     $exurl = explode('/',$_GET['url'])[0];

     if(is_file("pages/{$exurl}.php")){
       include_once "pages/{$exurl}.php";
     }else{
       echo "404";
     }

  }else{
    include_once 'pages/1.php';
  }


?>
