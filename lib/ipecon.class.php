<?php
/**
* Classe responsavel por operacoes relacionadas a base de dados IPECON
* @author Regis Andrade <regisandrade@gmail.com>
* @access public
* @version 0.1
*/

class Ipecon {

	/**
	* Método para listar conteúdo empresa
	* @param int $_id
	* @param int $_topico
	* @access public
	* @return boolean
	*/
	function listarConteudoEmpresa($_id){
		global $conexao;

		$consulta = "SELECT * FROM empresa WHERE id_empresa = ".$_id;

		/*echo $cons;*/
		if($conexao->executaConsulta($consulta))
			return 1; // Ok
		else
			return 0; // Erro
		//return $cons;

	} // Fim metodo


	/**
	* Método para listar conteúdo cursos
	* @param int $_id
	* @param int $_topico
	* @access public
	* @return boolean
	*/
	function listarConteudoCurso($_id){
		global $conexao;
		
		$consulta = "SELECT * FROM descricaoCursos WHERE id_descricao_curso = ".$_id;
		
		/*echo $cons;*/
		if($conexao->executaConsulta($consulta))
			return 1; // Ok
		else
			return 0; // Erro
		//return $cons;

	} // Fim metodo


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

}// Fim da Class