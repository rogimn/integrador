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
require_once '../models/Pessoa.php';

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
#$escola = new Escola($db);
#$pessoa = new Pessoa($db);

// Variáveis de controle

$entrega->monitor = true;

// se o parâmetro por ALL, busca todas as entregas

if ($_GET['' . $cfg['qsmd5']['report'] . ''] == 'all') {
?>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <span>
                    <i class="fas fa-file-invoice"></i>&nbsp;Todas as Entregas Registradas
                </span>
            </h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover table-data-report">
                <thead>
                    <tr>
                        <th>Escola</th>
                        <th>Pessoa</th>
                        <th>Matr&iacute;cula</th>
                        <th>C&oacute;digo</th>
                        <th>Qtde</th>
                        <th>Data</th>
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
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            const fade = 150,
                delay = 100,
                Toast = Swal.mixin(
                    { toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 }
                );

            (async function pullDataDeliveryReport() {
                await $.ajax({
                    type: 'GET',
                    url: 'entregaReadAll',
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
                                    + '</tr>';
                                }

                                $('.table-data-report').removeClass('d-none');

                                $('.table-data-report tbody').html(response);

                                // DATATABLE

                                $('.table-data-report').DataTable({
                                    "paging": true,
                                    "lengthChange": false,
                                    "searching": true,
                                    "ordering": true,
                                    "order": [[5, 'asc']],
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
                                    },
                                    "dom": "Bfrtip",
                                    "buttons": [
                                        {
                                            extend: 'copy',
                                            title: 'Todas as Entregas',
                                            text: 'Copiar'
                                        },
                                        {
                                            extend: 'csv',
                                            title: 'Todas as Entregas'
                                        },
                                        {
                                            extend: 'excel',
                                            title: 'Todas as Entregas',
                                            text: 'XLSX'
                                        },
                                        {
                                            extend: 'pdf',
                                            title: 'Todas as Entregas'
                                        },
                                        {
                                            extend: 'print',
                                            title: 'Todas as Entregas',
                                            text: 'Imprimir as Entregas',
                                            exportOptions: {
                                                modifier: {
                                                    selected: null
                                                }
                                            }
                                        },
                                        {
                                            extend: 'print',
                                            title: 'Todas as Entregas selecionadas',
                                            text: 'Imprimir as Entregas selecionadas <i>(Segure SHIFT+Click para selecionar)</i>'
                                        }
                                    ],
                                    "select": true
                                });
                            } else {
                                //$('.div-load-page').addClass('d-none');
                                $('.table-data-report').addClass('d-none');
                                //$('.blockquote-data').removeClass('d-none');
                            }
                        }
                    }
                });
            })();
        });
    </script>

<?php
}

unset($cfg, $database, $db, $entrega, $escola, $pessoa);