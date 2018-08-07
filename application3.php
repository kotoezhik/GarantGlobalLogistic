<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Создание формы обратной связи</title>
<meta http-equiv="Refresh" content="4; http://miles-logistic.com/"> 
</head>
<body>

<?php 

$sendto   = "nikita@optimo.su"; // почта, на которую будет приходить письмо
$username = $_POST['name3'];   // сохраняем в переменную данные полученные из поля c именем
$usertel = $_POST['telephone3']; // сохраняем в переменную данные полученные из поля c телефонным номером
/*$usermail = $_POST['email']; // сохраняем в переменную данные полученные из поля c адресом электронной почты
$usertxt1 = $_POST['txt1'];
$usertxt2 = $_POST['txt2'];
$usertxt3 = $_POST['txt3'];
$usertxt4 = $_POST['txt4'];
$usertxt5 = $_POST['txt5'];*/


// Формирование заголовка письма
$subject  = "Новое сообщение";
$headers  = "From: " . strip_tags($usermail) . "\r\n";
$headers .= "Reply-To: ". strip_tags($usermail) . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html;charset=utf-8 \r\n";

// Формирование тела письма
$msg  = "<html><body style='font-family:Arial,sans-serif;'>";
$msg .= "<h2 style='font-weight:bold;border-bottom:1px dotted #ccc;'>Cообщение с сайта (МОРСКОЙ ЭКОНОМ)</h2>\r\n";
$msg .= "<p><strong>От кого:</strong> ".$username."</p>\r\n";
/*$msg .= "<p><strong>Почта:</strong> ".$usermail."</p>\r\n";*/
$msg .= "<p><strong>Телефон:</strong> ".$usertel."</p>\r\n";
/*$msg .= "<p><strong>Пункт отправления:</strong> ".$usertxt1."</p>\r\n";

$msg .= "<p><strong>Пункт назначения:</strong> ".$usertxt2."</p>\r\n";
$msg .= "<p><strong>Вес:</strong> ".$usertxt3."</p>\r\n";
$msg .= "<p><strong>Обьем:</strong> ".$usertxt4."</p>\r\n";
$msg .= "<p><strong>Назание компании:</strong> ".$usertxt5."</p>\r\n";*/
$msg .= "</body></html>";

// отправка сообщения
if(@mail($sendto, $subject, $msg, $headers)) {
	echo "<center><img src='images/spasibo.png'></center>";
} else {
	echo "<center><img src='images/ne-otpravleno.png'></center>";
}

?>

</body>
</html>