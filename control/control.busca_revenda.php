<?php

@session_start();

if (isset($_SESSION['SESSION_USER'])) {

    if ($_SESSION['SESSION_USER']['id'] != "") {

        if (isset($_POST['busca'])) {

            $busca = trim($_POST['busca']);

            require_once '../class/Conn.class.php';
            require_once '../class/Clientes.class.php';
            require_once '../class/Planos.class.php';
            require_once '../class/Gestor.class.php';
            require_once '../class/User.class.php';
            require_once '../class/Revenda.class.php';

            $clientes = new Clientes();
            $planos = new Planos();
            $gestor = new Gestor();
            $user = new User();
            $revenda_class = new Revenda();

            $dados_user = $user->dados($_SESSION['SESSION_USER']['id']); // Busca dados do user atual
            $plano_usergestor = $gestor->plano($dados_user->id_plano); // Identifica o plano, amador/pro/patrão


            // $buscar = $clientes->buscaRevenda($busca, $_SESSION['SESSION_USER']['id']); // Aqui ele faz a busca pelo nome
            $buscar = $user->buscaRevenda($busca, $_SESSION['SESSION_USER']['id']); // Aqui ele faz a busca pelo nome

            if ($buscar) {

                echo '<form class="" id="form_checkbox" action="../control/control.delete_clientes.php" method="POST">';

                while ($rev = $buscar->fetch(PDO::FETCH_OBJ)) {

                    // buscar dados do plano
                    $plano = $gestor->plano($rev->id_plano); // Identifica o plano, amador/pro/patrão
                    // $plano = $planos->plano($rev->id_plano); //Adaptar para revendedor


                    if ($rev->vencimento != '0') {

                        // verificar data do vencimento
                        $explodeData = explode('/', $rev->vencimento);
                        $explodeData2 = explode('/', date('d/m/Y'));
                        $dataVen = $explodeData[2] . $explodeData[1] . $explodeData[0];
                        $dataHoje = $explodeData2[2] . $explodeData2[1] . $explodeData2[0];

                        if ($dataVen == $dataHoje) {
                            $ven = "<b class='badge badge-warning'>{$rev->vencimento}</b>";
                        } else if ($dataHoje > $dataVen) {
                            $ven = "<b class='badge badge-danger'>{$rev->vencimento}</b>";
                        } else if ($dataHoje < $dataVen) {
                            $ven = "<b class='badge badge-success'>{$rev->vencimento}</b>";
                        }
                    } else {
                        $ven = "<b class='badge badge-secondary'>Não definido</b>";
                    }

                    $getCategoria = $clientes->get_categoria($rev->categoria);
                    if ($getCategoria) {
                        $colorCate = $getCategoria->cor;
                    } else {
                        $colorCate = "secondary";
                    }

                    ?>

                    <tr id="tr_<?= $rev->id; ?>" class="trs ">

                        <td>
                            <?= $rev->id; ?>
                        </td>
                        <td>
                            <?= $rev->nome; ?>
                            <?php
                            require_once '../class/Conn.class.php';
                            $conn = new Conn();
                            $pdo = $conn->pdo();

                            $idCategoria = $rev->categoria;
                            $query = $pdo->prepare("SELECT nome FROM `categorias_cliente` WHERE id = :idCategoria LIMIT 1");
                            $query->bindParam(':idCategoria', $idCategoria, PDO::PARAM_INT);
                            $query->execute();

                            // Recuperar o resultado
                            $result = $query->fetch(PDO::FETCH_ASSOC);
                            $nomeCategoria = $result['nome'];
                            ?>
                        </td>
                        <td>
                            <?php if ($plano) {
                                echo $plano->nome;
                            } else {
                                echo "<i style='cursor:pointer;' title='ADICIONE UM PLANO' class='text-danger fa fa-warning' ></i> ";
                            } ?>
                        </td>
                        <td>
                            <?php if (@$rev->telefone == "vazio") {
                                echo @$rev->telefone . " <i style='font-size:10px;cursor:pointer;' title='" . @$idioma->adicione_um_telefone . "' class='text-danger fa fa-warning' ></i>";
                            } else {
                                echo '<a target="_blank" class="break-line" href="http://wa.me/' . $rev->ddi . @$rev->telefone . '" > ' . $rev->ddi . @$rev->telefone . '</a>';
                            } ?>
                        </td>
                        <td>
                            <?= str_replace('@', '<br>@', $rev->email); ?>
                        </td>
                        <td>
                        <span class="text-info" style="cursor:pointer;" onclick="alert('<?= $rev->senha; ?>');">******</span>
                        </td>
                        <td>
                            <?= $ven; ?>

                        </td>
                        <td>
                            <?php
                            $credCadaRev = $revenda_class->qtd_creditos($rev->id);
                            echo $credCadaRev[0]->qtd;
                            ?>
                        </td>
                        <td>
                            <button onclick="renew_user_rev(<?= $rev->id; ?>,<?= $rev->id_plano; ?>);" title="RENOVAR" type="button"
                                class="btn-outline-primary btn w-100 d-md-block" style="padding: 0px"> <i class="fa fa-refresh"></i> </button>
                            <button onclick="add_user_cred(<?= $rev->id; ?>,<?= $rev->id_plano; ?>);" title="ADICIONAR CRÉDITOS"
                                type="button" class="btn-outline-primary btn w-100 d-md-block" style="padding: 0px"> <i class="fa fa-plus"></i> </button>
                            <button id="btn_del_<?= $rev->id; ?>" onclick="modal_del_user_rev(<?= $rev->id; ?>);" title="REMOVER"
                                type="button" class="btn-outline-danger btn w-100 d-md-block" style="padding: 0px"> <i class="fa fa-trash"></i> </button>
                        </td>
                    </tr>

                    <?php
                }
            } else {
                echo '<tr><td class="text-center" colspan="7" >Nenhum revendedor encontrado com "' . $busca . '" </td></tr></form>';
            }

        } else {
            echo '{"erro":true,"msg":"Request is required"}';
        }


    } else {
        echo '{"erro":true,"msg":"User not found"}';
    }

} else {
    echo '{"erro":true,"msg":"403"}';
}

?>