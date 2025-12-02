<?php $render('header'); ?>
<link rel="stylesheet" href="<?= $base; ?>/css/form.css">
<main class='main-div' style="width:100%;">

    <div class="form-container">
        <div class="header-container">
            <button id="novo" class="btn-custom" onclick="limparForm()">Novo</button>
            <h5 id="form-title" class="form-cad">Cadastrando Usuários</h5>
            <h5></h5>
        </div>

        <div style="margin-top: 50px;">
            <div class="row">
                <input id="idusuario" type="text" class="form-control" hidden>

                <div class="col-md-6 mb-3">
                    <label for="nome" class="form-label">Nome<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="login" class="form-label">Login<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="login" name="login" placeholder="Login">
                </div>
                <div class="col-md-6 mb-3" style="position: relative;">
                    <label for="senha" class="form-label">Senha<span class="text-danger">*</span></label>
                    <input type="password" class="form-control pr-5" id="senha" name="senha" placeholder="Senha">
                    <i onclick="mostrarSenha()" class="fa fa-eye" style="position: absolute; top: 74%; right: 25px; transform: translateY(-50%); cursor: pointer;"></i>
                </div>
            </div>
            <div class="form-footer">
                <button id="cadastro" class="btn-custom">Gravar</button>
            </div>
        </div>
    </div>

    <div class="form-container">
        <h1><strong>Usuários</strong></h1>
        <h4>Gestão de usuários e acessos:</h4>
        <table id="mytable" class="table table-bordered display nowrap" style="width:100%"></table>
    </div>

</main>

</body>
<script src="<?= $base; ?>/js/usuario.js"></script>