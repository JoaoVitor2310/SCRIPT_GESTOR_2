<?php 

    @session_start();
    

    if(!isset($_SESSION['AFILIADO'])){
        header('Location: https://gestormaster.top/parceiro/login');
        exit();
    }

    if($_SESSION['AFILIADO']['parceiro'] == 0){
        header('Location: https://gestormaster.top/parceiro/sair');
        exit();
    }


?>