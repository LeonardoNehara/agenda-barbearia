$(document).ready(function () {

    const apiGet = base + '/getservicos';
    const apiCadastro = base + '/cadservico';
    const apiEditar = base + '/editarservico';
    const apiUpdateSituacao = base + '/updateSituacaoServico';

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
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
        },
        columns: [
            { data: 'id', title: 'ID', className: 'text-center', width: '6%' },

            { data: 'nome', title: 'Nome' },

            {
                data: 'valor',
                title: 'Valor (R$)',
                className: 'text-center',
                render: function (v) {
                    v = Number(v || 0).toFixed(2);
                    return `<strong>R$ ${v}</strong>`;
                }
            },

            {
                data: 'tempoMinutos',
                title: 'Tempo (min)',
                className: 'text-center'
            },

            {
                data: 'situacao',
                title: 'Status',
                className: 'text-center',
                render: function (sit) {
                    sit = String(sit).toLowerCase();
                    return sit === 'ativo'
                        ? `<span class="badge-status ativo">Ativo</span>`
                        : `<span class="badge-status inativo">Inativo</span>`;
                }
            },

            {
                data: null,
                title: 'Ações',
                className: 'text-center',
                orderable: false,
                render: function (row) {

                    const id = row.id;
                    const ativo = String(row.situacao).toLowerCase() === 'ativo';

                    const toggleClass = ativo
                        ? 'btn-outline-danger'
                        : 'btn-outline-success';

                    return `
                        <div class="table-action">
                            <button class="btn btn-sm btn-primary btn-edit" data-id="${id}">
                                <i class="fa fa-pencil"></i>
                            </button>

                            <button class="btn btn-sm ${toggleClass} btn-toggle" 
                                data-id="${id}" 
                                data-situacao="${ativo ? 1 : 2}">
                                <i class="fa fa-power-off"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ]
    });

    function limparForm() {
        $('#form-title').text('Cadastrando Serviço').css('color', 'black');
        $('#idServico').val('');
        $('#nome').val('');
        $('#valor').val('');
        $('#tempoMinutos').val('');
        $('#cadastro').text('Gravar');
    }

    $('#cadastro').on('click', function (e) {
        e.preventDefault();

        const id = $('#idServico').val();

        const dados = {
            nome: $('#nome').val().trim(),
            valor: $('#valor').val().replace(',', '.'),
            tempoMinutos: $('#tempoMinutos').val()
        };

        if (!dados.nome || !dados.valor || !dados.tempoMinutos) {
            Swal.fire({ icon: "warning", title: "Atenção!", text: "Preencha todos os campos." });
            return;
        }

        if (Number(dados.valor) <= 0) {
            Swal.fire({ icon: "warning", title: "Atenção!", text: "O valor deve ser maior que zero." });
            return;
        }

        if (Number(dados.tempoMinutos) <= 0) {
            Swal.fire({ icon: "warning", title: "Atenção!", text: "O tempo deve ser maior que zero." });
            return;
        }

        if (!id) {
            $.post(apiCadastro, dados, function (resp) {
                if (resp && resp.success) {
                    Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Serviço cadastrado!' });
                    table.ajax.reload();
                    limparForm();
                } else {
                    Swal.fire({ icon: 'error', title: 'Erro', text: resp?.message || 'Erro ao salvar.' });
                }
            }, 'json');
        } else {
            dados.id = id;

            $.post(apiEditar, dados, function (resp) {
                if (resp && resp.success) {
                    Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Serviço atualizado!' });
                    table.ajax.reload();
                    limparForm();
                } else {
                    Swal.fire({ icon: 'error', title: 'Erro', text: resp?.message || 'Erro ao atualizar.' });
                }
            }, 'json');
        }
    });

    $('#mytable').on('click', '.btn-edit', function () {

        const row = table.row($(this).closest('tr')).data();
        if (!row) return;

        $('#form-title').text('Editando Serviço').css('color', 'blue');

        $('#idServico').val(row.id);
        $('#nome').val(row.nome);
        $('#valor').val(row.valor);
        $('#tempoMinutos').val(row.tempoMinutos);

        $('#cadastro').text('Atualizar');

        $('html, body').animate({ scrollTop: $(".form-container").first().offset().top }, 200);
    });

    $('#mytable').on('click', '.btn-toggle', function () {

        const id = $(this).data('id');
        const atual = Number($(this).data('situacao')); // 1 ativo, 2 inativo
        const novaSit = atual === 1 ? 2 : 1;

        const acao = novaSit === 1 ? 'Ativar' : 'Inativar';

        Swal.fire({
            title: 'Confirmação',
            text: `Deseja realmente ${acao.toLowerCase()} este serviço?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não'
        }).then(result => {
            if (result.isConfirmed) updateSituacao(id, novaSit);
        });
    });

    function updateSituacao(id, situacao) {

        $.post(apiUpdateSituacao, { id: id, idsituacao: situacao }, function (resp) {

            if (resp && resp.success) {
                Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Situação atualizada!' });
                table.ajax.reload(null, false);
            } else {
                Swal.fire({ icon: 'error', title: 'Erro!', text: resp?.message || 'Erro ao atualizar situação.' });
            }

        }, 'json');
    }

    limparForm();
});
