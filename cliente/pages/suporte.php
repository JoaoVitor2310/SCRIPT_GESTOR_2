
  <?php

   include_once 'inc/head.php';
   include_once 'inc/nav-top.php';
   include_once 'inc/nav-sidebar.php';

   $clientes_class = new Clientes();
   $faturas_cliente = $clientes_class->list_fat($_SESSION['SESSION_CLIENTE']['id']);


  ?>



    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
          <div class="content-header-left col-md-4 col-12 mb-2">
            <h5 class="content-header-title">Olá, <?= explode(' ',$_SESSION['SESSION_CLIENTE']['nome'])[0];?> !</h5>
            <p style="color:#fff;">
            <?php

            $name = explode(' ',$_SESSION['SESSION_CLIENTE']['nome'])[0];

            // $msg_madruga = array(
            //   0 => "Ainda acordado?",
            //   1 => "Essas horas acordado!",
            //   2 => "Quem precisa dormir não é mesmo?",
            //   3 => "Dizem que Einstein dormia apenas 3 horas por dia.",
            //   4 => "Vai dormi jovem!",
            //   5 => "Falta de sono pode causar varios danos a saúde.",
            //   6 => "Vai lá, vai dormi, deixa que eu cuido das coisas pra você.",
            //   7 => "Sem sono? Pois é eu também...",
            //   8 => "Bom, agora deve ser meio dia em algum lugar não é mesmo.",
            //   9 => "Pois é {$name}, as vezes eu também não durmo de madrugada.",
            //   10 => "Você tem café ai? porquê eu quero um"
            // );

            $sp = $_SESSION['PAINEL']['slug'];

            $msg_boa_tarde = array(
              // 0 => "Oiii.. Como vc ta?",
              0 => "Agora são ".date('H:i').'',
              1 => "Precisa de alguma coisa ? <a href='{$link_gestor}/{$sp}/suporte' >Clique aqui</a>",
              2 => "Boa tarde!",
              // 4 => "Eu gosto de cookie com leite e você?",
              // 5 => "Hoje eu preciso fazer o que fiz ontem. Te ajudar <3",
              // 6 => "Tu viu que em 2024 o homem é pra voltar a Lua?",
              // 7 => "Deixa eu te conta. Sabia que a NASA vai voltar pra lua em 2024?",
              // 0 => "Quer conversar? <a href='{$link_gestor}/{$sp}/suporte' >Me chama aqui</a>",
              // 9 => "{$name} você gosta de kiwi?",
              // 10 => "Hey {$name}, ta tudo bem com vc?"
            );


            $hr = date(" H ");
            if($hr >= 12 && $hr<18) {
            $resp = $msg_boa_tarde[rand(0,1)];}
            else if ($hr >= 0 && $hr <4 ){
            $resp = $msg_boa_tarde[rand(0,1)];}
            else if($hr >= 4 && $hr <12){
            $resp = "Bom dia!";}
            else{
            $resp = "Boa noite";}

            echo "$resp";
            ?>
            </p>
          </div>
          <div class="content-header-right col-md-8 col-12">
            <div class="breadcrumbs-top float-md-right">
              <div class="breadcrumb-wrapper mr-1">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item text-white"> Vencimento: <i class="fa fa-calendar" ></i> <?= $_SESSION['SESSION_CLIENTE']['vencimento']; ?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div class="content-body"><!-- Basic Tables start -->


          <div class="row">
          	<div class="col-12">
          		<div class="card">
          			<div class="card-header">
          				<h4 class="card-title">Alguma dúvida? Ajuda ? Entre em contato conosco.</h4>
          			</div>
          			<div class="card-content collapse show">
          				<div style="white-space:  pre;" class="card-body"><?= $_SESSION['PAINEL']['suporte']; ?></div>
          			</div>
          		</div>
          	</div>
          </div>
          <!-- Basic Tables end -->

        </div>
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <?php include_once 'inc/footer.php';?>
