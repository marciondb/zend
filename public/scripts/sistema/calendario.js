/**
 * @author Alexandre Magno
 *
 * Inicializacao do calendario com os parametros necessarios para
 * funcionar em datas no padrao portugues
 *
 */
var d=new Date();

 $(function(){
	$(".calendario").datepicker({
		dateFormat: 'dd/mm/yy',
		dayNames: [
			'Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'
		],
		dayNamesMin: [
			'D','S','T','Q','Q','S','S','D'
		],
		dayNamesShort: [
			'Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'
		],
		monthNames: [
			'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro',
			'Outubro','Novembro','Dezembro'
		],
		monthNamesShort: [
			'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',
			'Out','Nov','Dez'
		],
		nextText: 'Próximo',
		prevText: 'Anterior',
		changeMonth: true,
		changeYear: true,
		yearRange: '1910:'+d.getFullYear()

	});
	
 });
  
