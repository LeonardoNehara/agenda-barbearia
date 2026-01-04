function aplicarMascaraTelefone(selector) {
    $(selector).mask('(00) 00000-0000', {
        placeholder: '(  ) _____-____',
        onKeyPress: function (val, e, field, options) {
            const numbers = val.replace(/\D/g, '');

            const mask = numbers.length > 10
                ? '(00) 00000-0000'
                : '(00) 0000-00009';

            field.mask(mask, options);
        }
    });
}

function normalizarTelefone(valor) {
    return String(valor || '').replace(/\D/g, '');
}

function validarTelefone(telefone) {
    return [10, 11].includes(telefone.length);
}
