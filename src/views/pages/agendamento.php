<?php $render('header'); ?>
<link rel="stylesheet" href="<?= $base; ?>/css/form.css">
<main class='main-div' style="width:100%;">
    <div class="form-container">
        <div class="titulo-container">
            <h1><strong>Agendamento de Barbearia</strong></h1>
            <div class="header-container">
                <h5>Informe os dados abaixo para realizar o agendamento.</h5>
            </div>
        </div>
        <div style="margin-top: 50px;">
            <div class="row">
                <input id="id" type="text" class="form-control" hidden>

                <div class="col-md-6 mb-3">
                    <label for="nome_completo" class="form-label">Nome Completo<span class="text-danger">*</span></label>
                    <input type="text" id="nome_completo" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="telefone" class="form-label">Telefone<span class="text-danger">*</span></label>
                    <input type="text" id="telefone" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="datahora" class="form-label">Data e Hora<span class="text-danger">*</span></label>
                    <input type="datetime-local" class="form-control" id="datahora" name="datahora" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="barbeiro_id" class="form-label">Barbeiro<span class="text-danger">*</span></label>
                    <select class="form-select" id="barbeiro_id" name="barbeiro_id" required>
                        <option value="">Selecione o Barbeiro</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="servico_id" class="form-label">Serviço<span class="text-danger">*</span></label>
                    <select class="form-select" id="servico_id" name="servico_id" required>
                        <option value="">Selecione o Serviço</option>
                    </select>
                </div>
            </div>
            <div class="form-footer">
                <button id="cadastro" class="btn btn-primary">Solicitar Agendamento</button>
            </div>
        </div>  
    </div>
    <div class="form-container">
            <h1><strong>Gestão de Agendamentos:</strong></h1>
            <br>
            <div class="filters">
                <label for="start_date">Data Inicial:</label>
                <input type="date" id="start_date" class="form-control" style="display: inline-block; width: auto;">

                <label for="end_date">Data Final:</label>
                <input type="date" id="end_date" class="form-control" style="display: inline-block; width: auto;">

                <label for="filter_barbeiro">Barbeiro:</label>
                <select id="filter_barbeiro" class="form-control" style="display: inline-block; width: auto;">
                    <option value="">Todos os Barbeiros</option>
                </select>

                <button id="btnBuscar" class="btn btn-primary">Buscar</button>
                <button id="btnLimpar" class="btn btn-secondary">Limpar Filtros</button>
            </div>
            <br>
            <table id="mytable" class="table table-bordered display nowrap" style="width: 100%"></table>
    </div>
</main>
</body>
<script src="<?= $base; ?>/js/agendamento.js"></script>