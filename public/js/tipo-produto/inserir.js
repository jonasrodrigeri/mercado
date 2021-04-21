$('.sidebar-menu li').removeClass('active');
$('#menu-tipo-produto').addClass('active');

$('[name=percentual_imposto]').maskMoney({decimal: ',', thousands: '.', precision: 2});