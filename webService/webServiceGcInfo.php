<?php
/* WebService para conceção e busca de dados ao servidor GCInfo
   Retorna Json com os dados necessário
*/

/** DEFINIR A CONSTANTES DO SITE **/
define("website", 7); // Código do Website na tabela website
define("urlImagens", "http://www.gcinfo.com.br/arquivos/fotos/");
define("urlGalerias", "http://www.gcinfo.com.br/arquivos/galeriaFotos/");

/** CLASSE DE CONEXAO E OUTRAS FUNCIONALIDADES **/
require_once('../lib/BDMySQL.class.php');
$conexao = new BDMySQL();
$conexao->conectar();

/** CLASSE DE NEGOCIO E PERSISTENCIA GCINFO **/
require_once("../lib/gcinfo.class.php");
$gcinfo = new Gcinfo();

$gcinfo->listarMaterias(2,$_POST['idMateria'],null,website,"P");
$dados = $conexao->retornaArray();
$dadosJson = json_encode($dados);
echo $dadosJson;
?>