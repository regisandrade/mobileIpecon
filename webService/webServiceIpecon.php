<?php
/**
* WebService para conceção e busca de dados ao servidor IPECON
* @return Json
*/

/** CLASSE DE CONEXAO E OUTRAS FUNCIONALIDADES **/
require_once('../lib/BDMySQL.class.php');
$conexao = new BDMySQL();
$conexao->conectar();

/** CLASSE DE NEGOCIO E PERSISTENCIA IPECON **/
require_once("../lib/ipecon.class.php");
$ipecon = new Ipecon();

switch ($_POST['topico']) {
	case 'curso':
		$ipecon->listarConteudoCurso($_POST['id']);
		$retorno = $conexao->retornaArray();
		$dados = array('curso' => $retorno['codg_curso_descricao'],
					   'apresentacao'  => nl2br(utf8_encode($retorno['apresentacao'])),
					   'publico'  => nl2br(utf8_encode($retorno['publico'])),
					   'datas'  => nl2br(utf8_encode($retorno['datas'])),
					   'inscricao'  => nl2br(utf8_encode($retorno['inscricao'])),
					   'avaliacao'  => nl2br(utf8_encode($retorno['avaliacao'])),
					   'disciplinas'  => nl2br(utf8_encode($retorno['disciplinas'])),
					   'metodologia'  => nl2br(utf8_encode($retorno['metodologia'])),
					   'certificados'  => nl2br(utf8_encode($retorno['certificados'])),
					   'duracao'  => nl2br(utf8_encode($retorno['duracao'])),
					   'numeroVagas'  => nl2br(utf8_encode($retorno['numeroVagas'])),
					   'coordenacaogeral'  => nl2br(utf8_encode($retorno['coordenacaogeral'])),
					   'coordenacaoacademica'  => nl2br(utf8_encode($retorno['coordenacaoacademica'])),
					   'horario'  => nl2br(utf8_encode($retorno['horario'])),
					   'processo'  => nl2br(utf8_encode($retorno['processo'])),
					   'corpoDocente'  => nl2br(utf8_encode($retorno['corpoDocente'])),
					   'informacoes'  => nl2br(utf8_encode($retorno['informacoes'])),
					   );
		break;

	case 'empresa':
		$ipecon->listarConteudoEmpresa($_POST['id']);
		$retorno = $conexao->retornaArray();
		$dados = array('titulo' => $retorno['titulo'],
					   'texto'  => nl2br(utf8_encode($retorno['texto']))
					   );
		break;
}
#echo "<pre>"; print_r($dados); echo "</pre>";
$dadosJson = json_encode($dados);
#echo "<pre>"; print_r(json_decode($dados)); echo "</pre>";
echo $dadosJson;
?>