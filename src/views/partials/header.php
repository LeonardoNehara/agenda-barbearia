<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Barbearia</title>
    <!-- ESTILOS PRINCIPAIS DO SISTEMA -->
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="<?= $base; ?>/css/header/botoes.css">
    <link rel="stylesheet" href="<?= $base; ?>/css/header/header.css">

    <!-- FONT AWESOME (ÍCONES) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- JQUERY (OBRIGATORIAMENTE ANTES DE QUALQUER PLUGIN) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- DATATABLES (CSS e JS) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- DATATABLES RESPONSIVE -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <!-- PLUGIN JQUERY MASK (DEVE VIR DEPOIS DO JQUERY) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <!-- ALERTAS BONITOS - SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body style="background-color: #EDF2F6;">
    <?php if (isset($_SESSION['usuario'])): ?>
        <div class="sair-icon" style="display: flex; align-items: center;">
            <i class="fa-solid fa-user"></i>
            <span style="margin-left: 5px;"><?= $_SESSION['usuario'] ?></span>
            <div style="border-left: 1px solid #ccc; height: 20px; margin: 0 10px;"></div>

            <a href="<?= $base; ?>/deslogar" class="btn-logout" style="color: rgb(161, 161, 170); margin-left: 7px;">
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
    <?php endif; ?>
    <script src="<?= $base; ?>/js/header.js"></script>