function validarUsuario(dados, edicao = false) {

    const nome  = dados.nome?.trim();
    const login = dados.login?.trim();
    const senha = dados.senha;

    if (!nome || !login) {
        return 'Campos obrigatórios ausentes.';
    }

    if (nome.length < 3 || nome.length > 100) {
        return 'Nome inválido.';
    }

    if (!/^[a-zA-Z0-9._]+$/.test(login)) {
        return 'Login inválido.';
    }

    if (!edicao) {
        if (!senha) {
            return 'Senha é obrigatória.';
        }

        if (senha.length < 8) {
            return 'Senha deve ter no mínimo 8 caracteres.';
        }
    }

    if (edicao && senha && senha.length < 8) {
        return 'Senha deve ter no mínimo 8 caracteres.';
    }

    return null;
}

function mostrarSenha() {
    const input = document.getElementById('senha');
    input.type = input.type === 'password' ? 'text' : 'password';
}

$(function () {

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
            Usuario.alert('warning', 'Validação', erro);
            return;
        }

        const url = id ? Usuario.api.editar : Usuario.api.cadastrar;
        const data = id ? { id, ...payload } : payload;

        $.post(url, data, resp => {

            if (resp?.success?.success === true) {
                Usuario.alert('success', 'Sucesso', 'Dados salvos');
                tabelaUsuarios.ajax.reload();
                limparForm();
                return;
            }

            Usuario.alert(
                'warning',
                'Atenção',
                resp?.success?.message || 'Erro ao salvar usuário.'
            );

        }, 'json').fail(Usuario.erro);
    });
});

function limparForm() {
    $('#nome').val('');
    $('#login').val('');
    $('#senha').val('');
    $('#id').val('');

    $('#form-title').text('Cadastrando Usuários');
    $('#cadastro').text('Gravar');
}