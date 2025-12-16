<?php $render('header'); ?>
<link rel="stylesheet" href="<?= $base; ?>/css/form.css">

<main class="main-div" style="width: 100%;">

    <!-- FORMULÁRIO -->
    <div class="form-container">
        <div class="header-container">
            <button id="novo" class="btn-custom" onclick="limparForm()">Novo</button>
            <h5 id="form-title" class="form-cad">Solicitar Agendamento</h5>
            <h5 class="media-h5"></h5>
        </div>

        <div style="margin-top: 50px;">
            <div class="row">

                <input id="id" type="text" class="form-control" hidden>

                <div class="col-md-6 mb-3">
                    <label for="nome_completo" class="form-label">
                        Nome Completo <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        id="nome_completo"
                        class="form-control"
                        placeholder="Nome completo do cliente"
                        required
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label for="telefone" class="form-label">
                        Telefone <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        id="telefone"
                        class="form-control"
                        placeholder="(00) 00000-0000"
                        required
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label for="datahora" class="form-label">
                        Data e Hora <span class="text-danger">*</span>
                    </label>
                    <input
                        type="datetime-local"
                        id="datahora"
                        class="form-control"
                        required
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label for="barbeiro_id" class="form-label">
                        Barbeiro <span class="text-danger">*</span>
                    </label>
                    <select id="barbeiro_id" class="form-select" required>
                        <option value="">Selecione o Barbeiro</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="servico_id" class="form-label">
                        Serviço <span class="text-danger">*</span>
                    </label>
                    <select id="servico_id" class="form-select" required>
                        <option value="">Selecione o Serviço</option>
                    </select>
                </div>

            </div>

            <div class="form-footer">
                <button id="cadastro" class="btn-custom">
                    Gravar
                </button>
            </div>
        </div>
    </div>

    <!-- LISTAGEM -->
    <div class="form-container">
        <h1><strong>Agendamentos</strong></h1>
        <h4 class="titulo">Gestão de agendamentos:</h4>

        <div class="filters mb-3">
            <label for="start_date">Data Inicial:</label>
            <input type="date" id="start_date" class="form-control d-inline-block w-auto">

            <label for="end_date">Data Final:</label>
            <input type="date" id="end_date" class="form-control d-inline-block w-auto">

            <label for="filter_barbeiro">Barbeiro:</label>
            <select id="filter_barbeiro" class="form-control d-inline-block w-auto">
                <option value="">Todos os Barbeiros</option>
            </select>

            <button id="btnBuscar" class="btn btn-primary">Buscar</button>
            <button id="btnLimpar" class="btn btn-secondary">Limpar</button>
        </div>

        <table id="mytable" class="table table-bordered display nowrap" style="width: 100%"></table>
    </div>

</main>

<script>
    const base = '<?= $base; ?>';
</script>
<script src="<?= $base; ?>/js/agendamento.js"></script>
