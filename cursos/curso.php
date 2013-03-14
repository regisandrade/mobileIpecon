<!DOCTYPE html>
<html>
    <head>
        <title>IPECON Pós-Graduação</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />        

        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
        <link rel="stylesheet" href="../css/my.css" />
        
        <script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
        <script src="../js/my.js"></script>
    </head>
    <body onLoad="initialize(<?php echo $_REQUEST['idMateria'] ?>)">
        <div data-role="page" id="page1">
            <div data-theme="b" data-role="header">
                <h1 class="header">
                    IPECON
                </h1>
            </div>
            <div data-role="content">
                <h2>
                    Cursos
                </h2>
                <p>
                    <span id="textoInfoCompleta"></span>
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
