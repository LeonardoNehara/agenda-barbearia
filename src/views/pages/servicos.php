<?php $render('header'); ?>
<link rel="stylesheet" href="<?= $base; ?>/css/form.css">
<main class="main-div" style="width: 100%;">
    <div class="form-container">
        <div class="header-container">
            <button id="novo" class="btn-custom" onclick="limparForm()">Novo</button>
            <h5 id="form-title" class="form-cad">Cadastrando Serviço</h5>
            <h5 class="media-h5"> </h5>
        </div>

        <div style="margin-top: 50px;">
            <div class="row">
                <input id="idServico" type="text" class="form-control" hidden>

                <div class="col-md-6 mb-3">
                    <label for="nome" class="form-label">Nome<span class="text-danger">*</span></label>
                    <input id="nome" type="text" class="form-control" placeholder="Nome do Serviço">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="valor" class="form-label">Valor<span class="text-danger">*</span></label>
                    <input id="valor" type="text" class="form-control" placeholder="Valor do Serviço">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tempoMinutos" class="form-label">Tempo (minutos)<span class="text-danger">*</span></label>
                    <input id="tempoMinutos" type="number" class="form-control" placeholder="Duração do Serviço em Minutos">
                </div>
            </div>

            <div class="form-footer">
                <button id="cadastro" class="btn-custom">Gravar</button>
            </div>
        </div>
    </div>

    <div class="form-container">
        <h1><strong>Serviços</strong></h1>
        <h4 class="titulo">Gestão de serviços:</h4>
        <table id="mytable" class="table table-bordered display nowrap" style="width: 100%"></table>
    </div>
</main>

</body>
<script src="<?= $base; ?>/js/servico.js"></script>