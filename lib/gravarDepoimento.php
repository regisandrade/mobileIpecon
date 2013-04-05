<?php
session_start();
require_once('../../conexao.inc.php'); //== Conexão com o Banco de Dados

if($_REQUEST['txtDepoimento']){
	$gravar = "INSERT INTO depoimento (
				Aluno,
				Codg_Curso,
				Depoimento,
				Data,
				Status
			)VALUES(
				'".$_SESSION['id_numero']."',
				".$_SESSION['curso'].",
				'".$_POST['txtDepoimento']."',
				'".date('Y-m-d')."',
				0)";
	mysql_query($gravar) or die('Erro na gravação do Depoimento. '.mysql_error());
	$retorno['sucesso']  = true;
	$retorno['mensagem'] = "Depoimento enviado com sucesso!";
	echo json_encode($retorno);
	exit;
}else{
	$retorno['sucesso']  = false;
	$retorno['mensagem'] = "Digitar o depoimento!";
	echo json_encode($retorno);
	exit;
}
?>