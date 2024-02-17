<?php

if (isset($_COOKIE['new_v'])) {
  echo '<script>location.href="https://' . $gestor_class->get_options("dominio") . '/painel-gestor/";</script>';
  die;
}


if (isset($_GET['limit'])) {
  $limit = $_GET['limit'] == "all" ? false : $_GET['limit'];
} else {
  $limit = 10000;
}


// listar clientes

$clientes_class = new Clientes();
$planos_class = new Planos();

if (!isset($whatsapi_class)) {
  $whatsapi_class = new Whatsapi();
}




$clientes = $clientes_class->list_clientes($_SESSION['SESSION_USER']['id'], $limit);

$list_categorias_1 = $clientes_class->list_categorias_clientes($_SESSION['SESSION_USER']['id']);
$list_categorias_2 = $clientes_class->list_categorias_clientes($_SESSION['SESSION_USER']['id']);
$list_categorias_3 = $clientes_class->list_categorias_clientes($_SESSION['SESSION_USER']['id']);


$planos = $planos_class->list($_SESSION['SESSION_USER']['id']);
$planos2 = $planos_class->list($_SESSION['SESSION_USER']['id']);
$planos3 = $planos_class->list($_SESSION['SESSION_USER']['id']);

$num_cli = 0;

$count_cli = $clientes_class->count_clientes($_SESSION['SESSION_USER']['id']);
if ($count_cli) {
  $num_cli = $count_cli;
}

$wsapi = $whatsapi_class->verific_device_situ($_SESSION['SESSION_USER']['id']);
$array_clis_comp = $clientes_class->list_fats_comp($_SESSION['SESSION_USER']['id']);

?>



<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>
<?php if ($user->somente_finan == 1) {
  include_once('pages/financeiro.php');
  die;
} ?>

<style>
  .inativo {
    display: none;
  }

  input[type="color"] {
    display: none;
  }

  .bg-#b700fa {
    background-color: #b700fa;
  }

  button {
    margin-bottom: 5px;
  }
</style>



<!-- NavBar -->
<?php include_once 'inc/nav-bar.php'; ?>


<main class="page-content">

  <div class="">

    <div
      style="padding: 0px;-webkit-box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);width: 100%;"
      class="card row full">

      <!-- qtd clientes -->
      <div class="col-md-12">
        <h2 class="h2-cell" class="h2">Possui
          <?= $num_cli; ?> clientes</small>
        </h2><br />
      </div>



      <!-- Btns home -->
      <div class="col-md-6">
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button onclick="location.href='painel_cliente_conf';" type="button"
              class="btn btn-sm btn-outline-secondary"><i class="fa fa-user"></i>
              <?= $idioma->area_cliente; ?>
              <?php if (isset($plano_usergestor->mini_area_cliente)) {
                if ($plano_usergestor->mini_area_cliente == 0) {
                  echo "<i class='fa fa-star text-primary' ></i>";
                }
              } ?>
            </button>
            <button onclick="modal_import_clientes();" type="button" class="btn btn-sm btn-outline-secondary"><i
                class="fa fa-upload"></i>
              <?= $idioma->importar; ?>
            </button>
            <!-- <button onclick="location.href='../control/control.export_clientes.php';" type="button" -->
            <button onclick="$('#modal_export_cli').modal('show');" type="button"
              class="btn btn-sm btn-outline-secondary"><i class="fa fa-download"></i>
              <?= $idioma->exportar; ?>
            </button>
            <button onclick="modal_add_cli();" type="button" class="btn btn-sm btn-outline-secondary"><i
                class="fa fa-plus"></i>
              <?= $idioma->adicionar_novo; ?>
            </button>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <?php
        if (isset($_SESSION['INFO'])) {
          echo '<div id="msg_hide" class="alert alert-secondary">' . $_SESSION['INFO'] . '</div>';
          unset($_SESSION['INFO']);
        }
        ?>
      </div>

      <!-- Categorias -->
      <div class="col-md-12 border-bottom" style="padding-bottom:5px;">
        <div class="row">
          <div class="col-md-4">
            <div class="btn-group">
              <button onclick="list_categorias_cards();$('#modal_categorias').modal();" type="button"
                class="btn btn-sm btn-outline-secondary"><i class="fa fa-users"></i> Categorias</button>
            </div>
            <div class="btn-group">
              <button onclick="$('#modal_disparo').modal();" type="button" class="btn btn-sm btn-outline-secondary"><i
                  class="fa fa-users"></i> Disparo de mensagem</button>
            </div>
          </div>
          <div class="col-md-8">
            <?php if ($list_categorias_3) {



              $color_text['danger'] = "white";
              $color_text['primary'] = "white";
              $color_text['secondary'] = "white";
              $color_text['info'] = "white";
              $color_text['warning'] = "black";
              $color_text["marrom"] = "white";
              $color_text["green"] = "white";
              $color_text["roxo"] = "white";
              $color_text["verde2"] = "white";

              $cores['danger'] = "#ec3541";
              $cores['primary'] = "#0048ff";
              $cores['secondary'] = "#dddddd";
              $cores['info'] = "#2d87ce";
              $cores['warning'] = "#fb9100";
              $cores['marrom'] = "#6d2b19";
              $cores['green'] = "#2bad18";
              $cores['roxo'] = "#7922ff";
              $cores['verde2'] = "#04fbb1";

              ?>

              <?php while ($categ = $list_categorias_3->fetch(PDO::FETCH_OBJ)) {

                if (isset($cores[$categ->cor])) {
                  $back = $cores[$categ->cor];
                } else {
                  $back = $categ->cor;
                }

                ?>


                <span class="text-<?= $color_text[$categ->cor]; ?> badge "
                  style="margin:5px;background-color: <?= $back; ?>">
                  <?= $categ->nome; ?>
                </span>

              <?php }
            } ?>
          </div>
        </div>
      </div>
      <!-- End categorias -->


      <!-- options table -->
      <div class="col-md-12" style="margin-top:10px;margin-bottom:10px;">
        <div class="row">
          <div class="col-md-2">
            <div id="com_selecionados" style="display:none;" class="mb-2 form-group">
              <select class="form-control form-control-sm" name="selecionados" id="selecionados"
                onchange="$('#form_checkbox').submit();">
                <option value="deletar">
                  <?= $idioma->com_selecionados; ?>
                </option>
                <option value="deletar">
                  <?= $idioma->deletar; ?>
                </option>
              </select>
            </div>
          </div>
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="btn-group col-md-12">
              <button style="height: 38px;" class="btn btn-sm btn-outline-secondary" id="btn_inativo"
                onclick="$('#btn_ativo').show();$('#btn_inativo').hide();$('.ativo').hide();$('.inativo').show();">Inadimplentes</button>
              <button class="btn btn-sm btn-outline-secondary" style="height: 38px;display:none;" id="btn_ativo"
                onclick="$('#btn_inativo').show();$('#btn_ativo').hide();$('.inativo').hide();$('.ativo').show();">Ativos</button>
              <select style="border-radius: 0px!important;"
                onchange="location.href='?limit='+(this.options[this.selectedIndex].value);" class="form-control"
                name="limit_clientes" id="limit_clientes" onchange="">
                <option <?php if (isset($_GET['limit'])) {
                  if ($_GET['limit'] == 100) {
                    echo "selected";
                  }
                } ?> value="100">
                  100
                  <?= $idioma->clientes; ?>
                </option>
                <option <?php if (isset($_GET['limit'])) {
                  if ($_GET['limit'] == 150) {
                    echo "selected";
                  }
                } ?> value="150">
                  150
                  <?= $idioma->clientes; ?>
                </option>
                <option <?php if (isset($_GET['limit'])) {
                  if ($_GET['limit'] == 200) {
                    echo "selected";
                  }
                } ?> value="200">
                  200
                  <?= $idioma->clientes; ?>
                </option>
                <option <?php if (isset($_GET['limit'])) {
                  if ($_GET['limit'] == 300) {
                    echo "selected";
                  }
                } ?> value="300">
                  300
                  <?= $idioma->clientes; ?>
                </option>
                <option <?php if (isset($_GET['limit'])) {
                  if ($_GET['limit'] == 'all') {
                    echo "selected";
                  }
                } ?> value="all">
                  <?= $idioma->todos; ?>
                </option>
              </select>
              <input style="border-radius: 0px!important;" type="text" id="busca_user" placeholder="Pesquisar"
                class="form-control" name="" value="">
            </div>
          </div>
        </div>
      </div>
      <!-- end options table -->


      <!-- table comprovante -->
      <?php if ($array_clis_comp) { ?>

        <div style="margin-bottom:10px;" class="col-md-12">
          <div class="row" style="background-color:#6550681c;border-radius:10px;">
            <h5>Comprovantes enviados</h5>


            <div class="table-responsive">


              <table class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <th>Arquivo</th>
                    <th>Cliente</th>
                    <th>Categoria</th>
                    <th>Fatura</th>
                    <th>Valor</th>
                    <th>Plano</th>
                    <th>Opções</th>
                  </tr>
                </thead>
                <tbody>
                  <?php


                  if ($array_clis_comp) {

                    while ($comp = $array_clis_comp->fetch(PDO::FETCH_ASSOC)) {
                      // buscar dados do plano
                      $plano = $planos_class->plano($comp['id_plano']);
                      $cliente = $clientes_class->dados($comp['id_cliente']);

                      //jay11
                      require_once '../class/Conn.class.php';
                      $conn = new Conn();
                      $pdo = $conn->pdo();

                      $idCategoria = $cliente->categoria;
                      $query = $pdo->prepare("SELECT nome FROM `categorias_cliente` WHERE id = :idCategoria LIMIT 1");
                      $query->bindParam(':idCategoria', $idCategoria, PDO::PARAM_INT);
                      $query->execute();

                      // Recuperar o resultado
                      $result = $query->fetch(PDO::FETCH_ASSOC);
                      $nomeCategoria = $result['nome'];
                      //jay11
                
                      ?>

                      <tr>
                        <td><a href="../comprovantes/<?= $comp['file']; ?>" target="_blank">Ver <i class="fa fa-file"></i></a>
                        </td>
                        <td>
                          <?= $cliente->nome; ?>
                        </td>
                        <td>
                          <?= $nomeCategoria; ?>
                        </td>
                        <td>#
                          <?= $comp['id_fat']; ?>
                        </td>
                        <td>R$
                          <?= $comp['valor']; ?>
                        </td>
                        <td>
                          <?= $plano->nome; ?>
                        </td>
                        <td>
                          <button onclick="aprova_comp('<?= $comp['id_fat']; ?>');" title="APROVAR" type="button"
                            class="btn-outline-success btn w-100 d-md-block" style="padding: 0px;"
                            id="btn_aprova_comp_<?= $comp['id_fat']; ?>"> <i id="_btn_aprova_comp_<?= $comp['id_fat']; ?>"
                              class="fa fa-check"></i></button>

                          <button onclick="recusa_comp('<?= $comp['id_fat']; ?>');" title="RECUSAR" type="button"
                            class="btn-outline-info btn btn-outline-danger w-100 d-md-block" style="padding: 0px;"
                            id="btn_recusa_comp_<?= $comp['id_fat']; ?>"> <i id="_btn_aprova_comp_<?= $comp['id_fat']; ?>"
                              class="fa fa-close"></i></button>

                        </td>
                      </tr>

                    <?php }
                  } else { ?>

                    <tr>
                      <td class="text-center" colspan="6">Nenhum comprovante enviado</td>
                    </tr>


                  <?php } ?>

                </tbody>
              </table>


            </div>
          </div>
        </div>

      <?php } ?>
      <!-- end table comprovantes -->


      <!-- table clientes -->
      <div class="col-md-12 no-padding">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-sm">
            <thead>
              <tr>
                <th>
                  <?= $idioma->nome; ?>
                </th>
                <th>
                  Categoria
                </th>
                <th>
                  <?= $idioma->whatsapp; ?>
                </th>
                <th>
                  <?= $idioma->vencimento; ?>
                </th>
                <th>
                  <?= $idioma->plano; ?>
                </th>
                <th>
                  Ações
                </th>
              </tr>
            </thead>
            <tbody id="tbody_clientes" class="">
              <form class="" id="form_checkbox" action="../control/control.delete_clientes.php" method="POST">
                <?php

                if ($clientes) {

                  while ($cli = $clientes->fetch(PDO::FETCH_OBJ)) {



                    // buscar dados do plano
                    $plano = $planos_class->plano($cli->id_plano);

                    //jay11
                    require_once '../class/Conn.class.php';
                    $conn = new Conn();
                    $pdo = $conn->pdo();

                    $idCategoria = $cli->categoria;
                    $query = $pdo->prepare("SELECT nome FROM `categorias_cliente` WHERE id = :idCategoria LIMIT 1");
                    $query->bindParam(':idCategoria', $idCategoria, PDO::PARAM_INT);
                    $query->execute();

                    // Recuperar o resultado
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    $nomeCategoria = $result['nome'];

                    if ($cli->vencimento != '0' && $cli->vencimento != '00/00/0000') {

                      $vencido = false;

                      // verificar data do vencimento
                      $explodeData = explode('/', $cli->vencimento);
                      $explodeData2 = explode('/', date('d/m/Y'));
                      $dataVen = $explodeData[2] . $explodeData[1] . $explodeData[0];
                      $dataHoje = $explodeData2[2] . $explodeData2[1] . $explodeData2[0];

                      $three = date('Ymd', strtotime('+3 days', strtotime($explodeData2[0] . '-' . $explodeData2[1] . '-' . $explodeData2[2])));
                      $two = date('Ymd', strtotime('+2 days', strtotime($explodeData2[0] . '-' . $explodeData2[1] . '-' . $explodeData2[2])));
                      $for = date('Ymd', strtotime('+4 days', strtotime($explodeData2[0] . '-' . $explodeData2[1] . '-' . $explodeData2[2])));
                      $one = date('Ymd', strtotime('+1 days', strtotime($explodeData2[0] . '-' . $explodeData2[1] . '-' . $explodeData2[2])));

                      $vencidoTrue = false;

                      if ($dataVen == $dataHoje) {
                        $ven = "<b class='badge badge-warning'>{$cli->vencimento}</b>";
                      } else if ($dataHoje > $dataVen) {
                        $ven = "<b class='badge badge-danger'>{$cli->vencimento}</b>";
                        $vencidoTrue = true;
                        $vencido = true;
                      } else if ($dataHoje < $dataVen) {
                        $ven = "<b class='badge badge-success'>{$cli->vencimento}</b>";
                      }


                      if ($dataVen == $for) {
                        $ven = "<b class='badge badge-info'>{$cli->vencimento}</b>";
                      }

                      if ($dataVen == $three) {
                        $ven = "<b class='badge badge-info'>{$cli->vencimento}</b>";
                      }

                      if ($dataVen == $two) {
                        $ven = "<b class='badge badge-info'>{$cli->vencimento}</b>";
                      }

                      if ($dataVen == $one) {
                        $ven = "<b class='badge badge-info'>{$cli->vencimento}</b>";
                      }



                    } else {
                      $ven = "<b class='badge badge-secondary'>$idioma->nao_definido</b>";
                    }


                    $getCategoria = $clientes_class->get_categoria($cli->categoria);
                    if ($getCategoria) {
                      $colorCate = $getCategoria->cor;
                    } else {
                      $colorCate = "secondary";
                    }
                    ?>

                    <tr <?php if (@$vencidoTrue == true) {
                      echo "class='inativo';";
                    } else {
                      echo "class='ativo';";
                    } ?>
                      id="tr_<?= $cli->id; ?>"
                      class="trs <?= @$dataHoje; ?> <?= @$three . ' - ' . @$for . ' - ' . @$two . ' - ' . @$one; ?>">

                      <td>

                        <?= $cli->nome; ?>
                        <?php if ($cli->identificador_externo != NULL && $cli->identificador_externo != "") { ?>
                          <br /><span
                            style="font-size: 13px; margin: 0px;top: 0px!important;position: relative;color: gray;font-style: italic;">#
                            <?= $cli->identificador_externo; ?>
                          </span>
                        <?php } ?>
                      </td>
                      <td>
                        <?= $nomeCategoria ? $nomeCategoria : 'Nenhuma' ?>
                      </td>
                      <td class="wpp-td">
                        <?php if ($cli->telefone == "vazio") {
                          echo $cli->telefone . " <i style='font-size:10px;cursor:pointer;' title='" . $idioma->adicione_um_telefone . "' class='text-danger fa fa-warning' ></i>";
                        } else {
                          echo '<a target="_blank" class="break-line" href="http://wa.me/' . $cli->telefone . '" >' . $cli->telefone . '</a>';
                        } ?>
                      </td>
                      <td>
                        <?= $ven; ?>
                      </td>
                      <td>
                        <?php if ($plano) {
                          echo $plano->nome;
                        } else {
                          echo "<i style='cursor:pointer;' title='" . $idioma->adicione_um_plano . "' class='text-danger fa fa-warning' ></i> ";
                        } ?>
                      </td>
                      <td class="action-td">
                        <button onclick="modal_send_zap(<?= $cli->id; ?>,'<?= $cli->nome; ?>','<?= $cli->telefone; ?>',<?php if ($plano) {
                                echo $plano->id;
                              } else {
                                echo 'no';
                              } ?>);" title="COBRANÇA" type="button" class="btn-outline-primary w-100 d-md-block"
                          id=""> <i class="fa fa-paper-plane"></i> </button>
                        <button <?php if ($plano == false) {
                          echo 'disabled style="cursor:no-drop;" ';
                        } ?>
                          onclick="renew_cli(<?= $cli->id; ?>,<?= $cli->id_plano; ?>);" title="RENOVAR" type="button"
                          class="btn-outline-primary w-100 d-md-block  " id="btn_renew_<?= $cli->id; ?>"> <i
                            id="_btn_renew_<?= $cli->id; ?>" class="fa fa-refresh"></i> </button>
                        <button onclick="edite_cliente(<?= $cli->id; ?>);" title="EDITAR" type="button"
                          class="btn-outline-primary w-100 d-md-block btn-outline-primary"> <i class="fa fa-pencil"></i>
                        </button>
                        <button onclick="modal_del_cli(<?= $cli->id; ?>);" title="EXCLUIR" type="button"
                          class="btn-outline-primary w-100 d-md-block  "> <i class="fa fa-trash"></i> </button>
                        <button <?php if ($plano_usergestor->faturas_cliente == 1) { ?>
                            onclick="modal_faturas_cli(<?= $cli->id; ?>,'<?= $cli->nome; ?>','<?= $cli->email; ?>');" <?php } else {
                          echo 'onclick="alert(\'' . $idioma->faca_upgrade_alert . '\');location.href=\'cart?upgrade\';"';
                        } ?> title="<?= $idioma->registr_de_fats; ?>"
                          type="button" class="btn-outline-primary w-100 d-md-block  ">
                          <i class="fa fa-file"></i> </button>

                      </td>
                    </tr>

                  <?php }
                } else { ?>

                  <tr>
                    <td class="text-center" colspan="7">
                      <?= $idioma->nenhum_cliente_cadastrado; ?>
                    </td>
                  </tr>


                <?php } ?>

              </form>
            </tbody>
          </table>


        </div>
      </div>
      <!-- end table clientes -->



    </div>

  </div>

</main>


</div>
</div>



<!--  Modal Import clientes -->
<div class="modal fade" id="modal_import_clientes" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TituloModalLongoExemplo">
          <?= $idioma->import_clis_para_gestor_lite; ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


        <form enctype="multipart/form-data" id="form_import_json_clientes"
          action="../control/control.import_json_clientes.php" method="POST">

          <div class="form-group text-center">

            <div hidden class="form-group">
              <label>Selecione a plataforma</label>
              <select class="form-control" name="type">
                <option selected value="gestor">gestormaster.top</option>
                <!-- <option value="xtream">Xtream UI</option> -->
              </select>
            </div>

            <div class="form-group">
              <input onchange="$('#selecionado_msg').show('200');$('#btn_import').show('200');" id="import_cliente_json"
                type="file" name="import_cliente_json" class="" style="display:none;" />
              <!-- <br /> -->
              <a target="_blank" href="https://youtu.be/kp6gNxd3B2c">
                <label class="btn btn-primary">
                  Assitir video tutorial <i class="fa fa-youtube"></i>
                </label>
              </a>
              <a href="https://gestormaster.top/painel/download/PLANILHA%20PADR%C3%83O%20-%20GESTOR%20MASTER.xlsx"
                download="PLANILHA PADRÃO - GESTOR MASTER.xlsx">
                <label class="btn btn-primary">
                  Baixar Modelo de planilha
                </label>
              </a>
              <br />
              <label>Sites para converter de excel para JSON</label>
              <br>
              <a target="_blank" href="https://products.aspose.app/cells/pt/conversion/excel-to-json">
                <label class="btn btn-primary">Opção 1</label>
              </a>
              <a target="_blank" href="https://tableconvert.com/pt/excel-to-json">
                <label class="btn btn-primary">Opção 2</label>
              </a>
              <a target="_blank" href="https://cdkm.com/pt/xls-to-json">
                <label class="btn btn-primary">Opção 3</label>
              </a>
              <a target="_blank" href="https://anyconv.com/pt/conversor-de-excel-para-json">
                <label class="btn btn-primary">Opção 4</label>
              </a>



              <br>
              <label>Opções de importação</label>
              <br>
              <label for="import_cliente_json" class="btn btn-primary">
                Selecionar arquivo JSON <i class="fa fa-desktop"></i>
              </label>

              <!-- <br /> -->
              <span id="selecionado_msg" style="display:none;" class="text-success">
                <?= $idioma->selecionado; ?> <i class="fa fa-check"></i>
              </span>
            </div>


          </div>


        </form>

        <form class="btn btn-primary" id="form_import" method="POST"
          action="https://gestormaster.top/control/control.import_xlsx_clientes.php" enctype="multipart/form-data">
          <div class="form-group">
            <h6> Selecionar arquivo excel<b>(.xlsx)</b> </h6>
            <input type="file" name="file_import" />
            <input type="submit" value="Enviar">
            <br />
          </div>
        </form>


      </div>


      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <?= $idioma->cancelar; ?>
        </button>
        <button type="button"
          onclick="$('#form_import_json_clientes').submit();$('#btn_import');$('#btn_import').html('<i class=\'fa fa-refresh fa-spin\' ></i> Aguarde');"
          id="btn_import" style="display:none;" class="btn btn-primary">
          <?= $idioma->importar; ?>
        </button>
      </div>


    </div>
  </div>
</div>




<!--  Modal edite clientes -->
<div class="modal fade" id="modal_edite_cliente" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Titutlo_modal_edite_cliente">
          <?= $idioma->editar_cliente; ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="body_modal_edite_cli">

        <input type="hidden" name="id_cli" id="id_cli">

        <div class="row">

          <?php


          if (@$plano_usergestor->mini_area_cliente == 1) {

            ?>

            <div class="col-md-12">
              <input type="text" class="form-control margin" id="nome_cli" placeholder="<?= $idioma->nome; ?>">
            </div>

            <div class="col-md-5">
              <input type="text" class="form-control margin" id="senha_cli" placeholder="<?= $idioma->senha; ?>">
              <small style="font-size:10px;color:#696464;">
                <?= $idioma->acess_mini_painel_cli; ?>
              </small>
            </div>

            <div class="col-md-7">
              <input type="hidden" id="email_cli_atual" value="">
              <input type="text" class="form-control margin" id="email_cli"
                placeholder="<?= $idioma->email; ?> [Opcional]">
              <small id="response_email_cli"></small>
            </div>

          <?php } else { ?>

            <div class="col-md-5">
              <input type="text" class="form-control margin" id="nome_cli" placeholder="<?= $idioma->nome; ?>">
            </div>

            <div class="col-md-7">
              <input type="hidden" id="email_cli_atual" value="">
              <input type="text" class="form-control margin" id="email_cli"
                placeholder="<?= $idioma->email; ?> [Opcional]">
              <small id="response_email_cli"></small>
            </div>

          <?php } ?>



          <div class="col-md-12">

            <div style="margin-bottom:20px; padding-left: 0px; padding-right: 0px; display: block;"
              class="input-group col-md-12">
              <span style="height:10px!important;"></span>
              <div class="input-group-append">
                <input type="hidden" value="55" id="ddi_cli_edit" />
                <button id="dropDownDDI" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <img id="ddi_atual_rev" src="https://gestormaster.top/img/country/br.png" /> <span>+55</span>
                </button>
                <div style="z-index:9999!important;" id="dropdown_ddi" class="dropdown-menu">
                  <a onclick="changeDDI('55','br')" class="dropdown-item"><img id="ddi_55"
                      src="https://gestormaster.top/img/country/br.png" /> +55</a>
                  <a onclick="changeDDI('351','pt');" class="dropdown-item"><img id="ddi_351"
                      src="https://gestormaster.top/img/country/pt.png" /> +351</a>
                  <a onclick="changeDDI('1','usa');" class="dropdown-item"><img id="ddi_1"
                      src="https://gestormaster.top/img/country/usa.png" /> +1</a>
                  <a onclick="changeDDI('49','ger');" class="dropdown-item"><img id="ddi_49"
                      src="https://gestormaster.top/img/country/ger.png" /> +49</a>
                  <a onclick="changeDDI('54','arg');" class="dropdown-item"><img id="ddi_54"
                      src="https://gestormaster.top/img/country/arg.png" /> +54</a>
                  <a onclick="changeDDI('598','uru');" class="dropdown-item"><img id="ddi_598"
                      src="https://gestormaster.top/img/country/uru.png" /> +598</a>
                  <a onclick="changeDDI('44','gbr');" class="dropdown-item"><img id="ddi_44"
                      src="https://gestormaster.top/img/country/gbr.png" /> +44</a>
                  <a onclick="changeDDI('34','esp');" class="dropdown-item"><img id="ddi_34"
                      src="https://gestormaster.top/img/country/esp.png" /> +34</a>
                  <a onclick="changeDDI('1','can');" class="dropdown-item"><img id="ddi_1_can"
                      src="https://gestormaster.top/img/country/can.png" /> +1</a>
                  <a onclick="changeDDI('57','col');" class="dropdown-item"><img id="ddi_57"
                      src="https://gestormaster.top/img/country/col.png" /> +57</a>
                </div>
                <input type="text" id="telefone_cli_edit" name="telefone_cli_edit" class="form-control"
                  placeholder="Telefone" value="">
              </div>


              <script>
                function changeDDI(ddi, country) {
                  $("#ddi_cli_edit").val(ddi);
                  $("#dropDownDDI").html('<img src="https://gestormaster.top/img/country/' + country + '.png" /> +' + ddi);
                }
              </script>

            </div>

            <div class="col-md-6">
              <label style="display: inline-block">Data de vencimento</label>
              <input min="<?= date('Y-m-d'); ?>" type="date" style="margin-left: 0px" class="form-control margin" id="vencimento_cli"
                placeholder="<?= $idioma->vencimento; ?>">
            </div>

            <div class="col-md-6" style="width: 100%;">
              <select class="form-control" name="categoria_cli_atual" id="categoria_cli_atual">
                <option value="0">Selecionar uma categoria</option>
                <?php if ($list_categorias_2) {
                  while ($cate = $list_categorias_2->fetch(PDO::FETCH_OBJ)) {
                    ?>
                    <option value="<?= $cate->id; ?>">
                      <?= $cate->nome; ?>
                    </option>
                  <?php }
                } else { ?>
                  <option value="0">Nenhuma categoria cadastrada</option>
                <?php } ?>
              </select>
              <small>Determine a categoria deste cliente</small>
            </div>

            <div class="col-md-12 margin">
              <select class="form-control" name="recebe_zap_cli" id="recebe_zap_cli">
                <option value="1">
                  <?= $idioma->notificas_via_zap; ?>
                </option>
                <option value="0">
                  <?= $idioma->nao_notificar_zap; ?>
                </option>
              </select>
              <small>
                <?= $idioma->clientes_recebera_todos_mes_aviso; ?>
              </small>
            </div>

            <div class="col-md-12 margin">
              <select class="form-control" name="plano_cli" id="plano_cli">
                <option value="0">
                  <?= $idioma->selecionar_plano; ?>
                </option>

                <?php

                if ($planos) {
                  while ($plano = $planos->fetch(PDO::FETCH_OBJ)) {

                    ?>

                    <option value="<?= $plano->id; ?>">
                      <?= $plano->nome; ?>
                    </option>

                  <?php }
                } else { ?>

                  <option value="">
                    <?= $idioma->nenhum_plano_cadastrado; ?>
                  </option>

                <?php } ?>


              </select>
            </div>



            <div class="col-md-12 margin">
              <?php if (@$plano_usergestor->mini_area_cliente == 1) { ?><small>Isso ira aparecer para seu cliente na
                  area
                  do
                  cliente</small>
              <?php } ?>
              <textarea name="notas" id="notas_cli" class="form-control" rows="3" cols="80"
                placeholder="Observações para seu cliente."></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">
                <?= $idioma->fechar; ?>
              </button>
              <button onclick="save_cli();" type="button" id="btn_save_cli" class="btn btn-primary">
                <?= $idioma->salvar; ?>
              </button>
            </div>
          </div>




        </div>
      </div>
    </div>
  </div>
</div>



<!--  Modal add clientes -->
<div class="modal fade" id="modal_add_cli" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Titutlo_modal_add_cliente">
          <?= $idioma->adicionar_cliente; ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="body_modal_add_cli">

        <input type="hidden" name="id_cli_add" id="id_cli_add">

        <div class="row">

          <?php

          if (@$plano_usergestor->mini_area_cliente == 1) {

            ?>

            <div class="col-md-12">
              <input type="text" class="form-control margin" id="nome_cli_add" placeholder="<?= $idioma->nome; ?>">
            </div>

            <div class="col-md-5">
              <input type="text" class="form-control margin" id="senha_add" placeholder="<?= $idioma->senha; ?>">
              <small style="font-size:10px;color:#696464;">
                <?= $idioma->acess_mini_painel_cli; ?></b>
              </small>
            </div>

            <div class="col-md-7">
              <input type="text" class="form-control margin" id="email_cli_add" placeholder="Email">
              <small id="response_email_add"></small>
            </div>

          <?php } else { ?>

            <div class="col-md-5">
              <input type="text" class="form-control margin" id="nome_cli_add" placeholder="<?= $idioma->nome; ?>">
            </div>

            <div class="col-md-7">
              <input type="text" class="form-control margin" id="email_cli_add"
                placeholder="<?= $idioma->email; ?> [Opcional]">
              <small id="response_email_add"></small>
            </div>

          <?php } ?>

          <div class="col-md-6">

            <div style="margin-bottom:20px; padding-left: 0px; padding-right: 0px;" class="input-group col-md-12">
              <span style="height:10px!important;"></span>
              <div class="input-group-append">
                <input type="hidden" value="55" id="ddi_cli_add" />
                <button id="desceDDI" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <img id="ddi_atual_rev" src="https://gestormaster.top/img/country/br.png" /> <span>+55</span>
                </button>
                <div style="z-index:9999!important;" id="dropdown_ddi" class="dropdown-menu">
                  <a onclick="mudaDDI('55','br')" class="dropdown-item"><img id="ddi_55"
                      src="https://gestormaster.top/img/country/br.png" /> +55</a>
                  <a onclick="mudaDDI('351','pt');" class="dropdown-item"><img id="ddi_351"
                      src="https://gestormaster.top/img/country/pt.png" /> +351</a>
                  <a onclick="mudaDDI('1','usa');" class="dropdown-item"><img id="ddi_1"
                      src="https://gestormaster.top/img/country/usa.png" /> +1</a>
                  <a onclick="mudaDDI('49','ger');" class="dropdown-item"><img id="ddi_49"
                      src="https://gestormaster.top/img/country/ger.png" /> +49</a>
                  <a onclick="mudaDDI('54','arg');" class="dropdown-item"><img id="ddi_54"
                      src="https://gestormaster.top/img/country/arg.png" /> +54</a>
                  <a onclick="mudaDDI('598','uru');" class="dropdown-item"><img id="ddi_598"
                      src="https://gestormaster.top/img/country/uru.png" /> +598</a>
                  <a onclick="mudaDDI('44','gbr');" class="dropdown-item"><img id="ddi_44"
                      src="https://gestormaster.top/img/country/gbr.png" /> +44</a>
                  <a onclick="mudaDDI('34','esp');" class="dropdown-item"><img id="ddi_34"
                      src="https://gestormaster.top/img/country/esp.png" /> +34</a>
                  <a onclick="mudaDDI('1','can');" class="dropdown-item"><img id="ddi_1_can"
                      src="https://gestormaster.top/img/country/can.png" /> +1</a>
                  <a onclick="mudaDDI('57','col');" class="dropdown-item"><img id="ddi_57"
                      src="https://gestormaster.top/img/country/col.png" /> +57</a>
                </div>
              </div>

              <input type="text" id="telefone_cli_add" name="telefone_cli_add" class="form-control"
                placeholder="Telefone" value="">



              <script>
                function mudaDDI(ddi, country) {
                  $("#ddi_cli_add").val(ddi);
                  $("#desceDDI").html('<img src="https://gestormaster.top/img/country/' + country + '.png" /> +' + ddi);
                }
              </script>

              <!-- <input type="text" class="form-control margin" id="telefone_cli_add" placeholder="DDI+DDD+NUM"
                pattern="[0-9]+" inputmode="numeric" oninput="validarNumeros(this)"> -->


            </div>


          </div>

          <div class="col-md-6">
            <label style="display: inline-block">Data de vencimento</label>
            <input min="<?= date('Y-m-d'); ?>" type="date" class="form-control margin" id="vencimento_cli_add"
              placeholder="<?= $idioma->vencimento; ?>">
          </div>

          <div class="col-md-6">
            <select class="form-control" name="categoria_cli_add" id="categoria_cli_add">
              <option value="0">Selecionar uma categoria</option>
              <?php if ($list_categorias_1) {
                while ($cate = $list_categorias_1->fetch(PDO::FETCH_OBJ)) {
                  ?>
                  <option value="<?= $cate->id; ?>">
                    <?= $cate->nome; ?>
                  </option>
                <?php }
              } else { ?>
                <option value="0">Nenhuma categoria cadastrada</option>
              <?php } ?>
            </select>
            <small>Determine a categoria deste cliente</small>
          </div>

          <!-- Input de criar -->
          <!-- <div class="col-md-6">
            <input type="text" class="form-control margin" maxlength="15" name="identificador_externo_cli_add"
              id="identificador_externo_cli_add" placeholder="ID Externo [Opcional] ">
          </div> -->


          <div class="col-md-12 margin">
            <select class="form-control" name="recebe_zap_add" id="recebe_zap_add">
              <option value="1">
                <?= $idioma->notificas_via_zap; ?>
              </option>
              <option value="0">
                <?= $idioma->nao_notificar_zap; ?>
              </option>
            </select>
            <small>
              <?= $idioma->clientes_recebera_todos_mes_aviso; ?>
            </small>
          </div>






          <div class="col-md-12 margin">
            <select class="form-control" name="plano_cli" id="plano_cli_add">
              <option value="0">
                <?= $idioma->selecionar_plano; ?>
              </option>

              <?php

              if ($planos2) {
                while ($plano2 = $planos2->fetch(PDO::FETCH_OBJ)) {

                  ?>

                  <option value="<?= $plano2->id; ?>">
                    <?= $plano2->nome; ?>
                  </option>

                <?php }
              } else { ?>

                <option value="">
                  <?= $idioma->nenhum_plano_cadastrado; ?>
                </option>

              <?php } ?>


            </select>
          </div>


          <div class="col-md-12 margin">
            <?php if (@$plano_usergestor->mini_area_cliente == 1) { ?><small>Isso ira aparecer para seu cliente na
                area
                do cliente</small>
            <?php } ?>
            <textarea name="notas" id="notas_cli_add" class="form-control" rows="3" cols="80"
              placeholder="Observações para seu cliente."></textarea>
          </div>



        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <?= $idioma->fechar; ?>
          </button>
          <button type="button" onclick="add_cli();" id="btn_add_cli" class="btn btn-primary">
            <?= $idioma->adicionar; ?>
          </button>

        </div>


      </div>
    </div>
  </div>
</div>


<!--  Modal send_zap clientes -->
<div class="modal fade" id="modal_send_zap" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_send_zap"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title text-white" id="Titutlo_modal_send_zap">Reenviar Cobrança por whatsapp <i
            class="fa fa-whatsapp"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="body_modal_send_zap">


        <input type="hidden" name="id_cli_send" id="id_cli_send">

        <div class="row">

          <div class="col-md-12 margin">


            <div id="form_send_zap">
              <div class="form-group">
                <input disabled style="cursor:no-drop;" type="text" value="" id="nome_cli_send1" class="form-control">
              </div>

              <div class="form-group">
                <input disabled style="cursor:no-drop;" type="text" value="" id="zap_cli" class="form-control">
              </div>

              <div class="form-group">
                <textarea data-emojiable="true" data-emoji-input="unicode" placeholder="Texto da mensagem"
                  class="emoji-wysiwyg-editor form-control textarea-control" rows="10" id="texto_to"></textarea>
              </div>
            </div>

          </div>

        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <?= $idioma->cancelar; ?>
          </button>
          <a type="button" style="cursor:pointer;" onclick="send_zap();" target="_blank" id="btn_send_zap"
            class="btn btn-success text-white">Enviar</a>

        </div>


      </div>
    </div>
  </div>
</div>


<!--  Modal del clientes -->
<div class="modal fade" id="modal_del_cli" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_del_cliente"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-white" id="Titutlo_modal_del_cliente">
          <?= $idioma->deletar_cliente; ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="body_modal_del_cli">

        <input type="hidden" name="id_del_add" id="id_del_add">

        <div class="row">

          <div class="col-md-12 text-center margin">

            <h4>
              <?= $idioma->deseja_deletar_cliente; ?>
            </h4>

          </div>

        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <?= $idioma->cancelar; ?>
          </button>
          <button type="button" onclick="del_cli();" id="btn_del_cli" class="btn btn-primary">
            <?= $idioma->deletar; ?>
          </button>

        </div>


      </div>
    </div>
  </div>
</div>

<!--  Modal del clientes -->
<div class="modal fade" id="modal_categorias" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_del_cliente"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title " id="Titutlo_modal_del_cliente">Categorias de clientes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="body_modal_categorias">


        <div class="row">
          <div class="col-md-12">
            <p class="alert alert-danger" id="msg_return_categoria" style="display:none;"></p>
          </div>
          <div class="col-md-12 border-bottom">
            <button onclick="add_categoria();" id="btn_add_categoria" class="btn btn-outline-secondary btn-sm"
              style="width:100%;"> <i class="fa fa-plus"></i> Nova categoria</button>
          </div>

          <div class="col-md-12 text-center margin">
            <div id="div_list_categorias" class="row" style="margin:10px;">
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <p>
            As cores das categorias são geradas aleatóriamente.
          </p>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <?= $idioma->fechar; ?>
          </button>

        </div>


      </div>
    </div>
  </div>
</div>

<!-- Modal disparo de mensagem para inadimplentes -->
<div class="modal fade" id="modal_disparo" tabindex="-1" role="dialog" aria-labelledby="modal_disparo"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title " id="Titutlo_modal_del_cliente">Disparo de mensagem para clientes inadimplentes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="body_modal_categorias">
        <p><strong>ATENÇÃO:</strong> Ao realizar o envio de um grande número de mensagens, seu Whatsapp pode ser
          bloqueado ou <span style="color: red;">banido</span>, use essa ferramenta com moderação.
        </p>
        <div class="row">
          <div class="col-md-12">
            <p class="alert alert-danger" id="msg_return_categoria" style="display:none;"></p>
          </div>
          <div class="col-md-12">
            <textarea data-emojiable="true" data-emoji-input="unicode"
              placeholder="Texto da mensagem para clientes inadimplentes"
              class="emoji-wysiwyg-editor2 form-control textarea-control" rows="10" id="text"></textarea>
          </div>
          <!-- <div class="col-md-2 border-bottom">
            <button onclick="" id="btn_add_categoria" class="btn btn-outline-secondary btn-sm"
              style="width:100%;"> <i class="fa fa-plus"></i> Enviar mensagem para todos </button>
          </div> -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <?= $idioma->fechar; ?>
          </button>
          <button type="button" onclick="send_disparo();" class="btn btn-success" id="btn_send_disparo"
            data-dismiss="modal">
            Enviar
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!--  Modal create faturas cliente -->
<div class="modal fade" data-backdrop="static" id="modal_create_fat" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Titutlo_modal_fat_cli">
          <?= $idioma->nova_fatura_cliente; ?>
        </h5>
      </div>
      <div class="modal-body" id="body_modal_add_fat">

        <input type="hidden" name="id_cli_new_fat" id="id_cli_new_fat" value="">
        <input type="hidden" name="nome_cli_new_fat" id="nome_cli_new_fat" value="">
        <input type="hidden" name="email_new_fat" id="email_new_fat" value="">

        <div class="row">
          <div style="margin-bottom:5px;" class="col-md-12 text-center">
            <span id="response_msg"></span>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <input type="text" class="form-control" id="nome_cli_view" name="nome_cli_view" value="" disabled>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <input type="text" class="form-control" id="email_cli_view" name="email_cli_view" value="" disabled>
            </div>
          </div>
          <div class="col-md-12 margin">
            <div class="form-group">
              <select onchange="busca_plano_fat();" class="form-control" name="plano_fat" id="plano_fat">
                <option value="">
                  <?= $idioma->selecionar_plano; ?>
                </option>

                <?php

                if ($planos3) {
                  while ($plano = $planos3->fetch(PDO::FETCH_OBJ)) {

                    ?>

                    <option value="<?= $plano->id; ?>">
                      <?= $plano->nome; ?>
                    </option>

                  <?php }
                } else { ?>

                  <option value="">
                    <?= $idioma->nenhum_plano_cadastrado; ?>
                  </option>

                <?php } ?>


              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <input type="text" class="form-control" name="valor_fat" id="valor_fat_add" value="0,00">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <input type="date" class="form-control" name="data_fat" id="data_fat_add" value="<?= date('Y-m-d'); ?>">
            </div>
          </div>
          <div class="col-md-12 margin">
            <select onchange="mostra_move();" class="form-control" name="status_fat" id="status_fat">
              <option value="Pendente">
                <?= $idioma->pendente; ?>
              </option>
              <option value="Pago">
                <?= $idioma->pago; ?>
              </option>
              <option value="Rejeitado">
                <?= $idioma->rejeitado; ?>
              </option>
              <option value="Devolvido">
                <?= $idioma->devolvido; ?>
              </option>
            </select>
          </div>
          <div class="col-md-12 margin" id="div_move_fat" style="display:none;">
            <div class="col-auto my-1">
              <div class="custom-control custom-checkbox mr-sm-2">
                <input value="1" type="checkbox" id="move_fatura" name="move_fatura" class="custom-control-input">
                <label class="custom-control-label" for="move_fatura">Lançar no financeiro</label>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button onclick="cancel_new_fat();" type="button" class="btn btn-secondary" data-dismiss="modal">
          <?= $idioma->cancelar; ?>
        </button>
        <button onclick="create_fat();" type="button" class="btn btn-primary">
          <?= $idioma->criar; ?>
        </button>
      </div>
    </div>
  </div>
</div>

<?php if (@$plano_usergestor->faturas_cliente == 1) { ?>
  <!--  Modal faturas cliente -->
  <div class="modal fade" data-backdrop="static" id="modal_fat_cli" tabindex="-1" role="dialog"
    aria-labelledby="Titutlo_modal_del_cliente" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="Titutlo_modal_fat_cli">
            <?= $idioma->faturas_cliente; ?>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="body_modal_fat_cli">

          <input type="hidden" id="id_cli_fat">
          <input type="hidden" id="nome_cli_fat">
          <input type="hidden" id="email_cli_fat">

          <div style="margin-bottom:10px;" class="row">
            <div class="col-md-4 text-left">
              <button onclick="modal_create_fat();" type="button" class="btn btn-sm btn-outline-success" name="button"><i
                  class="fa fa-plus"></i> Nova Fatura</button>
            </div>
            <div class="col-auto my-1">
              <div class="custom-control custom-checkbox mr-sm-2">
                <input onclick="status_lanca_finan();" value="1" <?php if ($user->lancar_finan == 1) {
                  echo "checked";
                } ?> type="checkbox" id="lancar_finan_status" name="lancar_finan_status" class="custom-control-input">
                <input type="hidden" id="status_lanca_finan" value="<?= $user->lancar_finan; ?>" />
                <label class="custom-control-label" for="lancar_finan_status">Lançamento automático financeiro</label>
              </div>
              <div class="custom-control custom-checkbox mr-sm-2">
                <input onclick="status_vencimento_flex();" value="1" <?php if ($user->vencimento_flex == 1) {
                  echo "checked";
                } ?> type="checkbox" id="vencimento_flex_status" name="vencimento_flex_status"
                  class="custom-control-input">
                <input type="hidden" id="status_vencimento_flex" value="<?= $user->vencimento_flex; ?>" />
                <label class="custom-control-label" for="vencimento_flex_status">Vencimentos Flexíveis</label>
                <!-- |  -->
                <!-- <a
                  href="https://youtu.be/FmI-DDg96ZQ" target="_blank"><i class="fa fa-question"></i>
                </a> -->
              </div>
            </div>
            <div class="col-auto my-1">
              <div class="custom-control custom-checkbox mr-sm-2">
                <input onclick="status_gera_fat_cli();" value="1" <?php if ($user->gera_fat_cli == 1) {
                  echo "checked";
                } ?> type="checkbox" id="gera_fat_cli" name="gera_fat_cli" class="custom-control-input">
                <input type="hidden" id="status_gera_fat_cli" value="<?= $user->gera_fat_cli; ?>" />
                <label class="custom-control-label" for="gera_fat_cli">Gerar faturas automáticas</label>
              </div>
            </div>
          </div>
          <table class="table">
            <span id="response_msg_fat_"></span>
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">
                  <?= $idioma->valor; ?>
                </th>
                <th scope="col">
                  <?= $idioma->data; ?>
                </th>
                <th scope="col">
                  <?= $idioma->plano; ?>
                </th>
                <th scope="col">
                  <?= $idioma->status; ?>
                </th>
                <th scope="col">
                  <?= $idioma->deletar; ?>
                </th>
              </tr>
            </thead>

            <tbody id="tbody_faturas">

            </tbody>
          </table>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <?= $idioma->fechar; ?>
          </button>
        </div>
      </div>

    </div>
  </div>

<?php } ?>

<div class="modal fade" id="modal_export_cli" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titutlo_modal_export_financeiro">Escolha o formato do arquivo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="body_modal_export_financeiro">

        <form class="" action="../control/control.export_clientes.php" id="form_export" method="post">

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <select class="form-control" name="type_export" id="type_export">
                  <option value="xls">Exportar em excel (xls)</option>
                  <option value="json">Exportar em JSON</option>
                </select>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <button onclick="$('#form_export').submit();" id="btn_export_dados_financeiros" style="width:100%;"
                  type="button" class="btn btn-primary" name="button">Exportar</button>
              </div>
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>



  <script>

    function status_gera_fat_cli() {
      var a = $("#status_gera_fat_cli").val();
      $.post("../control/control.status_create_fat_vencimento.php", {
        status: a
      }, function (a) {
        var objResGerarFat = JSON.parse(a);
        $("#status_gera_fat_cli").val(objResGerarFat.statusRes);
      })
    }

    function save_name_categoria(id) {
      var name = $("#input_categoria_" + id).val();
      $.post('../control/control.categorias_cliente.php', { type: "save", nome: name, id: id }, function (data) {

        try {

          var responseObj = JSON.parse(data);

          if (typeof responseObj.erro == "undefined") {
            $("#msg_return_categoria").show();
            $("#msg_return_categoria").html('Desculpe, volte mais tarde');
            setTimeout(function () {
              $("#msg_return_categoria").html("");
              $("#msg_return_categoria").hide();
            }, 5000);
          } else {

            if (responseObj.erro) {
              $("#msg_return_categoria").show();
              $("#msg_return_categoria").html(responseObj.msg);
              setTimeout(function () {
                $("#msg_return_categoria").html("");
                $("#msg_return_categoria").hide();
              }, 5000);
            } else {
              $("#title_categoria_" + id).html(name);
              $("#title_categoria_" + id).show();
              $("#input_categoria_" + id).hide();
            }

          }
        } catch (e) {
          $("#msg_return_categoria").show();
          $("#msg_return_categoria").html('Desculpe, volte mais tarde');
          setTimeout(function () {
            $("#msg_return_categoria").html("");
            $("#msg_return_categoria").hide();
          }, 5000);
        }

      });
    }

    function rename_categoria(id) {
      $("#title_categoria_" + id).hide();
      $("#input_categoria_" + id).show();
      $("#input_categoria_" + id).focus();

    }

    function list_categorias_cards() {
      $.post('../control/control.categorias_cliente.php', { type: "list" }, function (dataRes) {
        try {
          var responseObj = JSON.parse(dataRes);

          if (typeof responseObj.erro == "undefined") {
            $("#div_list_categorias").html(dataRes);
          } else {
            $("#div_list_categorias").html('<div class="col-md-12 text-center" ><h5>Nenhuma categoria no momento</h5></div>');
          }
        } catch (e) {
          $("#div_list_categorias").html(dataRes);
        }

      });
    }

    function remove_categoria(categoria) {

      $.post('../control/control.categorias_cliente.php', { type: "remove", categoria: categoria }, function (data) {

        var obj = JSON.parse(data);

        if (obj.erro) {
          $("#msg_return_categoria").show();
          $("#msg_return_categoria").html(obj.msg);
          setTimeout(function () {
            $("#msg_return_categoria").html("");
            $("#msg_return_categoria").hide();
          }, 5000);
        } else {
          list_categorias_cards();
        }

      });

    }

    function add_categoria() {

      $("#btn_add_categoria").prop('disabled', true);
      $("#btn_add_categoria").html('Aguarde <i class="fa fa-spinner fa-spin" ></i> ');

      $.post('../control/control.categorias_cliente.php', { type: "add" }, function (data) {
        var obj = JSON.parse(data);

        if (obj.erro) {
          $("#msg_return_categoria").show();
          $("#msg_return_categoria").html(obj.msg);
          setTimeout(function () {
            $("#msg_return_categoria").html("");
            $("#msg_return_categoria").hide();
          }, 5000);
        } else {
          list_categorias_cards();
        }

        $("#btn_add_categoria").prop('disabled', false);
        $("#btn_add_categoria").html('<i class="fa fa-plus"></i> Nova categoria');

      });
    }

    function send_zap() {

      $("#btn_send_zap").prop('disabled', true);
      $("#btn_send_zap").html('Aguarde <i class="fa fa-refresh fa-spin" ></i>');

      var id_cli = $("#id_cli_send").val();
      var text_to = $("div.emoji-wysiwyg-editor").text();
      let phone = $("#zap_cli").val();

      // console.log(text_to);

      $.post('../control/control.resend_cobranca.php', { text_to, id_cli, }, function (data) {
        var ResJson = JSON.parse(data);
        console.log(ResJson);

        if (ResJson.erro == false) {
          alert('Sua mensagem foi adicionada na fila e será enviada!');
          location.href = "";
          $("#btn_send_zap").html('Enviado');

        } else {
          alert(ResJson.msg);
          location.href = "";
          $("#btn_send_zap").html('Tente novamente.');



          // $("#form_send_zap").hide();
          // $("#btn_send_zap").hide();
          // $("#msg_send_zap_aguarde").show('100');
          // $("#msg_send_zap_aguarde").html('<h5 class="text-success">' + ResJson.msg + '</h5>');
          // setTimeout(function () {
          //   $("#modal_send_zap").modal('toggle');
          // }, 4000);
        }

        $("#btn_send_zap").prop('disabled', false);
        // $("#btn_send_zap").html('Agendar envio');
      });
    }

    function send_disparo() {

      $("#btn_send_disparo").prop('disabled', true);
      $("#btn_send_disparo").html('Aguarde <i class="fa fa-refresh fa-spin" ></i>');

      var text = $("textarea.emoji-wysiwyg-editor2").val();

      // console.log(text);

      $.post('../control/control.send_disparo.php', { text }, function (data) {
        var ResJson = JSON.parse(data);
        console.log(ResJson);

        if (ResJson.erro == false) {
          alert('Sua mensagem foi adicionada na fila e será enviada!');
          location.href = "";
          $("#btn_send_disparo").html('Enviado');
        } else {
          alert(ResJson.msg);
          location.href = "";
          $("#btn_send_disparo").html('Tente novamente.');
        }
        $("#btn_send_disparo").prop('disabled', false);
      });
    }

    function modal_send_zap(id_cli, nome_cli, tel_cli, plano) {

      $("#modal_send_zap").modal();
      $("#nome_cli_send").html(nome_cli);

      $.post('../control/control.dados_plano.php', { id_plano: plano }, function (data) {

        var returnJsonP = JSON.parse(data);

        if (returnJsonP.erro) {

          $("#msg_send_zap_aguarde").html('<h5 class="text-danger">' + returnJsonP.msg + '</h5>');

        } else {

          emojiPicker = new EmojiPicker({

            emojiable_selector: '[data-emojiable=true]',
            assetsPath: 'emojis/img/',
            popupButtonClasses: 'fa fa-smile-o'
          });

          emojiPicker.discover();


          $("#msg_send_zap_aguarde").hide();
          $("#form_send_zap").show('100');
          $("#btn_send_zap").show('100');

          $(".emoji-wysiwyg-editor").text(returnJsonP.template_zap);
          $("#id_cli_send").val(id_cli);
          $("#nome_cli_send1").val(nome_cli);
          $("#zap_cli").val(tel_cli);
        }

      });


    }

    function modal_create_fat() {
      $("#modal_fat_cli").modal("toggle");
      $("#modal_create_fat").modal("show");
      console.log("Função modal_create_fat() chamada com sucesso!");
      var a = $("#id_cli_fat").val(),
        e = $("#nome_cli_fat").val(),
        o = $("#email_cli_fat").val();
      o == "" ? $("#email_cli_view").val("[sem email]") : $("#email_cli_view").val(o);
      $("#id_cli_new_fat").val(a);
      $("#nome_cli_view").val(e);
      $("#nome_cli_new_fat").val(e);
      $("#email_new_fat").val(o);
      $("#div_move_fat").hide(100);
      $("#move_fatura").prop("checked", !1);
    }
  </script>

  <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->


  <!-- footer -->
  <?php include_once 'inc/footer.php'; ?>