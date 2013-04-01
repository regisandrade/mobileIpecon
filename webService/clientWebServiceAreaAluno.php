<?php
# clientWebServiceAreaAluno.php
# Copyright (c) 2013 by Regis Andrade
#
# idPagina
# 1 - Entrar na área do aluno
# 2 - Listar os avisos
# 3 - Listar o cronograma da turma
# 4 - Listar as notas e frequências

include_once('webServiceAreaAluno.php');
$areaAluno = new webServiceAreaAluno();

switch($_REQUEST['idPagina']){
	case 1:
		$parametros['txtLogin'] = $_REQUEST['txtLogin'];
		$parametros['txtSenha'] = $_REQUEST['txtLogin'];
		$areaAluno->entrarAreaAluno($parametros);
		unset($parametros);
	break;

	case 2:
		$areaAluno->listarAvisos();
	break;

	case 3:
		$areaAluno->listarCronograma();
	break;

	case 4:
		$areaAluno->listarNotasFrequenciasAluno();
	break;
}