<?php
include_once('../lib/database.class.php');

class webServiceAreaAluno extends database {

	function entrarAreaAluno($parametros){
		try {
			$sql = "SELECT
					       UA.Login
					      ,UA.Id_Numero
					      ,UA.Senha
					      ,AL.Status
					      ,AL.Nome
					      ,AL.e_Mail
					FROM
					       usuario_aluno UA
					INNER JOIN aluno AL ON
					       AL.Id_Numero = UA.Id_Numero
					WHERE
					       UA.Login = ? 
					   AND UA.Senha = ?";
			$rs = $this->conectar()->prepare($sql);
			$count = $rs->execute(array($parametros['txtLogin']
	                                   ,$parametros['txtSenha']));
			
			if($count === false){
				
				$resposta['msgResposta'] = "E-mail / Login ou senha não cadastrada.";
				$resposta['caminho']     = "";
				$resposta['sucesso']     = false;
			}else{
				
				$registro = $rs->fetch(PDO::FETCH_OBJ) or die(print_r($query->errorInfo(), true));
				if(is_array($registro)){
					$registro = current($registro);
				}
				$resposta['dados']['nome']      = $registro->Nome;
				$resposta['dados']['id_numero'] = $registro->Id_Numero;
				$resposta['dados']['eMail']     = $registro->e_Mail ? $registro->e_Mail : 'E-mail não cadastrado.';

				$resposta['msgResposta'] = "Entrou";
				$resposta['caminho']     = "homeAreaAluno.html";
				$resposta['sucesso']     = true;
			}
			$this->desconectar();
			echo json_encode($resposta);
		} catch (Exception $e) {
			$resposta['msgResposta'] = $e->getMessage();
			$resposta['sucesso']     = false;
			$this->desconectar();
			echo json_encode($resposta);
		}
	}
	
}

$areaAluno = new webServiceAreaAluno();

switch($_REQUEST['idPagina']){
	case 1:
		$parametros['txtLogin'] = $_REQUEST['txtLogin'];
		$parametros['txtSenha'] = $_REQUEST['txtLogin'];
		$areaAluno->entrarAreaAluno($parametros);
		unset($parametros);
	break;
}