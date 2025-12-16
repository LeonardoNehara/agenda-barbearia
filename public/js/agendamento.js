$(document).ready(function () {

    const apiGet = base + '/getagendamentos';
    const apiCadastro = base + '/cadagendamento';
    const apiEditar = base + '/editarAgendamento';
    const apiUpdateSituacao = base + '/updateSituacaoAgendamento';

    const table = $('#mytable').DataTable({
        ajax: {
            url: apiGet,
            dataSrc: function (json) {
                if (!json || !json.success) return [];
                return json.ret || [];
            }
        },
        responsive: true,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
        },
        columns: [
            { data: 'id', title: 'ID', className: 'text-center', width: '5%' },
            { data: 'cliente', title: 'Cliente' },
            { data: 'telefone', title: 'Telefone', className: 'text-center' },
            { data: 'datahora', title: 'Data/Hora', className: 'text-center' },
            { data: 'barbeiro', title: 'Barbeiro' },
            { data: 'servico', title: 'Serviço' },
            {
                data: 'situacao',
                title: 'Situação',
                className: 'text-center',
                render: function (data) {
                    return data == 1
                        ? `<span class="badge-status ativo">Ativo</span>`
                        : `<span class="badge-status inativo">Cancelado</span>`;
                }
            },
            {
                data: null,
                title: 'Ações',
                className: 'text-center',
                orderable: false,
                render: function () {
                    return `
                        <button class="btn btn-sm btn-edit">
                            <i class="fa fa-pencil"></i>
                        </button>
                    `;
                }
            }
        ]
    });

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
            nome_completo: $('#nome_completo').val().trim(),
            telefone: $('#telefone').val().trim(),
            datahora: $('#datahora').val(),
            barbeiro_id: $('#barbeiro_id').val(),
            servico_id: $('#servico_id').val()
        };

        if (
            !payload.nome_completo ||
            !payload.telefone ||
            !payload.datahora ||
            !payload.barbeiro_id ||
            !payload.servico_id
        ) {
            Swal.fire({
                icon: 'warning',
                title: 'Atenção',
                text: 'Preencha todos os campos obrigatórios'
            });
            return;
        }

        if (!id) {
            $.post(apiCadastro, payload, function (resp) {
                if (resp && resp.success) {
                    Swal.fire('Sucesso', 'Agendamento realizado', 'success');
                    table.ajax.reload();
                    limparForm();
                } else {
                    Swal.fire('Erro', resp.message || 'Erro ao salvar', 'error');
                }
            }, 'json');

        } else {
            payload.id = id;

            $.post(apiEditar, payload, function (resp) {
                if (resp && resp.success) {
                    Swal.fire('Atualizado', 'Agendamento atualizado', 'success');
                    table.ajax.reload();
                    limparForm();
                } else {
                    Swal.fire('Erro', resp.message || 'Erro ao atualizar', 'error');
                }
            }, 'json');
        }
    });

    $('#mytable').on('click', '.btn-edit', function () {
        const row = table.row($(this).closest('tr')).data();
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

    $('#mytable').on('click', '.btn-toggle', function () {
        const id = $(this).data('id');
        const situacaoAtual = $(this).data('situacao');
        const novaSituacao = situacaoAtual == 1 ? 2 : 1;

        $.post(apiUpdateSituacao, {
            id: id,
            situacao: novaSituacao
        }, function (resp) {
            if (resp && resp.success) {
                Swal.fire('OK', 'Situação atualizada', 'success');
                table.ajax.reload(null, false);
            } else {
                Swal.fire('Erro', resp.message || 'Erro ao atualizar situação', 'error');
            }
        }, 'json');
    });

    limparForm();
});

$(document).ready(function () {

    const apiBarbeiros = base + '/getbarbeirosativos';

    $.ajax({
        url: apiBarbeiros,
        type: 'GET',
        dataType: 'json',
        success: function (response) {

            if (response.success && response.success.ret) {

                const barbeiros = response.success.ret;

                $('#barbeiro_id').html(
                    '<option value="">Selecione o Barbeiro</option>'
                );

                barbeiros.forEach(function (barbeiro) {
                    $('#barbeiro_id').append(
                        `<option value="${barbeiro.id}">
                            ${barbeiro.nome}
                        </option>`
                    );
                });
            }
        },
        error: function () {
            alert('Erro ao carregar barbeiros');
        }
    });

});

$(document).ready(function () {

    const apiServicos = base + '/getservicosativos';
    
    $.ajax({
        url: apiServicos,
        type: 'GET',
        dataType: 'json',
        success: function (response) {

            if (response.success && response.success.ret) {

                const servicos = response.success.ret;

                $('#servico_id').html(
                    '<option value="">Selecione o Serviço</option>'
                );

                servicos.forEach(function (servico) {
                    $('#servico_id').append(
                        `<option value="${servico.id}">
                            ${servico.nome}
                        </option>`
                    );
                });
            }
        },
        error: function () {
            alert('Erro ao carregar serviços');
        }
    });

});
