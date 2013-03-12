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

        <script type="text/javascript">
            var largura = screen.width;
            var altura  = screen.height;
        </script>
    </head>
    <body>
        <?php
            $largura = "<script type=text/javascript> document.write(largura); </script>";
            $altura = "<script type =text/javascript> document.write(altura); </script>";
        ?>
        <div data-role="page" id="page1">
            <div data-theme="b" data-role="header">
                <h1 class="header">
                    IPECON
                </h1>
            </div>
            <div data-role="content">
                <h2>
                    Localização
                </h2>
                <img src="https://maps.googleapis.com/maps/api/staticmap?center=-16.7193978, -49.2668751&amp;zoom=15&amp;size=288x200&amp;markers=Ipecon,GO&amp;sensor=false" width="<?php echo $largura ?>" height="<?php echo $altura ?>" />
            </div>
            <p>
                Av. T-4, nº 1478, Edf. Absolut Business Style, Sala A-132 (13º andar)<br>
                Setor Bueno, Goiânia/GO - CEP: 74230-030<br>
                (62) 3214-2563<br>
                (62) 3214-3229<br>
                <a href="mailto:ipecon@ipecon.com.br">ipecon@ipecon.com.br</a><br>
            </p>
            <a data-role="button" data-inline="true" data-rel="back" data-theme="e" href="#page1">
                Voltar
            </a>
            <div data-theme="b" data-role="footer" data-position="fixed">
                <h1 class="footer">
                    Av. T-4, nº 1.478, Ed. Absolut Business Style,<br>
                    sala A-132 (13º andar) - Setor Bueno, Goiânia-GO
                </h1>
            </div>
        </div>
    </body>
</html>
