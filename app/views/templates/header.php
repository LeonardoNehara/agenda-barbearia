<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Administrativa</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Ícones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CSS personalizados -->
    <link rel="stylesheet" href="<?= $base; ?>/css/header/botoes.css">
    <link rel="stylesheet" href="<?= $base; ?>/css/header/header.css">
    <link rel="stylesheet" href="<?= $base; ?>/css/header/body.css">
    <link rel="stylesheet" href="<?= $base; ?>/css/tabela/tabela-responsive.css">

    <!-- Fonte -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>

<body style="background-color: #EDF2F6;">
    <div class="sair-icon" style="display: flex; align-items: center;">
        <i class="fa-solid fa-user"></i>
        <span style="margin-left: 5px;">Administrador</span>
        <div style="border-left: 1px solid #ccc; height: 20px; margin: 0 10px;"></div>
        <a href="<?= $base; ?>/deslogar" style="color: rgb(161, 161, 170); margin-left: 7px;">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>

    <header class="header">
        <div>
            <i class="fas fa-bars hamburger" style="font-size: 22px;"></i>
        </div>
    </header>

    <aside class="sidebar">
        <img src="<?= $base; ?>/img/logo_topo.png" class="img-fluid" alt="logo">
        <ul>
            <li class="<?= (basename($_SERVER['REQUEST_URI']) == 'inicio') ? 'active' : ''; ?>">
                <a class="negrito" href="<?= $base; ?>/inicio">
                    <i class="fa-solid fa-house" style="margin-right: 10px; font-size: 22px;"></i>Inicio
                </a>
            </li>

            <li class="<?= (basename($_SERVER['REQUEST_URI']) == 'usuario') ? 'active' : ''; ?>">
                <a class="negrito" href="<?= $base; ?>/usuario">
                    <i class="fa-solid fa-users-gear" style="margin-right: 10px; font-size: 22px;"></i>Usuários
                </a>
            </li>

            <li class="<?= (basename($_SERVER['REQUEST_URI']) == 'barbeiros') ? 'active' : ''; ?>">
                <a class="negrito" href="<?= $base; ?>/barbeiros">
                    <i class="fa-solid fa-cut" style="margin-right: 10px; font-size: 22px;"></i>Barbeiros
                </a>
            </li>

            <li class="<?= (basename($_SERVER['REQUEST_URI']) == 'servicos') ? 'active' : ''; ?>">
                <a class="negrito" href="<?= $base; ?>/servicos">
                    <i class="fa-solid fa-cogs" style="margin-right: 10px; font-size: 22px;"></i>Serviços
                </a>
            </li>

            <li class="<?= (basename($_SERVER['REQUEST_URI']) == 'agendamentos') ? 'active' : ''; ?>">
                <a class="negrito" href="<?= $base; ?>/agendamentos">
                    <i class="fa-solid fa-clipboard-list" style="margin-right: 10px; font-size: 22px;"></i>Agendar
                </a>
            </li>
        </ul>
    </aside>

    <script>
        $('.hamburger').on('click', function() {
            $('.sidebar').toggleClass('open');
            $('body').toggleClass('sidebar-open');
            $('.header').toggleClass('sidebar-open');
        });
    </script>
</body>

</html>
