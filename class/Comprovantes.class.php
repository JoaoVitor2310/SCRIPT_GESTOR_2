<?php


/**
 *
 */
class Comprovantes extends Conn
{


    function __construct()
    {
        $this->conn = new Conn;
        $this->pdo = $this->conn->pdo();
    }


    public function remove_comp($fat)
    {
        if ($this->pdo->query("DELETE FROM `comprovantes_fat` WHERE id_fat='" . $fat . "' ")) {
            $this->pdo->query("UPDATE `faturas_user` SET comprovante='0' WHERE id='" . $fat . "' ");
            return true;
        } else {
            return false;
        }
    }



    public function rejeita_comp($fat, $user, $user_class, $faturas_class, $whatsapi_class, $mp_class, $gestor_class, $revenda_class)
    {

        // buscar dados user
        $user = $user_class->dados($user);

        if ($user) {

            // buscar fatura
            $fatura = $faturas_class->dados($fat);

            if ($fatura) {

                // remover comprovante em aberto
                $this->pdo->query("DELETE FROM `comprovantes_fat` WHERE id_fat='" . $fatura->id . "' ");

                // atualiza fatura
                $this->pdo->query("UPDATE `faturas_user` SET status='Rejeitado', forma='TED', comprovante='0' WHERE id='" . $fatura->id . "' ");

                // deletar comprovante
                if (is_file('../comprovantes/' . $fatura->comprovante)) {
                    unlink('../comprovantes/' . $fatura->comprovante);
                }

                // remover qrcode link comprovante
                if (is_file('../qrcodes/imgs/' . $fatura->id . '.png')) {
                    unlink('../qrcodes/imgs/' . $fatura->id . '.png');
                }

                $ar1 = array('{nome}');
                $ar2 = array($user->nome);
                $text = str_replace($ar1, $ar2, "Olá {nome}. \n\nSeu comprovante foi recusado. \n\n Seu comprovante para a fatura de R${$fatura->valor} foi recusado :(  \n\n\n Sentimos muito por isso. \n\n\n Se você acha que isso não deveria ter acontecido, entre em contato conosco. ");

                $ar1 = array('+', ')', '(', ' ', '-');
                $ar2 = array('', '', '', '', '');
                $phone = $user->ddi . str_replace($ar1, $ar2, $user->telefone);

                $whatsapi_class->fila($phone, $text, $user->id, 'ZAPI', 'ZAPI', '0000', '0000', "comprovante_recusado", 1);

                return true;

            } else {
                return false;
            }


        } else {
            return false;
        }
    }

    public function aprova_comp($fat, $user, $user_class, $faturas_class, $whatsapi_class, $mp_class, $gestor_class, $revenda_class)
    {
        // buscar dados user
        $user = $user_class->dados($user);
        // echo 'aprova_comp';
        // $moeda = 'BRL';


        if ($user) {

            // buscar fatura
            $fatura = $faturas_class->dados($fat);
            // echo json_encode($fatura);
            // var_dump($fatura);

            if ($fatura) {

                $msgAleatoria[0] = "Obrigado!";
                // $msgAleatoria[1] = "Tamo Junto 💪 !";
                // $msgAleatoria[2] = "Fica em paz... 🖖";
                // $msgAleatoria[3] = "Muito obrigado 💖 ";
                // $msgAleatoria[4] = "Caramba agora tu vai arrebenta 😎 ";
                // $msgAleatoria[5] = "É assim que se faz ! pode contar comigo pra oque precisar... 👊";
                // $msgAleatoria[6] = "Abraços e beijinhos 🤭";

                $msgAleatoria1[0] = "Olá {nome}.";
                // $msgAleatoria1[1] = "{nome} Como vai?";
                // $msgAleatoria1[2] = "Eae {nome}!";
                // $msgAleatoria1[3] = "Falaaaa {nome}!!!";
                // $msgAleatoria1[4] = "Olá {nome} ";
                // $msgAleatoria1[5] = "{nome} Novidade no ar";



                if ($fatura->tipo == 'creditos') { // N tá entrando aqui
                    // return true;
                    
                    // remover comprovante em aberto
                    $this->pdo->query("DELETE FROM `comprovantes_fat` WHERE id_fat='" . $fatura->id . "' ");
                    
                    $nota = "
                    Compra de créditos revenda.
                    Valor Real: R$ {$fatura->valor}
                        Cliente: {$user->nome}
                        ";
                        $valor_fat = $fatura->valor;
                        $data = date('d/m/Y');
                        
                        $this->pdo->query("INSERT INTO `financeiro_gestor` (tipo, valor, data, nota) VALUES ('1','$valor_fat','$data','$nota')");
                        
                        // atualiza fatura
                        $this->pdo->query("UPDATE `faturas_user` SET status='Aprovado', forma='TED', comprovante='0' WHERE id='" . $fatura->id . "' ");
                        
                        // deletar comprovante
                        if (is_file('../comprovantes/' . $fatura->comprovante)) {
                            unlink('../comprovantes/' . $fatura->comprovante);
                        }

                        // remover qrcode link comprovante
                        if (is_file('../qrcodes/imgs/' . $fatura->id . '.png')) {
                            unlink('../qrcodes/imgs/' . $fatura->id . '.png');
                    }
                    
                    $creditos = $fatura->id_plano;
                    $add = $mp_class->creditos_rev_change($fatura->id_user, $creditos, true);
                    
                    $ar1 = array('{nome}');
                    $ar2 = array($user->nome);
                    $text = str_replace($ar1, $ar2, $msgAleatoria1[0] . "Olá {nome}. Seu comprovante foi aceito. \n\nSeu comprovante para a fatura de R$ {$fatura->valor} foi aceito! E nós ja adicionamos {$creditos} créditos em seu painel 🤑!. \n\nObrigado!" . $msgAleatoria[0]);
                    
                    $ar1 = array('+', ')', '(', ' ', '-');
                    $ar2 = array('', '', '', '', '');
                    $phone = $user->ddi . str_replace($ar1, $ar2, $user->telefone);
                    
                    $whatsapi_class->fila($phone, $text, $user->id, 'ZAPI', 'ZAPI', '0000', '0000', "comprovante_aceito", 1);
                    
                    
                    return true;
                    
                } else { // Não é do tipo créditos
                    
                    
                    // buscar plano do da fatura
                    $plano = $gestor_class->plano($fatura->id_plano);
                    
                    if ($plano) {
                        
                        
                        // $num_fats = $faturas_class->num_fats($user);
                        
                        // if ($num_fats <= 2) {
                            
                            //     $indicado = $user->indicado;
                            
                            //     if ($indicado != 0) {
                                
                                //         $val = 2;
                                //         $add_saldo = $revenda_class->change_saldo($indicado, false, $val);
                                
                                //     }
                                
                                // }
                                
                        // calcular novo vencimento 
                        $dataUser = str_replace('/', '-', $user->vencimento);
                        $explodeData_user = explode('/', $user->vencimento);
                        $explodeData2_user = explode('/', date('d/m/Y'));
                        $dataVen_user = $explodeData_user[2] . $explodeData_user[1] . $explodeData_user[0];
                        $dataHoje_user = $explodeData2_user[2] . $explodeData2_user[1] . $explodeData2_user[0];

                        if ($dataVen_user == $dataHoje_user) {

                            $timestamp = strtotime('+1 months', strtotime($dataUser));

                        } else if ($dataHoje_user > $dataVen_user) {

                            $timestamp = strtotime('+1 months', strtotime(date('d-m-Y')));

                        } else {

                            $timestamp = strtotime('+1 months', strtotime($dataUser));

                        }

                        $novoVencimento = date('d/m/Y', $timestamp);


                        $query__ = $this->pdo->query("UPDATE `user` SET id_plano='" . $plano->id . "', vencimento='" . $novoVencimento . "' WHERE id='" . $user->id . "' ");

                        if ($query__) {

                            $nota = "
                                    Compra plano {$plano->nome}.
                                    Valor Real: R$ {$fatura->valor}
                                    Cliente: {$user->nome}
                                    ";
                            $valor_fat = $fatura->valor;
                            $data = date('d/m/Y');

                            $this->pdo->query("INSERT INTO `financeiro_gestor` (tipo, valor, data, nota) VALUES ('1','$valor_fat','$data','$nota')");

                            // remover comprovante em aberto
                            $this->pdo->query("DELETE FROM `comprovantes_fat` WHERE id_fat='" . $fatura->id . "' ");

                            // atualiza fatura
                            $this->pdo->query("UPDATE `faturas_user` SET status='Aprovado', forma='TED', comprovante='0' WHERE id='" . $fatura->id . "' ");

                            // deletar comprovante
                            if (is_file('../comprovantes/' . $fatura->comprovante)) {
                                unlink('../comprovantes/' . $fatura->comprovante);
                            }

                            // remover qrcode link comprovante
                            if (is_file('../qrcodes/imgs/' . $fatura->id . '.png')) {
                                unlink('../qrcodes/imgs/' . $fatura->id . '.png');
                            }



                            $ar1 = array('{nome}');
                            $ar2 = array($user->nome);
                            $text = str_replace($ar1, $ar2, $msgAleatoria1[0] . " \n\nSeu comprovante foi aceito. \n\nSeu comprovante para a fatura de R$ {$fatura->valor} foi aceito! \n\n\nO vencimento do seu painel agora é {$novoVencimento}. \n\n\n" . $msgAleatoria[0]);

                            $ar1 = array('+', ')', '(', ' ', '-');
                            $ar2 = array('', '', '', '', '');
                            $phone = $user->ddi . str_replace($ar1, $ar2, $user->telefone);

                            $whatsapi_class->fila($phone, $text, $user->id, 'ZAPI', 'ZAPI', '0000', '0000', "comprovante_aceito", 1);


                            return true;

                        }


                    } else {
                        return false;
                    }

                }

            } else {
                return false;
            }

        } else {
            return false;
        }


    }


    public function count_comp($idfat = false)
    {

        if ($idfat) {

            $query = $this->pdo->query("SELECT * FROM `comprovantes_fat` WHERE id_fat='$idfat' ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);

            return count($fetch);
        } else {
            $query = $this->pdo->query("SELECT * FROM `comprovantes_fat`  ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);

            return count($fetch);
        }


    }

    public function list_comp()
    {

        $query = $this->pdo->query("SELECT * FROM `comprovantes_fat`");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if (count($fetch) > 0) {
            $query = $this->pdo->query("SELECT * FROM `comprovantes_fat`");
            return $query;
        }


    }


    public function uploadComp($files, $post, $path, $user, $whatsapi_class)
    {

        //Diretorio aonde será armazenado o comprovamte
        $pathToSave = $path;
        if (!file_exists($pathToSave)) {
            mkdir($pathToSave);
        }

        if ($files && isset($post['meio_pay_idFat'])) {


            if ($user != false) {
                $comp_sended = self::count_comp($post['meio_pay_idFat']);

                if ($comp_sended) {
                    if ($comp_sended > 0) {
                        return "Você ja enviou um comprovante para esta fatura.";
                    }
                }
            }


            $msg = false;

            $dir = $pathToSave;
            $tmpName = $files['comprovante']['tmp_name'];
            $name1 = $files['comprovante']['name'];
            $idFat = $post['meio_pay_idFat'];

            preg_match_all('/\.[a-zA-Z0-9]+/', $name1, $extensao);
            $name = rand(10000, 999999) . '_' . $idFat . strtolower(current(end($extensao)));

            if (!in_array(strtolower(current(end($extensao))), array('.jpg', '.jpeg', '.pdf', '.png', '.txt'))) {
                $msg = "Somente é permitido arquivos com o formato <b>.PDF</b>, <b>.JPG</b>, <b>.JPEG</b>, <b>.PNG</b> e <b>.TXT</b>";
                return $msg;
            }

            if (move_uploaded_file($tmpName, $dir . $name)) {


                if ($user == false) {

                    $cliente_id = $post['cliente_id'];
                    $id_user = $post['id_user'];
                    $id_plano = $post['id_plano'];
                    $valor = $post['valor_fat'];


                    if ($this->pdo->query("INSERT INTO `comprovantes_fat_cli` (id_fat,id_cliente,id_user,file,id_plano,valor) VALUES ('$idFat','$cliente_id','$id_user','$name','$id_plano','$valor') ")) {


                        $msg = "Comprovante enviado. Os comprovantes são aprovados dentro de 24Hr";
                        return $msg . '|' . $name;
                    }
                } else {

                    if ($this->pdo->query("UPDATE `faturas_user` SET forma='TED', comprovante='$name' WHERE id='$idFat' ")) {

                        $this->pdo->query("INSERT INTO `comprovantes_fat` (id_fat) VALUES ('$idFat') ");

                        $ar1 = array('{nome}');
                        $ar2 = array($user->nome);
                        $text = str_replace($ar1, $ar2, "Olá {nome}. Nós recebemos seu comprovante, comprovantes são aprovados dentro de 24 horas úteis. \n Assim que for aprovado você será notificado.");

                        $ar1 = array('+', ')', '(', ' ', '-');
                        $ar2 = array('', '', '', '', '');
                        $phone = $user->ddi . str_replace($ar1, $ar2, $user->telefone);

                        $whatsapi_class->fila($phone, $text, $user->id, '0000', '0000', '0000', '0000', "comprovante_enviado_user", 1);

                        $whatsapi_class->fila('5545998339113', 'Olá. Um cliente enviou um comprovante para a fatura numero ' . $idFat . '', '156', '0000', '0000', '0000', '0000', "comprovante_enviado_adm", 1);


                        $msg = "Comprovante enviado. Os comprovantes são aprovados dentro de 24Hr";
                        return $msg;

                    } else {
                        $msg = "Desculpe, ocorreu um erro. Entre em contato com o suporte.";
                        return $msg;
                    }

                }

            } else {
                $msg = "Desculpe, ocorreu um erro. Entre em contato com o suporte.";
                return $msg;
            }

        }


    }


}





?>