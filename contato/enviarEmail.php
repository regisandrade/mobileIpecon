<?php
//$to      = "IPECON - Ensino e consultoria <ipecon@ipecon.com.br>";
$to      = "Regis Andrade <regisandrade@gmail.com>";
$subject = $_REQUEST['txtAssunto'];
$message = $_REQUEST['txtMensagem'];

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
//$headers .= 'To: IPECON - Ensino e consultoria <ipecon@ipecon.com.br>' . "\r\n";
$headers .= 'To: Regis Andrade <regisandrade@gmail.com>' . "\r\n";
$headers .= 'From: '.$_REQUEST['txtEmail'].' <'.$_REQUEST['txtEmail'].'>' . "\r\n";

if(!mail($to, $subject, $message, $headers)){
	$var['msg'] = "Erro no envio do e-mail.";
	$var['sucesso'] = false;
	mail("regisandrade@gmail.com", "[Não responder] Erro no envio de e-mail", "Erro ao tentar enviar e-mail pelo site mobile do IPECON.");
}else{
	$var['msg'] = "E-mail enviado com sucesso.";
	$var['sucesso'] = true;
}
return json_encode($var);
?>