<?php $render('header'); ?>
<link rel="stylesheet" href="<?= $base; ?>/css/login.css">
<body>
<div class="container-fluid d-flex align-items-center justify-content-center" style="height: 100vh;">
    
    <div class="login-form">
        <h1 class="text-center">Login</h1>

        <!-- IMPORTANTE: mantive method e action -->
        <form id="loginForm" method="POST" action="<?= $base ?>/logar">

            <div class="input-group mb-3">
                <span class="input-group-text">
                    <i class="fas fa-user"></i>
                </span>
                <input 
                    type="text" 
                    class="form-control" 
                    name="login" 
                    id="login" 
                    placeholder="Digite seu login" 
                    required
                >
            </div>

            <div class="input-group mb-3 position-relative">
                <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                </span>
                <input 
                    type="password" 
                    class="form-control" 
                    name="password" 
                    id="senha" 
                    placeholder="Digite sua senha" 
                    required
                >

                <!-- OLHO -->
                <i 
                    onclick="mostrarSenha()" 
                    id="toggleSenha" 
                    class="fa fa-eye"
                    style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;"
                ></i>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Acessar
            </button>

        </form>
    </div>

</div>

<!-- BASE PARA JS -->
<script>
    const base = '<?= $base; ?>';
</script>

<script src="<?= $base; ?>/js/login.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>