$('.sidebar-menu li').removeClass('active');
$('#menu-venda').addClass('active');

$('[name=quantidade]').maskMoney({decimal: ',', thousands: '.', precision: 0});

function limparLista() {

    if (!confirm("Deseja realmente limpar a lista de itens da venda?")) {
        return false;
    }

    window.location.href = '/venda/limpar';
}

function removerItem() {

    if (!confirm("Deseja realmente remover o ultimo item da venda?")) {
        return false;
    }

    window.location.href = '/venda/remover-item';
}

function finalizarVenda() {
    window.location.href = '/venda/finalizar';
}