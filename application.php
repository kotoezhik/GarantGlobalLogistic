<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Создание формы обратной связи</title>
<meta http-equiv="Refresh" content="4; http://miles-logistic.com/"> 
</head>
<body>

<?php 
$sendto   = "nikita@optimo.su";
//$sendto   = "nikita@optimo.su"; // почта, на которую будет приходить письмо
$username = $_POST['name'];   // сохраняем в переменную данные полученные из поля c именем
$usertel = $_POST['telephone']; // сохраняем в переменную данные полученные из поля c телефонным номером
/*$usermail = $_POST['email']; // сохраняем в переменную данные полученные из поля c адресом электронной почты
$usertxt1 = $_POST['txt1'];
$usertxt2 = $_POST['txt2'];
$usertxt3 = $_POST['txt3'];
$usertxt4 = $_POST['txt4'];
$usertxt5 = $_POST['txt5'];*/
$from = $_POST['from'];

// Формирование заголовка письма
$subject  = "Новое сообщение";
$headers  = "From: " . strip_tags($usermail) . "\r\n";
$headers .= "Reply-To: ". strip_tags($usermail) . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html;charset=utf-8 \r\n";

// Формирование тела письма
$msg  = "<html><body style='font-family:Arial,sans-serif;'>";
$msg .= "<h2 style='font-weight:bold;border-bottom:1px dotted #ccc;'>Cообщение с сайта (форма с шапки)</h2>\r\n";
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

require_once __DIR__ . '/ap_s/amocrm.phar';

//rocket sales
    $data = $_POST;
    $data['cookies'] = @$_COOKIE;
    // $data['server'] = @$_SERVER; // это опционально

    file_get_contents('https://b2b.rocketcrm.bz/api/channels/site/form?hash=6287202fce', false, stream_context_create(
        array(
            'http' => array(
                'method'  => 'POST',
                'header'  => implode("\r\n", [
                    'Content-type: application/x-www-form-urlencoded'
                ]) . "\r\n",
                'content' => http_build_query($data),
                'timeout' => 10
            )
        )
    ));
//rocket sales
    try {
    // Создание клиента
    $amo = new \AmoCRM\Client('miles', 'ivanov@miles-logistic.ru', '4022ecca8c5e69829de070d4402fa38e');

    $unsorted = $amo->unsorted;
    $unsorted['source'] = 'miles-logistic.com';
    $unsorted['source_uid'] = null;
    // Данные заявки (зависят от категории)
    $unsorted['source_data'] = [
        'data' => [
            'name_1' => [
                'type' => 'text',
                'id' => 'name',
                'element_type' => '1',
                'name' => 'Клиент',
                'value' => $username,
            ]
        ],
        'form_id' => 1,
        'form_type' => 1,
        'origin' => [
            'ip' => '',
            'datetime' => '',
            'referer' => '',
        ],
        'date' => 1446544971,
        'from' => 'miles-logistic.com',
        'form_name' => 'Новая заявка с сайта',
    ];
    // Сделка которая будет создана после одобрения заявки.
    $lead = $amo->lead;
    $lead['name'] = 'Заявка с сайта';
    $lead['tags'] = $from;
    $lead['responsible_user_id'] = 2028685;
    
    // Контакт
    $contact = $amo->contact;
    $contact['name'] = $username;
    $contact->addCustomField(360401, $usertel, 'WORK');

    // Присоединение сделки к неразобранному
    $unsorted->addDataLead($lead);
    // Присоединение контакта к неразобранному
    $unsorted->addDataContact($contact);
    // Добавление неразобранной заявки с типом FORMS
    $unsortedId = $unsorted->apiAddForms();
    //print_r($unsortedId);
} catch (\AmoCRM\Exception $e) {
    printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
}


?>

</body>
</html>