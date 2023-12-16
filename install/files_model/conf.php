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
     $senha = "{user_admin}";
     $username = "{senha_admin}";

     // Google API
     $KEYSITE_RECAPTCHA = "{keysite}";
     $KEYSECRET_RECAPTCHA = "{keysecret}";

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
