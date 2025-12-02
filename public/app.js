window.app = {
    validarCNPJ(cnpj) {
        cnpj = cnpj.replace(/[^\d]/g, '');
        return cnpj.length != 14 ? false : true
    },

    validarCampos_old(obj) {
        if (typeof obj !== 'object' || obj === null) {
            throw new Error('O argumento deve ser um objeto.');
        }

        for (const key in obj) {
            if (obj.hasOwnProperty(key)) {
                const valor = obj[key];
                if (valor === undefined || valor === null || valor === '' || (typeof valor === 'string' && valor.trim() === '')) {
                    return false
                }
            }
        }
        return true;
    },
    callController : function (config) {
        $.ajax({
            url : config.url,
            data : config.params,
            autoAbort : false,
            disableCaching : false,
            timeout : 180000000,
            type : config.method,
            success : function (a, b, c) {
                var tmp = JSON.parse(a);
                if (tmp[0].success == true) {
                    if (typeof config.onSuccess == 'function') {
                        config.onSuccess(tmp);
                    }
                } else {
                    if (typeof config.onFailure == 'function') {
                        config.onFailure(tmp);
                    }
                }
            }
        });
    },

    validarCampos(obj) {
        if (typeof obj !== 'object' || obj === null) {
            throw new Error('O argumento deve ser um objeto.');
        }
    
        let valido = true;
    
        for (const key in obj) {
            if (obj.hasOwnProperty(key)) {
                const valor = obj[key];
                const campo = $('#' + key);
    
                campo.removeClass('erro');
    
                if (valor === undefined || valor === null || valor === '' || (typeof valor === 'string' && valor.trim() === '')) {
                    valido = false;
                    campo.addClass('erro');
                }
            }
        }
    
        return valido;
    }
}