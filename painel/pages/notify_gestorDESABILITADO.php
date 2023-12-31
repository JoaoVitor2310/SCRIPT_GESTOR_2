 <?php

    $dados_notify = $user->notify_page;


    if($dados_notify == NULL && $dados_notify == ""){
        $notify = 0;
        $teste  = false;
        $bussines = "";
    }else{
        $jsonNotify = json_decode($dados_notify);
        $notify     = $jsonNotify->notify;
        $teste      = $jsonNotify->teste;
        $bussines   = $jsonNotify->bussines;
    }


 ?>


<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>


    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>

    <main class="page-content">
<div class="">

            <div style="padding: 10px;-webkit-box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);width: 99%;" class="card row" >

          <div class="col-md-12">
            <h1 class="h2">Notificações de conversão Gestor <i class="fa fa-bell" ></i> <span class="badge badge-danger">BETA</span></h1>
            <p>
                Passe credibilidade a novos visitantes, notificando sobre conversões recentes.
            </p>
          </div>

          <div class="col-md-12">
            <hr>
            <div class="form-group" >
                <button onclick="$('#modal_code').modal('show');" class="btn btn-sm btn-info" > <i class="fa fa-code"></i> Instalação</button>
            </div>

            <div class="form-group" >
                <h3>Faça os ajustes necessários</h3>
            </div>

             <div class="form-group">
                <label>Status das notificações</label>
                <select class="form-control" id="notify" >
                    <option <?php if($notify == 1){ echo 'selected'; } ?> value="1" >Ativar</option>
                    <option <?php if($notify == 0){ echo 'selected'; } ?> value="0" >Desativar</option>
                </select>
            </div>

            <div class="form-group">
                <label>Conversões fakes (sandbox)</label>
                <select class="form-control" id="teste" >
                    <option <?php if($teste == true){ echo 'selected'; } ?> value="true" >Ativar Conversões Fakes</option>
                    <option <?php if($teste == false){ echo 'selected'; } ?> value="false" >Desativar Conversões Fakes</option>
                </select>
                <small>Se ativo, as conversões reais não serão mostradas</small>
            </div>

            <div class="form-group">
                <label>Nome Business</label>
                 <input type="text" class="form-control" value="<?= $bussines; ?>" placeholder="ex: Sua empresa" id="bussines" />
                <small>Nome da sua empresa ou negócio</small>
            </div>

            <div id="preview-notify" class="form-group">

            </div>

           <div class="form-group">
                 <button id="btn_config_notify" class="btn btn-success btn-lg" onclick="setConfNotify();" style="width:100%;" >Salvar</button>
            </div>

          </div>
      </div>
      </div>
    </main>
  </div>
</div>

<!--  Modal response add error -->
<div class="modal fade" id="modal_error" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="">Aconteceu algo de errado</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_del_mov" >
       <input type="hidden" name="input_id_del_mov" id="input_id_del_mov" value="">

       <h3 class="text-danger" > <i class="fa fa-close"></i> Oops!</h3>
       <h4 id="msg_error" class="text-danger" ></h4>
     </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    </div>
  </div>
</div>
</div>

<!--  Modal code successfull -->
<div class="modal fade" id="modal_code" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="">Faça a instalação em seu site</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_del_mov" >


        <div class="form-group">

        <b>1 -</b> Copie o código abaixo: <br />

         <pre><code>
<span style="color:green;">&lt;!-- gestormaster.top notify --&gt;</span>
<span style="color:#ff6a00;">&lt;script&gt;</span>
   (<span style="color:#7806f5fc;">function</span>(<span style="color:#0671f5fc;">d</span>, <span style="color:#0671f5fc;">s</span>, <span style="color:#0671f5fc;">id</span>) {
    <span style="color:#ff6a00;">var</span> <span style="color:#0671f5fc;">js</span>, <span style="color:#0671f5fc;">fjs</span> = <span style="color:#0671f5fc;">d</span>.<span style="color:#7a09f5;">getElementsByTagName</span>(<span style="color:#0671f5fc;">s</span>)[<span style="color:#f50606fc;">0</span>];
    <span style="color:#7a09f5;">if</span> (<span style="color:#0671f5fc;">d</span>.<span style="color:#7a09f5;">getElementById</span>(<span style="color:#0671f5fc;">id</span>)) <span style="color:#f50606fc;">return</span>;
    <span style="color:#0671f5fc;">js</span>  = <span style="color:#0671f5fc;">d</span>.<span style="color:#7a09f5;">createElement</span>(<span style="color:#0671f5fc;">s</span>); <span style="color:#0671f5fc;">js</span>.<span style="color:#f506ee;">id</span> = <span style="color:#0671f5fc;">id</span>;
    <span style="color:#0671f5fc;">memberidGl</span> = <span style="color:#f50606fc;"><?= $user->id; ?></span>;
    <span style="color:#0671f5fc;">js</span>.<span style="color:#f506ee;">src</span> = <span style="color:#0e792ffc;">'https://gestormaster.top/notify-gestor/notify-gestorlite.js?v=9'</span>;
    <span style="color:#0671f5fc;">fjs</span>.<span style="color:#f506ee;">parentNode</span>.<span style="color:#7a09f5;">insertBefore</span>(<span style="color:#0671f5fc;">js</span>, <span style="color:#0671f5fc;">fjs</span>);
    }(<span style="color:#0671f5fc;">document</span>, <span style="color:#0e792ffc;">'script'</span>, <span style="color:#0e792ffc;">'notify-gestor-lite'</span>));
<span style="color:#ff6a00;">&lt;/script&gt;</span>
<span style="color:green;">&lt;!-- gestormaster.top notify --&gt;</span>
</code></pre>

        <br />
        <b>2 -</b> Em seu site, cole o código entre as tags <code>&lt;head&gt;&lt;/head&gt;</code><br />
        <br />
        <b>3 - </b> Acesse seu site, aguarde alguns segundos e verá as notificações<br />
        <center><img src="https://gestormaster.top/assets/images/notify-gestorlite.gif?v=2" /></center>
        </div>

     </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    </div>
  </div>
</div>
</div>



 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
