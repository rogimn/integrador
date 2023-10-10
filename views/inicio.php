<?php
// chama os arquivos necessários

require_once '../config/app.php';
require_once '../models/Database.php';
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

#$cliente = new Cliente($db);

//pré-definição de variáveis

$menu = 1;
$prefix = '../';
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
        <!-- SweetAlert2 -->
        <link rel="stylesheet" media="print" href="plugins/sweetalert2/sweetalert2.min.css" onload="this.media='all'">
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
                                <input type="hidden" name="idusuario" id="idusuario" value="<?= $_SESSION['id']; ?>">
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
        <!-- SweetAlert2 -->
        <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
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


                // ROTINA QUE REALIZA A BUSCA DE TODAS AS NOTAS

                (async function pullDataNote() {
                    await $.ajax({
                        type: 'GET',
                        url: 'notaReadAll',
                        dataType: 'json',
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
                                dataType: 'json',
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
            });
        </script>
    </body>
</html>

<?php
unset($cfg,$database,$db,$menu,$prefix);