<?php

// chama os arquivos necessários

require_once '../config/app.php';

// controle de sessão

if (is_session_started() === TRUE) {
    if (empty($_SESSION['key'])) {
        header('location: ./');
    }
}

//pré-definição de variáveis

$menu = 2;
$prefix = '../';
?>

<!DOCTYPE html>
<html lang="<?= $cfg['lang']; ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>
            <?= $cfg['header']['title'] . $cfg['header']['subtitle']['school']; ?>
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
                            <div class="col-7">
                                <h1><?= $cfg['header']['subtitle']['school']; ?></h1>
                            </div>

                            <div class="col-5">
                                <div class="text-right">
                                    <a href="#" class="btn btn-primary" title="Clique para cadastrar uma nova escola" data-toggle="modal" data-target="#modal-new-escola">
                                        <i class="fas fa-user"></i> Novo escola
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Default box -->
                    <div class="card">
                        <div class="card-body">
                            <!--<div class="div-load-page d-none"></div>-->

                            <table class="table table-bordered table-hover table-data d-none">
                                <thead>
                                    <tr>
                                        <th>C&oacute;digo</th>
                                        <th>Nome</th>
                                        <th>Bairro</th>
                                        <th>Endere&ccedil;o</th>
                                        <th>Contatos</th>
                                        <th>E&#45;mail</th>
                                        <th style="max-width: 100px;width: 90px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>C&oacute;digo</th>
                                        <th>Nome</th>
                                        <th>Bairro</th>
                                        <th>Endere&ccedil;o</th>
                                        <th>Contatos</th>
                                        <th>E&#45;mail</th>
                                        <th style="max-width: 100px;width: 90px;"></th>
                                    </tr>
                                </tfoot>
                            </table>

                            <blockquote class="quote-secondary blockquote-data d-none">
                                <h5><?= $cfg['msg_empty_table']['title']; ?></h5>
                                <p>
                                    <span><?= $cfg['msg_empty_table']['msg']; ?></span>
                                    <a href="#" title="Clique para cadastrar um novo escola" data-toggle="modal" data-target="#modal-new-escola">
                                        Novo escola
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
            <div class="modal fade" id="modal-new-escola">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form class="form-new-escola">
                            <div class="modal-header">
                                <h4 class="modal-title">
                                    <span>Novo escola</span>
                                </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="rand" id="rand" value="<?= md5(mt_rand()); ?>">
                                <input type="hidden" name="codigo" id="codigo" value="<?= createCode(); ?>">

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                        <div class="row form-group g-3 align-items-center">
                                            <div class="col-3">
                                                <label class="text text-danger" for="nome">Nome</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" name="nome" id="nome" minlength="2" maxlength="200" class="form-control" title="Informe o nome do escola" placeholder="Nome" required>
                                            </div>
                                        </div>

                                        <div class="row form-group g-3 align-items-center">
                                            <div class="col-3">
                                                <label class="text text-danger" for="cep">CEP</label>
                                            </div>
                                            <div class="col-4">
                                                <input type="text" name="cep" id="cep" minlength="9" maxlength="9" class="form-control" title="Informe o CEP" placeholder="CEP" required>
                                            </div>
                                            <div class="col-5">
                                                <cite class="msg-cep"></cite>
                                            </div>
                                        </div>

                                        <div class="row form-group g-3 align-items-center">
                                            <div class="col-3">
                                                <label class="text text-danger" for="logradouro">Logradouro</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" name="logradouro" id="logradouro" minlength="2" maxlength="200" class="form-control" title="Informe o Logradouro" placeholder="Logradouro" readonly>
                                            </div>
                                        </div>

                                        <div class="row form-group g-3 align-items-center">
                                            <div class="col-3">
                                                <label class="text text-danger" for="numero">N&uacute;mero</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" name="numero" id="numero" minlength="1" maxlength="10" class="form-control col-6" title="Informe o N&uacute;mero" placeholder="N&uacute;mero" required>
                                            </div>
                                        </div>

                                        <div class="row form-group g-3 align-items-center">
                                            <div class="col-3">
                                                <label class="text text-danger" for="bairro">Bairro</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" name="bairro" id="bairro" minlength="2" maxlength="100" class="form-control" title="Informe o Bairro" placeholder="Bairro" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                        <div class="row form-group g-3 align-items-center">
                                            <div class="col-3">
                                                <label class="text text-danger" for="cidade">Cidade</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" name="cidade" id="cidade" minlength="2" maxlength="100" class="form-control" title="Informe a Cidade" placeholder="Cidade" readonly>
                                            </div>
                                        </div>

                                        <div class="row form-group g-3 align-items-center">
                                            <div class="col-3">
                                                <label class="text text-danger" for="uf">UF</label>
                                            </div>
                                            <div class="col-9">
                                                <!--<select name="uf" id="uf" class="selectpicker show-tick form-control" title="Selecione a Unidade Federativa" placeholder="UF" data-width="" data-size="7">-->
                                                <select name="uf" id="uf" class="form-control col-6" title="Selecione a Unidade Federativa" placeholder="UF" readonly>
                                                    <option value="" selected></option>
                                                    <option value="AC">AC</option>
                                                    <option value="AL">AL</option>
                                                    <option value="AM">AM</option>
                                                    <option value="AP">AP</option>
                                                    <option value="BA">BA</option>
                                                    <option value="CE">CE</option>
                                                    <option value="DF">DF</option>
                                                    <option value="ES">ES</option>
                                                    <option value="GO">GO</option>
                                                    <option value="MA">MA</option>
                                                    <option value="MG">MG</option>
                                                    <option value="MS">MS</option>
                                                    <option value="MT">MT</option>
                                                    <option value="PA">PA</option>
                                                    <option value="PB">PB</option>
                                                    <option value="PE">PE</option>
                                                    <option value="PI">PI</option>
                                                    <option value="PR">PR</option>
                                                    <option value="RJ">RJ</option>
                                                    <option value="RN">RN</option>
                                                    <option value="RO">RO</option>
                                                    <option value="RR">RR</option>
                                                    <option value="RS">RS</option>
                                                    <option value="SC">SC</option>
                                                    <option value="SE">SE</option>
                                                    <option value="SP">SP</option>
                                                    <option value="TO">TO</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row form-group g-3 align-items-center">
                                            <div class="col-3">
                                                <label class="text" for="celular">Celular</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" name="celular" id="celular" minlength="11" maxlength="15" class="form-control col-6" title="Informe um contato por Celular" placeholder="Celular">
                                            </div>
                                        </div>

                                        <div class="row form-group g-3 align-items-center">
                                            <div class="col-3">
                                                <label class="text" for="telefone">Telefone</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" name="telefone" id="telefone" minlength="10" maxlength="15" class="form-control col-6" title="Informe um contato por Telefone" placeholder="Telefone">
                                            </div>
                                        </div>

                                        <div class="row form-group g-3 align-items-center">
                                            <div class="col-3">
                                                <label class="text text-danger" for="senha">E-mail</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="email" name="email" id="email" minlength="5" maxlength="100" class="form-control" title="Informe um e-mail v&aacute;lido" placeholder="Email" required>
                                            </div>
                                        </div>

                                        <div class="row form-group g-3 align-items-center">
                                            <div class="col-3">
                                                <label class="text" for="observacao">Observa&ccedil;&atilde;o</label>
                                            </div>
                                            <div class="col-9">
                                                <textarea name="observacao" id="observacao" class="form-control" title="Se tiver alguma observa&ccedil;&atilde;o, esse &eacute o momento." placeholder="Observa&ccedil;&atilde;o"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary btn-new-escola">Salvar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <div class="modal fade" id="modal-edit-escola">
                <div class="modal-dialog modal-xl">
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
        <!-- Input Mask -->
        <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
        <!-- SweetAlert2 -->
        <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
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

                // MASK
        
                $('#cep').inputmask('99999-999');
                $('#celular').inputmask('(99)99999-9999');
                $('#telefone').inputmask('(99)9999-9999');

                // CHECK CEP

                function checkCEP() {
                    $.post('loadCEP', {
                        cep: $.trim($('#cep').val())
                    }, data => {
                        let parsed = $.parseJSON(data);
                        
                        if (parsed.resultado === '1') {
                            $('#logradouro').val(parsed.tipo_logradouro + ' ' + parsed.logradouro);
                            $('#bairro').val($.trim(parsed.bairro));
                            $('#cidade').val($.trim(parsed.cidade));
                            $('#uf').val(parsed.uf);
                            $('#cep').css('background', 'transparent');
                            $('.msg-cep').addClass('text-success').removeClass('text-danger').css('display', 'block').html('CEP V&aacute;lido!');
                        } else {
                            $('#logradouro').val('');
                            $('#bairro').val('');
                            $('#cidade').val('');
                            $('#uf').val('');
                            $('#cep').focus().css('background', 'transparent');
                            $('.msg-cep').addClass('text-danger').removeClass('text-success').css('display', 'block').html('CEP Inv&aacute;lido!');
                        }
                    });
                }

                $('#cep').keyup(function() {
                    if ($('#cep').val().length == 9) {
                        if (!$('#cep').val().match(/_/g)) {
                            checkCEP();
                            $('#cep').css('background', 'transparent url("dist/img/rings-black.svg") right center no-repeat');
                        }
                    } else {
                        $('#cep').val('');
                        $('.msg-cep').css('display', 'none');
                    }
                });

                // ROTINA QUE REALIZA A BUSCA DE TODOS OS REGISTROS

                (async function pullData() {
                    await $.ajax({
                        type: 'GET',
                        url: 'escolaReadAll',
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
                                    showConfirmButton: true
                                }).then((result) => {
                                    window.setTimeout("location.href='sair'", delay);
                                });
                            }
                        },
                        success: function (data) {
                            if (data) {
                                if (data[0].status == true) {
                                    let response = '';

                                    for (let i in data) {
                                        response += '<tr>'
                                        + '<td>' + data[i].codigo + '</td>'
                                        + '<td>' + data[i].nome + '</td>'
                                        + '<td>' + data[i].bairro + '</td>'
                                        + '<td>' + data[i].logradouro + ', ' + data[i].numero + '</td>'
                                        + '<td>' + data[i].celular + ' &#45; ' + data[i].telefone + '</td>'
                                        + '<td>' + data[i].email + '</td>'
                                        + '<td class="td-action">'
                                        + '<span class="bg bg-warning mr-2"><a class="fas fa-pen a-edit-escola" href="escolaEdit/' + data[i].idescola + '" title="Editar escola"></a></span>'
                                        
                                        <?php
                                            // Apenas usuários administradores podem excluir o registro

                                            if ($_SESSION['type'] == true) {
                                        ?>
                                        
                                        + '<span class="bg bg-danger"><a class="fas fa-trash a-delete-escola" id="<?= $cfg['id']['escola']; ?>-' + data[i].idescola + '" href="#" title="Excluir escola"></a></span>'
                                        
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
                            pullData();
                        }, timeout),
                        timeout
                    });
                })();

                // MODAL

                $('.table-data').on('click', '.a-edit-escola', function (e) {
                    e.preventDefault();

                    $('#modal-edit-escola').modal('show').find('.modal-content').load($(this).attr('href'));
                });

                // NOVA ESCOLA

                $('.form-new-escola').submit(function (e) {
                    e.preventDefault();

                    $.post('escolaInsert', $(this).serialize(), function (data) {
                        $('.btn-new-escola').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                        switch (data) {
                            case 'true':
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Escola cadastrada.'
                                }).then((result) => {
                                    window.setTimeout("location.href='escolas'", delay);
                                });
                                break;

                            default:
                                Toast.fire({
                                    icon: 'error',
                                    title: data
                                });
                                break;
                        }

                        $('.btn-new-escola').html('Salvar').fadeTo(fade, 1);
                    });

                    return false;
                });

                // DELETE ESCOLA

                $('.table-data').on('click', '.a-delete-escola', function (e) {
                    e.preventDefault();

                    let click = this.id.split('-'),
                        py = click[0],
                        id = click[1];

                    swalButton.fire({
                        icon: 'question',
                        title: 'Desativar a escola',
                        showCancelButton: true,
                        confirmButtonText: 'Sim',
                        cancelButtonText: 'Não'
                    }).then((result) => {
                        if (result.value == true) {
                            $.ajax({
                                type: 'GET',
                                //url: 'controllers/escola/delete.php?' + py + '=' + id,
                                url: 'escolaDelete/' + id,
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
                                            title: 'Escola desativada.'
                                        }).then((result) => {
                                            window.setTimeout("location.href='escolas'", delay);
                                        });
                                    }/* else {
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Escola desativada.'
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
unset($cfg, $menu, $prefix);