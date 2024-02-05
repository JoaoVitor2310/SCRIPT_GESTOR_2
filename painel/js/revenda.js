
function add_user_cred(cli) {
  $("#modal_add_cred").modal('show');
  $("#id_cli_revendedor").val(cli);
}
function renew_user_rev(cli, plano) {
  $("#id_plano_cli_rev_renew").val(plano);
  $("#modal_ren_cliente").modal('show');
  $("#id_cli_rev").val(cli);
}


function info_p() {
  var id_plano = $("#id_plano_cli_rev_renew").val();
  var id_plano2 = $("#id_plano_cli_rev").val();

  if (id_plano == 7 || id_plano2 == 7) {
    // alert("Vai vender o plano Patrão ? Entre em contato conosco antes ! Isso é obrigatório.");
  }

}

function renew_rev_cli() {

  $("#btn_renew_rev").prop('disabled', true);
  $("#btn_renew_rev").html('Adicionar <i class="fa fa-refresh fa-spin" ></i>');

  var id_plano = $("#id_plano_cli_rev_renew").val();
  var vencimento = $("#vencimento_cli_rev_renew").val();
  var id_cli = $("#id_cli_rev").val();

  $.post('../control/control.renew_cli_rev.php', { id_plano: id_plano, vencimento: vencimento, id_cli: id_cli }, function (data) {
    var obj = JSON.parse(data);

    if (typeof obj != "undefined") {

      if (typeof obj.erro != "undefined") {

        if (obj.erro) {

          $("#response_cli_rev_renew").addClass('text-danger');
          $("#response_cli_rev_renew").removeClass('text-success');
          $("#response_cli_rev_renew").html('<b>' + obj.msg + '</b>');
          $("#btn_renew_rev").prop('disabled', false);
          $("#btn_renew_rev").html('Adicionar');
        } else {
          $("#response_cli_rev_renew").addClass('text-success');
          $("#response_cli_rev_renew").removeClass('text-danger');
          $("#response_cli_rev_renew").html('<b>' + obj.msg + '</b>');
          location.href = "";
        }


      } else {
        $("#response_cli_rev_renew").addClass('text-danger');
        $("#response_cli_rev_renew").removeClass('text-success');
        $("#response_cli_rev_renew").html('Erro, por favor, comunicar ao suporte.');
        $("#btn_renew_rev").prop('disabled', false);
        $("#btn_renew_rev").html('Adicionar');
      }

    } else {
      $("#response_cli_rev_renew").addClass('text-danger');
      $("#response_cli_rev_renew").removeClass('text-success');
      $("#response_cli_rev_renew").html('Erro, por favor, comunicar ao suporte.');
      $("#btn_renew_rev").prop('disabled', false);
      $("#btn_renew_rev").html('Adicionar');
    }
  });
}


function payment_credits(isRevenda) {

  $("#btn_pay_cred").prop('disabled', true);
  $("#btn_pay_cred").html('<i class="fa fa-refresh fa-spin" ></i> Aguarde');

  const num_cred = $("#qtd_credit").val();
  console.log(num_cred);
  const tipo_pay = $("#tipo_pay").val();

  if (num_cred == "" || typeof num_cred == "undefined") {
    alert('Não entendemos quantos créditos você precisa, atualize a página e tente novamente.');
    $("#btn_pay_cred").prop('disabled', false);
    $("#btn_pay_cred").html('Pagar');
    return;
  }

  if (isRevenda) {
    // console.log('TRUE')
    alert("Você foi indicado, contacte o seu superior para comprar créditos por fora da plataforma.");
    window.location.href = "https://gestormaster.top/painel/revenda";
    return;
  }

  $.post('../control/control.register_pay_credits.php', { cred: num_cred, tipo_pay: tipo_pay }, function (data) {

    var obj = JSON.parse(data);

    if (obj.erro) {

      alert(obj.msg);

      if (typeof obj.redirect != "undefined") {
        if (obj.redirect) {
          location.href = "pagamentos?click";
        }
      } else {
        location.href = "pagamentos?click";
      }



    } else {
      if (tipo_pay == "mp") {
        location.href = "pagamentos?click";
      } else {
        location.href = "";
      }
    }

    $("#btn_pay_cred").prop('disabled', false);
    $("#btn_pay_cred").html('Pagar');

  });

}

function add_credits(creditos, userID, cli) {
  // console.log('CRÉDITOS: ' + creditos) // saldo atual do vendedor
  // console.log('userId: ' + userID) // id do vendedor
  // console.log('cli: ' + cli); // id do revendedor
  $("#btn_add_cred").prop('disabled', true);
  $("#btn_add_cred").html('<i class="fa fa-refresh fa-spin" ></i> Aguarde');

  const credToAdd = $("#qtd_creditos").val();
  var regex = /^-?\d+\.\d+$/; // Expressão regular para saber se o número possui vírgula ou não
  console.log(regex.test(credToAdd))

  if (credToAdd == "" || typeof credToAdd == "undefined" || credToAdd <= 9 || regex.test(credToAdd)) {
    alert('Quantidade inválida, tente novamente.');
    $("#btn_add_cred").prop('disabled', false);
    $("#btn_add_cred").html('Adicionar');
    return;
  }

  // Ver se o número de créditos é menor que o credToAdd, se for, manda um aviso de saldo insuficiente, se não for, continua
  if (creditos < credToAdd) {
    alert('Você não possui saldo suficiente, diminua a quantidade ou compre mais créditos.');
    $("#btn_add_cred").prop('disabled', false);
    $("#btn_add_cred").html('Adicionar');
    return;
  }

  // Ir no banco de dados creditos_rev e ver quantos créditos o revendedor tem através do id dele CHECK
  // Ir no banco de dados creditos_rev e adicionar os créditos para o revendedor através do id dele CHECK
  // Abater a quantidade de créditos inserida no saldo do vendedor CHECK
  $.post('../control/control.add_cred_rev.php', { creditos, credToAdd, userID, cli }, function (data) {

    var obj = JSON.parse(data);
    // console.log(obj);


    if (obj.erro) {
      alert(obj.msg);
      location.href = "https://gestormaster.top/painel/revenda";
    } else {
      $("#btn_add_cred").prop('disabled', false);
      $("#btn_add_cred").html('Adicionado!');
      window.alert('Adicionado!');
      location.href = "https://gestormaster.top/painel/revenda";
    }

    // $("#btn_add_cred").html('Adicionar');

  });

}

function calc_qtd_credits_add_cli_renew() {

  var id_plano = $("#id_plano_cli_rev_renew").val();
  var vencimento = $("#vencimento_cli_rev_renew").val();
  $.post('../control/control.calc_credits.php', { calc: '', id_plano: id_plano, vencimento: vencimento }, function (data) {

    var obj = JSON.parse(data);

    if (typeof obj.erro != "undefined") {

      if (obj.erro == false) {
        $("#qtd_cred_rev_renew").val(obj.creditos);
      } else {
        $("#qtd_cred_rev_renew").val('0');
      }

    }

  });
}


function calc_qtd_credits_add_cli() {
  var id_plano = $("#id_plano_cli_rev").val();
  var vencimento = $("#vencimento_cli_rev").val();
  $.post('../control/control.calc_credits.php', { calc: '', id_plano: id_plano, vencimento: vencimento }, function (data) {

    var obj = JSON.parse(data);

    if (typeof obj.erro != "undefined") {

      if (obj.erro == false) {
        $("#qtd_cred_rev").val(obj.creditos);
      } else {
        $("#qtd_cred_rev").val('0');
      }

    }

  });
}

function add_new_cli() {
  console.log('Clicado');

  $("#btn_add_cli_rev").prop('disabled', true);
  $("#btn_add_cli_rev").html('<i class="fa fa-refresh fa-spin" ></i> Aguarde');

  var json_cli = $("#json_inputs").val();

  $.post('../control/control.add_cli_rev.php', { add_cli: '', dados: json_cli }, function (data) {

    var obj = JSON.parse(data);
    console.log(obj);

    if (typeof obj != "undefined") {

      if (typeof obj.erro != "undefined") {

        if (obj.erro) {
          $("#response_add_new_cli_rev").addClass('text-danger');
          $("#response_add_new_cli_rev").removeClass('text-success');
          $("#response_add_new_cli_rev").html('<b>' + obj.msg + '</b>');
          $("#btn_add_cli_rev").prop('disabled', false);
          $("#btn_add_cli_rev").html('Adicionar');
        } else {
          $("#response_add_new_cli_rev").addClass('text-success');
          $("#response_add_new_cli_rev").removeClass('text-danger');
          $("#response_add_new_cli_rev").html('<b>' + obj.msg + '</b>');
          location.href = "";
        }


      } else {
        $("#response_add_new_cli_rev").addClass('text-danger');
        $("#response_add_new_cli_rev").removeClass('text-success');
        $("#response_add_new_cli_rev").html('Erro, por favor, comunicar ao suporte.');
        $("#btn_add_cli_rev").prop('disabled', false);
        $("#btn_add_cli_rev").html('Adicionar');
      }

    } else {
      $("#response_add_new_cli_rev").addClass('text-danger');
      $("#response_add_new_cli_rev").removeClass('text-success');
      $("#response_add_new_cli_rev").html('Erro, por favor, comunicar ao suporte.');
      $("#btn_add_cli_rev").prop('disabled', false);
      $("#btn_add_cli_rev").html('Adicionar');
    }



  });



}

function modal_solicita_money() {
  $("#modal_solicita_saque").modal('show');
}

function modal_del_user_rev(id) {
  $("#id_modal_del_user_rev").val(id);
  $("btn_del_" + id).html('<i class="fa fa-refresh fa-spin" ></i>');
  if ($("#modal_del_user_rev").modal('show')) {
    $("btn_del_" + id).html('<i class="fa fa-trash" ></i>');
  }

}

function delete_user_rev(userID) {
  // console.log(userID); // id do usuário atual(avô)
  $("#btn_modal_del_user").prop('disabled', true);

  var id = $("#id_modal_del_user_rev").val(); // id de quem será apagado(pai)

  // Identificar todos os usuários que são "filhos" do "id"
  // Mudar o "id_rev" desses "filhos" para o valor de userID
  // Apagar o "pai"
  
  // Caso exemplo: teste2(avô) deletando o teste6(pai) que possui o teste66(filho), o id_rev do teste66 deve ser igual ao teste2 dps de deletado
  // -na tabela user, buscar todos os id que possuem o id_rev do teste66(3865)





  $.post('../control/control.remove_cli_rev.php', { id, userID }, function (data) {
    var obj = JSON.parse(data);
    console.log(obj);
    if (data == 1 || data == "1") {
      location.href = "";
    } else {
      alert('Erro ao deletar');
      $("#btn_modal_del_user").prop('disabled', false);
    }
  });

}


function solicita_saque() {

  $("#btn_solicita_saque").prop('disabled', true);

  var info = $("#info_saque").val();
  var valor = $("#valor_saque").val();

  $.post('../control/control.solicita_saque.php', { info: info, valor: valor }, function (data) {

    var objRes = JSON.parse(data);

    if (typeof objRes.erro != "undefined") {

      alert(objRes.msg);
      location.reload();
    } else {
      alert('Erro, entre em contato com o suporte');

    }

    $("#btn_solicita_saque").prop('disabled', false);


  });

}

function verific_inputs_add_cli() {
  setInterval(function () {
    verific_inputs_add_cli2();
  }, 1000);
}

function verific_inputs_add_cli2() {

  var cli_add = new Object();

  cli_add.nome = $("#nome_cli_rev").val();
  cli_add.email = $("#email_cli_rev").val();
  cli_add.ddi = $("#ddi_cli_rev").val();
  cli_add.telefone = $("#telefone_cli_rev").val();
  cli_add.senha = $("#senha_cli_rev").val();
  // cli_add.id_plano = $("#id_plano_cli_rev").val();
  cli_add.id_plano = 7; // 7 é o id do plano patrão, que será sempre o padrão
  cli_add.vencimento = $("#vencimento_cli_rev").val();
  cli_add.qtd_cred = $("#qtd_cred_rev").val();
  // cli_add.teste = $("#planoTeste").val();

  var dados = JSON.stringify(cli_add);
  $("#json_inputs").val(dados);

  // if (cli_add.nome != "" && cli_add.email != "" && cli_add.ddi != "" && cli_add.telefone != "" && cli_add.senha != "" && cli_add.id_plano != "" && cli_add.vencimento != "" && cli_add.qtd_cred > 0) {
  if (cli_add.nome != "" && cli_add.email != "" && cli_add.ddi != "" && cli_add.telefone != "" && cli_add.senha != "" && cli_add.id_plano != "" ) {
    $("#btn_add_cli_rev").prop('disabled', false);
  } else {
    $("#btn_add_cli_rev").prop('disabled', true);
  }

}
