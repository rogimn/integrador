<?php
// chamada de arquivos necessários

require_once 'config/app.php';
require_once 'config/Database.php';
require_once 'models/Usuario.php';

// controlando o primeiro acesso

if (file_exists('appInstall.php')) {
    header('location: instalacao');
}

// controle de sessão ativa

#if (isset($_SESSION['key'])) {
#    header('location: inicio');
#}
if (is_session_started() === TRUE) {
    if (isset($_SESSION['key'])) {
        header('location: inicio');
    }
}

// abre a conexão com o banco

$database = new Database();
$db = $database->getConnection();

// prepara o objeto

$usuario = new Usuario($db);

// procura por usuários, caso não encontre
// redireciona para o arquivo de instalação

$sql = $usuario->check();

if ($sql->rowCount() == 0) {
    rename('appInstallDone.php', 'appInstall.php');
    header('location: instalacao');
}
?>

<!DOCTYPE html>
<html lang="<?= $cfg['lang']; ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=5">
    
    <title>
        <?= $cfg['header']['title'] . $cfg['header']['subtitle']['index']; ?>
    </title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

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

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#" title="<?= $cfg['login_title']; ?>"><?= $cfg['login_title']; ?></a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Entre para iniciar sua sess&atilde;o</p>

                <form class="form-login">
                    <div class="input-group mb-3">
                        <input type="text" name="usuario" id="usuario" class="form-control" minlength="3" maxlength="15" placeholder="Usu&aacute;rio" required>
                        
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="input-group mb-3">
                        <input type="password" name="senha" id="senha" class="form-control" minlength="4" maxlength="15" placeholder="Senha" required>
                        
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <!--<p class="mb-0">
                                <a href="#" title="Clique para cadastrar um novo cliente"
                                    class="btn btn-secondary"
                                    data-toggle="modal" data-target="#modal-new-usuario">
                                    Criar conta
                                </a>
                            </p>-->
                        </div>

                        <div class="col-4">
                            <button type="submit" aria-label="Entrar" class="btn btn-primary btn-block btn-login">Entrar</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- Modals -->
    <!-- /.Modals -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- Custom -->
    <script>
        $(document).ready(function () {
            const fade = 150,
                delay = 100,
                Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });

            // LOGIN

            $('.form-login').submit(function (e) {
                e.preventDefault();

                let usuario = btoa($('#usuario').val()),
                    senha = btoa($('#senha').val());

                $.post('usuarioTrust', {
                    usuario,
                    senha,
                    rand: Math.random()
                }, function (data) {
                    $('.btn-login').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                    switch (data) {
                        case 'reload':
                            Toast
                                .fire({ icon: 'warning', title: 'Aguarde...' })
                                .then((result) => {
                                    location.reload();
                                });
                            break;

                        case 'true':
                            Toast
                                .fire({ icon: 'success', title: 'Login efetuado.' })
                                .then((result) => {
                                    window.setTimeout("location.href='inicio'", delay);
                                });
                            break;

                        default:
                            Toast.fire({ icon: 'error', title: data });
                            break;
                    }

                    $('.btn-login').html('Entrar').fadeTo(fade, 1);
                });

                return false;
            });
        });
    </script>
</body>

</html>

<?php
unset($cfg,$database,$db,$usuario);