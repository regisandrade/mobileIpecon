// Put your custom code here

// unblock when ajax activity stops 
$(document).ajaxStop($.unblockUI); 

$(document).ready(function(){
	// Enviar e-mail
	$('#btnEnviarEmail').click(function() {
		enviarEmail();
	});

	// Entrar na área do aluno
	$('#btnEntrarAreaAluno').click(function() {
		entrarAreaAluno();
	});
});

function loading(txt){
	$.blockUI({ 
		message: '<h2>'+txt+'</h2>',
		css: { 
            border: 'none', 
            padding: '10px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff',
            width: '50%'
        } });
}

function alertBlokUi(titulo,mensagem){
	$.blockUI({ 
            theme:     true, 
            title:    titulo, 
            message:  '<p>'+mensagem+'</p>', 
            timeout:   2500 
        });
}
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
	loading("Enviando...");
	$.ajax({
		type     : 'POST',
		dataType : 'JSON',
		url      : 'http://m.ipecon.com.br/contato/enviarEmail.php',
		data     : dados,
		success  : function(retorno){
			if(retorno.sucesso == 'true') {
				$('#txtEmail').val('');
				$('#txtAssunto').val('');
				$('#txtMensagem').val('');
				//alert(retorno.msg);
				//history.back(-1);
				alertBlokUi('Alerta',retorno.msg);
			}else{
				alertBlokUi('Alerta',retorno.msg);
			}
		}
	});
}

function initialize() {
    var param = "idMateria="+_GET('idMateria');
	loading("Carregando...");
    $.ajax({
        type     : 'POST',
        dataType : 'JSON',
        url      : 'http://m.ipecon.com.br/webService/webServiceGcInfo.php',
        data     : param,
        cache    : false,
        success  : function(retorno){
            $('#textoInfoCompleta').html(retorno.info_completa);
            //$('#textoEmpresa').html(retorno.info_completa);
        }
    });
}

function entrarAreaAluno(){
	var dados = $("#formLoginAreaAluno").serialize();
	loading("Entrando...");
    $.ajax({
        type     : 'POST',
        dataType : 'JSON',
        url      : 'http://m.ipecon.com.br/webService/clientWebServiceAreaAluno.php',
        data     : dados,
        cache    : false,
        success  : function(retorno){
            //console.log(retorno);
            if(retorno.sucesso){
            	window.location = retorno.caminho;
            }else{
            	alert('Erro na requisição');
            }
            return false;
        }
    });
}

function carregandoNotasFrequencia() {
    var param = "idPagina=4";
	loading("Carregando...");
    $.ajax({
        type     : 'POST',
        dataType : 'JSON',
        url      : 'http://m.ipecon.com.br/webService/clientWebServiceAreaAluno.php',
        data     : param,
        cache    : false,
        success  : function(retorno){
            console.log(retorno);            
            //var retorno;
            reTela = '<div class="ui-grid-c"><div class="ui-block-a larguraDisciplina">'
                    + '<strong>Disciplina</strong>'
                    + '</div>'
                    + '<div class="ui-block-b larguraNota">'
                    + '<strong>Nota</strong>'
                    + '</div>'
                    + '<div class="ui-block-c larguraFrequencia">'
                    + '<strong>Frequência</strong>'
                    + '</div>';
            $.each(retorno.valor, function(index, value) {
            	//alert(index + ': ' + value.disciplina);
				reTela += '<div class="ui-block-a larguraDisciplina">'
						+ '<i>'+value.disciplina+'</i>'
						+ '</div>'
						+ '<div class="ui-block-b larguraNota">'
						+ '<i>'+value.nota+'</i>'
						+ '</div>'
						+ '<div class="ui-block-c larguraFrequencia">'
						+ '<i>'+value.frequencia+'</i>'
						+ '</div>';
			});
			reTela += "</div>";
            $('#nomeTurma').after(reTela);
            $('.ui-collapsible .ui-btn-text').html("Turma: "+retorno.nomeTurma);
        }
    });
}

function carregandoCronograma() {
    var param = "idPagina=3";
	loading("Carregando...");
    $.ajax({
        type     : 'POST',
        dataType : 'JSON',
        url      : 'http://m.ipecon.com.br/webService/clientWebServiceAreaAluno.php',
        data     : param,
        cache    : false,
        success  : function(retorno){
            //var retorno;
            reTela = '<div data-role="collapsible-set">';
            $.each(retorno.valor, function(index, value) {
				reTela += '<div data-role="collapsible" data-theme="e">'
                        + '  <h3>' + value.disciplina + '</h3>'
                        + '  <div class="ui-grid-b">'
                        + '    <div class="ui-block-a">' + '[ ' + value.Data_01 + ' ]  [ ' + value.Data_02 + ' ] </div>'
                        + '    <div class="ui-block-b">' + '[ ' + value.Data_03 + ' ]  [ ' + value.Data_04 + ' ] </div>'
                        + '    <div class="ui-block-c">' + '[ ' + value.Data_05 + ' ]  [ ' + value.Data_06 + ' ] </div>'
                        + '  </div>'
                        + '</div>';
			});
			//reTela += "</div>";
            //console.log(reTela);
            $novo = "<div data-role=\"collapsible\" data-theme=\"e\"><h3>OPA</h3><p>rnrnrnrnrnrnrnrnrnrnrnrnrnrnrnrnrnrnrnrnrnrnr</p></div>";
            $('#meioCronograma').html($novo);
            //$('#nomeTurma').html("Turma: "+retorno.nomeTurma);
        }
    });
}

function carregandoAvisos() {
    var param = "idPagina=2";
	loading("Carregando...");
    $.ajax({
        type     : 'POST',
        dataType : 'JSON',
        url      : 'http://m.ipecon.com.br/webService/clientWebServiceAreaAluno.php',
        data     : param,
        cache    : false,
        success  : function(retorno){
            console.log(retorno);            
            //var retorno;
            //$('#tituloAviso').after(retorno.valor);
        }
    });
}