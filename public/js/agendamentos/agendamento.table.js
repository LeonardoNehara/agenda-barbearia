$(document).ready(function () {

    const apiGet = base + '/getagendamentos';

    window.tableAgendamentos = $('#mytable').DataTable({
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
                render: data =>
                    data == 1
                        ? `<span class="badge-status ativo">Ativo</span>`
                        : `<span class="badge-status inativo">Cancelado</span>`
            },
            {
                data: null,
                title: 'Ações',
                className: 'text-center',
                orderable: false,
                render: () => `
                    <button class="btn btn-sm btn-edit">
                        <i class="fa fa-pencil"></i>
                    </button>
                `
            }
        ]
    });

});
