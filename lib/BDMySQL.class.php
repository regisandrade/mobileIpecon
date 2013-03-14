<?php
/*
*	BDMySQL - Clase que fornece funções (métodos) para trabalhar com banco de dados MySQL
*	Autor: Regis Andrade
*	Email: regisandrade@gmail.com
*	
*/


/*
	Definições de constantes a serem utilizadas como informações sobre erros
*/

define ("ERRO_BD", "Erro ao conectar ao Banco de dados");
define ("ERRO_HOST", "Erro ao conectar aos Host");
define ("ERRO_CONS", "Erro ao executar consulta no banco");

class BDMySQL 	{
	/*
		Variáveis de instância da Classe
	*/
	var $idConexao, $consulta, $linhasAfetadas, $hostname, $porta, $usuario, $bancoDeDados, $senha, $resulConsulta = NULL, $numrows, $row = -1;

	/*
		CONFIGURAÇÕES ESSENCIAIS PARA CONEXÃO AO BANCO
	*/
	function conectar(){
		/** Conexão de produção **/
		$this->hostname		=	'50.22.37.199';
		$this->usuario		=	'control1_ugcinfo';
		$this->senha		=	'tre147!!';
		$this->bancoDeDados	=	'control1_gcinfo';
	
		/** Conexão de desenv **/
		/*$this->hostname		=	'localhost';
		$this->usuario		=	'root';
		$this->senha		=	'123456';
		$this->bancoDeDados	=	'regis_gcinfo';*/
				
		
		if(!($this->idConexao =  mysql_connect($this->hostname, $this->usuario, $this->senha))){
			echo ERRO_BD;	// Retorna mensagem de erro
			return 0;	// Retorna FALSO
		}
		mysql_select_db($this->bancoDeDados,$this->idConexao);
		
		return 1;	// Retorna verdadeiro
	}
			
	/*
		FECHA A CONEXAO COM O BANCO DE DADOS
	*/
	function desconectar(){
		mysql_close($this->idConexao);
	}
	
	/*
		EXECULTA UMA CONSULTA
	*/
	function executaConsulta($consulta){
		if (!($this->resulConsulta = mysql_query($consulta))){
			echo ERRO_CONS;
			return 0; 		// Retorna falso
		}
		//if ($this->numRows() > 0)$this->moveFirst();
			return 1; // retorna verdadeiro
	}
	
	/*
		RETORNA A QUANTIDADE DE LINHA(S) DE UMA CONSULTA
	*/
	function qtdeLinhas(){
		return mysql_num_rows($this->resulConsulta);
	}
				
	/* 
		RETORNA UM OBJETO A PARTIR DA CONSULTA EXECUTADA
		$obj->campo_na_tabela;
	*/
	function retornaObj() // Retorno de único objeto
	{
		if ($this->resulConsulta == null || $this->row == "-1" || $this->numRows() == 0) return null;
		else return mysql_fetch_object($this->resulConsulta, $this->row);
	}
				
	/*
		RETORNA UM ARRAY ASSOCIATIVO A PARTIR DA CONSULTA EXECUTADA
		$var['campo_na_tabela']
	*/		
	function retornaArray(){
		return mysql_fetch_array($this->resulConsulta);
	}
				
	/*
		RETORNA UM ARRAY ASSOCIATIVO A PARTIR DA CONSULTA EXECUTADA
		$var['campo_na_tabela']
	*/		
	function retornaArray2(){
		$volta = 0;
		while ($dados = mysql_fetch_array($this->resulConsulta, MYSQL_ASSOC)){
			$arrayDados[$volta] = $dados;
			$volta++;
		}
		return $arrayDados;
	}
	
	/*
		RETORNA UM ARRAY VETORIAL A PARTIR DA CONSULTA EXECUTADA
		$var[0]  -> pega a primeira coluna da consulta
	*/
	function retornaLinhaEnum(){
		return mysql_fetch_row($this->resulConsulta);
	}
		
	/*
		AVANÇA PARA O PRÓXIMO REGISTRO DA CONSULTA REALIZADA
	*/
	function moveNext(){ 
		if ($this->row < $this->numRows()-1) { 
			$this->setRow($this->row +1); 
		return true; 
		}
		else return false; 
	} 
				
	function setRow($row){
		$this->row = $row;
	}
	
	function numRows(){
		if ($this->resulConsulta == null) return 0;
		else {
			$this->numrows = mysql_num_rows($this->resulConsulta);
			return $this->numrows;
		}
	}
	
	function moveFirst(){
		if ($this->resulConsulta == null) return false;
		else {
			$this->setRow(0);
			return true;
		} 
	} 
} // fim da classe BDMySQL
?>
