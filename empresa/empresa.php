<?php
/** DEFINIR A CONSTANTES DO SITE **/
define("website", 7); // Código do Website na tabela website
define("urlImagens", "http://www.gcinfo.com.br/arquivos/fotos/");
define("urlGalerias", "http://www.gcinfo.com.br/arquivos/galeriaFotos/");

/** CLASSE DE CONEXAO E OUTRAS FUNCIONALIDADES **/
require_once('../class/BDMySQL.class.php');
$conexao = new BDMySQL();
$conexao->conectar();

/** CLASSE DE NEGOCIO E PERSISTENCIA GCINFO **/
require_once("../class/gcinfo.class.php");
$gcinfo = new Gcinfo();

// Empresa
$gcinfo->listarMaterias(1,null,27,website,"P",1);
$dados = $conexao->retornaArray();
$textoEmpresa = stripslashes($dados['info_completa']);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <title>IPECON Pós-Graduação</title>

        <link rel="stylesheet" href="../css/jquery.mobile-1.2.0.min.css" />
        <link rel="stylesheet" href="../css/my.css" />
        
        <script src="../js/jquery-1.7.2.min.js"></script>
        <script src="../js/jquery.mobile-1.2.0.min.js"></script>
        <script src="../js/my.js"></script>
    </head>
    <body>
        <div data-role="page" id="page1">
            <div data-theme="b" data-role="header">
                <h1 class="header">
                    IPECON
                </h1>
            </div>
            <div data-role="content">
                <h2>
                    Empresa
                </h2>
                <p>
                    <?php echo $textoEmpresa; ?>
                </p>
                <a data-role="button" data-inline="true" data-rel="back" data-theme="e" href="#page1">
                    Voltar
                </a>
            </div>
            <div data-theme="b" data-role="footer" data-position="fixed">
                <h1 class="footer">
                    Av. T-4, nº 1.478, Ed. Absolut Business Style,<br>
                    sala A-132 (13º andar) - Setor Bueno, Goiânia-GO
                </h1>
            </div>
        </div>
    </body>
</html>
