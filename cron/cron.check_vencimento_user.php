<?php
echo "Cron check vencimento user <br>";

set_time_limit(30000);

require_once 'autoload.php';

$user_class = new User();
$gestor_class = new Gestor();
$faturas_class = new Faturas();
$whatsapi_class = new Whatsapi();
$financeiro_class = new Financeiro();

$daqui_5_days = date('d/m/Y', strtotime('+5 days', strtotime(date('d-m-Y'))));

$list_users = $user_class->list_5_days($daqui_5_days);
// echo "list_users {$list_users} <br>";
// var_dump($list_users);

if ($list_users) {
  echo "entrou no if list_users <br>";
  while ($user = $list_users->fetch(PDO::FETCH_OBJ)) {
    echo "entrou no while <br>";
    // echo "user: {$user} <br>"; // Quebrando o código!
    // $moeda = $financeiro_class->getmoeda($user->moeda);
    $moeda = 'BRL';
    echo "moeda: {$moeda} <br>";

    $plano = $gestor_class->plano($user->id_plano);
    // echo "plano: {$plano} <br>"; // Quebrando o código!

    $create_fat = $faturas_class->create($plano, $user, @$moeda);
    echo "create_fat: {$create_fat} <br>";

    //Jay11
    //Desabilitado pq tava banindo os números do zap
    // $tema = $whatsapi_class->get_template('faturas');

    // if ($tema) {
    //   echo "entrou no if tema <br>";

    //   $ar1 = array('{vencimento}', '{valor}', '{primeiro_nome}', '{plano_nome}');
    //   $ar2 = array($daqui_5_days, $plano->valor, explode(' ', $user->nome)[0], $plano->nome);
    //   $text = str_replace($ar1, $ar2, $tema->texto);

    //   $ar1 = array('+', ')', '(', ' ', '-');
    //   $ar2 = array('', '', '', '', '');
    //   $phone = $user->ddi . str_replace($ar1, $ar2, $user->telefone);

    //   echo "phone: {$phone}, text:{$text}, user->id: ${$user->id} <br>";

    //   $whatsapi_class->fila($phone, $text, $user->id, 'ZAPI', 'ZAPI', '0000', '0000', "vencimento_user"); //tava escrito gestorbot e mudei pra ZAPI

    // }


  }
}

?>