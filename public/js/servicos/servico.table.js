window.ServicoTable = (function () {

    let table;

    function init() {

        table = $('#mytable').DataTable({
            ajax: {
                url: ServicoAPI.get,
                dataSrc: json => json?.success ? json.ret : []
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
                    render: v => `<strong>R$ ${Number(v || 0).toFixed(2)}</strong>`
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
                    render: sit => {
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
                    render: row => {

                        const ativo = String(row.situacao).toLowerCase() === 'ativo';

                        const toggleClass = ativo
                            ? 'btn-outline-danger'
                            : 'btn-outline-success';

                        return `
                            <div class="table-action">
                                <button 
                                    class="btn btn-sm btn-primary btn-edit" 
                                    data-id="${row.id}">
                                    <i class="fa fa-pencil"></i>
                                </button>

                                <button 
                                    class="btn btn-sm ${toggleClass} btn-toggle"
                                    data-id="${row.id}"
                                    data-situacao="${ativo ? 1 : 2}">
                                    <i class="fa fa-power-off"></i>
                                </button>
                            </div>
                        `;
                    }
                }
            ]
        });

        bindEvents();
    }

    function bindEvents() {

        $('#mytable').on('click', '.btn-edit', function () {
            const row = table.row($(this).closest('tr')).data();
            if (row) ServicoForm.preencher(row);
        });

        $('#mytable').on('click', '.btn-toggle', function () {

            const id = $(this).data('id');
            const atual = Number($(this).data('situacao'));
            const novaSit = atual === 1 ? 2 : 1;

            const acao = novaSit === 1 ? 'Ativar' : 'Inativar';

            Swal.fire({
                title: 'Confirmação',
                text: `Deseja realmente ${acao.toLowerCase()} este serviço?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não'
            }).then(r => {
                if (r.isConfirmed) updateSituacao(id, novaSit);
            });
        });
    }

    function updateSituacao(id, situacao) {

        $.post(ServicoAPI.updateSituacao, { id, idsituacao: situacao }, resp => {

            if (resp?.success) {
                Swal.fire('Sucesso!', 'Situação atualizada!', 'success');
                table.ajax.reload(null, false);
            } else {
                Swal.fire('Erro!', resp?.message || 'Erro ao atualizar situação.', 'error');
            }

        }, 'json');
    }

    function reload() {
        table.ajax.reload();
    }

    return { init, reload };

})();
