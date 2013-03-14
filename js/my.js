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

function initialize(id) {
    var param = "idMateria="+id;
    $.ajax({
        type     : 'POST',
        dataType : 'JSON',
        url      : 'http://m.ipecon.com.br/webserviceGCInfo/webServiceGcInfo.php',
        data     : param,
        success  : function(retorno){
            $('#textoInfoCompleta').html(retorno.info_completa);
            //$('#textoEmpresa').html(retorno.info_completa);
        }
    });
}

function chamarPagina(id){
	window.location = "curso.php?idMateria="+id;
}