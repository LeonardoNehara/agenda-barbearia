$(document).ready(function () {
    window.apiGet = base + '/getbarbeiros';

    window.tableBarbeiros = $('#mytable').DataTable({
        ajax: {
            url: apiGet,
            dataSrc: json => (json && json.success ? json.ret : [])
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
                render: d => `<strong>${d || ''}</strong>`
            },
            {
                data: 'telefone',
                title: 'Telefone',
                className: 'text-center',
                render: formatTelefone
            },
            {
                data: null,
                title: 'Status',
                className: 'text-center',
                render: renderStatus
            },
            {
                data: null,
                title: 'Ações',
                className: 'text-center',
                orderable: false,
                render: renderAcoes
            }
        ]
    });
});

function formatTelefone(data) {
    if (!data) return '';
    const only = String(data).replace(/\D/g, '');
    if (only.length === 10) return only.replace(/^(\d{2})(\d{4})(\d{4})$/, "($1) $2-$3");
    if (only.length === 11) return only.replace(/^(\d{2})(\d{5})(\d{4})$/, "($1) $2-$3");
    return data;
}

function getSituacao(row) {
    if (row.idsituacao != null) return Number(row.idsituacao);
    if (row.situacao != null) {
        const s = String(row.situacao).toLowerCase();
        return (s === 'ativo' || s === '1' || s === 'true') ? 1 : 2;
    }
    return 2;
}

function renderStatus(_, __, row) {
    return getSituacao(row) === 1
        ? `<span class="badge-status ativo">Ativo</span>`
        : `<span class="badge-status inativo">Inativo</span>`;
}

function renderAcoes(row) {
    const situ = getSituacao(row);
    const toggleClass = situ === 1 ? 'btn-outline-danger' : 'btn-outline-success';

    return `
        <div class="table-action">
            <button class="btn btn-sm btn-primary btn-edit" data-id="${row.id}">
                <i class="fa fa-pencil"></i>
            </button>
            <button class="btn btn-sm ${toggleClass} btn-toggle"
                data-id="${row.id}"
                data-situacao="${situ}">
                <i class="fa fa-power-off"></i>
            </button>
        </div>
    `;
}
