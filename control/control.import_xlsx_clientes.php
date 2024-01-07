<?php

@session_start();

if (isset($_SESSION['SESSION_USER'])) {


    $id_user = $_SESSION['SESSION_USER']['id'];
    if (isset($_FILES['file_import']['tmp_name'])) {
        require_once 'import-xlsx/src/SimpleXLSX.php';
        require_once '../class/Conn.class.php';

        require_once '../class/User.class.php';
        require_once '../class/Clientes.class.php';
        $user = new User();
        $clientes = new Clientes();

        if ($xlsx = SimpleXLSX::parse($_FILES['file_import']['tmp_name'])) {
            $i = 0;

            foreach ($xlsx->rows() as $key => $value) {

                if ($i > 0) {

                    $dadosUser = new stdClass();

                    // $limitCli
                    $limitCli = $user->limit_plano($_SESSION['GESTOR']['plano']);
                    $dadosUser->limit_plano = $limitCli;

                    // id_user
                    $dadosUser->id_user = $_SESSION['SESSION_USER']['id'];
                    
                    // nome
                    $dadosUser->nome = $value[0];
                    
                    // email
                    $dadosUser->email = $value[1];
                    
                    // telefone
                    $dadosUser->telefone = $value[2];
                    
                    // Vencimento
                    $formatoEsperado = 'd/m/Y';
                    $data = DateTime::createFromFormat($formatoEsperado, $value[3]);
                
                    if ($data !== false && $data->format($formatoEsperado) === $value[3]) {
                        // A data foi analisada corretamente e tem o formato desejado
                        $dadosUser->vencimento = $value[3];
                    } else {
                        // A data não tem o formato esperado
                        echo '<script>alert("O formato de data de vencimento não está correto, use o formato dd/mm/yyyy.");</script>';
                        echo '<script>location.href="https://gestormaster.top/painel/home";</script>';
                        return;
                    }

                    // id_plano
                    $dadosUser->id_plano = $value[4];
                    
                    // notas
                    $dadosUser->notas = $value[5];
                    
                    // senha
                    $dadosUser->senha = $value[6];
                    
                    // recebe_zap
                    $dadosUser->recebe_zap = $value[2] == "" ? 0 : 1;
                    
                    // $totime
                    $explode = explode('/', $dadosUser->vencimento);
                    $totime = $explode[2] . $explode[1] . $explode[0];
                    $dadosUser->totime = $totime;

                    $inser = $clientes->insert($dadosUser);

                }

                $i++;
            }


            echo '<script>alert("Clientes adicionados com sucesso!");</script>';
            echo '<script>location.href="https://gestormaster.top/painel/home";</script>';
            unlink('../tmp/file.xlsx');

        } else {
            echo 'Erro ao ler o arquivo.';
            echo SimpleXLSX::parseError();
        }

    } else {
        echo 'Arquivo não enviado.';
    }


}

echo '<script>location.href="https://gestormaster.top/painel/home";</script>';


?>