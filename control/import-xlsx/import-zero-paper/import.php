<?php

if ( $xlsx = SimpleXLSX::parse($_FILES['file_import']['tmp_name'])) {
    
    $i =0;
    
    foreach($xlsx->rows() as $key => $value){
        // var_dump($value);
        
        if($i>0){
            
            $tipo_lancamento = $value[0];
            $data_lancamento = $value[1];
            $descricao       = $value[2];
            $valor           = $financeiro->convertMoney(2,$value[3]);
            $categoria       = $value[4];
            $cliente_nome    = $value[5];
            $pago            = $value[6];
            $detalhes        = $value[7];
            $conta           = $value[8];
            
            $descricao_final = $descricao." | ".$categoria." | ".$cliente_nome." | ".$detalhes;
            
            
            $dados = new stdClass();
            $dados->id_user = $id_user;
            
            if($pago == 1){
                $dados->tipo = 1;
            }else{
                $dados->tipo = 2;
            }
            
            $data1 = explode(' ',$data_lancamento);
            $data2 = explode('-',$data1[0]);
            $hora1 = explode(':',$data1[1]);
            
            $dados->data = $data2[2].'/'.$data2[1].'/'.$data2[0];
            $dados->hora = $hora1[0].':'.$hora1[1];
            $dados->valor = $valor;
            $dados->nota = $descricao_final;
            
            if($dados->tipo == 1){
            // var_dump($dados);
            $financeiro->insert($dados);
           }            
        }
        
        $i++;
    }

    echo '<script>location.href="https://gestormaster.top/painel/financeiro";</script>';
    // unlink('../tmp/file.xlsx');

} else {
	echo SimpleXLSX::parseError();
}