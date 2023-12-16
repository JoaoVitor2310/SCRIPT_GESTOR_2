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

                    $limitCli = $user->limit_plano($_SESSION['GESTOR']['plano']);
                    $dadosUser->limit_plano = $limitCli;

                    $dadosUser->id_user = $_SESSION['SESSION_USER']['id'];
                    
                    $dadosUser->nome = $value[0];
                    
                    $dadosUser->email = $value[1];
                    
                    $dadosUser->telefone = $value[2];
                    
                    $dadosUser->vencimento = $value[3];
                    
                    $dadosUser->id_plano = $value[4];
                    
                    $dadosUser->notas = $value[5];
                    
                    $dadosUser->senha = $value[6];
                    
                    $dadosUser->recebe_zap = $value[2] == "" ? 0 : 1;
                    
                    $explode = explode('/', $dadosUser->vencimento);
                    $totime = $explode[2] . $explode[1] . $explode[0];
                    $dadosUser->totime = $totime;

                    $inser = $clientes->insert($dadosUser);

                }

                $i++;
            }


            echo '<script>alert("Clientes adicionados com sucesso!");script>';
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