const Usuario = {
    api: {
        get: base + '/getusuarios',
        cadastrar: base + '/cadusuario',
        editar: base + '/editarusuario',
        updateSituacao: base + '/updatesituacaousuario'
    },

    alert(tipo, titulo, msg) {
        Swal.fire({ icon: tipo, title: titulo, text: msg });
    },

    erro(xhr) {
        this.alert(
            'error',
            'Erro',
            xhr.responseJSON?.message || 'Erro na requisição'
        );
    }
};
