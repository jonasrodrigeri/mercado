$('.sidebar-menu li').removeClass('active');
$('#menu-tipo-produto').addClass('active');

function excluir(id) {

    if (!confirm("Deseja realmente remover este tipo de produto?")) {
        return false;
    }

    window.location.href = '/tipo-produto/exclui/' + id;
}