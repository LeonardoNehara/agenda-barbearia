$(document).ready(function () {

    const apiBarbeiros = base + '/getbarbeirosativos';
    const apiServicos  = base + '/getservicosativos';

    function carregarBarbeiros() {
        $.getJSON(apiBarbeiros, function (response) {
            if (response.success?.ret) {
                $('#barbeiro_id').html('<option value="">Selecione o Barbeiro</option>');
                response.success.ret.forEach(b =>
                    $('#barbeiro_id').append(`<option value="${b.id}">${b.nome}</option>`)
                );
            }
        });
    }

    function carregarServicos() {
        $.getJSON(apiServicos, function (response) {
            if (response.success?.ret) {
                $('#servico_id').html('<option value="">Selecione o Serviço</option>');
                response.success.ret.forEach(s =>
                    $('#servico_id').append(`<option value="${s.id}">${s.nome}</option>`)
                );
            }
        });
    }

    carregarBarbeiros();
    carregarServicos();
});
