$('[name=quantidade]').maskMoney({decimal: ',', thousands: '.', precision: 0});

function limparLista() {
    window.location.href = '/venda/limpar';
}

function removerItem() {
    window.location.href = '/venda/remover-item';
}

function finalizarVenda() {
    window.location.href = '/venda/finalizar';
}