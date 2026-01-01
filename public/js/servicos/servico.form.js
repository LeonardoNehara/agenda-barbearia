window.ServicoForm = (function () {

    function init() {
        limpar();
        $('#cadastro').on('click', salvar);
        $('#novo').on('click', limpar);
    }

    function salvar(e) {
        e.preventDefault();

        const id = $('#idServico').val();
        const dados = {
            nome: $('#nome').val().trim(),
            valor: $('#valor').val().replace(',', '.'),
            tempoMinutos: $('#tempoMinutos').val()
        };

        const erro = validar(dados);
        if (erro) {
            Swal.fire('Atenção!', erro, 'warning');
            return;
        }

        const url = id ? ServicoAPI.editar : ServicoAPI.cadastro;
        if (id) dados.id = id;

        $.post(url, dados, resp => {
            if (resp?.success) {
                Swal.fire('Sucesso!', 'Dados salvos.', 'success');
                ServicoTable.reload();
                limpar();
            } else {
                Swal.fire('Erro!', resp?.message || 'Erro.', 'error');
            }
        }, 'json');
    }

    function preencher(row) {
        $('#form-title').text('Editando Serviço').css('color', 'blue');
        $('#idServico').val(row.id);
        $('#nome').val(row.nome);
        $('#valor').val(row.valor);
        $('#tempoMinutos').val(row.tempoMinutos);
        $('#cadastro').text('Atualizar');
    }

    function limpar() {
        $('#form-title').text('Cadastrando Serviço').css('color', 'black');
        $('#idServico, #nome, #valor, #tempoMinutos').val('');
        $('#cadastro').text('Gravar');
    }

    function validar(d) {

        if (!d.nome || d.valor === '' || d.tempoMinutos === '') {
            return 'Nome, valor e tempo são obrigatórios.';
        }

        if (d.nome.length < 3 || d.nome.length > 100) {
            return 'O nome do serviço deve ter entre 3 e 100 caracteres.';
        }

        const regexNome = /^[a-zA-ZÀ-ÿ0-9\s]+$/u;
        if (!regexNome.test(d.nome)) {
            return 'O nome do serviço contém caracteres inválidos.';
        }

        const valor = Number(d.valor);
        if (isNaN(valor) || valor <= 0) {
            return 'O valor deve ser um número maior que zero.';
        }

        const tempo = Number(d.tempoMinutos);
        if (!Number.isInteger(tempo) || tempo <= 0) {
            return 'O tempo deve ser um número inteiro maior que zero.';
        }

        return null;
    }

    return { init, preencher, limpar };
})();
