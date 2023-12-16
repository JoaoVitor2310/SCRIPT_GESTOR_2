<?php

echo "Cron send fila <br>";

set_time_limit(0);

require_once 'autoload.php';
// include_once '../libs/phpmailer/PHPMailerAutoload.php'; // Aparentemente não é necessário esse import, vou desativar pq ele tá quebrando.

$user_class = new User();
$whatsapi_class = new Whatsapi();
$clientes_class = new Clientes();
$gestor_class = new Gestor();

function link_texto($texto)
{
    if (!is_string($texto))
        return $texto;

    $er = "/(https:\/\/(www\.|.*?\/)?|http:\/\/(www\.|.*?\/)?|www\.)([a-zA-Z0-9]+|_|-)+(\.(([0-9a-zA-Z]|-|_|\/|\?|=|&)+))+/i";

    $texto = preg_replace_callback($er, function ($match) {
        $link = $match[0];
        //coloca o 'http://' caso o link nao o possua
        $link = (stristr($link, "http") === false) ? "http://" . $link : $link;

        //troca "&" por "&", tornando o link vÃ¡lido pela W3C
        $link = str_replace("&", "&amp;", $link);
        $a = str_replace('http://', '', ((strlen($link) > 60) ? substr($link, 0, 25) . "..." . substr($link, -15) : $link));

        return "<a href=\"" . $link . "\" target=\"_blank\">" . $a . "</a>";
    }, $texto);
    return $texto;
}

$fila_lock = $whatsapi_class->list_msgs_fila();
echo "<br>fila lock:<br>";
// var_dump($fila_lock);
echo "<br>";

if ($fila_lock) {//fila_lock tem os dados da fila email ou wpp
    // echo 'Entrou no fila_lock';
    $whatsapi_class->delete_fila($fila_lock->id);
    
    // buscar dados cliente
    // $cliente = $clientes_class->dados($fila_lock->id_cliente);
    $cliente = $clientes_class->dados($fila_lock->id_cliente); // OLHAR AQUI NO CASO DO ADM
    echo "<br>CLIENTE: <br>";
    var_dump($cliente);
    echo "<br>";
    
    $adm = $user_class->dados($fila_lock->id_user); //Id do revendedor que recebe a msg
    echo "<br>ADM: <br>";
    var_dump($adm);
    
    // ARRUMAR ESSA CONDIÇÃO
    if(!$cliente){ 
        echo "<br> MSG DO GESTOR PARA O REVENDEDOR! <br>";
        $cliente = clone $adm; // Pega os atributos de adm e coloca em cliente, pq o revendedor que irá receber a mensagem agr
        // Entender e colocar os atributos do gestor no lugar do adm.
        // adm e cliente agora são iguais
        echo "<br>CLIENTE ATUALIZADO: <br>";
        var_dump($cliente);
        echo "<br>";
        
    }
    

    
    $nome = $adm->nome;
    $email = $adm->email;
    $titulo = "Gestor Master";
    $img = "https://gestormaster.top/painel/img/logo-gestor-lite_dark_on.png";

    $texto = str_replace("*", "", link_texto($fila_lock->msg));
    $html = file_get_contents("../template_mail/template_1/index.html");

    if ($fila_lock->tipo == "vencimento_day") { // Tipo de mensagem que o cliente receberá
        echo "vencimento_day: <br>";
        $img = "https://gestormaster.top/template_mail/template_1/img/Generic-calendar-page-icon.png";
        $titulo = "{$cliente->nome} seu Plano vence hoje !!!";
        $email = $cliente->email;
        $nome = $cliente->nome;
    } else if ($fila_lock->tipo == "aviso_antecipado") {
        echo "aviso_antecipado: <br>";
        $img = "https://gestormaster.top/template_mail/template_1/img/Generic-calendar-page-icon.png";
        $titulo = "Falta alguns dias para seu plano vencer !";
        $email = $cliente->email;
        $nome = $cliente->nome;
    } else if ($fila_lock->tipo == "recover_pass") {
        echo "recover_pass: <br>";
        $img = "https://gestormaster.top/template_mail/template_1/img/forgot-password.png";
        $titulo = "Recuperação de Senha - Gestor Master";
        $email = $adm->email;
        $nome = explode(' ', $adm->nome)[0];
    } else if ($fila_lock->tipo == "novo_user") {
        echo "novo_user: <br>";
        $img = "https://gestormaster.top/template_mail/template_1/img/forgot-password.png";
        $titulo = "Bem Vindo(a) !";
        $email = $cliente->email;
        $nome = explode(' ', $cliente->nome)[0];
    } else if ($fila_lock->tipo == "vencimento_user") {
        echo "vencimento_user: <br>";
        $img = "https://gestormaster.top/template_mail/template_1/img/Generic-calendar-page-icon.png";
        $titulo = "Vencimento Gestor Master";
        $email = $adm->email;
        $nome = explode(' ', $adm->nome)[0];
    } else if ($fila_lock->tipo == "pagamento_confirmado") {
        echo "pagamento_confirmado: <br>";
        $img = "https://gestormaster.top/template_mail/template_1/img/check-icone-scaled.png";
        $titulo = "Pagamento Confirmado";
        $email = $cliente->email;
        $nome = $cliente->nome;
    } else if ($fila_lock->tipo == "comprovante_enviado_user") {
        echo "comprovante_enviado_user: <br>";
        $img = "https://gestormaster.top/template_mail/template_1/img/boletonovo.png";
        $titulo = "Recebemos seu comprovante";
        $email = $adm->email;
        $nome = $adm->nome;
    } else if ($fila_lock->tipo == "comprovante_enviado_adm") {
        echo "comprovante_enviado_adm: <br>";
        $img = "https://gestormaster.top/template_mail/template_1/img/boletonovo.png";
        $titulo = "Um cliente enviou um comprovante";
        $email = $adm->email;
        $nome = $adm->nome;
    } else if ($fila_lock->tipo == "comprovante_aceito") {
        echo "comprovante_aceito: <br>";
        $img = "https://gestormaster.top/template_mail/template_1/img/check-icone-scaled.png";
        $titulo = "Comprovante aceito !";
        $email = $adm->email;
        $nome = $adm->nome;
    } else if ($fila_lock->tipo == "comprovante_recusado") {
        echo "comprovante_recusado: <br>";
        $img = "https://gestormaster.top/template_mail/template_1/img/close.png";
        $titulo = "Comprovante recusado !";
        $email = $adm->email;
        $nome = $adm->nome;
    } else if ($fila_lock->tipo == "vencimento_lembrete") {
        echo "vencimento_lembrete: <br>";
        $img = "https://gestormaster.top/template_mail/template_1/img/Generic-calendar-page-icon.png";
        $titulo = "Lembrete de pagamento";
        $email = $cliente->email;
        $nome = explode(' ', $cliente->nome)[0];
    } else if ($fila_lock->tipo == "novo_user_dono") {
        echo "novo_user_dono: <br>";
        $img = "https://gestormaster.top/template_mail/template_1/img/check-icone-scaled.png";
        $titulo = "Novo cliente se cadastrou no site !";
        $email = $adm->email;
        $nome = $adm->nome;
    } else if ($fila_lock->tipo == "comprovante_aceito_cli") {
        echo "comprovante_aceito_cli: <br>";
        $img = "https://gestormaster.top/template_mail/template_1/img/check-icone-scaled.png";
        $titulo = "Seu Comprovante foi aceito !";
        $email = $cliente->email;
        $nome = explode(' ', $cliente->nome)[0];
    } else if ($fila_lock->tipo == "comprovante_recusado_cli") {
        echo "comprovante_recusado_cli: <br>";
        $img = "https://gestormaster.top/template_mail/template_1/img/close.png";
        $titulo = "Seu Comprovante foi recusado !";
        $email = $cliente->email;
        $nome = explode(' ', $cliente->nome)[0];
    } else if ($fila_lock->tipo == "comprovante_recebido") {
        echo "comprovante_recebido: <br>";
        $img = "https://gestormaster.top/template_mail/template_1/img/boletonovo.png";
        $titulo = "Um cliente enviou um comprovante";
        $email = $adm->email;
        $nome = $adm->nome;
    } else if ($fila_lock->tipo == "pagamento_aprovado") {
        echo "pagamento_aprovado: <br>";
        $img = "https://gestormaster.top/template_mail/template_1/img/check-icone-scaled.png";
        $titulo = "Pagamento Recebido !";
        $email = $adm->email;
        $nome = $adm->nome;
    } else if ($fila_lock->tipo == "send_delivery") {
        echo "send_delivery: <br>";
        $img = "https://gestormaster.top/template_mail/template_1/img/check-icone-scaled.png";
        $titulo = "Seu pagamento foi confirmado !";
        $email = $cliente->email;
        $nome = explode(' ', $cliente->nome)[0];
    }


    if ($fila_lock->id_cliente != '0000') {

        $listaNegra = $clientes_class->dados_lista_negra($cliente->id);

        $link_cancel = "<p style=\"text-align:center;color:#fff;\" >Deseja não receber mais estes emails ? <br />Clique neste link: <br /><a href='https://gestormaster.top/gmaster/l/{$cliente->id}/n/{$cliente->email}' >https://gestormaster.top/gmaster/l/{$cliente->id}/n/{$cliente->email}</a></p>";
    } else {
        $link_cancel = "";
    }




    $body = str_replace('{cancel_insc}', $link_cancel, str_replace(date('d/m/Y'), "Hoje", str_replace("{imagem}", $img, str_replace("{titulo}", "Olá {$nome} !", str_replace("{texto}", $texto, $html)))));

    $obj = new stdClass();
    $obj->nome = $titulo;
    $obj->corpo = $body;

    $to = $email;
    $subject = $titulo;
    $from = 'contact@gestormaster';

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    $headers .= "From: Gestor Master <{$from}> \r\n" .
        'Reply-To: ' . $from . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

        
        if ($cliente) {
            
            if ($listaNegra) {
                if ($listaNegra->email != 'n') {
                    
                } else {
                    if (filter_var($to, FILTER_VALIDATE_EMAIL)) {
                        mail($to, $subject, $obj->corpo, $headers);
                    }
                }
            } else {
                if (filter_var($to, FILTER_VALIDATE_EMAIL)) {
                    mail($to, $subject, $obj->corpo, $headers);
                }
                
            }

    } else {

        if (filter_var($to, FILTER_VALIDATE_EMAIL)) {
            mail($to, $subject, $obj->corpo, $headers);
        }
        
    }
    
    if (strlen($fila_lock->destino) > 10) {
        
        if ($fila_lock->id_cliente != '0000') {
            
            if ($adm->id_plano != 7 && $adm->id_plano != 6) {
                $fila_lock->msg .= "\n\n\n Se deseja não receber mais mensagens como esta, clique no link abaixo.\n https://gestormaster.top/gmaster/l/{$fila_lock->id_cliente}/{$fila_lock->destino}/n";
            }
            
            if ($cliente->recebe_zap == 1) {
                echo "cliente->recebe_zap <br>";
                
                
                if ($listaNegra) {
                    echo "<br>tá na listaNegra <br>";
                    if ($listaNegra->whatsapp != 'n') {
                        
                    } else {
                        if (is_file('sends_api/send_' . $fila_lock->api . '.php')) {
                            require_once 'sends_api/send_' . $fila_lock->api . '.php';
                        }
                    }
                } else {
                    // echo "NÃO tá na listaNegra <br>";
                    echo "fila_lock->api = {$fila_lock->api} <br>";
                    if (is_file('sends_api/send_' . $fila_lock->api . '.php')) {
                        // echo "entrou no if do is_file <br>";
                        require_once 'sends_api/send_' . $fila_lock->api . '.php';
                    }else{
                        echo "NÃO entrou no if do is_file. ARRUMAR <br>";
                    }
                }
            }
        } else {
            if (is_file('sends_api/send_' . $fila_lock->api . '.php')) {
                require_once 'sends_api/send_' . $fila_lock->api . '.php';
            }
        }
    }
} else {
    echo '1';
}

?>