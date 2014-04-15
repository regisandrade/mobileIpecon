<?php
/**
* Classe responsavel por operacoes relacionadas a base de dados IPECON
* @author Regis Andrade <regisandrade@gmail.com>
* @access public
* @version 0.1
*/

class Gcinfo {

	var $cons;
	var $_codgConsulta;
	var $_codgMateria;
	var $_codgEditoria;
	var $_website;
	var $_status;
	var $_limite;

	/**
	* Mï¿½todo para Organizar as consultas de Editorias
	* @param int $_codgConsulta
	* @param int $_codgEditoria
	* @access public
	* @return boolean
	*/
	function consultasEditorias($_codgConsulta, $_codgEditoria = NULL, $_codgWebsite = NULL){

		switch($_codgConsulta){
			// Todos os editorias
			case 1:
				$cons = "SELECT E_A.*
						, E_B.desc_editoria AS desc_editoria_relacionada
					FROM
						editorias E_A
					LEFT OUTER JOIN editorias E_B ON
					  E_B.iden_editoria = E_A.iden_iden_editoria
					WHERE
						E_A.iden_website = ".$_codgWebsite." ORDER BY E_A.desc_editoria";
			break;
			// Listar dados de uma unica editoria
			case 2:
				$cons = "SELECT * FROM editorias WHERE iden_editoria = ".$_codgEditoria." AND iden_website = ".$_codgWebsite;
			break;
			// Criar menu
			case 3:
				$cons = "SELECT * FROM editorias WHERE iden_website = ".$_codgWebsite." AND info_visivel = 'S' ORDER BY numr_ordem";
			break;
		}
		/*echo "<pre>";
		echo $cons;
		echo "</pre>";*/
		return $cons;
	} // Fim metodo consultaSQL


	/**
    * Mï¿½todo para Listar editorias
    * @access public
    * @return boolean
	*/
	function listarEditorias($_codgConsulta,$_codgEditoria = NULL, $_codgWebsite = NULL){
		global $conexao;

		$_consulta = $this->consultasEditorias($_codgConsulta,$_codgEditoria,$_codgWebsite);

		if($conexao->executaConsulta($_consulta))
			return 1; // Ok
		else
			return 0; // Erro

	} // Fim metodo Listar Editorias

	/**
	* Método para Organizar as consultas
	* @param int $_codgConsulta
	* @param int $_codgMateria
	* @param int $_website
	* @access public
	* @return boolean
	*/
	function consultarMaterias($_codgConsulta, $_codgMateria = NULL, $_codgEditoria = NULL, $_website = NULL, $_status = NULL, $_limite = NULL){

		switch($_codgConsulta){
                    // Todos as materias
                    /*case 1:
                            $cons = "SELECT MAT.*
                                    , EDI.desc_editoria
                                    , COL.desc_colaborador
                            FROM
                                    materias MAT
                            JOIN editorias EDI ON EDI.iden_editoria = MAT.iden_editoria
                            JOIN colaboradores COL ON COL.iden_colaborador = MAT.iden_colaborador
                            WHERE
                                    MAT.iden_website = ".$_website." ORDER BY MAT.data_publicacao, MAT.hora_publicacao";
                    break;*/
                    // BUSCAR TODAS AS MAï¿½TRIAS DE UMA EDITORIA
                    case 1:
                        $cons = "SELECT * FROM materias WHERE iden_website = ".$_website." AND iden_editoria = ".$_codgEditoria." AND info_situacao = '".$_status."' ORDER BY data_publicacao DESC LIMIT ".$_limite;
                    break;
                    // BUSCAR MATERIA
                    case 2:
                        $cons = "SELECT * FROM materias WHERE iden_website = ".$_website." AND iden_materia = ".$_codgMateria." AND info_situacao = '".$_status."' ORDER BY data_publicacao DESC";
                    break;
                    // BUSCAR MATERIA COM 15 DIAS NO MÁXIMO
                    case 3:
                        $data_final = strftime("%Y-%m-%d", strtotime("+15 days"));
                        $cons = "SELECT * FROM materias WHERE iden_website = ".$_website." AND
                                 iden_editoria = ".$_codgEditoria." AND
                                 info_situacao = '".$_status."' AND
                                 ( data_publicacao >= '".date('Y-m-d')."' AND data_publicacao <= '".$data_final."') 
                                 ORDER BY data_publicacao DESC LIMIT ".$_limite; echo $cons;
                    break;
		}
		/*echo $cons;*/
		return $cons;

	} // Fim metodo consultaSQL


	/**
    * Mï¿½todo para Listar Materias
    * @access public
    * @return boolean
	*/
	function listarMaterias($_codgConsulta, $_codgMateria = NULL, $_codgEditoria = NULL, $_website = NULL, $_status = NULL, $_limite = NULL){
		global $conexao;

		$_consulta = $this->consultarMaterias($_codgConsulta,$_codgMateria,$_codgEditoria,$_website,$_status,$_limite);

		if($conexao->executaConsulta($_consulta))
			return 1; // Ok
		else
			return 0; // Erro

	} // Fim metodo Listar Materias

	/**
    * Mï¿½todo para Ultimas materias da editoria
    * @access public
    * @return boolean
	*/
	function ultimasNoticias($_codgMateria = NULL, $_codgEditoria = NULL, $_website = NULL, $_status = NULL, $_limite = NULL){
		global $conexao;

		$_consulta = "SELECT * FROM materias WHERE iden_website = ".$_website." AND iden_editoria = ".$_codgEditoria." AND info_situacao = '".$_status."' AND iden_materia <> ".$_codgMateria." ORDER BY data_publicacao DESC LIMIT ".$_limite;

		if($conexao->executaConsulta($_consulta))
			return 1; // Ok
		else
			return 0; // Erro

	} // Fim metodo Listar Materias

	/**
	* Mï¿½todo para Organizar as consultas de Colaboradores
	* @param int $_codgConsulta
	* @access public
	* @return boolean
	*/
	function consultasColaborador($_codgConsulta,$_codg_colaborador = NULL, $_website = NULL){

		switch($_codgConsulta){
			// Todos os colaboradors
			case 1:
				$cons = "SELECT * FROM colaboradores WHERE iden_website = ".$_website." ORDER BY iden_colaborador, desc_colaborador";
			break;
			// Desativar colaborador
			case 2:
				$cons = "UPDATE colaboradores SET status_colaborador = 'I' WHERE iden_colaborador = ".$_codg_colaborador;
			break;
			// Listar todos os colaboradores de um determinado site
			case 3:
				$cons = "SELECT * FROM colaboradores WHERE iden_website = ".$_website." AND status_colaborador = 'A' ORDER BY desc_colaborador";
			break;
			// Listar os dados do colaborador
			case 4:
				$cons = "SELECT * FROM colaboradores WHERE iden_colaborador = ".$_codg_colaborador." AND iden_website = ".$_website;
			break;
		}
		//echo $cons;
		return $cons;

	} // Fim metodo consultaSQL


	/**
    * Mï¿½todo para Listar colaboradors
    * @access public
    * @return boolean
	*/
	function listarColaboradores($_codgConsulta,$_codg_colaborador = NULL, $_website = NULL){
		global $conexao;

		$_consulta = $this->consultasColaborador($_codgConsulta,$_codg_colaborador,$_website);

		if($conexao->executaConsulta($_consulta))
			return 1; // Ok
		else
			return 0; // Erro

	} // Fim metodo Listar colaboradors


	/**
	*	Mï¿½todo que autoriza a entrada no sistema do colaborador
	*	@param String Login
	*	@param String Senha
	*	@return Resource
	*/
	function entrarSistema($_login, $_senha){
		global $conexao;

		$_consulta = "SELECT * FROM colaboradores WHERE iden_colaborador = ".$_login." AND info_senha = '".$_senha."'";

		if($conexao->executaConsulta($_consulta))
			if($conexao->numRows() > 0){
				return 1; // Existe
			}else{
				return 0; // nao existe
			}
	} // Fim Entrar no sistema

	/**
	* Mï¿½todo para Organizar as consultas de galeria de fotos
	* @param int $_codgConsulta
	* @param int $_codgMateria
	* @param int $_website
	* @access public
	* @return boolean
	*/
	function consultaGaleriaFotos($_codgConsulta,$_codgMateria = NULL, $_codgFoto = NULL){

		switch($_codgConsulta){
			// Listar todas as fotos da materia
			case 1:
				$cons = "SELECT * FROM materias_fotos WHERE iden_materia = ".$_codgMateria;
			break;
			// Excluir a foto da galeria
			case 2:
				$cons = "DELETE FROM materias_fotos WHERE iden_galeria = ".$_codgFoto;
			break;
		}
		//echo $cons;
		return $cons;

	} // Fim metodo consultaSQL


	/**
    * Mï¿½todo para Listar Galeria de Fotos
    * @access public
    * @return boolean
	*/
	function listarFotos($_codgConsulta,$_codgMateria = NULL, $_codgFoto = NULL){
		global $conexao;

		$_consulta = $this->consultaGaleriaFotos($_codgConsulta,$_codgMateria,$_codgFoto);

		if($conexao->executaConsulta($_consulta))
			return 1; // Ok
		else
			return 0; // Erro

	} // Fim metodo Listar Galeria de Fotos

}// Fim da Class GCINFO
?>
