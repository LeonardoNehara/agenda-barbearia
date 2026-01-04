$(document).ready(function () {
    window.apiCadastro = base + '/cadbarbeiro';
    window.apiEditar   = base + '/editarbarbeiro';

    aplicarMascaraTelefone('#telefone');

    $('#cadastro').on('click', salvarBarbeiro);
    $('#mytable').on('click', '.btn-edit', editarBarbeiro);

    limparForm();
});

function limparForm() {
    $('#form-title').text('Cadastrando Barbeiro').css('color', 'black');
    $('#nome, #telefone, #id').val('');
    $('#cadastro').text('Gravar');
}

function salvarBarbeiro(e) {
    e.preventDefault();

    const id = $('#id').val();

    const dados = {
        nome: $('#nome').val().trim(),
        telefone: $('#telefone').val().replace(/\D/g, '')
    };

    const erro = validarBarbeiro(dados, !!id, id);
    if (erro) {
        Swal.fire("Atenção!", erro, "warning");
        return;
    }

    const url = id ? apiEditar : apiCadastro;
    const data = id ? { id, ...dados } : dados;

    $.post(url, data, resp => {

        if (resp?.success?.success === true) {
            Swal.fire("Sucesso!", "Operação realizada!", "success");
            tableBarbeiros.ajax.reload();
            limparForm();
            return;
        }

        Swal.fire(
            "Atenção!",
            resp?.success?.message || "Erro ao salvar",
            "warning"
        );

    }, 'json').fail(() => {
        Swal.fire("Erro", "Erro de comunicação com o servidor", "error");
    });
}

function editarBarbeiro() {
    const row = tableBarbeiros.row($(this).closest('tr')).data();
    if (!row) return;

    $('#form-title').text('Editando Barbeiro').css('color', 'blue');
    $('#id').val(row.id);
    $('#nome').val(row.nome);
    $('#telefone').val(formatTelefone(row.telefone));
    $('#cadastro').text('Atualizar');

    $('html, body').animate({ scrollTop: $(".form-container").offset().top }, 200);
}

function validarBarbeiro(dados, isEdicao = false, id = null) {

    if (isEdicao) {
        if (!id || isNaN(parseInt(id))) {
            return "ID inválido.";
        }
    }

    if (!dados.nome || !dados.telefone) {
        return "Nome e telefone são obrigatórios.";
    }

    if (dados.nome.length < 3 || dados.nome.length > 100) {
        return "O nome deve ter entre 3 e 100 caracteres.";
    }

    const nomeRegex = /^[A-Za-zÀ-ÿ\s]+$/;
    if (!nomeRegex.test(dados.nome)) {
        return "O nome não pode conter números ou caracteres especiais.";
    }

    if (![10, 11].includes(dados.telefone.length)) {
        return "Telefone inválido.";
    }

    return null;
}