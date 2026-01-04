<?php $render('header'); ?>
<link rel="stylesheet" href="<?= $base; ?>/css/form.css">
<main class="main-div" style="width: 100%;">
    <div class="form-container">
        <div class="header-container">
            <button id="novo" class="btn-custom" onclick="limparForm()">Novo</button>
            <h5 id="form-title" class="form-cad">Cadastrando Barbeiro</h5>
            <h5 class="media-h5"></h5>
        </div>

        <div style="margin-top: 50px;">
            <div class="row">
                <input id="id" type="text" class="form-control" hidden>

                <div class="col-md-6 mb-3">
                    <label for="nome" class="form-label">Nome<span class="text-danger">*</span></label>
                    <input id="nome" type="text" class="form-control" placeholder="Nome do Barbeiro">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="telefone" class="form-label">Telefone<span class="text-danger">*</span></label>
                    <input id="telefone" type="text" class="form-control" placeholder="Telefone">
                </div>
            </div>

            <div class="form-footer">
                <button id="cadastro" class="btn-custom">Gravar</button>
            </div>
        </div>
    </div>

    <div class="form-container table-card">
        <h1><strong>Barbeiros</strong></h1>
        <h4>Gestão de barbeiros:</h4>
        <table id="mytable" class="table table-bordered display nowrap" style="width: 100%"></table>
    </div>
</main>

<script>
    const base = '<?= $base; ?>';
</script>
<script src="<?= $base; ?>/js/barbeiros/barbeiro.form.js"></script>
<script src="<?= $base; ?>/js/barbeiros/barbeiro.js"></script>
<script src="<?= $base; ?>/js/barbeiros/barbeiro.table.js"></script>
<script src="<?= $base; ?>/js/utils/telefone.js"></script>