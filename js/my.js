// Put your custom code here

// unblock when ajax activity stops 
$(document).ajaxStop($.unblockUI); 

$(document).ready(function(){
	// Enviar e-mail
	$('#btnEnviarEmail').click(function() {
		enviarEmail();
	});

	$.blockUI({ message: '<h2><img src="../imagens/ajax-loader.gif" /><br>Carregando...</h2>' });
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

/* Modelo de Dialog para mobile */
function alertaMobile(seletor,msg){
	$("#dialogModal").remove();
	var $divDialog = "<div role=\"dialog\" class=\"ui-dialog-contain ui-corner-all ui-overlay-shadow\" id=\"dialogModal\">"
					+"	<div data-role=\"header\" data-theme=\"d\" class=\"ui-corner-top ui-header ui-bar-d\" role=\"banner\">"
					+"		<a href=\"#\" data-icon=\"delete\" data-iconpos=\"notext\" class=\"ui-btn-left ui-btn ui-btn-up-d ui-shadow ui-btn-corner-all ui-btn-icon-notext\" data-corners=\"true\" data-shadow=\"true\" data-iconshadow=\"true\" data-wrapperels=\"span\" data-theme=\"d\" title=\"Fechar\">"
					+"			<span class=\"ui-btn-inner ui-btn-corner-all\">"
					+"				<span class=\"ui-btn-text\">Fechar</span>"
					+"				<span class=\"ui-icon ui-icon-delete ui-icon-shadow\">&nbsp;</span>"
					+"			</span>"
					+"		</a>"
					+"		<h1 class=\"ui-title\" role=\"heading\" aria-level=\"1\">Atenção</h1>"
					+"	</div>"
					+"	<div data-role=\"content\" data-theme=\"c\" class=\"ui-corner-bottom ui-content ui-body-c\" role=\"main\">"
					+msg+
					+"		<a href=\"contato.html\" data-role=\"button\" data-rel=\"back\" data-theme=\"c\" data-corners=\"true\" data-shadow=\"true\" data-iconshadow=\"true\" data-wrapperels=\"span\" class=\"ui-btn ui-shadow ui-btn-corner-all ui-btn-up-c\">"
					+"			<span class=\"ui-btn-inner ui-btn-corner-all\">"
					+"				<span class=\"ui-btn-text\">Cancel</span>"
					+"			</span>"
					+"		</a>"
					+"	</div>"
					+"</div>";
	$(seletor).appendTo($divDialog);
	
}

function enviarEmail(){
	var dados = $('#formContato').serialize();
	$.ajax({
		type     : 'POST',
		dataType : 'JSON',
		url      : 'http://m.ipecon.com.br/contato/enviarEmail.php',
		data     : dados,
		success  : function(retorno){
			if(retorno.sucesso == 'true') {
				$('txtEmail').val('');
				$('txtAssunto').val('');
				$('txtMensagem').val('');
				//history.back(-1);
				alertaMobile('#pageContato',retorno.msg);
			}else{
				alertaMobile('#pageContato',retorno.msg);
			}
		}
	});
}

function initialize() {
    var param = "idMateria="+_GET('idMateria');
    $.ajax({
        type     : 'POST',
        dataType : 'JSON',
        url      : 'http://m.ipecon.com.br/webserviceGCInfo/webServiceGcInfo.php',
        data     : param,
        cache    : false,
        success  : function(retorno){
            $('#textoInfoCompleta').html(retorno.info_completa);
            //$('#textoEmpresa').html(retorno.info_completa);
        }
    });
}
