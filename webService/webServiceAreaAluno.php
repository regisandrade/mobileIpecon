<?php
session_start();

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

				// Buscar as turmas do aluno
				$sql   = "SELECT Turma FROM alunos_academicos WHERE Aluno = ? GROUP BY Turma ORDER BY Ano";
				$rs    = $this->conectar()->prepare($sql);
				$count = $rs->execute(array($registro->Id_Numero));
				$arrTurmas = array();
				while ($registro = $rs->fetch(PDO::FETCH_OBJ)) {
					$arrTurmas = $registro->Turma;
				}

				// Sessão
				$_SESSION['NOME'] = $resposta['dados']['nome'];
				$_SESSION['ID_NUMERO_ALUNO'] = $resposta['dados']['id_numero'];
				$_SESSION['EMAIL'] = $registro->e_Mail ? $registro->e_Mail : 'E-mail não cadastrado.';
				$_SESSION['TURMAS'] = $arrTurmas;
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

	function listarNotasFrequenciasAluno(){
		try {
			$sql = "SELECT
					       CONCAT(TUR.TURMA,' - ',TUR.NOME) AS NomeTurma
					      ,DIS.Nome AS NomeDisciplina
					      ,AC.Nota
					      ,AC.Frequencia
					FROM
					       alunos_academicos AC
					INNER JOIN disciplina    DIS ON
					       DIS.Codg_Disciplina = AC.Disciplina
					INNER JOIN turma TUR ON
       				       TUR.TURMA = AC.TURMA
					WHERE
					       AC.Aluno  = ?
					   AND AC.Nota  <> 0
					GROUP BY
					       NomeTurma, NomeDisciplina
					ORDER BY
					       DIS.Nome";
			$rs    = $this->conectar()->prepare($sql);
			$count = $rs->execute(array($_SESSION['ID_NUMERO_ALUNO']));
			
			if($count === false){
				$resposta['msgResposta'] = "Nenhum registro encontrado.";
				$resposta['caminho']     = "";
				$resposta['sucesso']     = false;
			}else{
				$valor = null;
				$volta = 0;
				while ($registro = $rs->fetch(PDO::FETCH_OBJ)) {
					if($volta == 0){
						$turma = $registro->NomeTurma;
					}
					$valor[$volta] = array('disciplina' => utf8_encode($registro->NomeDisciplina),
										   'nota'       => $registro->Nota,
										   'frequencia' => $registro->Frequencia );
					$volta++;
				}
				$resposta['valor']     = $valor;
				$resposta['nomeTurma'] = utf8_encode($turma);
				$resposta['sucesso']   = true;
			}
			// echo "<pre>";
			// print_r($resposta);
			// $this->desconectar();
			echo json_encode($resposta);
		} catch (Exception $e) {
			$resposta['msgResposta'] = $e->getMessage();
			$resposta['sucesso']     = false;
			$this->desconectar();
			echo json_encode($resposta);
		}
	}

	function listarCronograma(){
		try {
			$sql = "SELECT DISTINCT
					       CRO.Id_Numero
					      ,CRO.Turma
					      ,TUR.Nome AS NomeTurma
					      ,CRO.Disciplina AS CodgDisciplina
					      ,DISC.Nome AS Disciplina
					      ,DATE_FORMAT(Data_01,'%d/%m/%Y') AS Data_01
					      ,DATE_FORMAT(Data_02,'%d/%m/%Y') AS Data_02
					      ,DATE_FORMAT(Data_03,'%d/%m/%Y') AS Data_03
					      ,DATE_FORMAT(Data_04,'%d/%m/%Y') AS Data_04
					      ,DATE_FORMAT(Data_05,'%d/%m/%Y') AS Data_05
					      ,DATE_FORMAT(Data_06,'%d/%m/%Y') AS Data_06
					FROM
					       cronograma CRO
					INNER JOIN turma TUR ON
					       TUR.Turma = CRO.Turma
					INNER JOIN disciplina DISC ON
					       DISC.Codg_Disciplina = CRO.Disciplina
					WHERE 
					       CRO.Id_Numero > 0
					   and CRO.Turma IN (?)
					ORDER BY
					       TUR.Nome, CRO.Data_01, CRO.Data_02, CRO.Data_03, CRO.Data_04, CRO.Data_05, CRO.Data_06 DESC";
			$rs    = $this->conectar()->prepare($sql);
			$count = $rs->execute(array($_SESSION['TURMAS']));
			// echo "<pre>";
			// print_r($resposta);
			// $this->desconectar();
			if($count === false){
				$resposta['msgResposta'] = "Nenhum registro encontrado.";
				$resposta['caminho']     = "";
				$resposta['sucesso']     = false;
			}else{
				$valor = null;
				$volta = 0;
				while ($registro = $rs->fetch(PDO::FETCH_OBJ)) {
					if($volta == 0){
						$nomeTurma = $registro->Turma.' - '.$registro->NomeTurma;
					}
					$valor[$volta] = array('disciplina' => utf8_encode($registro->Disciplina),
										   'Data_01'    => ($registro->Data_01 == '00/00/0000') ? '' : $registro->Data_01,
										   'Data_02'    => ($registro->Data_02 == '00/00/0000') ? '' : $registro->Data_02,
										   'Data_03'    => ($registro->Data_03 == '00/00/0000') ? '' : $registro->Data_03,
										   'Data_04'    => ($registro->Data_04 == '00/00/0000') ? '' : $registro->Data_04,
										   'Data_05'    => ($registro->Data_05 == '00/00/0000') ? '' : $registro->Data_05,
										   'Data_06'    => ($registro->Data_06 == '00/00/0000') ? '' : $registro->Data_06);
					$volta++;
				}
				$resposta['valor']     = $valor;
				$resposta['nomeTurma'] = utf8_encode($nomeTurma);
				$resposta['sucesso']   = true;
			}
			$this->desconectar();
			echo json_encode($resposta);
			return $valor;
		} catch (Exception $e) {
			$resposta['msgResposta'] = $e->getMessage();
			$resposta['sucesso']     = false;
			$this->desconectar();
			echo json_encode($resposta);
		}
	}

	function listarAvisos(){
		try {
			$sql = "SELECT
					       Codg_Aviso
					      ,Titulo
					      ,Descricao
					FROM
					       aviso
					ORDER BY
					       Data_Cadastro DESC
					LIMIT 5";
			$rs    = $this->conectar()->prepare($sql);
			$count = $rs->execute();

			if($count === false){
				$resposta['msgResposta'] = "Nenhum registro encontrado.";
				$resposta['caminho']     = "";
				$resposta['sucesso']     = false;
			}else{
				$valor = "<div data-role=\"collapsible-set\"> \n";
				$volta = 0;
				while ($registro = $rs->fetch(PDO::FETCH_OBJ)) {
					$valor .= "\t <div data-role=\"collapsible\" data-theme=\"e\"> \n";
					$valor .= "\t\t <h3>".utf8_encode($registro->Titulo)."</h3> \n";
					$valor .= "\t\t <p>".utf8_encode(nl2br($registro->Descricao))."</p> \n";
					$valor .= "\t </div> \n\n";
					// $valor[$registro->Codg_Aviso] = array('titulo'    => utf8_encode($registro->Titulo),
					// 									  'descricao' => utf8_encode($registro->Descricao) );
					$volta++;
				}
				$valor .= "</div>";
				$resposta['valor']   = $valor;
				$resposta['sucesso'] = true;
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