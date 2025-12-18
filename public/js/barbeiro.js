$(document).ready(function () {
    const apiGet = base + '/getbarbeiros';
    const apiCadastro = base + '/cadbarbeiro';
    const apiEditar = base + '/editarbarbeiro';
    const apiUpdateSituacao = base + '/updateSituacaoBarbeiro';

    $('#telefone').mask('(00) 00000-0000', { placeholder: '(  ) _____-____' });

    const table = $('#mytable').DataTable({
        ajax: {
            url: apiGet,
            dataSrc: function(json) {
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
            { 
                data: 'nome', 
                title: 'Nome',
                render: function(data) { return `<strong>${data || ''}</strong>`; }
            },
            { 
                data: 'telefone', 
                title: 'Telefone',
                className: 'text-center',
                render: function(data) {
                    if (!data) return '';
                    const only = String(data).replace(/\D/g, '');
                    if (only.length === 10) return only.replace(/^(\d{2})(\d{4})(\d{4})$/, "($1) $2-$3");
                    if (only.length === 11) return only.replace(/^(\d{2})(\d{5})(\d{4})$/, "($1) $2-$3");
                    return data;
                }
            },
            {
                data: null,
                title: 'Status',
                className: 'text-center',
                render: function(data, type, row) {
                    let idsit = null;
                    if (row.idsituacao !== undefined && row.idsituacao !== null) {
                        idsit = Number(row.idsituacao);
                    } else if (row.situacao !== undefined && row.situacao !== null) {
                        const s = String(row.situacao).toLowerCase();
                        idsit = (s === 'ativo' || s === '1' || s === 'true') ? 1 : 2;
                    } else {
                        idsit = 2;
                    }

                    return idsit === 1
                        ? `<span class="badge-status ativo">Ativo</span>`
                        : `<span class="badge-status inativo">Inativo</span>`;
                }
            },
            {
                data: null,
                title: 'Ações',
                className: 'text-center',
                orderable: false,
                render: function(rowData) {
                    const id = rowData.id;
                    let situ = null;
                    if (rowData.idsituacao !== undefined && rowData.idsituacao !== null) {
                        situ = Number(rowData.idsituacao);
                    } else if (rowData.situacao !== undefined && rowData.situacao !== null) {
                        const s = String(rowData.situacao).toLowerCase();
                        situ = (s === 'ativo' || s === '1' || s === 'true') ? 1 : 2;
                    } else {
                        situ = 2;
                    }

                    const toggleClass = situ == 1 ? 'btn-outline-danger' : 'btn-outline-success';
                    return `
                        <div class="table-action">
                            <button class="btn btn-sm btn-primary btn-edit" data-id="${id}" title="Editar">
                                <i class="fa fa-pencil"></i>
                            </button>

                            <button class="btn btn-sm ${toggleClass} btn-toggle" data-id="${id}" data-situacao="${situ}" title="Ativar/Inativar">
                                <i class="fa fa-power-off"></i>
                            </button>
                        </div>`;
                }
            }
        ]
    });

    function limparForm() {
        $('#form-title').text('Cadastrando Barbeiro').css('color', 'black');
        $('#nome').val('');
        $('#telefone').val('');
        $('#id').val('');
        $('#cadastro').text('Gravar');
    }

    function validarTelefone(telefone) {
        const apenasNumeros = (telefone || '').replace(/\D/g, '');
        return apenasNumeros.length === 10 || apenasNumeros.length === 11;
    }

    function nomeValido(nome) {
        return /^[A-Za-zÀ-ÿ\s]+$/.test(nome);
    }

    function validarBarbeiro(dados) {
        const nome = (dados.nome || '').trim();
        const telefone = (dados.telefone || '').replace(/\D/g, '');

        if (!nome || !telefone) {
            return "Nome e telefone são obrigatórios.";
        }

        if (nome.length < 3 || nome.length > 100) {
            return "O nome deve ter entre 3 e 100 caracteres.";
        }

        if (!nomeValido(nome)) {
            return "O nome não pode conter números ou caracteres especiais.";
        }

        if (!validarTelefone(telefone)) {
            return "Telefone inválido! O número de telefone deve conter 11 dígitos (incluindo o DDD).";
        }

        return null;
    }
    $('#cadastro').on('click', function (e) {
        e.preventDefault();

        const id = $('#id').val();
        const dados = {
            nome: $('#nome').val().trim(),
            telefone: $('#telefone').val().replace(/[^\d]/g, '')
        };

        const erro = validarBarbeiro(dados);
        if (erro) {
            Swal.fire({
                icon: "warning",
                title: "Atenção!",
                text: erro
            });
            return;
        }

        if (!id) {
            $.post(apiCadastro, dados, function(resp) {
                if (resp && resp.success) {
                    Swal.fire({ icon: "success", title: "Sucesso!", text: "Cadastrado com sucesso!" });
                    table.ajax.reload();
                    limparForm();
                } else {
                    Swal.fire({ icon: "error", title: "Erro", text: resp?.message || JSON.stringify(resp?.ret || resp) });
                }
            }, 'json').fail(function(xhr){
                Swal.fire({ icon: "error", title: "Erro", text: xhr.responseJSON?.message || 'Erro na requisição' });
            });
        } else {
            const payload = { id: id, nome: dados.nome, telefone: dados.telefone };
            $.post(apiEditar, payload, function(resp) {
                if (resp && resp.success) {
                    Swal.fire({ icon: "success", title: "Sucesso!", text: "Editado com sucesso!" });
                    table.ajax.reload();
                    limparForm();
                } else {
                    Swal.fire({ icon: "error", title: "Erro", text: resp?.message || JSON.stringify(resp?.ret || resp) });
                }
            }, 'json').fail(function(xhr){
                Swal.fire({ icon: "error", title: "Erro", text: xhr.responseJSON?.message || 'Erro na requisição' });
            });
        }
    });

    $('#mytable').on('click', '.btn-edit', function (e) {
        e.preventDefault();
        const row = table.row($(this).closest('tr')).data();
        if (!row) return;
        setEditar(row);
        $('html, body').animate({ scrollTop: $(".form-container").offset().top }, 200);
    });

    function setEditar(row) {
        $('#form-title').text('Editando Barbeiro').css('color', 'blue');
        $('#id').val(row.id);
        $('#nome').val(row.nome || '');

        const telOnly = (row.telefone || '').replace(/\D/g, '');
        if (telOnly.length === 11) {
            $('#telefone').val(telOnly.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3'));
        } else if (telOnly.length === 10) {
            $('#telefone').val(telOnly.replace(/^(\d{2})(\d{4})(\d{4})$/, '($1) $2-$3'));
        } else {
            $('#telefone').val(row.telefone || '');
        }

        $('#cadastro').text('Atualizar');
    }

    $('#mytable').on('click', '.btn-toggle', function (e) {
        e.preventDefault();
        const $btn = $(this);
        const id = $btn.data('id');
        const atual = $btn.data('situacao');
        const novaSit = atual == 1 ? 2 : 1;
        const acao = novaSit == 1 ? 'Ativar' : 'Inativar';

        confirmUpdateSituacao(id, novaSit, atual, acao);
    });

    function updateSituacao(id, idsituacao) {
        $.post(apiUpdateSituacao, { id: id, idsituacao: idsituacao }, function(resp) {
            if (resp && resp.success) {
                Swal.fire({ icon: "success", title: "Sucesso!", text: "Situação atualizada!" });
                table.ajax.reload(null, false);
            } else {
                Swal.fire({ icon: "error", title: "Erro", text: resp?.message || JSON.stringify(resp?.ret || resp) });
            }
        }, 'json').fail(function(xhr){
            Swal.fire({ icon: "error", title: "Erro", text: xhr.responseJSON?.message || 'Erro na requisição' });
        });
    }

    function confirmUpdateSituacao(id, idsituacao, atualsituacao, acao) {
        if (String(idsituacao) === String(atualsituacao)) {
            const estado = idsituacao == 1 ? 'Ativo' : 'Inativo';
            Swal.fire({ icon: "warning", title: "Atenção!", text: `Barbeiro já está ${estado}` });
            return;
        }

        Swal.fire({
            title: 'Confirmação',
            text: `Você tem certeza que deseja ${acao.toLowerCase()} o Barbeiro?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                updateSituacao(id, idsituacao);
            }
        });
    }

    limparForm();
});
