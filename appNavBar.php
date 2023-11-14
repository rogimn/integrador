<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button" title="bars">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a href="usuarios" class="nav-link" title="Gerenciar usu&aacute;rios" role="button" data-toggle="tooltip" data-original-title="Gerenciar usu&aacute;rios">
                <mark>Hi <span><?= $_SESSION['name']; ?>!</span></mark>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" title="Modo tela cheia" role="button" data-toggle="tooltip" data-original-title="Modo tela cheia">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

<?php
    if ($_SESSION['type'] == true) {
?>

        <li class="nav-item">
            <a class="nav-link a-make-bkp" href="#" title="Realizar uma c&oacute;pia de seguran&ccedil;a do banco de dados" role="button" data-toggle="tooltip" data-original-title="Realizar uma c&oacute;pia de seguran&ccedil;a do banco de dados">
                <i class="fas fa-database"></i>
            </a>
        </li>

<?php
    }
?>
        
        <li class="nav-item">
            <a class="nav-link a-logout-app" href="#" title="Sair do app" role="button" data-toggle="tooltip" data-original-title="Sair do app">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->