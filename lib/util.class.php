<?php

class Util {

	function fmtDataHifen ( $data ) // Recebe data no formato 25/10/2004
		{
			$novaData		=		explode ("/", $data);
			return $novaData[0] . "-" . $novaData[1] . "-" . $novaData[2];
			// Formato: 24-10-1982
		}

	function fmtDataBarra ( $data ) // Recebe data no formato: yyyy-mm-dd
		{
			$novaData		=		explode("-", $data);
			return $novaData[2] . "/" . $novaData[1] . "/" . $novaData[0];
			// Formato: 24/10/1982
		}

	function fmtDataBD ( $data ) // Recebe data no formato: dd/mm/aaaa
		{
			$novaData		=		explode("/", $data);
			return $novaData[2] . "-" . $novaData[1] . "-" . $novaData[0];
			// Format: 1982-10-24
		}

	function fmtValorBD($valor) // Recebe o valor R$2.500,20
	{
		$valor = str_replace('.','',$valor);
		$valor = str_replace(',','.',$valor);
		return $valor;
	}
	public function mesExtenso($_mes){
		$mes = array('01'=>'Janeiro',
					 '02'=>'Fevereiro',
					 '03'=>'Março',
					 '04'=>'Abril',
					 '05'=>'Maio',
					 '06'=>'Junho',
					 '07'=>'Julho',
					 '08'=>'Agosto',
					 '09'=>'Setembro',
					 '10'=>'Outubro',
					 '11'=>'Novembro',
					 '12'=>'Dezembro'
					);
		return $mes[$_mes];
	}
	/**
		$data -> Y-m-d
		return dia de mes de ano
	*/
	public function fmtDataExtenso ($data){
		$d = explode('-',$data);
		$dia = $d[2];
		$mes = $this->mesExtenso($d[1]);
		$ano = $d[0];

		return $dia.' de '.$mes.' de '.$ano;
	}
	function fmtDataAtualExtenso ()
		{

			$diaSemana			=		date("w");
			$mesAtual			=		date("n");
			$diaSemanaExtenso		=		'';
			$mesAtualExtenso		=		'';

			switch ($diaSemana)
				{
					case 0 :
						{
							$diaSemanaExtenso		=	  'Domingo';
							break;
						}
					case 1 :
						{
							$diaSemanaExtenso		=	  'Segunda-feira';
							break;
						}
					case 2 :
						{
							$diaSemanaExtenso		=	  'Terça-feira';
							break;
						}
					case 3 :
						{
							$diaSemanaExtenso		=	  'Quarta-feira';
							break;
						}
					case 4 :
						{
							$diaSemanaExtenso		=	  'Quinta-feira';
							break;
						}
					case 5 :
						{
							$diaSemanaExtenso		=	  'Sexta-feira';
							break;
						}
					case 6 :
						{
							$diaSemanaExtenso		=	  'Sábado';
							break;
						}
				} // fim de Switch diaSemana


			switch ($mesAtual) // PEGANDO O NOME DO MÊS ATUAL
				{
					case 1 :
						{
							$MesExtenso			=	  'Janeiro';
							break;
						}
					case 2 :
						{
							$MesExtenso			=	  'Fevereiro';
							break;
						}
					case 3 :
						{
							$MesExtenso			=	  'Março';
							break;
						}
					case 4 :
						{
							$MesExtenso			=	  'Abril';
							break;
						}
					case 5 :
						{
							$MesExtenso			=	  'Maio';
							break;
						}
					case 6 :
						{
							$MesExtenso			=	  'Junho';
							break;
						}
					case 7 :
						{
							$MesExtenso			=	  'Julho';
							break;
						}
					case 8 :
						{
							$MesExtenso			=	  'Agosto';
							break;
						}
					case 9 :
						{
							$MesExtenso			=	  'Setembro';
							break;
						}
					case 10 :
						{
							$MesExtenso			=	  'Outubro';
							break;
						}
					case 11 :
						{
							$MesExtenso			=		'Novembro';
							break;
						}
					case 12 :
						{
							$MesExtenso			=	  'Dezembro';
							break;
						}
				} // fim de Switch ($mesAtual)

			return $diaSemanaExtenso . ", " . date("d") . " de " . $MesExtenso . " de " . date("Y");
			// Terça-feira, 14 de dezembro de 2004
		}

		function validaArquivo($urlArquivo)
		{
			$p_zip		=	".zip$";
			$p_exe		=	".exe$";
			$p_pdf		=	".pdf$";
			$p_doc		=	".doc$";

			if(ereg($p_zip, $urlArquivo) OR ereg($p_exe, $urlArquivo) OR ereg($p_pdf, $urlArquivo) OR ereg($p_doc, $urlArquivo))
				return 1; // Arquivo válido
			else
				return 0;
		}

	//Retorna o link específico para cada item
	function TipoLink($_idEditoria, $_url, $_target){

	if(empty($_url))
	   $link = "index.php?idEditoria=".$_idEditoria;
	else if($link = $this->ValidaUrl($_url)){
	   if($_target == '_blank')
		  $link = "javascript:window.open('$link','','toolbar=yes,scrollbars=yes,resizable=yes,location=yes,status=yes,menubar=yes');";
		else
		 $link = $link;
	 }
	 else if($this->ValidaArquivo($_url)){
	   if($_target == '_blank')
		  $link = "javascript:window.open('$_url','','toolbar=yes,scrollbars=yes,resizable=yes,location=yes,status=yes,menubar=yes');";
		else
		 $link = $_url;
	 }
	 else if($this->ValidaPagina($_url)){
	   if($_target == '_blank')
		  $link = "javascript:window.open('index.php?pg=$_url','','toolbar=yes,scrollbars=yes,resizable=yes,location=yes,status=yes,menubar=yes');";
		else
		 $link = $_url;
	 }
	 return $link;

	}

	function validaData($data)
		{
			$padrao		=		"([0-9]{4})-([0-9]{2})-([0-9]{2})";

			if(ereg($padrao, $data))
				return 1;
			else
				return 0;
		}

	function validaHora($hora)
		{
			$padrao		=		"([0-9]{2}):([0-9]{2}):([0-9]{2})";
			if(ereg($padrao, $hora))
				return 1;
			else
				return 0;
		}
	function retirarAcentos($texto){
		//== Retirar acentos
		$txt = strtr($texto,"SOZsozY¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ",
		"SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
		return $txt;
	}

	/** COPIAR ARQUIVOS **/
	function copiarArquivo($arquivo,$destino){
		if(!move_uploaded_file($arquivo, $destino)) {
			return 0; // Erro
		}else {
			return 1; // Sucesso
		}
	}

	function visualizarCaptcha(){
		// Incluímos a Classe

		require_once 'class.captcha.php';

		// Definimos as fontes a serem usadas nas
		// imagens por meio de um array

		$aFonts =    array( 'fonts/VeraBd.ttf', 'fonts/VeraIt.ttf', 'fonts/Vera.ttf' );

		// Instanciamos a classe, criando uma nova imagem

		$oVisualCaptcha  =    new PhpCaptcha( $aFonts, 200, 60 );

		return $oVisualCaptcha -> Create();

	}

	function extenso($valor=0, $maiusculas=false){
		// verifica se tem virgula decimal
		if (strpos($valor,",") > 0){
			// retira o ponto de milhar, se tiver
			$valor = str_replace(".","",$valor);

			// troca a virgula decimal por ponto decimal
			$valor = str_replace(",",".",$valor);
		}

		$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
		$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");

		$c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
		$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
		$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
		$u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");

		$z=0;

		$valor = number_format($valor, 2, ".", ".");
		$inteiro = explode(".", $valor);
		for($i=0;$i<count($inteiro);$i++)
			for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
				$inteiro[$i] = "0".$inteiro[$i];

	        $fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
		for ($i=0;$i<count($inteiro);$i++) {
			$valor = $inteiro[$i];
			$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
			$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
			$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

			$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
			$t = count($inteiro)-1-$i;
			$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
			if ($valor == "000")$z++; elseif ($z > 0) $z--;
			if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
			if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
		}

		 if(!$maiusculas){
			return($rt ? $rt : "zero");
		 } elseif($maiusculas == "2") {
			return (strtoupper($rt) ? strtoupper($rt) : "Zero");
		 } else {
			return (ucwords($rt) ? ucwords($rt) : "Zero");
		 }

	}

    // Função que valida o CPF
    function validaCPF($cpf)
    {	// Verifiva se o número digitado contém todos os digitos
        $cpf = str_pad(ereg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);

	// Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
        if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
	{
            return false;
        }
	else
	{   // Calcula os números para verificar se o CPF é verdadeiro
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf{$c} != $d) {
                return false;
            }
        }

        return true;
    }
}

	function getBrowser(){
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
		    $browser_version=$matched[1];
		    $browser = 'IE';
		  } elseif (preg_match( '|Opera/([0-9].[0-9]{1,2})|',$useragent,$matched)) {
		    $browser_version=$matched[1];
		    $browser = 'Opera';
		  } elseif(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)) {
		    $browser_version=$matched[1];
		    $browser = 'Firefox';
		  } elseif(preg_match('|Chrome/([0-9\.]+)|',$useragent,$matched)) {
		    $browser_version=$matched[1];
		    $browser = 'Chrome';
		  } elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)) {
		    $browser_version=$matched[1];
		    $browser = 'Safari';
		  } else {
		    // browser not recognized!
		    $browser_version = 0;
		    $browser= 'other';
  		}
		return $browser.$browser_version;
	}

}// Fim da Classe
?>
