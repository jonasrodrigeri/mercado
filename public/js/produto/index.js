$('.sidebar-menu li').removeClass('active');
$('#menu-produto').addClass('active');

function excluir(id) {

    if (!confirm("Deseja realmente remover este produto?")) {
        return false;
    }

    window.location.href = '/produto/exclui/' + id;
}