$(document).ready(function () {

    const apiCadastro = base + '/cadagendamento';
    const apiEditar   = base + '/editarAgendamento';

    aplicarMascaraTelefone('#telefone');

    window.limparForm = function () {
        $('#id').val('');
        $('#nome_completo').val('');
        $('#telefone').val('');
        $('#datahora').val('');
        $('#barbeiro_id').val('');
        $('#servico_id').val('');

        $('#form-title').text('Solicitar Agendamento');
        $('#cadastro').text('Gravar');
    };

    $('#cadastro').on('click', function (e) {
        e.preventDefault();

        const id = $('#id').val();

        const payload = {
            id: id || null,
            nome_completo: $('#nome_completo').val().trim(),
            telefone: $('#telefone').val().trim(),
            datahora: $('#datahora').val(),
            barbeiro_id: $('#barbeiro_id').val(),
            servico_id: $('#servico_id').val()
        };

        const erro = validarFormulario(payload, !!id);
        if (erro) {
            Swal.fire('Atenção', erro, 'warning');
            return;
        }

        console.log('Payload enviado:', payload);

        const url = id ? apiEditar : apiCadastro;

        $.post(url, payload, function (resp) {
            if (resp?.success) {
                Swal.fire('Sucesso', 'Operação realizada', 'success');
                window.tableAgendamentos.ajax.reload();
                limparForm();
            } else {
                Swal.fire('Erro', resp.ret || 'Erro ao salvar', 'error');
            }
        }, 'json');
    });

    $('#mytable').on('click', '.btn-edit', function () {
        const row = window.tableAgendamentos
            .row($(this).closest('tr'))
            .data();

        if (!row) return;

        $('#id').val(row.id);
        $('#nome_completo').val(row.cliente);
        $('#telefone').val(row.telefone);
        $('#datahora').val(row.datahora.replace(' ', 'T'));
        $('#barbeiro_id').val(row.barbeiro_id);
        $('#servico_id').val(row.servico_id);
        $('#form-title').text('Editando Agendamento #' + row.id);
        $('#cadastro').text('Atualizar');

        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    function validarFormulario(dados, isEdicao = false) {

        if (isEdicao && !dados.id) {
            return 'ID do agendamento é obrigatório para edição.';
        }

        if (!dados.nome_completo) {
            return 'Nome completo é obrigatório.';
        }

        if (dados.nome_completo.length < 3) {
            return 'Nome deve ter no mínimo 3 caracteres.';
        }

        if (!dados.telefone) {
            return 'Telefone é obrigatório.';
        }

        if (!dados.barbeiro_id) {
            return 'Selecione um barbeiro.';
        }

        if (!dados.servico_id) {
            return 'Selecione um serviço.';
        }

        if (!dados.datahora) {
            return 'Data e hora são obrigatórias.';
        }

        const dataSelecionada = new Date(dados.datahora);
        const agora = new Date();

        if (dataSelecionada < agora) {
            return 'Não é permitido agendar para uma data passada.';
        }

        return null;
    }

    limparForm();
});
