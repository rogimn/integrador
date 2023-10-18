<?php
// chama os arquivos necessários

require_once '../config/app.php';
require_once '../models/Database.php';
require_once '../models/Entrega.php';
require_once '../models/Escola.php';
require_once '../models/Nota.php';

// controle de sessão

if (is_session_started() === TRUE) {
    if (empty($_SESSION['key'])) {
        header('location: ./');
    }
}

// conecta no banco de dados

$database = new Database();
$db = $database->getConnection();

// inicializando os objetos

$escola = new Escola($db);

// carrega o componente que gerencia a barra da linha do tempo

include_once '../components/loadTimeLine.php';

//pré-definição de variáveis

$menu = 1;
$prefix = '../';
$timestamp = new DateTime();
?>

<!DOCTYPE html>
<html lang="<?= $cfg['lang']; ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=5">
        
        <title>
            <?= $cfg['header']['title'] . $cfg['header']['subtitle']['home']; ?>
        </title>

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="preload prefetch stylesheet" as="style" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="dist/img/favicon.png">
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" media="print" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" onload="this.media='all'">
        <!-- Font Awesome -->
        <link rel="stylesheet" media="print" href="plugins/fontawesome-free/css/all.min.css" onload="this.media='all'">
        <!-- DataTables -->
        <link rel="stylesheet" media="print" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" onload="this.media='all'">
        <link rel="stylesheet" media="print" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css" onload="this.media='all'">
        <!-- SweetAlert2 -->
        <link rel="stylesheet" media="print" href="plugins/sweetalert2/sweetalert2.min.css" onload="this.media='all'">
        <!-- DatePicker -->
        <link rel="stylesheet" media="print" href="plugins/datepicker/css/datepicker.min.css" onload="this.media='all'">
        <!-- Select Picker -->
        <link rel="stylesheet" media="print" href="plugins/bootstrap-select-1.13.14/css/bootstrap-select.min.css" onload="this.media='all'">
        <!-- Theme style -->
        <link rel="stylesheet" media="print" href="dist/css/adminlte.min.css" onload="this.media='all'">
        <!-- Custom -->
        <link rel="stylesheet" media="print" href="dist/css/custom.css" onload="this.media='all'">
    </head>

    <body class="hold-transition sidebar-mini sidebar-collapse text-sm">
        <!-- Site wrapper -->
        <div class="wrapper">

            <?php
            include_once ''.$prefix.'appNavBar.php';
            include_once ''.$prefix.'appSideBar.php';
            ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-1 mt-1">
                            <div class="col-3">
                                <h1><?= $cfg['header']['subtitle']['home']; ?></h1>
                            </div>

                            <div class="col-9">
                                <div class="text-right">
                                    <a href="#" class="btn btn-primary" title="Clique para cadastrar uma nova nota" data-toggle="modal" data-target="#modal-new-nota">
                                        <i class="fas fa-sticky-note"></i>&nbsp;Nova nota
                                    </a>
                                    <a href="#" class="btn btn-primary" title="Clique para registrar uma nova entrega" data-toggle="modal" data-target="#modal-new-entrega">
                                        <i class="fas fa-file-invoice"></i>&nbsp;Nova entrega
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="card card-note d-none">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-sticky-note"></i>&nbsp;Notas
                            </h3>

                            <div class="card-tools">
                                <!--<span title="3 New Messages" class="badge badge-primary">3</span>-->
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <dl class="dl-data"></dl>
                        </div>
                    </div>
                    <!-- /.card -->

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-file-invoice"></i>&nbsp;Entregas
                            </h3>

                            <div class="card-tools">
                                <!--<span title="3 New Messages" class="badge badge-primary">3</span>-->
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="div-time">
                                <div class="div-time-left text-center">
                                    <a
                                        class="lead"
                                        href="inicio?<?= $cfg['qsmd5']['mes']; ?>=<?= $mesleft; ?>&<?= $cfg['qsmd5']['ano']; ?>=<?= $ano; ?>&left=1"
                                        title="M&ecirc;s anterior"
                                        data-toggle="tooltip" data-original-title="M&ecirc;s anterior">
                                        <i class="fas fa-arrow-left"></i>
                                    </a>
                                </div>

                                <div class="div-time-center">
                                    <p class="lead text-center">
                                        <input
                                            type="text"
                                            class="col-12 date-pick text-center"
                                            value="<?= mes_extenso($mes); ?> de <?= $ano; ?>"
                                            readonly="readonly">
                                    </p>
                                </div>

                                <div class="div-time-right text-center">
                                    <a
                                        class="lead"
                                        href="inicio?<?= $cfg['qsmd5']['mes']; ?>=<?= $mesright; ?>&<?= $cfg['qsmd5']['ano']; ?>=<?= $ano; ?>&right=1"
                                        title="Pr&oacute;ximo m&ecirc;s"
                                        data-toggle="tooltip" data-original-title="Pr&oacute;ximo m&ecirc;s">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>

                            <table class="table table-bordered table-hover table-data">
                                <thead>
                                    <tr>
                                        <th>Escola</th>
                                        <th>Pessoa</th>
                                        <th>Matr&iacute;cula</th>
                                        <th>C&oacute;digo</th>
                                        <th>Qtde</th>
                                        <th>Data</th>
                                        <th style="max-width: 100px;width: 100px;"></th>
                                    </tr>
                                </thead>

                                <tbody></tbody>
                                
                                <tfoot>
                                    <tr>
                                        <th>Escola</th>
                                        <th>Pessoa</th>
                                        <th>Matr&iacute;cula</th>
                                        <th>C&oacute;digo</th>
                                        <th>Qtde</th>
                                        <th>Data</th>
                                        <th style="max-width: 100px;width: 100px;"></th>
                                    </tr>
                                </tfoot>
                            </table>

                            <blockquote class="quote-secondary blockquote-data">
                                <h5><?= $cfg['msg_empty_table']['title']; ?></h5>
                                <p>
                                    <span><?= $cfg['msg_empty_table']['msg']; ?></span>
                                    <a 
                                        href="#" 
                                        title="Clique para cadastrar uma nova entrega" 
                                        data-toggle="modal" 
                                        data-target="#modal-new-entrega">
                                        Nova entrega
                                    </a>
                                </p>
                            </blockquote>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Modals -->
            <div class="modal fade" id="modal-new-nota">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <form class="form-new-nota">
                            <div class="modal-header">
                                <h4 class="modal-title">
                                    <span>Nova nota</span>
                                </h4>

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <input type="hidden" name="rand" id="rand_note" value="<?= md5(mt_rand()); ?>">
                                <input type="hidden" name="idusuario" id="idusuario_note" value="<?= $_SESSION['id']; ?>">
                                <input type="hidden" name="codigo" id="codigo_note" value="<?= createCode(); ?>">
                                
                                <div class="form-group">
                                    <label for="texto" class="d-none">Texto</label>
                                    <textarea name="texto" id="texto" class="form-control" rows="5" title="Insira o conte&uacute;do da nota" placeholder="Texto"></textarea>
                                </div>
                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary btn-new-nota">Salvar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <div class="modal fade" id="modal-edit-nota">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content"></div>
                </div>
            </div>

            <div class="modal fade" id="modal-new-entrega">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-new-entrega">
                            <div class="modal-header">
                                <h4 class="modal-title">
                                    <span>Nova entrega</span>
                                </h4>

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <input type="hidden" name="rand" id="rand_delivery" value="<?= md5(mt_rand()); ?>">
                                <input type="hidden" name="idusuario" id="idusuario_delivery" value="<?= $_SESSION['id']; ?>">
                                <input type="hidden" name="codigo" id="codigo_delivery" value="<?= createCode(); ?>">
                                
                                <div class="row form-group g-3 align-items-center">
                                    <div class="col-3">
                                        <label class="text" for="conta">Data e Hora:</label>
                                    </div>
                                    <div class="col-9">
                                        <code><?= date('d/m/Y H:m:s') . 'h'; ?></code>
                                    </div>
                                </div>
                                
                                <hr>

                                <div class="row form-group g-3 align-items-center">
                                    <div class="col-3">
                                        <label class="text text-danger" for="escola">Escola</label>
                                    </div>
                                    <div class="col-9">
                                        <select name="escola" id="escola" class="selectpicker show-tick form-control" title="Selecione a escola" placeholder="Escola" data-live-search="true" data-width="" data-size="7" required>
                                        <?php
                                            $escola->monitor = true;
                                            $sql = $escola->readAll();

                                            if ($sql->rowCount() > 0) {
                                                echo '<option value="" selected>Selecione a escola</option>';

                                                while($row = $sql->fetch(PDO::FETCH_OBJ)) {
                                                    echo '<option title="'.$row->nome.'" data-subtext="'.$row->cep.', '.$row->numero.', '.$row->bairro.', '.$row->cidade.', '.$row->uf.'" value="'.$row->idescola.'">'.$row->nome.'</option>';
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
                                        <select name="pessoa" id="pessoa" class="selectpicker show-tick form-control" title="Selecione a pessoa" placeholder="Pessoa" data-live-search="true" data-width="" data-size="7" required>
                                            <!--<option value="" selected>Selecione a pessoa</option>-->
                                        </select>
                                    </div>
                                </div>

                                <div class="row form-group g-3 align-items-center">
                                    <div class="col-3">
                                        <label class="text text-danger" for="quantidade">Quantidade</label>
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="quantidade" id="quantidade" minlength="1" maxlength="2" class="form-control" title="Informe a quantidade de pacotes de absorvente que ser&aacute; entregue" placeholder="Quantidade de pacotes" required>
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
                                <button type="submit" class="btn btn-primary btn-new-entrega">Salvar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <div class="modal fade" id="modal-edit-entrega">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content"></div>
                </div>
            </div>
            <!-- /.Modals -->

            <?php
            include_once ''.$prefix.'appFootBar.php';
            ?>
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- DataTables -->
        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <!-- SweetAlert2 -->
        <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
        <!-- DatePicker -->
        <script src="plugins/datepicker/js/datepicker.min.js"></script>
        <!-- Select Picker -->
        <script src="plugins/bootstrap-select-1.13.14/js/bootstrap-select.min.js"></script>
        <!-- Input Mask -->
        <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.min.js"></script>
        <!-- Custom -->
        <script defer src="dist/js/custom.js"></script>
        <script>
            $(document).ready(function () {
                const fade = 150,
                    delay = 100,
                    timeout = 60000,
                    swalButton = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-danger',
                            cancelButton: 'btn btn-secondary'
                        },
                        buttonsStyling: true
                    }),
                    Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1000
                    });

                // DATEPICKER

                $('.date-pick').show(function () {
                    $('.date-pick').datepicker({
                        language: 'pt-BR',
                        format: "mm yyyy",
                        startView: 1,
                        minViewMode: 1
                    }).on('hide', function (e) {
                        let dt = e.target.value.split(' ');
                        location.href = "inicio?<?= $cfg['qsmd5']['mes']; ?>=" + dt[0] + "&<?= $cfg['qsmd5']['ano']; ?>=" + dt[1] + "&pick=1";
                    });
                });

                // AUTO CARREGA O SELECTBOX DE PESSOAS BASEADO NA ESCOLA DA ESCOLA

                $('#escola').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                    //$('#pessoa').find('option').not(':first').remove();

                    $.ajax({
                        type: 'POST',
                        url: 'loadPessoa',
                        dataType: 'JSON',
                        data: {'<?= $cfg['id']['escola']; ?>': $('#escola').val()},
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
                                        //$('#pessoa').append('<option title="' + rs[i]['nome'] + '" data-subtext="Matr&iacute;cula: ' + rs[i]['matricula'] + ' | ' + rs[i]['cep'] + ', ' + rs[i]['bairro'] + ', ' + rs[i]['cidade'] + ', ' + rs[i]['uf'] + ' | ' + rs[i]['celular'] + '"  value="' + rs[i]['idpessoa'] + '">' + rs[i]['nome'] + '</option>');
                                        $('#pessoa').html('<option title="' + rs[i]['nome'] + '" data-subtext="Matr&iacute;cula: ' + rs[i]['matricula'] + ' | ' + rs[i]['cep'] + ', ' + rs[i]['bairro'] + ', ' + rs[i]['cidade'] + ', ' + rs[i]['uf'] + ' | ' + rs[i]['celular'] + '"  value="' + rs[i]['idpessoa'] + '">' + rs[i]['nome'] + '</option>');
                                    }
                                } else {
                                    $('#pessoa').html('<option value="" selected>Nenhuma pessoa encontrada</option>');
                                    
                                }
                            }
                        },
                        complete: rs => {
                            $('.div-load-page').addClass('d-none');
                            $('#pessoa').selectpicker('refresh');
                        }
                    });
                });

                // ROTINA QUE REALIZA A BUSCA DE TODAS AS NOTAS

                (async function pullDataNote() {
                    await $.ajax({
                        type: 'GET',
                        url: 'notaReadAll',
                        dataType: 'JSON',
                        cache: false,
                        beforeSend: function (result) {
                            $('.div-load-page').removeClass('d-none').html('<p class="p-cog-spin lead text-center"><i class="fas fa-cog fa-spin"></i></p>');
                        },
                        error: function (result) {
                            if (result.responseText) {
                                Swal.fire({
                                    icon: 'error',
                                    html: result.responseText,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    html: 'Verifique se o servidor est&aacute; operacional.',
                                    showConfirmButton: false
                                });
                            }
                        },
                        success: function (data) {
                            if (data) {
                                if (data[0].status == true) {
                                    let response = '';

                                    for (let i in data) {
                                        response += '<dt>'
                                        + data[i].created_at
                                        + '<span class="bg pl-3">'
                                        + '<a class="fas fa-pen a-edit-nota text-warning" href="notaEdit/' + data[i].idnota + '" title="Editar a nota"></a>'
                                        + '</span>'

                                        <?php
                                            // Apenas usuários administradores podem excluir a nota

                                            if ($_SESSION['type'] == true) {
                                        ?>
                                        
                                        + '<span class="bg">'
                                        + '<a class="fas fa-trash a-delete-nota text-danger" id="<?= $cfg['id']['nota']; ?>-' + data[i].idnota + '" href="#" title="Excluir a nota"></a>'
                                        + '</span>'
                                        
                                        <?php
                                            }
                                        ?>

                                        + '</dt>'
                                        + '<dd>' + data[i].texto + '</dd>';
                                    }

                                    $('.div-load-page').addClass('d-none');
                                    $('.card-note').removeClass('d-none');
                                    $('.dl-data').html(response);

                                    // TOOLTIP LOCAL

                                    $('div a, td span a, span a').tooltip({
                                        boundary: 'window'
                                    });
                                } else {
                                    $('.div-load-page').addClass('d-none');
                                    $('.card-note').addClass('d-none');
                                    //$('.blockquote-data').removeClass('d-none');
                                }
                            }
                        },
                        complete: setTimeout(function () {
                            pullDataNote();
                        }, timeout),
                        timeout
                    });
                })();

                // MODAL

                $('.dl-data').on('click', '.a-edit-nota', function (e) {
                    e.preventDefault();

                    $('#modal-edit-nota').modal('show').find('.modal-content').load($(this).attr('href'));
                });

                $('.table-data').on('click', '.a-edit-entrega', function (e) {
                    e.preventDefault();

                    $('#modal-edit-entrega').modal('show').find('.modal-content').load($(this).attr('href'));
                });

                // NOVA NOTA

                $('.form-new-nota').submit(function (e) {
                    e.preventDefault();

                    $.post('notaInsert', $(this).serialize(), function (data) {
                        $('.btn-new-nota').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                        switch (data) {
                            case 'true':
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Nota cadastrada.'
                                }).then((result) => {
                                    window.setTimeout("location.href='inicio'", delay);
                                });
                                break;

                            default:
                                Toast.fire({
                                    icon: 'error',
                                    title: data
                                });
                                break;
                        }

                        $('.btn-new-nota').html('Salvar').fadeTo(fade, 1);
                    });

                    return false;
                });

                // DELETE NOTA

                $('.dl-data').on('click', '.a-delete-nota', function (e) {
                    e.preventDefault();

                    let click = this.id.split('-'),
                        py = click[0],
                        id = click[1];

                    swalButton.fire({
                        icon: 'question',
                        title: 'Excluir a nota',
                        showCancelButton: true,
                        confirmButtonText: 'Sim',
                        cancelButtonText: 'Não'
                    }).then((result) => {
                        if (result.value == true) {
                            $.ajax({
                                type: 'GET',
                                //url: 'controllers/nota/delete.php?' + py + '=' + id,
                                url: 'notaDelete/' + id,
                                dataType: 'JSON',
                                cache: false,
                                error: function (result) {
                                    Swal.fire({
                                        icon: 'error',
                                        html: result.responseText,
                                        showConfirmButton: false
                                    });
                                },
                                success: function (data) {
                                    if (data == true) {
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Nota exclu&iacute;da.'
                                        }).then((result) => {
                                            window.setTimeout("location.href='inicio'", delay);
                                        });
                                    }/* else {
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Nota desativada.'
                                        }).then((result) => {
                                            window.setTimeout("location.href='index'", delay);
                                        });
                                    }*/
                                }
                            });    
                        }
                    });
                });

                // ROTINA QUE REALIZA A BUSCA DE TODAS AS ENTREGAS

                (async function pullDataDelivery() {
                    await $.ajax({
                        type: 'GET',
                        url: 'entregaReadAll/<?= $mes . '/' . $ano; ?>',
                        dataType: 'JSON',
                        cache: false,
                        beforeSend: function (result) {
                            $('.div-load-page').removeClass('d-none').html('<p class="p-cog-spin lead text-center"><i class="fas fa-cog fa-spin"></i></p>');
                        },
                        error: function (result) {
                            if (result.responseText) {
                                Swal.fire({
                                    icon: 'error',
                                    html: result.responseText,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    html: 'Verifique se o servidor est&aacute; operacional.',
                                    showConfirmButton: false
                                });
                            }
                        },
                        success: function (data) {
                            if (data) {
                                if (data[0].status == true) {
                                    let response = '';

                                    for (let i in data) {
                                        response += '<tr>'
                                        + '<td>' + data[i].escola + '</td>'
                                        + '<td>' + data[i].pessoa + '</td>'
                                        + '<td>' + data[i].matricula + '</td>'
                                        + '<td>' + data[i].codigo + '</td>'
                                        + '<td>' + data[i].quantidade + '</td>'
                                        + '<td>' + data[i].created_at + '</td>'
                                        + '<td class="td-action">'
                                        + '<span class="bg bg-warning mr-2"><a class="fas fa-pen a-edit-entrega" href="entregaEdit/' + data[i].identrega + '" title="Editar entrega"></a></span>'
                                        
                                        <?php
                                            // Apenas usuários administradores podem excluir o registro

                                            if ($_SESSION['type'] == true) {
                                        ?>

                                        + '<span class="bg bg-danger"><a class="fas fa-trash a-delete-entrega" id="<?= $cfg['id']['entrega']; ?>-' + data[i].identrega + '" href="#" title="Excluir entrega"></a></span>'
                                        
                                        <?php
                                            }
                                        ?>

                                        + '</td></tr>';
                                    }

                                    $('.div-load-page').addClass('d-none');
                                    $('.blockquote-data').addClass('d-none');
                                    $('.table-data').removeClass('d-none');

                                    $('.table-data tbody').html(response);

                                    // TOOLTIP LOCAL

                                    $('div a, td span a, span a').tooltip({
                                        boundary: 'window'
                                    });

                                    // DATATABLE

                                    $('.table-data').DataTable({
                                        "paging": true,
                                        "lengthChange": false,
                                        "searching": true,
                                        "ordering": true,
                                        "info": true,
                                        "autoWidth": false,
                                        "responsive": true,
                                        "destroy": true,
                                        "language": {
                                            "emptyTable": "Nenhum dado dispon&iacute;vel",
                                            "info": "Mostrando _START_ para _END_ de _TOTAL_ registros",
                                            "infoEmpty": "Sem registros",
                                            "infoFiltered": "(filtrado de _MAX_ registros)",
                                            "paginate": {
                                                "first": 'Primeira p&aacute;gina',
                                                "last": '&Uacute;ltima p&aacute;gina',
                                                "previous": '<i class="fa fa-arrow-left"></i>',
                                                "next": '<i class="fa fa-arrow-right"></i>'
                                            },
                                            "lengthMenu": "Mostrar _MENU_ registros por p&aacute;gina'",
                                            "search": "Filtrar:",
                                            "zeroRecords": "Nada encontrado"
                                        }
                                    });
                                } else {
                                    $('.div-load-page').addClass('d-none');
                                    $('.table-data').addClass('d-none');
                                    $('.blockquote-data').removeClass('d-none');
                                }
                            }
                        },
                        complete: setTimeout(function () {
                            pullDataDelivery();
                        }, timeout),
                        timeout
                    });
                })();

                // NOVA ENTREGA

                $('.form-new-entrega').submit(function (e) {
                    e.preventDefault();

                    $.post('entregaInsert', $(this).serialize(), function (data) {
                        $('.btn-new-entrega').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                        switch (data) {
                            case 'true':
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Entrega efetuada.'
                                }).then((result) => {
                                    window.setTimeout("location.href='inicio'", delay);
                                });
                                break;

                            default:
                                Toast.fire({
                                    icon: 'error',
                                    title: data
                                });
                                break;
                        }

                        $('.btn-new-entrega').html('Salvar').fadeTo(fade, 1);
                    });

                    return false;
                });

                // DELETE ENTREGA

                $('.table-data').on('click', '.a-delete-entrega', function (e) {
                    e.preventDefault();

                    let click = this.id.split('-'),
                        py = click[0],
                        id = click[1];

                    swalButton.fire({
                        icon: 'question',
                        title: 'Excluir a entrega',
                        showCancelButton: true,
                        confirmButtonText: 'Sim',
                        cancelButtonText: 'Não'
                    }).then((result) => {
                        if (result.value == true) {
                            $.ajax({
                                type: 'GET',
                                //url: 'controllers/nota/delete.php?' + py + '=' + id,
                                url: 'entregaDelete/' + id,
                                dataType: 'JSON',
                                cache: false,
                                error: function (result) {
                                    Swal.fire({
                                        icon: 'error',
                                        html: result.responseText,
                                        showConfirmButton: false
                                    });
                                },
                                success: function (data) {
                                    if (data == true) {
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Entrega exclu&iacute;da.'
                                        }).then((result) => {
                                            window.setTimeout("location.href='inicio'", delay);
                                        });
                                    }/* else {
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Nota desativada.'
                                        }).then((result) => {
                                            window.setTimeout("location.href='index'", delay);
                                        });
                                    }*/
                                }
                            });    
                        }
                    });
                });
            });
        </script>
    </body>
</html>

<?php
unset($cfg, $database, $db, $escola, $menu, $prefix, $timestamp, $mes, $mesleft, $mesright, $ano, $sql, $row);