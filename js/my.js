// Put your custom code here
$(document).ready(function() {
	$('#btnEnviarEmail').live('click',function(){
		enviarEmail();
	});
});

function enviarEmail(){
	var dados = $('#formContato').serialize();

	$.ajax({
		type     : 'POST',
		dataType : 'JSON',
		url      : 'enviarEmail.php',
		data     : dados,
		success  : function(ret){
			if(ret.sucesso == 'true') {
				alert(ret.msg);
				history.back(-1);
			}else{
				alert(ret.msg);
			}
		}
	});
}