<?php
// chama os arquivos necessários

require_once '../config/app.php';
include_once '../models/Database.php';

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
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <h1></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Modals -->
            
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

                /*// PULL DATA CLIENTE - CONTA - INVESTIMENTO

                (async function pullData() {
                    await $.ajax({
                        type: 'GET',
                        url: 'controllers/cliente/readSingle.php',
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
                            if (data[0]) {
                                $('.div-load-page').addClass('d-none');

                                // o tempo de resgate e o rendimento serão passados para sessions
                                // porque será utilizado no cálculo dos rendimentos na função pullDataMovimentacao()

                                sessionStorage.setItem('rendimento', data[0].rendimento);
                                sessionStorage.setItem('tempo_resgate', data[0].tempo_resgate);

                                if (data[0].status == true) {
                                    $('.data-name').html(data[0].nome);
                                    $('.data-document').html(data[0].documento);
                                    $('#idconta_deposito').val(data[0].idconta);
                                    $('#idconta_resgate').val(data[0].idconta);
                                    $('.data-account').html(data[0].conta);
                                    $('.data-investiment').html(data[0].investimento);
                                    $('.data-investiment-more').html(data[0].tempo_resgate + ' dias &#45; ' + data[0].rendimento + '%');
                                } else {
                                    $('.data-name').html('&#45;');
                                    $('.data-document').html('&#45;');
                                    $('.data-account').html('&#45;');
                                    $('.data-investiment').html('&#45;');
                                    $('.data-balance').html('&#45;');
                                }
                            }
                        }
                    });
                })();

                // PULL DATA MOVIMENTAÇÕES

                (async function pullDataMovimentacao() {
                    await $.ajax({
                        type: 'GET',
                        url: 'controllers/movimentacao/readAll.php',
                        dataType: 'json',
                        cache: false,
                        beforeSend: function (result) {
                            $('.div-load-page').removeClass('d-none').html('<p class="p-cog-spin lead text-center"><i class="fas fa-cog fa-spin"></i></p>');
                        },
                        error: function(result) {
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
                        success: function(data) {
                            if (data) {
                                $('.div-load-page').addClass('d-none');
                                
                                if (data[0].status == false) {
                                    $('.data-balance-deposit').html(new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL'}).format('0.00'));
                                    $('.data-balance-profitable').html(new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL'}).format('0.00'));
                                    $('.data-balance-total').html(new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL'}).format('0.00'));
                                    $('#saldo_resgate').val('');
                                    $('.table-data').addClass('d-none');
                                    $('.dl-data').removeClass('d-none');
                                } else {
                                    let response = '',
                                        dataAtual, dia, mes, $ano,
                                        diffInMs, diffInDays,
                                        saldo = 0,
                                        rendimento = sessionStorage.getItem('rendimento'),
                                        tempo_resgate = sessionStorage.getItem('tempo_resgate');

                                    // obtendo a data atual no formato yyyy-mm-dd

                                    dataAtual = new Date();
                                    dia = String(dataAtual.getDate()).padStart(2, '0');
                                    mes = String(dataAtual.getMonth() + 1).padStart(2, '0');
                                    ano = dataAtual.getFullYear();
                                    dataAtual = ano + '-' + mes + '-' + dia;
                                    
                                    // calculando a diferença de dias

                                    diffInMs   = new Date(dataAtual) - new Date(data[0].datado_calculo)
                                    diffInDays = diffInMs / (1000 * 60 * 60 * 24);

                                    for (let i in data) {
                                        data[i].valor = Number(data[i].valor);

                                        if (data[i].tipo == 1) {
                                            response += '<tr>'
                                            + '<td><span class="badge badge-success">Entrada</span></td>'
                                            + '<td>' + data[i].datado + '</td>'
                                            + '<td>' + new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL'}).format(data[i].valor) + '</td>'
                                            + '</tr>';

                                            saldo = saldo + data[i].valor;
                                        } else if (data[i].tipo == 0) {
                                            response += '<tr>'
                                            + '<td><span class="badge badge-danger">Sa&iacute;da</span></td>'
                                            + '<td>' + data[i].datado + '</td>'
                                            + '<td>' + new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL'}).format(data[i].valor) + '</td>'
                                            + '</tr>';

                                            saldo = saldo - data[i].valor;
                                        }
                                    }

                                    // calculando o rendimento

                                    tempo_resgate = Number(tempo_resgate);
                                    rendimento = Number(rendimento / 100);

                                    calc1 = rendimento / tempo_resgate;
                                    calc2 = calc1 * diffInDays;
                                    calc3 = calc2 / 100;
                                    rentabilizado = saldo * calc3;
                                    total = saldo + rentabilizado;

                                    $('.data-balance-deposit').html(new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL'}).format(saldo));
                                    $('.data-balance-profitable').html(new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL'}).format(rentabilizado));
                                    $('.data-balance-total').html(new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL'}).format(total));
                                    $('#saldo_resgate').val(total);
                                    $('.dl-data').addClass('d-none');
                                    $('.table-data tbody').html(response);                                    
                                }
                            }
                        },
                        complete: setTimeout(function () {
                            pullDataMovimentacao();
                        }, timeout),
                        timeout
                    });
                })();

                // NOVO PEDIDO

                $('.form-deposit').submit(function (e) {
                    e.preventDefault();

                    $.post('controllers/movimentacao/insert.php', $(this).serialize(), function (data) {
                        $('.btn-deposit').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                        switch (data) {
                            case 'true':
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Depósito realizado.'
                                }).then((result) => {
                                    window.setTimeout("location.href='inicio.php'", delay);
                                });
                                break;

                            default:
                                Toast.fire({
                                    icon: 'error',
                                    title: data
                                });
                                break;
                        }

                        $('.btn-deposit').html('Depositar').fadeTo(fade, 1);
                    });

                    return false;
                });

                // NOVO RESGATE

                $('.form-redeem').submit(function (e) {
                    e.preventDefault();
                    
                    // se o valor do resgate for maior do que está investido, retorna um aviso.

                    if (Number($('#valor_resgate').val()) > Number($('#saldo_resgate').val())) {
                        Toast.fire({
                            icon: 'error',
                            title: 'O valor não pode exceder o limite.'
                        });
                    } else {
                        $.post('controllers/movimentacao/insert.php', $(this).serialize(), function (data) {
                            $('.btn-redeem').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                            switch (data) {
                                case 'true':
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Resgate realizado.'
                                    }).then((result) => {
                                        window.setTimeout("location.href='inicio.php'", delay);
                                    });
                                    break;

                                default:
                                    Toast.fire({
                                        icon: 'error',
                                        title: data
                                    });
                                    break;
                            }

                            $('.btn-redeem').html('Resgatar').fadeTo(fade, 1);
                        });
                    }

                    return false;
                });*/
            });
        </script>
    </body>
</html>

<?php
unset($cfg,$database,$db,$menu,$prefix);