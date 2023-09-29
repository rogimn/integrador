<?php

// limpa o cache

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

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

// abre a conexão com o banco

$database = new Database();
$db = $database->getConnection();

// inicializa uma instância da classe

$nota = new Nota($db);

// Variáveis de controle

$nota->idnota = $_GET['' . $cfg['id']['nota'] . ''];

// executa a consulta e retorna

if ($sql = $nota->readSingle()) {
    if ($sql->rowCount() > 0) {
        $row = $sql->fetch(PDO::FETCH_OBJ);
?>

        <form class="form-edit-nota">
            <div class="modal-header">
                <h4 class="modal-title">
                    <span>Editar a nota</span>
                </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="rand" id="rand_note" value="<?= md5(mt_rand()); ?>">
                <input type="hidden" name="idnota" id="idnota_edit" value="<?= $row->idnota; ?>">
                
                <div class="form-group">
                    <label for="texto" class="d-none">Texto</label>
                    <textarea name="texto" id="texto_edit" class="form-control" rows="5" title="Edite o conte&uacute;do da nota" placeholder="Texto"><?= $row->texto; ?></textarea>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary btn-edit-nota">Salvar</button>
            </div>
        </form>

        <script>
            $(document).ready(function () {
                const fade = 150,
                    delay = 100,
                    Toast = Swal.mixin(
                        { toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 }
                    );

                // EDITAR NOTA

                $('.form-edit-nota').submit(function (e) {
                    e.preventDefault();

                    $.post('notaUpdate', $(this).serialize(), function (data) {
                        $('.btn-edit-nota').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                        switch (data) {
                            case 'true':
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Nota editada.'
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

                        $('.btn-edit-nota').html('Salvar').fadeTo(fade, 1);
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

unset($cfg, $database, $db, $nota, $sql, $row);