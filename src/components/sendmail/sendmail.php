<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru', 'phpmailer/language/');
$mail->IsHTML(true);


$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'smtp.timeweb.ru';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'drivers-lending77@es-trans.ru';                     //SMTP username
$mail->Password   = 'es-trans77';                               //SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
$mail->Port       = 465;


//От кого письмо
$mail->setFrom('drivers-lending77@es-trans.ru', 'Лендинг по поиску водителей'); // Указать нужный E-mail
//Кому отправить
$mail->addAddress('avs@es-trans.pro'); // Указать нужный E-mail 
//Тема письма
$mail->Subject = 'Привет! Это запрос с лендинга по поиску водителей.';

//Тело письма
$body = '<h1>Меня интересует работа водителем категории Е в ООО "ЕС Транс"</h1>';

if (trim(!empty($_POST['name']))) {
	$body .= '<p><strong>Имя:</strong> ' . $_POST['name'] . '</p>';
}

if (trim(!empty($_POST['tel']))) {
	$body .= '<p><strong>Телефон или мессенджер:</strong> ' . $_POST['tel'] . '</p>';
}

// Проверка на бота
if ($_POST['code'] != 'NOSPAM') {
	exit;
}

$mail->Body = $body;

//Отправляем
if (!$mail->send()) {
	$message = 'Ошибка';
} else {
	$message = 'Данные отправлены!';
}

$response = ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);
