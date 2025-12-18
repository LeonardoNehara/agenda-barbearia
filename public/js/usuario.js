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
            { data: 'id', title: 'ID', className: 'text-center', width: '6%' },
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
                    const id = rowData.id;
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
        $('#id').val('');
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

    $('#cadastro').on('click', function (e) {
        e.preventDefault();

        const id = $('#id').val();

        const payload = {
            nome: $('#nome').val().trim(),
            login: $('#login').val().trim(),
            senha: $('#senha').val()
        };

         const erro = validarUsuario(payload, !!id);

        if (erro) {
            Swal.fire({
                icon: 'warning',
                title: 'Validação',
                text: erro
            });
            return;
        }

        if (!id) {
            $.post(apiCadastro, payload, function (resp) {
                if (resp && resp.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Salvo',
                        text: 'Usuário cadastrado com sucesso'
                    });

                    table.ajax.reload();
                    limparForm();
                }
            }, 'json').fail(tratarErro);

        } else {
            const data = {
                id: id,
                nome: payload.nome,
                login: payload.login
            };

            if (payload.senha) {
                data.senha = payload.senha;
            }

            $.post(apiEditar, data, function (resp) {
                if (resp && resp.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Atualizado',
                        text: 'Usuário atualizado com sucesso'
                    });

                    table.ajax.reload();
                    limparForm();
                }
            }, 'json').fail(tratarErro);
        }
    });

    $('#mytable').on('click', '.btn-edit', function() {
        const row = table.row($(this).closest('tr')).data();
        if (!row) return;

        $('#id').val(row.id);
        $('#nome').val(row.nome);
        $('#login').val(row.login);
        $('#senha').val('');
        $('#form-title').text('Editando Usuário #' + row.id);
        $('#cadastro').text('Atualizar');

        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    $('#mytable').on('click', '.btn-toggle', function() {
        const id = $(this).data('id');
        const atual = $(this).data('situacao');
        const novaSit = atual == 1 ? 2 : 1;

        confirmUpdateSituacaoUsuario(id, novaSit, atual);
    });

    limparForm();

    function validarUsuario(dados, isEdicao = false) {

        const nome  = (dados.nome || '').trim();
        const login = (dados.login || '').trim();
        const senha = dados.senha || null;

        if (!nome || !login) {
            return 'Campos obrigatórios ausentes.';
        }

        if (nome.length < 3 || nome.length > 100) {
            return 'Nome inválido.';
        }

        const loginRegex = /^[a-zA-Z0-9._]+$/;
        if (!loginRegex.test(login)) {
            return 'Login inválido.';
        }

        if (!isEdicao) {
            if (!senha) {
                return 'Senha é obrigatória.';
            }

            if (senha.length < 8) {
                return 'Senha deve ter no mínimo 8 caracteres.';
            }
        }

        if (isEdicao && senha && senha.length < 8) {
            return 'Senha deve ter no mínimo 8 caracteres.';
        }

        return null;
    }

    function updateSituacaoUsuario(id, idsituacao) {
        $.post(apiUpdateSituacao, {
            id: id,
            idsituacao: idsituacao
        }, function (resp) {
            if (resp && resp.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Situação atualizada!'
                });
                table.ajax.reload(null, false);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: resp?.message || JSON.stringify(resp?.ret || resp)
                });
            }
        }, 'json').fail(function (xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: xhr.responseJSON?.message || 'Erro na requisição'
            });
        });
    }

    function confirmUpdateSituacaoUsuario(id, idsituacao, atualsituacao) {
        if (String(idsituacao) === String(atualsituacao)) {
            const estado = idsituacao == 1 ? 'Ativo' : 'Inativo';
            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: `Usuário já está ${estado}`
            });
            return;
        }

        const acao = idsituacao == 1 ? 'ativar' : 'inativar';

        Swal.fire({
            title: 'Confirmação',
            text: `Você tem certeza que deseja ${acao} o usuário?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                updateSituacaoUsuario(id, idsituacao);
            }
        });
    }
    
    function tratarErro(xhr) {
    let msg = 'Erro na requisição';

    if (xhr.responseJSON?.message) {
        msg = xhr.responseJSON.message;
    }

    Swal.fire({
        icon: 'error',
        title: 'Erro',
        text: msg
    });
}
});
