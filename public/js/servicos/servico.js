$(document).ready(function () {

    window.ServicoAPI = {
        get: base + '/getservicos',
        cadastro: base + '/cadservico',
        editar: base + '/editarservico',
        updateSituacao: base + '/updateSituacaoServico'
    };

    ServicoTable.init();
    ServicoForm.init();
});
