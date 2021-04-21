$('.sidebar-menu li').removeClass('active');
$('#menu-produto').addClass('active');

$('[name=valor]').maskMoney({decimal: ',', thousands: '.', precision: 2});