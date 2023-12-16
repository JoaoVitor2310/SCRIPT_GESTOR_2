<?php

header('Access-Control-Allow-Origin: *');
date_default_timezone_set('America/Sao_Paulo');


if (isset($_REQUEST['key'])) {
    
    require_once '../p/autoload.php';
    
    $json = json_decode(file_get_contents('php://input'));
    
    
    if (isset($json->senderMessage)) {
        $key = $_REQUEST['key'];
        $msg = $json->senderMessage;

        
        
        $properties = get_object_vars($json);
        // Converte as chaves do array em uma string separada por vírgulas
        $num = implode(',', array_keys($properties));
        
        // $headers = getallheaders();
        // $headersAsString = '';
        // foreach ($headers as $name => $value) {
        //     $headersAsString .= "$name: $value\n";
        // }
        // $num = $headersAsString;
        

        // receiveMessageAppId = com.whatsapp
        // receiveMessagePattern m: Array
                                        // (
                                        //     [0] => *
                                        // )
        // senderName Jay Novo (nome que o meu contato está salvo)
        // groupName VAZIO
        // senderMesage emailzin(mensagem enviada)
        // senderMessage
        // messageDateTime 1702405789000
        // isMessageFromGroup


        // $num = print_r($json->isMessageFromGroup, true);

         $num = str_replace(' ','',str_replace(')','',str_replace('(','',str_replace('-','',str_replace('+','',$json->senderName)))));
        //  $num = '1 aqui define o número';
        //jay11


        // buscar o número do id do usuário e buscar o telefone
        // $id = $_SESSION['SESSION_USER']['id'];
        // $num = $id; // tem que ser 3839
        //jay11
        $reply = new ChatBot();

        $res = $reply->getReply($key, $msg, $num);

        if ($res) {
            echo '{"data":[{"message":"' . $res . '"}]}';
        } else {
            $reply->removeSession($num);
        }
    } else if (isset($json->appPackageName)) {

        $key = $_REQUEST['key'];
        $msg = $json->query->message;
        // $num = str_replace(' ','',str_replace(')','',str_replace('(','',str_replace('-','',str_replace('+','',$json->query->sender)))));
        $num = '2 aqui define o número';

        $reply = new ChatBot();

        $res = $reply->getReply($key, $msg, $num);

        if ($res) {
            echo '{"replies":[{"message":"' . str_replace('<br />', '\n', nl2br($res)) . '"}]}';
        } else {
            $reply->removeSession($num);
        }

    } else {

        $json1 = file_get_contents('php://input');
        parse_str($json1, $output);

        if (isset($output['sender'])) {

            $key = $_REQUEST['key'];
            $msg = $output['message'];
            //  $num = str_replace(' ','',str_replace(')','',str_replace('(','',str_replace('-','',str_replace('+','',$output['sender'])))));
            $num = '3 aqui define o número ';

            $reply = new ChatBot();

            $res = $reply->getReply($key, $msg, $num);

            if ($res) {
                echo '{"reply":"' . $res . '"}';
            } else {
                $reply->removeSession($num);
            }


        }



    }

}