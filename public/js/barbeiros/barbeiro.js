$(document).ready(function () {
    window.apiUpdateSituacao = base + '/updateSituacaoBarbeiro';
    $('#mytable').on('click', '.btn-toggle', toggleSituacao);
});

function toggleSituacao(e) {
    e.preventDefault();

    const id = $(this).data('id');
    const atual = $(this).data('situacao');
    const nova = atual === 1 ? 2 : 1;

    Swal.fire({
        title: 'Confirmação',
        text: `Deseja ${nova === 1 ? 'ativar' : 'inativar'} o barbeiro?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then(res => {
        if (res.isConfirmed) {
            atualizarSituacao(id, nova);
        }
    });
}

function atualizarSituacao(id, situacao) {
    $.post(apiUpdateSituacao, { id, idsituacao: situacao }, resp => {
        if (resp?.success) {
            Swal.fire("Sucesso!", "Situação atualizada!", "success");
            tableBarbeiros.ajax.reload(null, false);
        } else {
            Swal.fire("Erro", resp?.message || "Erro ao atualizar", "error");
        }
    }, 'json');
}
