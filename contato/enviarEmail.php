<?php
// Validar os campo
if(!$_REQUEST['txtEmail'] || !$_REQUEST['txtAssunto'] || !$_REQUEST['txtMensagem'] ){
	$var['msg']     = "Por favor, preencher todos os campos para envio do e-mail!";
	$var['sucesso'] = false;
}else{
	//$to      = "IPECON - Ensino e consultoria <ipecon@ipecon.com.br>";
	$to      = "Regis Andrade <regisandrade@gmail.com>";
	$subject = $_REQUEST['txtAssunto'];
	$message = $_REQUEST['txtMensagem'];

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'From: '.$_REQUEST['txtEmail'].' <'.$_REQUEST['txtEmail'].'>' . "\r\n";
	$headers .= 'Reply-To: '.$_REQUEST['txtEmail'].' <'.$_REQUEST['txtEmail'].'>' . "\r\n";

	if(!mail($to, $subject, $message, $headers)){
		$var['msg']     = "Erro no envio do e-mail.";
		$var['sucesso'] = false;
		mail("regisandrade@gmail.com", "[Não responder] Erro no envio de e-mail", "Erro ao tentar enviar e-mail pelo site mobile do IPECON.");
	}else{
		$var['msg']     = "E-mail enviado com sucesso.";
		$var['sucesso'] = true;
	}	
}
echo json_encode($var);
?>