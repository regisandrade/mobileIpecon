<?php
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

	break;
}