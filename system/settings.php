<?php

 if(!isset($_SESSION['ADMIN_LOGADO'])){
     echo '<script>location.href="index.php?page=login";</script>';
     die;
 }


 $whatsapi_class = new Whatsapi();
 $comprovantes_class = new Comprovantes();
 $gestor_class = new Gestor();

 if(isset($_POST['dominio'])){

   $ar_post = $_POST;

   foreach ($ar_post as $key => $value) {
     $gestor_class->update_settings($key,$value);
   }

 }

 $traffic_class = new Traffic();
 $num_traffic   = $traffic_class->count_traffic_prossing();


 $flyers_class = new Flyer();
 $num_flyers   = $flyers_class->count_flyer_prossing();


 $num_fila_zap  = $whatsapi_class->count_fila();
 $num_comprovantes = $comprovantes_class->count_comp();

 $atualizacoes = $gestor_class->get_updates();

 $list_contatos3 = $gestor_class->list_contatos();
 if($list_contatos3){
 $num_contatos   = count($list_contatos3->fetchAll(PDO::FETCH_OBJ));
 }else{
     $num_contatos = 0;
 }


?>
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Administrativo</title>
    <link href="../img/favicon.ico" rel="shortcut icon" />

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.5/dist/css/bootstrap.min.css" rel="stylesheet" >

    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/font-awesome.min.css"/>

    <meta name="theme-color" content="#563d7c">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
  </head>
  <body>
      <?php require_once 'inc/nav.php'; ?>


<div class="container-fluid">
  <div class="row">
    <?php require_once 'inc/menu.php'; ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"> <i class="fa fa-cogs" ></i> Configurações do sistema</h1>
      </div>
      <?php if(isset($_GET['msg_hide'])){ ?>
      <div id="msg_hide" class="alert alert-<?= $_GET['color_msg_hide']?>" >
          <?= $_GET['msg_hide']; ?>
      </div>
      <script>
          setTimeout(function(){
              $("#msg_hide").hide(100);
          },5000);
      </script>
      <?php } ?>

       <div class="card">
        <div class="card-body" >

          <div class="row">

              <div class="col-md-2" ></div>
              <div  class="col-md-8" >
                  <form class="" action="" method="post">
                    <div class="form-group" >
                        <label for="">Dominio sistema</label>
                        <input type="text" class="form-control" placeholder="Dominio do sistema" value="gestormaster.top" name="dominio" id="dominio" />
                    </div>
                    <div class="form-group" >
                        <label for="">Endereço API Whatsapp</label>
                        <input type="text" class="form-control" placeholder="Endereço API Whatsapp" value="<?= $gestor_class->get_options("api_zap_address"); ?>" name="api_zap_address" id="api_zap_address" />
                        <small>Adicione com a porta se possuir</small>
                    </div>
                    <div class="form-group" >
                        <label for="">Client ID imgur.com</label>
                        <input type="text" class="form-control" placeholder="Api Imgur Client ID" value="<?= $gestor_class->get_options("client_id_imgur"); ?>" name="client_id_imgur" id="client_id_imgur" />
                    </div>

                    <div class="form-group" >
                        <label for="">Painel Mod</label>
                        <select class="form-control" name="mod_ligh" id="mod_ligh">

                          <option <?php if($gestor_class->get_options("mod_ligh") == "1"){ echo 'selected'; } ?> value="1">Modo Folk</option>
                          <option <?php if($gestor_class->get_options("mod_ligh") == "0"){ echo 'selected'; } ?> value="0">Modo Light</option>

                        </select>
                    </div>

                    <div class="form-group" >
                        <label for="">Cor Background Admin</label>
                        <input type="color" class="form-control" placeholder="Cor Background" value="<?= $gestor_class->get_options("color_background_admin"); ?>" name="color_background_admin" id="color_background_admin" />
                        <small>Consegues alterar a cor apenas no modo Folk</small>
                    </div>
                    <div class="form-group" >
                        <label for="">Cor Menu Admin</label>
                        <input type="color" class="form-control" placeholder="Cor Menu" value="<?= $gestor_class->get_options("color_menu_admin"); ?>" name="color_menu_admin" id="color_menu_admin" />
                        <small>Consegues alterar a cor apenas no modo Folk</small>
                    </div>

                    <div class="form-group" >
                        <button class="btn btn-lg btn-outline-primary" style="width:100%;" >Salvar</button>
                    </div>
                  </form>
              </div>
              <div class="col-md-2" ></div>
          </div>

        </div>
      </div>
    </main>
  </div>
</div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <script>

     function recheck(){
         $("#btn_recheck").hide(100);
         $("#return-check").hide();
         $("#form-check").show();
     }


       function checkZap(){

            $("#btnCheck").prop('disabled', true);
            $("#btnCheck").html('Um momento jovem...');

           var infoCli = $("#info_user").val();
           $.post("control/checkzap.php",{check:infoCli},function(data){

               $("#btnCheck").prop('disabled', false);
               $("#btnCheck").html('Checar');
               $("#btn_recheck").show();

               var obj = JSON.parse(data);

               if(obj.erro){

                   $("#form-check").hide(100);
                   $("#return-check").show();

                   if(typeof obj.type != 'undefined'){
                       $("#return-check").html('<h5 class="text-danger" >'+obj.msg+'</h5><p><i class="fa fa-calendar" ></i> '+obj.date+'</p>');
                   }else{
                       $("#return-check").html('<h5 class="text-danger" >'+obj.msg+'</h5><img src="img/not-connected.png" width="50%;" /><p><i class="fa fa-calendar" ></i> '+obj.date+'</p>');
                   }


               }else{

                   $("#form-check").hide(100);
                   $("#return-check").show();
                   $("#return-check").html('<h5 class="text-success" >'+obj.msg+'</h5><img src="img/connected.png" width="50%;" /><p><i class="fa fa-calendar" ></i> '+obj.date+'</p>');

               }

           });
       }




    </script>


 </body>
</html>
