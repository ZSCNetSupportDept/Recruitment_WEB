<?php

require_once dirname(__FILE__) . '/PHPMailer/PHPMailerAutoload.php';

function send_message($address, $subject, $body, $isHTML = true) {
	$usr = 'example@example.com';
	$pwd = 'xxxxxxxxxxxxxxxx';
	
	/*
	This password is NOT your e-mail password, it's a 16 characters smtp password provided by your e-mail ISP.
	此处的密码不是邮箱帐号，而是由邮箱服务提供商提供给你的16位smtp服务密码。
	*/
	

	$mail = new PHPMailer();

	$mail->isSMTP();
	$mail->CharSet = 'utf-8';
	$mail->Host = 'smtp.qq.com';
	$mail->SMTPAuth = true;
	$mail->Username = $usr;
	$mail->Password = $pwd;
	$mail->SMTPSecure = 'ssl';
	$mail->Port = '465';

	$mail->setFrom($usr, '网络维护科');
	if (is_array($address)) {
		for ($i = 0; $i < sizeof($address); $i++) {
			$mail->addBCC($address[$i]);
		}
	} else {
		$mail->addaddress($address);
	}

	$mail->addReplyTo($usr);
	$mail->isHTML($isHTML);

	$mail->Subject = $subject;
	$mail->Body = $body;
	if ($mail->send() == false) {
		return $mail->ErrorInfo;
	}
	return '发送成功';
}
