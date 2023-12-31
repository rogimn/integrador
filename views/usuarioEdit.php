<?php

// limpa o cache

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// chama os arquivos necessários

require_once '../config/app.php';
require_once '../models/Database.php';
require_once '../models/Usuario.php';

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

$usuario = new Usuario($db);

// Variáveis de controle

$usuario->idusuario = $_GET['' . $cfg['id']['usuario'] . ''];

// executa a consulta e retorna

if ($sql = $usuario->readSingle()) {
    if ($sql->rowCount() > 0) {
        $row = $sql->fetch(PDO::FETCH_OBJ);
?>

        <form class="form-edit-usuario">
            <div class="modal-header">
                <h4 class="modal-title">
                    <span>Editar usu&aacute;rio</span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="rand" id="rand_edit" value="<?= md5(mt_rand()); ?>">
                <input type="hidden" name="idusuario" id="idusuario_edit" value="<?= $row->idusuario; ?>">
                <input type="hidden" name="usuario_previous" id="usuario_previous_edit" value="<?= $_GET['' . $py_usuario . '']; ?>">

                <div class="row form-group g-3 align-items-center">
                    <div class="col-2">
                        <label class="text text-danger" for="tipo">Tipo</label>
                    </div>
                    <div class="col-10">
                    
                    <?php

                        switch ($row->tipo) {
                            case true:
                                echo
                                '<span class="form-icheck"><input type="radio" name="tipo" value="true" checked> Administrador</span>
                                <span class="form-icheck"><input type="radio" name="tipo" value="false"> Comum</span>';
                                break;

                            case false:
                                echo
                                '<span class="form-icheck"><input type="radio" name="tipo" value="true"> Administrador</span>
                                <span class="form-icheck"><input type="radio" name="tipo" value="false" checked> Comum</span>';
                                break;
                        }

                    ?>

                    </div>
                </div>
                <div class="row form-group g-3 align-items-center">
                    <div class="col-2">
                        <label class="text text-danger" for="nome">Nome</label>
                    </div>
                    <div class="col-10">
                        <input type="text" name="nome" id="nome_edit" minlength="2" maxlength="200" class="form-control"
                            value="<?= $row->nome; ?>" placeholder="Nome" required>
                    </div>
                </div>

                <div class="row form-group g-3 align-items-center">
                    <div class="col-2">
                        <label class="text text-danger" for="usuario">Usu&aacute;rio</label>
                    </div>
                    <div class="col-10">
                        <input type="text" name="usuario" id="usuario_edit" minlength="3" maxlength="10" class="form-control"
                            value="<?= decrypt($row->usuario, $cfg['enigma']); ?>" placeholder="Usu&aacute;rio" required>
                    </div>
                </div>

                <div class="row form-group g-3 align-items-center">
                    <div class="col-2">
                        <label class="text text-danger" for="senha">Senha</label>
                    </div>
                    <div class="col-10">
                        <input type="password" name="senha" id="senha_edit" minlength="4" maxlength="10" class="form-control"
                            value="<?= decrypt($row->senha, $cfg['enigma']); ?>" autocomplete="senha" spellcheck="false"
                            autocorrect="off" autocapitalize="off" placeholder="Senha" required>
                    </div>
                </div>

                <div class="row form-group g-3 align-items-center">
                    <div class="col-2">
                        <label class="text text-danger" for="senha">E-mail</label>
                    </div>
                    <div class="col-10">
                        <input type="email" name="email" id="email_edit" minlength="5" maxlength="100" class="form-control"
                            value="<?= $row->email; ?>" placeholder="Email" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex">
                <div class="mr-auto">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>

                <div class="ml-auto">
                    <button type="reset" class="btn btn-secondary">Restaurar dados iniciais</button>
                    <button type="submit" class="btn btn-primary btn-edit-usuario">Salvar</button>
                </div>
            </div>
        </form>

        <script>
            $(document).ready(function () {
                const fade = 150,
                    delay = 100,
                    Toast = Swal.mixin(
                        { toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 }
                    );

                // ICHECK LOCAL

                $("input[type='radio'], input[type='checkbox']").iCheck({
                    radioClass: 'iradio_minimal'
                });

                // SHOW PASS

                $('#senha_edit').password();

                // EDITAR USUÁRIO

                $('.form-edit-usuario').submit(function (e) {
                    e.preventDefault();

                    $.post('usuarioUpdate', $(this).serialize(), function (data) {
                        $('.btn-edit-usuario').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                        switch (data) {
                            case 'reload':
                                Toast
                                    .fire({ icon: 'success', title: 'Dados do usu&aacute;rio editado.' })
                                    .then((result) => {
                                        window.setTimeout("location.href='sair'", delay);
                                    });
                                break;

                            case 'true':
                                Toast
                                    .fire({ icon: 'success', title: 'Dados do usu&aacute;rio editado.' })
                                    .then((result) => {
                                        window.setTimeout("location.href='usuarios'", delay);
                                    });
                                break;

                            default:
                                Toast.fire({ icon: 'error', title: data });
                                break;
                        }

                        $('.btn-edit-usuario').html('Salvar').fadeTo(fade, 1);
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

unset($cfg, $database, $db, $usuario, $sql, $row);