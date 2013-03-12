// Put your custom code here
function enviarEmail(){
	var dados = $('#formContato').serialize();

	$.ajax({
		type   : 'POST',
		url    : 'enviarEmail.php',
		data   : dados,
		success: function(ret){
			if(ret.sucesso == true) {
				alert(ret.msg);
				history.back(-1);
			}else{
				alert(ret.msg);
			}
		}
	});
}