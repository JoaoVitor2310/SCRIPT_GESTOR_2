
  <?php

   include_once 'inc/head.php';
   include_once 'inc/nav-top.php';
   include_once 'inc/nav-sidebar.php';


   $clientes_class = new Clientes();
   $planos_class = new Planos();
   $gateways_class = new Gateways();
  
   
   
   if(isset($_POST['meio_pay_idFat'])){
       
       include_once 'control/send_comp.php';
      //  header('Location: ' . $_SERVER['PHP_SELF']);
      //   exit;
   }

   $faturas_cliente = $clientes_class->list_fat($_SESSION['SESSION_CLIENTE']['id']);
   $picpay_gate = $gateways_class->dados_picpay_user($_SESSION['PAINEL']['id_user']);
   $ph_gate = $gateways_class->dados_ph_user($_SESSION['PAINEL']['id_user']);
   $banco_gate = $gateways_class->dados_bank_user($_SESSION['PAINEL']['id_user']);

   $idCliente = $_SESSION['SESSION_CLIENTE']['id'];

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

            // $idCliente = $_SESSION['SESSION_CLIENTE']['id'];
            // echo $idCLiente;

            $msg_boa_tarde = array(
              // 0 => "Oiii.. Como vc ta?",
              0 => "Agora são ".date('H:i').'',
              1 => "Precisa de alguma coisa? <a href='{$link_gestor}/{$sp}/suporte' >Clique aqui</a>",
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
          				<h4 class="card-title">Últimas faturas</h4>
          				<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
          				<div class="heading-elements">
          					<ul class="list-inline mb-0">
          						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
          						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
          					</ul>
          				</div>
          			</div>
          			<div class="card-content collapse show">
          				<div class="card-body">
          					<p class="card-text"> Arraste para o lado para ver as ações no celular</p>
          					<?php 
          					  
          					  if(isset($msg)){
          					      echo '<br /><div class="alert alert-info" >'.$msg.'</div>';
          					  }
          					
          					?>
          					<div class="table-responsive">
          						<table class="table">
          							<thead>
          								<tr>
          								    <?php if($plano_gate == 1 && $mp_credenciais == true || $picpay_gate == true || $banco_gate == true && $fat->status == "Pendente"){
                                                echo '<th>Pagar</th>';
                                            } ?>
          									<th>Valor</th>
          									<th>Status</th>
          									<th>Data</th>
                                            <th>Plano</th>
                                            <th>Comprovante</th>
                                    		<th>#</th>

          								</tr>
          							</thead>
          							<tbody>
                          <?php

                        if($faturas_cliente){

                          while ($fat = $faturas_cliente->fetch(PDO::FETCH_OBJ)) {

                            $plano = $planos_class->plano($fat->id_plano);

                            switch ($fat->status) {
                              case 'Pendente': $status = "<span class='badge badge-secondary' ><i class='fa fa-credit-card' ></i> Pendente</span>"; break;
                              case 'Pago': $status = "<span class='badge badge-success' ><i class='fa fa-check' ></i> Pago</span>"; break;
                              case 'Devolvido': $status = "<span class='badge badge-danger' ><i class='fa fa-refresh' ></i> Devolvido</span>"; break;
                              case 'Rejeitado': $status = "<span class='badge badge-danger' ><i class='fa fa-close' ></i> Rejeitado</span>"; break;
                              default: $status = "<span class='badge badge-info' >{$fat->status}</span>"; break;
                            }

                            ?>
            								<tr>
            								     <?php if($plano_gate == 1 && $mp_credenciais == true || $picpay_gate == true || $banco_gate == true && $fat->status == "Pendente"){
                                                    echo '<td><button class="'.$fat->ref.' btn btn-sm btn-info" onclick="paymodal('.$fat->id.');" >Pagar</button></td>';
                                                } ?>
            									
            									<td style="font-size:12px;">R$ <?= $fat->valor; ?></td>
            									<td><?= $status; ?></td>
            									<td><?= $fat->data; ?></td>
                                                <td><?= $plano->nome; ?></td>
                                                <td><?php 
                                                // Fazer busca para saber se já tem 1 ou mais comprovantes em comprovantes_fat_cli com o id do cliente, se tiver, não deixar anexar comprovante
                                                
                                                //jay11
                                                // echo $idCliente;
                                                
                                                require_once '../class/Conn.class.php';
                                                $conn = new Conn();
                                                $pdo = $conn->pdo();
                                                
                                                $idFat = $fat->id;
                                                
                                                $query = $pdo->prepare("SELECT * FROM `comprovantes_fat_cli` WHERE id_fat = :idFat LIMIT 1");
                                                $query->bindParam(':idFat', $idFat, PDO::PARAM_INT);
                                                $query->execute();

                                                // Recuperar o resultado
                                                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                                                $tamanho = count($result);
                                                $podeEnviarComp = true;
                                                
                                                if($tamanho >= 1){
                                                  $podeEnviarComp = false;
                                                }
                                                
                                                $nomeCategoria = $result['nome'];
                                                
                                                if($podeEnviarComp){
                                                  
                                                  
                                                    if($fat->comprovante == "not"){ // Versão "original"
                                                      if($fat->status === 'Pendente'){
                                                        echo '<form action="" method="post" enctype="multipart/form-data" id="form_comp_'.$fat->id.'" ><label style="cursor:pointer;" class="text-info" for="comp_'.$fat->id.'" > <i class="fa fa-upload" ></i> Anexar comprovante</label><input onchange="$(\'#form_comp_'.$fat->id.'\').submit()" id="comp_'.$fat->id.'" type="file" style="display:none;" name="comprovante" /><input id="meio_pay_idFat" type="hidden" value="'.$fat->id.'" name="meio_pay_idFat" /><input id="id_plano" type="hidden" value="'.$fat->id_plano.'" name="id_plano" /><input id="valor_fat" type="hidden" value="'.$fat->valor.'" name="valor_fat" /></form>';
                                                      }else{
                                                        echo '<label class="text-info"> Comprovante já anexado</label>';
                                                      }
                                                    }
                                                }else{
                                                  echo '<label class="text-info"> Comprovante já anexado</label>';
                                                }
                                                //jay11

                                                ?></td>
                                                <th scope="row"><?= $fat->id; ?></th>
                                               
            								</tr>
            								            								   
                                            <!-- Modal -->
                                            <div class="modal fade" id="modal_method_pay_<?= $fat->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modal_method_pay" aria-hidden="true">
                                              <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="title_modal_method_pay_<?= $fat->id; ?>">Pagar fatura</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body" id="body_modal_pay_<?= $fat->id; ?>">
                                                     
                                                     <div class="row">
                                                         
                                                         
                                                         <div class="col-md-12">
                                                             <p>
                                                                 Olá <?= explode(' ',$_SESSION['SESSION_CLIENTE']['nome'])[0];?>. Como pretende pagar esta fatura ?
                                                             </p>
                                                         </div>
                                                         
                                                         <div id="dados_show_pay_<?= $fat->id; ?>" class="row " style="margin-left:10px;display:none;" >
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <button onclick="voltar_payments_methods(<?= $fat->id; ?>);" class="btn btn-outline-secondary btn-sm" > <i class="fa fa-arrow-left"></i> Voltar</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-1"></div>
                                                                    <div class="col-md-10">
                                                                        <div id="dados_gate_<?= $fat->id; ?>"></div>
                                                                    </div>
                                                                    <div class="col-md-1"></div>
                                                                </div>
                                                                 
                                                             </div>
                                                         
                                                         </div>
                                                         
                                                         <div class="text-center col-md-12" id="body_pay_second_<?= $fat->id; ?>" >
                                                             <div class="row">
                                                                 <div class="col-md-12">
                                                                     
                                                                    <?php if($plano_gate == 1 && $mp_credenciais == true && $fat->status == "Pendente" && $mp_credenciais->client_id != "" && $mp_credenciais->client_secret != ""){ ?>
                                                                      <button id="btn_payment_<?= $fat->id; ?>" onclick="payment('<?= $fat->id; ?>','<?= $fat->ref; ?>','MP','<?= $fat->valor; ?>','<?= $plano->nome; ?>');" style="width:100%!important;margin-bottom:5px;" class="btn btn-outline-info" >Mercado Pago <i class="fa fa-handshake-o" ></i></button> 
                                                                    <?php } ?>
                                                                 
                                                                 </div>
                                                                 
                                                                 <div class="col-md-12">
                                                                     <?php if(!empty((array)$picpay_gate)){ ?>
                                                                      <?php if($picpay_gate->situ == 1){ ?>
                                                                       <textarea id="dados_picpay_<?= $fat->id; ?>" style="display:none">
                                                                          <?php echo str_replace('{valor}',$fat->valor,$picpay_gate->content);?>
                                                                        </textarea>
                                                                       <button onclick="show_dados_picpay(<?= $fat->id; ?>);" style="width:100%!important;margin-bottom:5px;" class="btn btn-outline-success" >PicPay <i class="fa fa-qrcode" ></i> </button>
                                                                      <?php } ?>
                                                                    <?php } ?>
                                                                 </div>
                                                                 
                                                                 <div class="col-md-12">
                                                                      
                                                                      <?php if($ph_gate){ ?>
                                                                       <?php if($ph_gate->situ == 1){ ?>
                                                                        <button id="btn_payment_ph_<?= $fat->id; ?>" onclick="payment('<?= $fat->id; ?>','<?= $fat->ref; ?>','PH','<?= $fat->valor; ?>','<?= $plano->nome; ?>');" style="width:100%!important;margin-bottom:5px;" class="btn btn-outline-primary" > Boleto <i class="fa fa-barcode" ></i></button>
                                                                      <?php } ?>
                                                                    <?php } ?>
                                                                 </div>
                                                                 
                                                                 <div class="col-md-12">
                                                                      
                                                                      <?php if($banco_gate){ ?>
                                                                       <?php if($banco_gate->situ == 1){ ?>
                                                                        <textarea id="dados_ted_<?= $fat->id; ?>" style="display:none">
                                                                          <?php echo str_replace('{valor}',$fat->valor,$banco_gate->content);?>
                                                                        </textarea>
                                                                        <button onclick="show_dados_ted(<?= $fat->id; ?>);" style="width:100%!important;margin-bottom:5px;" class="btn btn-outline-secondary" > PIX <i class="fa fa-bank" ></i></button>
                                                                      <?php } ?>
                                                                    <?php } ?>
                                                                 </div>
                                                                 
                                                                 
                                                             </div>
                                                         </div>
                                                         
                                                     </div>
                                                 
                                                 
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                            <?php } }else{ ?>
                    
                                              <tr>
                                                <th class="text-center" colspan="7">Não há nenhuma fatura ainda.</th>
                                              </tr>
                    
                                            <?php } ?>

          							</tbody>
          						</table>
          					</div>
          				</div>
          			</div>
          		</div>
          	</div>
          </div>
          <!-- Basic Tables end -->

        </div>
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    
    <script>
        function show_dados_ted(id){
            var dados = $("#dados_ted_"+id).val();
            $("#body_pay_second_"+id).hide(100);
            $("#dados_gate_"+id).html(dados);
            $("#dados_show_pay_"+id).show(90);
        }
        
        function show_dados_picpay(id){
            var dados = $("#dados_picpay_"+id).val();
            $("#body_pay_second_"+id).hide(100);
            $("#dados_gate_"+id).html(dados);
            $("#dados_show_pay_"+id).show(90);
        }
        
        function voltar_payments_methods(id){
            $("#dados_gate_"+id).html('');
            $("#dados_show_pay_"+id).hide(100);
            $("#body_pay_second_"+id).show(90);
        }
    </script>

    <?php include_once 'inc/footer.php';?>
