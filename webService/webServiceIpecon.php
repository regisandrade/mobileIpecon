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