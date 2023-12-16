<?php

  @session_start();


  if(isset($_GET['sair'])){
      unset($_SESSION['ADMIN_LOGADO']);
      if(isset($_SESSION['SUB_ACCESS'])){
         unset($_SESSION['SUB_ACCESS']);
         echo '<script>location.href="index.php?sub_access";</script>';
         die;
      }else{
         echo '<script>location.href="index.php";</script>';
         die;
      }
  }

if(!isset($_SESION['ADMIN_LOGADO'])){


     // login admin
     $username = "gabrielcpaes200@gmail.com";
     $senha = "-Mrpaes256103";

     // Google API
     $KEYSITE_RECAPTCHA = "6Leq5tQnAAAAAOBxmRz6XCD7nT03Ywv6_YSxQl9M";
     $KEYSECRET_RECAPTCHA = "6Leq5tQnAAAAAI2bUFmKsP7bCjaM4wH6ioyw7QOr";

}

 // Autoload
 class Autoload {

        public function __construct() {

            spl_autoload_extensions('.class.php');
            spl_autoload_register(array($this, 'load'));

        }

        private function load($className) {

            $extension = spl_autoload_extensions();
            @require_once ('../class/' . $className . $extension);
        }
    }

    $autoload = new Autoload();


?>
