<?php 

                echo "/sends_api/send_gestorbot<br>";
                echo "DESCOBRIR COMO FUNCIONA PRA CADASTRAR QUEM ENVIA A MENSAGEM E ARRUMAR UM JEITO DE CADASTRAR O ADMIN<br>";               
if($fila_lock->id_user != '0'){
                   
                 
                    $device = $fila_lock->device_id;
                    $num = $fila_lock->destino;
                    $msg = urlencode($fila_lock->msg);
                    
                    $url = "http://api-zapi.gestormaster.top:3000/send?device=2f8cbc1b5b92ce32b422&num={$num}&msg={$msg}";
                    echo "url: {$url}, essa URL é o que? <br>";
                    $ch=curl_init();
                    $timeout=1;
                    
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                    
                   $result= curl_exec($ch);
                    curl_close($ch);
                    
                    $my_result_object = json_decode($result);
                    
                    if($my_result_object){
                           if($fila_lock->id_user != '0'){
                             $whatsapi_class->insert_disparo($fila_lock->id_user,$num,$fila_lock->msg);
                           }
                    }
                    
                    
               
                }else{
                    
                    $my_apikey = $fila_lock->device_id;
                    $destination = $fila_lock->destino;
                    $message = $fila_lock->msg;
                    
                    $url = "http://api-zapi.gestormaster.top:3000/send?device=2f8cbc1b5b92ce32b422&num={$num}&msg={$msg}";

                	$ch=curl_init();
                    $timeout=1;
                    
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                    
                    $result= curl_exec($ch);
                    curl_close($ch);
                    
                    $my_result_object = json_decode($result);
                    
                                       
                    if( $my_result_object->error == false ){
                           if($fila_lock->id_user != '0'){
                             $whatsapi_class->insert_disparo($fila_lock->id_user,$num,$fila_lock->msg);
                           }
                    }
                   
                }
            
          
                    

?>