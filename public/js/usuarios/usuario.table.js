let tabelaUsuarios;

function initTabelaUsuarios() {

    tabelaUsuarios = $('#mytable').DataTable({
        ajax: {
            url: Usuario.api.get,
            dataSrc: json => json?.success ? json.ret : []
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
                render: d =>
                    d == 1
                        ? '<span class="badge-status ativo">Ativo</span>'
                        : '<span class="badge-status inativo">Inativo</span>'
            },
            {
                data: null,
                orderable: false,
                className: 'text-center',
                render: row => `
                    <button class="btn btn-sm btn btn-edit">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-toggle"
                        data-id="${row.id}" data-situacao="${row.idsituacao}">
                        <i class="fa fa-power-off"></i>
                    </button>
                `
            }
        ]
    });

    // editar
    $('#mytable').on('click', '.btn-edit', function () {
        const row = tabelaUsuarios.row($(this).closest('tr')).data();
        if (!row) return;

        $('#id').val(row.id);
        $('#nome').val(row.nome);
        $('#login').val(row.login);
        $('#senha').val('');
        $('#form-title').text('Editando Usuário #' + row.id);
        $('#cadastro').text('Atualizar');

        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    $('#mytable').on('click', '.btn-toggle', function () {
        const id = $(this).data('id');
        const atual = $(this).data('situacao');
        const nova = atual == 1 ? 2 : 1;

        const acao = nova == 1 ? 'ativar' : 'inativar';

        Swal.fire({
            title: 'Confirmação',
            text: `Deseja ${acao} o usuário?`,
            icon: 'warning',
            showCancelButton: true
        }).then(r => {
            if (!r.isConfirmed) return;

            $.post(Usuario.api.updateSituacao, {
                id, idsituacao: nova
            }, resp => {
                if (resp?.success) {
                    Usuario.alert('success', 'Sucesso', 'Situação atualizada');
                    tabelaUsuarios.ajax.reload(null, false);
                }
            }, 'json').fail(Usuario.erro);
        });
    });
}

$(function () {
    initTabelaUsuarios();
});
