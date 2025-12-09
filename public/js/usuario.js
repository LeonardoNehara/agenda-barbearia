$(document).ready(function() {
    const apiGet = base + '/getusuarios';
    const apiCadastro = base + '/cadusuario';
    const apiEditar = base + '/editarusuario';
    const apiUpdateSituacao = base + '/updatesituacaousuario';

    const table = $('#mytable').DataTable({
        ajax: {
            url: apiGet,
            dataSrc: function(json) {
                if (!json || !json.success) {
                    return [];
                }
                return json.ret || [];
            }
        },
        responsive: true,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
        },
        columns: [
            { data: 'idusuario', title: 'ID', className: 'text-center', width: '6%' },
            { data: 'nome', title: 'Nome' },
            { data: 'login', title: 'Login', className: 'text-center' },
            { 
                data: 'idsituacao', 
                title: 'Situação',
                className: 'text-center',
                render: function(data) {
                    return data == 1 
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
                    const id = rowData.idusuario;
                    return `
                        <div class="table-action">
                            <button class="btn btn-sm btn-primary btn-edit" data-id="${id}">
                                <i class="fa fa-pencil"></i>
                            </button>

                            <button class="btn btn-sm ${rowData.idsituacao == 1 ? 'btn-outline-danger' : 'btn-outline-success'} btn-toggle"
                                data-id="${id}" data-situacao="${rowData.idsituacao}">
                                <i class="fa fa-power-off"></i>
                            </button>
                        </div>`;
                }
            }
        ]
    });

    window.limparForm = function() {
        $('#idusuario').val('');
        $('#nome').val('');
        $('#login').val('');
        $('#senha').val('');
        $('#form-title').text('Cadastrando Usuários');
        $('#cadastro').text('Gravar');
    };

    window.mostrarSenha = function() {
        const $s = $('#senha');
        $s.attr('type', $s.attr('type') === 'password' ? 'text' : 'password');
    };

    $('#cadastro').on('click', function(e) {
        e.preventDefault();

        const idusuario = $('#idusuario').val();
        const payload = {
            nome: $('#nome').val().trim(),
            login: $('#login').val().trim(),
            senha: $('#senha').val()
        };

        if (!payload.nome || !payload.login || (!payload.senha && !idusuario)) {
            Swal.fire({ icon: 'warning', title: 'Atenção', text: 'Preencha os campos obrigatórios' });
            return;
        }

        if (!idusuario) {
            $.post(apiCadastro, payload, function(resp) {
                if (resp && resp.success) {
                    Swal.fire({ icon: 'success', title: 'Salvo', text: 'Usuário cadastrado' });
                    table.ajax.reload();
                    limparForm();
                } else {
                    Swal.fire({ icon: 'error', title: 'Erro', text: resp.message || JSON.stringify(resp.ret || '') });
                }
            }, 'json').fail(function(xhr){
                Swal.fire({ icon: 'error', title: 'Erro', text: xhr.responseJSON?.message || 'Erro na requisição' });
            });

        } else {
            const data = { idusuario: idusuario, nome: payload.nome, login: payload.login };
            if (payload.senha) data.senha = payload.senha;

            $.post(apiEditar, data, function(resp) {
                if (resp && resp.success) {
                    Swal.fire({ icon: 'success', title: 'Atualizado', text: 'Usuário atualizado' });
                    table.ajax.reload();
                    limparForm();
                } else {
                    Swal.fire({ icon: 'error', title: 'Erro', text: resp.message || JSON.stringify(resp.result || resp.ret || '') });
                }
            }, 'json').fail(function(xhr){
                Swal.fire({ icon: 'error', title: 'Erro', text: xhr.responseJSON?.message || 'Erro na requisição' });
            });
        }
    });

    $('#mytable').on('click', '.btn-edit', function() {
        const row = table.row($(this).closest('tr')).data();
        if (!row) return;

        $('#idusuario').val(row.idusuario);
        $('#nome').val(row.nome);
        $('#login').val(row.login);
        $('#senha').val('');
        $('#form-title').text('Editando Usuário #' + row.idusuario);
        $('#cadastro').text('Atualizar');

        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    $('#mytable').on('click', '.btn-toggle', function() {
        const id = $(this).data('id');
        const atual = $(this).data('situacao');
        const novaSit = atual == 1 ? 2 : 1;

        $.post(apiUpdateSituacao, { idusuario: id, idsituacao: novaSit }, function(resp) {
            if (resp && resp.success) {
                Swal.fire({ icon: 'success', title: 'OK', text: 'Situação atualizada' });
                table.ajax.reload(null, false);
            } else {
                Swal.fire({ icon: 'error', title: 'Erro', text: resp.message || JSON.stringify(resp.ret || resp.result || '') });
            }
        }, 'json').fail(function(xhr){
            Swal.fire({ icon: 'error', title: 'Erro', text: xhr.responseJSON?.message || 'Erro na requisição' });
        });
    });

    limparForm();
});
