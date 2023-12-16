<?php
$gestor_class = new Gestor();

if (!isset($whatsapi_class)) {
  $whatsapi_class = new Whatsapi();
}

// listar clientes

// $wsapi = $whatsapi_class->list_msgs('admin');
// var_dump($wsapi);

$v_device_zapi = $whatsapi_class->verific_device('admin', 'ZAPI');
// var_dump($v_device_zapi);

?>



<!doctype html>
<html lang="pt-br">

<!-- Head and Nav -->
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Gestor Master">
  <meta name="generator" content="Gestor Master">
  <title id="page-title">Connect ADM</title>

  <!-- Bootstrap core CSS -->
  
  <!-- 1 -->
  <link href="../painel/css/bootstrap.min.css?v=" rel="stylesheet">
  
  
  <link rel='../painel/stylesheet' href='https://use.fontawesome.com/releases/v5.0.13/css/all.css'>
  <link href="../painel/css/icons/css/font-awesome.min.css" rel="stylesheet">

  <!-- 2 -->
  <link href="../painel/css/novo-painel.css?v=" rel="stylesheet">

<!-- 3 -->
<link href="../painel/css/bootstrap.min.css?v=" rel="stylesheet">

   
  
  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.0.13/css/all.css'>
   <link href="../painel/css/icons/css/font-awesome.min.css" rel="stylesheet">
   
   <!-- 4 -->
   <link href="../painel/css/novo-painel.css?v=" rel="stylesheet">

  <link href="../painel/css/time-line.css" rel="stylesheet">



  <!-- CSS Emojis -->
  <link href="../painel/emojis/css/emoji.css" rel="stylesheet">


  <link href="../painel/js/calc/css/sunny/jquery-ui-1.8.16.custom.css" rel="stylesheet">
  <link href="../painel/js/calc/mathquill/mathquill.css" rel="stylesheet">

  <!-- Favicons -->
  <meta name="theme-color" content="#563d7c">

  <link href="https://gestormaster.top/img/favicon.ico" rel="shortcut icon" />


  <style>
    #mceu_86 {
      display: none !important;
    }

    #mceu_87 {
      display: none !important;
    }

    .goog-te-banner-frame {
      display: none;
    }

    .nav-item {
      text-transform: uppercase;
    }

    .ui-widget-content {
      background-color: #6610f2 !important;
    }

    .ui-widget-header {
      background-color: #9d62fd !important;
    }

    .ui-dialog {
      z-index: 99999 !important;
    }

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

    .alert-minimalist {
      background-color: rgb(241, 242, 240);
      border-color: rgba(149, 149, 149, 0.3);
      border-radius: 3px;
      color: rgb(149, 149, 149);
      padding: 10px;
    }

    .alert-minimalist>[data-notify="icon"] {
      height: 50px;
      margin-right: 12px;
    }

    .alert-minimalist>[data-notify="title"] {
      color: rgb(51, 51, 51);
      display: block;
      font-weight: bold;
      font-size: 12px;
      margin-bottom: 5px;
    }

    .alert-minimalist>[data-notify="message"] {
      font-size: 12px;
    }

    .sidebar-sticky::-webkit-scrollbar {
      width: 5px !important;
    }

    .sidebar-sticky {
      scrollbar-width: 5px !important;
      ;
    }


    .foxgo_ad {
      width: 100%;
      height: 1000px;
      z-index: 9999999999999;
      position: absolute;
    }

    .bg-dark .auth_title,
    .auth_small {
      color: #000;
    }
  </style>
  <!-- Custom styles for this template -->
  <link href="css/dashboard.css" rel="stylesheet">


</head>
<main class="page-content">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <div class="">
    <div
      style="padding: 10px;-webkit-box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);width: 99%;"
      class="card row">
      <div class="col-md-6">
        <h1 class="h2">WhatsAPI <i class="fa fa-whatsapp"></i></h1>
        <span style="font-size:10px;">
          <?= $idioma->mostrados_ultimos_50_whats_api; ?>
        </span>
        <br />
      </div>
      <div style="margin-bottom:10px;" class="col-md-12">
        <div class="btn-toolbar ">
          <div class="btn-group mr-12">
            <button onclick="location.href='../control/control.export_ws_msg.php';" type="button"
              class="btn btn-sm btn-outline-secondary"><i class="fa fa-download"></i> Download</button>
          </div>
        </div>
      </div>
      <!-- end btns -->
      <!-- table -->
    </div>
  </div>
</main>
</div>
</div>

<!--  Modal Scan whatsapp -->
<div data-backdrop="static" id="modal_pareamento_zapi" tabindex="-1" role="dialog"
  aria-labelledby="Titutlo_modal_pareamento">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Titutlo_modal_fat_cli">Utilizar API </h5>
        
      </div>
      <input id="cont_scan" value="0" style="display: none;"/>
      <div class="modal-body " id="body_modal_pareamento_zapi">

        <input id="status_load_qr"value="1" style="display: none;"/>
        <input value="<?php if ($v_device_zapi) {
          echo $v_device_zapi->device_id;
        } else {
          echo 'none';
        } ?> " id="keydevice_zapi" style="display: none;"/>

        <div class="row">
          <?php if ($v_device_zapi) { ?>
            <div class="col-md-12 text-center">
              <button onclick="remove_api_zapi();" id="remove_api_zapi" class="btn btn-primary btn-sm">Desativar
                API</button>
            </div>
          <?php } ?>

          <div class="col-md-6">
            <!-- <center><img src="img/easy_zapi.png" style="width:70%;" /></center> -->
            <br />
            <ol class="_1p68X">
              <li class="eGEEX">Abra o WhatsApp no seu celular</li>
              <li class="eGEEX"><span dir="ltr" class="_3Whw5 selectable-text invisible-space copyable-text">Toque em
                  <strong><span dir="ltr" class="_3Whw5 selectable-text invisible-space copyable-text">Mais opções <span
                        class="_3cZ5X"><svg height="24px" viewBox="0 0 24 24" width="24px">
                          <rect fill="#f2f2f2" height="24" rx="3" width="24"></rect>
                          <path
                            d="m12 15.5c.825 0 1.5.675 1.5 1.5s-.675 1.5-1.5 1.5-1.5-.675-1.5-1.5.675-1.5 1.5-1.5zm0-2c-.825 0-1.5-.675-1.5-1.5s.675-1.5 1.5-1.5 1.5.675 1.5 1.5-.675 1.5-1.5 1.5zm0-5c-.825 0-1.5-.675-1.5-1.5s.675-1.5 1.5-1.5 1.5.675 1.5 1.5-.675 1.5-1.5 1.5z"
                            fill="#818b90"></path>
                        </svg></span></span></strong> ou <strong><span dir="ltr"
                      class="_3Whw5 selectable-text invisible-space copyable-text">Ajustes <span class="_3cZ5X"><svg
                          width="24" height="24" viewBox="0 0 24 24">
                          <rect fill="#F2F2F2" width="24" height="24" rx="3"></rect>
                          <path
                            d="M12 18.69c-1.08 0-2.1-.25-2.99-.71L11.43 14c.24.06.4.08.56.08.92 0 1.67-.59 1.99-1.59h4.62c-.26 3.49-3.05 6.2-6.6 6.2zm-1.04-6.67c0-.57.48-1.02 1.03-1.02.57 0 1.05.45 1.05 1.02 0 .57-.47 1.03-1.05 1.03-.54.01-1.03-.46-1.03-1.03zM5.4 12c0-2.29 1.08-4.28 2.78-5.49l2.39 4.08c-.42.42-.64.91-.64 1.44 0 .52.21 1 .65 1.44l-2.44 4C6.47 16.26 5.4 14.27 5.4 12zm8.57-.49c-.33-.97-1.08-1.54-1.99-1.54-.16 0-.32.02-.57.08L9.04 5.99c.89-.44 1.89-.69 2.96-.69 3.56 0 6.36 2.72 6.59 6.21h-4.62zM12 19.8c.22 0 .42-.02.65-.04l.44.84c.08.18.25.27.47.24.21-.03.33-.17.36-.38l.14-.93c.41-.11.82-.27 1.21-.44l.69.61c.15.15.33.17.54.07.17-.1.24-.27.2-.48l-.2-.92c.35-.24.69-.52.99-.82l.86.36c.2.08.37.05.53-.14.14-.15.15-.34.03-.52l-.5-.8c.25-.35.45-.73.63-1.12l.95.05c.21.01.37-.09.44-.29.07-.2.01-.38-.16-.51l-.73-.58c.1-.4.19-.83.22-1.27l.89-.28c.2-.07.31-.22.31-.43s-.11-.35-.31-.42l-.89-.28c-.03-.44-.12-.86-.22-1.27l.73-.59c.16-.12.22-.29.16-.5-.07-.2-.23-.31-.44-.29l-.95.04c-.18-.4-.39-.77-.63-1.12l.5-.8c.12-.17.1-.36-.03-.51-.16-.18-.33-.22-.53-.14l-.86.35c-.31-.3-.65-.58-.99-.82l.2-.91c.03-.22-.03-.4-.2-.49-.18-.1-.34-.09-.48.01l-.74.66c-.39-.18-.8-.32-1.21-.43l-.14-.93a.426.426 0 00-.36-.39c-.22-.03-.39.05-.47.22l-.44.84-.43-.02h-.22c-.22 0-.42.01-.65.03l-.44-.84c-.08-.17-.25-.25-.48-.22-.2.03-.33.17-.36.39l-.13.88c-.42.12-.83.26-1.22.44l-.69-.61c-.15-.15-.33-.17-.53-.06-.18.09-.24.26-.2.49l.2.91c-.36.24-.7.52-1 .82l-.86-.35c-.19-.09-.37-.05-.52.13-.14.15-.16.34-.04.51l.5.8c-.25.35-.45.72-.64 1.12l-.94-.04c-.21-.01-.37.1-.44.3-.07.2-.02.38.16.5l.73.59c-.1.41-.19.83-.22 1.27l-.89.29c-.21.07-.31.21-.31.42 0 .22.1.36.31.43l.89.28c.03.44.1.87.22 1.27l-.73.58c-.17.12-.22.31-.16.51.07.2.23.31.44.29l.94-.05c.18.39.39.77.63 1.12l-.5.8c-.12.18-.1.37.04.52.16.18.33.22.52.14l.86-.36c.3.31.64.58.99.82l-.2.92c-.04.22.03.39.2.49.2.1.38.08.54-.07l.69-.61c.39.17.8.33 1.21.44l.13.93c.03.21.16.35.37.39.22.03.39-.06.47-.24l.44-.84c.23.02.44.04.66.04z"
                            fill="#818b90"></path>
                        </svg></span></span></strong> e selecione <strong>WhatsApp Web</strong></span></li>
              <li class="eGEEX">Aponte seu celular para essa tela para capturar o código</li>
            </ol>
            <hr>
            <ul>
              <li>
                Após fazer o pareamento, atualize a página.
              </li>
            </ul>
          </div>
          <?php if (!$v_device_zapi) { ?>
            <div class="col-md-6">
              <center><span id="load_qr_icon" style="display:none;">Aguarde <i
                    class="fa fa-spinner fa-spin"></i></span><br /><br />
                <img onclick="init_qr();" src="img/qrcode-inative.png" class="img-thumbnail" id="qr-inative" />
                <!--<h5>Estamos atualizando</h5>-->
                <!--<p>Aguarde e volte mais tarde</p>-->
                <br /><br />
                <span class="text-danger" id="returnErro"></span>
              </center>
            <?php } else { ?>
              <ul>
                <li>
                  Você já está conectado, se deseja gerar outro QR Code, clique em <strong>"Desativar API"</strong> logo
                  acima.
                </li>
                <li>
                  <strong>Atenção:</strong> se você desconectou direto pelo seu celular, o sistema ainda acha que você
                  está conectado, clique em "Desativar a API" e se conecte novamente.
                </li>
              </ul>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

</html>

<script>
  function remove_api_zapi() {
    $("#status_load_qr").val('0');

    $("#remove_api_zapi").prop('disabled', true);
    $("#remove_api_zapi").html('Aguarde <i class="fa fa-spinner fa-spin" ></i>');

    var keydevice_zapi = $("#keydevice_zapi").val();
    $.post('../control/api-zapi/control.load_qr_admin.php', { remove: true, keydevice_zapi: keydevice_zapi }, function (data) {
      location.href = "";
    });
  }

  function init_qr() {
    $("#returnErro").html('');
    load_qr();
  }


  function load_qr() {
    $("#load_qr_icon").show();
    var status_load_qr = $("#status_load_qr").val();
    var keydevice_zapi = $("#keydevice_zapi").val();

    $("#status_load_qr").val('0');

    if (status_load_qr == 1) {
      $.post('../control/api-zapi/control.load_qr_admin.php', { load: true, keydevice_zapi: keydevice_zapi }, function (data) {
        $("#load_qr_icon").hide()
        // console.log(JSON.parse(data));
        try {
          var obj = JSON.parse(data);
          if (obj.erro) {
            $("#returnErro").html(obj.msg);
          } else {

            $("#qr-inative").attr("src", obj.qrcode);
            $("#keydevice_zapi").val(obj.key);
            setTimeout(function () {
              $("#status_load_qr").val('1');
              $("#qr-inative").attr("src", 'img/qrcode-inative.png');
            }, 60000);
          }
        } catch (e) {
          $("#returnErro").html('Desculpe, volte mais tarde, ou entre em contato com o suporte');
        }

      });
    } else {
      $("#load_qr_icon").hide()
      $("#returnErro").html('Aguarde até tentar novamente');
    }
  }

  function value_checkbox(id) {
    if (typeof $(id).val() != "undefined") {
      if ($(id).is(":checked") == true) {
        var situ = 1;
      } else {
        var situ = 0;
      }
    } else {
      var situ = 0;
    }
    return situ;
  }

  function save_key(api) {

    $("#btn_save_key_" + api).prop('disabled', true);
    $("#btn_save_key_" + api).html('Salvar <i class="fa fa-spin fa-refresh" ></i>');


    if (api == "chatpro") {
      var api_key = $("#api_key_" + api).val() + "@@@@" + $("#endpoint_chatpro").val();
    } else {
      var api_key = $("#api_key_" + api).val();
    }
    var situ = value_checkbox("#situ_api_" + api);

    $.post('../control/control.add_key_api.php', { api_key: api_key, api: api, situ: situ }, function (data) {
      var obj = JSON.parse(data);
      alert(obj.msg);

      $("#btn_save_key_" + api).prop('disabled', false);
      $("#btn_save_key_" + api).html('Salvar');

      if (obj.erro) {
        if (obj.msg == "Você já possui outra API ativa, desative-a para ativar está.") {
          $("#situ_api_" + api).prop("checked", false);
        }
      }

    });
  }
</script>