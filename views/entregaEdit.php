<?php

// limpa o cache

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// chama os arquivos necessários

require_once '../config/app.php';
require_once '../models/Database.php';
require_once '../models/Entrega.php';
require_once '../models/Escola.php';


// controle de sessão

if (is_session_started() === TRUE) {
    if (empty($_SESSION['key'])) {
        header('location: ./');
    }
}

// abre a conexão com o banco

$database = new Database();
$db = $database->getConnection();

// inicializa uma instância da classe

$entrega = new Entrega($db);
$escola = new Escola($db);

// Variáveis de controle

$escola->monitor = true;
$entrega->identrega = $_GET['' . $cfg['id']['entrega'] . ''];

// executa a consulta e retorna

if ($sql = $entrega->readSingle()) {
    if ($sql->rowCount() > 0) {
        $row = $sql->fetch(PDO::FETCH_OBJ);
        
        //extract($row);

        // format date and time

        $ano = substr($row->created_at, 0, 4);
        $mes = substr($row->created_at, 5, 2);
        $dia = substr($row->created_at, 8, 2);
        $hora = substr($row->created_at, 11, 8);
        $row->created_at = $dia . '/' . $mes . '/' . $ano . ' &#45; ' . $hora . 'h';
?>

        <form class="form-edit-entrega">
            <div class="modal-header">
                <h4 class="modal-title">
                    <span>Editar os dados da Entrega</span>
                </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="rand" id="rand_delivery_edit" value="<?= md5(mt_rand()); ?>">
                <input type="hidden" name="identrega" id="identrega_edit" value="<?= $row->identrega; ?>">
                
                <div class="row form-group g-3 align-items-center">
                    <div class="col-3">
                        <label class="text" for="conta">Data e Hora:</label>
                    </div>
                    <div class="col-9">
                        <code><?= $row->created_at; ?></code>
                    </div>
                </div>
                
                <hr>

                <div class="row form-group g-3 align-items-center">
                    <div class="col-3">
                        <label class="text text-danger" for="escola">Escola</label>
                    </div>
                    <div class="col-9">
                        <select name="escola" id="escola_edit" class="selectpicker show-tick form-control" title="Selecione a escola" placeholder="Escola" data-live-search="true" data-width="" data-size="7" required>
                        <?php
                            $escola->monitor = true;
                            $sql2 = $escola->readAll();

                            if ($sql2->rowCount() > 0) {
                                while($row2 = $sql2->fetch(PDO::FETCH_OBJ)) {
                                    if ($row->idescola == $row2->idescola) {
                                        echo '<option title="'.$row2->nome.'" data-subtext="'.$row2->cep.', '.$row2->numero.', '.$row2->bairro.', '.$row2->cidade.', '.$row2->uf.'" value="'.$row2->idescola.'" selected>'.$row2->nome.'</option>';
                                    } else {
                                        echo '<option title="'.$row2->nome.'" data-subtext="'.$row2->cep.', '.$row2->numero.', '.$row2->bairro.', '.$row2->cidade.', '.$row2->uf.'" value="'.$row2->idescola.'">'.$row2->nome.'</option>';
                                    }
                                }
                            } else {
                                echo '<option value="" selected>Nenhuma escola cadastrada</option>';
                            }
                        ?>
                        </select>
                    </div>
                </div>

                <div class="row form-group g-3 align-items-center">
                    <div class="col-3">
                        <label class="text text-danger" for="pessoa">Pessoa</label>
                    </div>
                    <div class="col-9">
                        <select name="pessoa" id="pessoa_edit" class="selectpicker show-tick form-control" title="Selecione a pessoa" placeholder="Pessoa" data-live-search="true" data-width="" data-size="7" required>
                            <!--<option value="" selected>Selecione a pessoa</option>-->
                        </select>
                    </div>
                </div>

                <div class="row form-group g-3 align-items-center">
                    <div class="col-3">
                        <label class="text text-danger" for="quantidade">Quantidade</label>
                    </div>
                    <div class="col-6">
                        <input type="number" name="quantidade" id="quantidade_edit" value="<?= $row->quantidade; ?>" minlength="1" maxlength="2" class="form-control" title="Informe a quantidade de pacotes de absorvente que ser&aacute; entregue" placeholder="Quantidade de pacotes" required>
                    </div>
                    <div class="col-3">
                        <a href="#" title="Informe a quantidade de pacotes de absorvente que ser&aacute; entregue">
                            <i class="fa fa-info"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary btn-edit-entrega">Salvar</button>
            </div>
        </form>

        <script>
            $(document).ready(function () {
                const fade = 150,
                    delay = 100,
                    Toast = Swal.mixin(
                        { toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 }
                    );

                // SELECTPICKER (precisa ser invocado aqui para surtir efeito em arquivo que utiliza modal)

                $('.selectpicker').selectpicker({
                    'showTick': true,
                    'liveSearch': true,
                    'size': 7
                });

                // AUTO CARREGA O SELECTBOX DE PESSOAS BASEADO NA ESCOLA DA ESCOLA

                $('#escola_edit').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                    //$('#pessoa').find('option').not(':first').remove();

                    $.ajax({
                        type: 'POST',
                        url: 'loadPessoa',
                        dataType: 'JSON',
                        data: {'<?= $cfg['id']['escola']; ?>': $('#escola_edit').val()},
                        cache: false,
                        beforeSend: rs => {
                            $('.div-load-page').removeClass('d-none').html('<p class="p-cog-spin lead text-center"><i class="fas fa-cog fa-spin"></i></p>');
                        },
                        error: rs => {
                            //
                        },
                        success: rs => {
                            if (rs) {
                                if (rs[0].status == true) {
                                    for (let i in rs) {
                                        //$('#pessoa_edit').append('<option title="' + rs[i]['nome'] + '" data-subtext="Matr&iacute;cula: ' + rs[i]['matricula'] + ' | ' + rs[i]['cep'] + ', ' + rs[i]['bairro'] + ', ' + rs[i]['cidade'] + ', ' + rs[i]['uf'] + ' | ' + rs[i]['celular'] + '"  value="' + rs[i]['idpessoa'] + '">' + rs[i]['nome'] + '</option>');
                                        $('#pessoa_edit').html('<option title="' + rs[i]['nome'] + '" data-subtext="Matr&iacute;cula: ' + rs[i]['matricula'] + ' | ' + rs[i]['cep'] + ', ' + rs[i]['bairro'] + ', ' + rs[i]['cidade'] + ', ' + rs[i]['uf'] + ' | ' + rs[i]['celular'] + '"  value="' + rs[i]['idpessoa'] + '">' + rs[i]['nome'] + '</option>');
                                    }
                                } else {
                                    $('#pessoa_edit').html('<option value="" selected>Nenhuma pessoa encontrada</option>');
                                    
                                }
                            }
                        },
                        complete: rs => {
                            $('.div-load-page').addClass('d-none');
                            $('#pessoa_edit').selectpicker('refresh');
                        }
                    });
                });

                // EDITAR ENTREGA

                $('.form-edit-entrega').submit(function (e) {
                    e.preventDefault();

                    $.post('entregaUpdate', $(this).serialize(), function (data) {
                        $('.btn-edit-entrega').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                        switch (data) {
                            case 'true':
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Dados da entrega editados.'
                                }).then((result) => {
                                    window.setTimeout("location.href='entregas'", delay);
                                });
                                break;

                            default:
                                Toast.fire({
                                    icon: 'error',
                                    title: data
                                });
                                break;
                        }

                        $('.btn-edit-entrega').html('Salvar').fadeTo(fade, 1);
                    });

                    return false;
                });
            });
        </script>

<?php
    } else {
        echo
        '<blockquote class="quote-danger">
            <h5>' . $cfg['error']['title'] . '</h5>
            <p>' . $cfg['error']['msg'] . '</p>
        </blockquote>';
    }
} else {
    die(var_dump($db->errorInfo()));
}

unset($cfg, $database, $db, $escola, $entrega, $sql, $row, $sql2, $row2);