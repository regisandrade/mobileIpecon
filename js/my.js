// Put your custom code here
$(document).ready(function(){
	$('#btnEnviarEmail').click( function() {
		enviarEmail();
	});
});

/**
 * Created by: http://gustavopaes.net
 * Created on: Nov/2009
 * 
 * Retorna os valores de parâmetros passados via url.
 *
 * @param String Nome da parâmetro.
 */
function _GET(name)
{
	var url   = window.location.search.replace("?", "");
	var itens = url.split("&");

	for(n in itens){
		if( itens[n].match(name) ){
			return decodeURIComponent(itens[n].replace(name+"=", ""));
		}
	}
	return null;
}

function enviarEmail(){
	var dados = $('#formContato').serialize();

	$.ajax({
		type     : 'POST',
		dataType : 'JSON',
		url      : 'http://www.m.ipecon.com.br/enviarEmail.php',
		data     : dados,
		success  : function(retorno){
			console.log(retorno);
			if(retorno.sucesso == 'true') {
				alert(retorno.msg);
				$('txtEmail').val() = "";
				$('txtAssunto').val() = "";
				$('txtMensagem').val() = "";
				history.back(-1);
			}else{
				alert(retorno.msg);
			}
		}
	});
}

function initialize() {
    var param = "idMateria="+_GET('idMateria');
    $.ajax({
        type     : 'POST',
        dataType : 'JSON',
        url      : 'http://www.m.ipecon.com.br/webserviceGCInfo/webServiceGcInfo.php',
        data     : param,
        success  : function(retorno){
            $('#textoInfoCompleta').html(retorno.info_completa);
            //$('#textoEmpresa').html(retorno.info_completa);
        }
    });
}