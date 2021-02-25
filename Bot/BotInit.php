<?php
require_once(__DIR__.'/../API/crestcurrent.php');
$_REQUEST['auth']['domain'] = $_POST['domain'];
$result = CRestCurrent::call('event.bind', $_POST['activity']);
$result = CRestCurrent::call('imbot.register',Array(
    'CODE' => 'notificationbot',
    'TYPE' => 'B',
    'EVENT_MESSAGE_ADD' => $handlerBackUrl,
    'EVENT_WELCOME_MESSAGE' => $handlerBackUrl,
    'EVENT_BOT_DELETE' => $handlerBackUrl,
    'PROPERTIES' => Array(
        'NAME' => 'NotificationBot',
        'COLOR' => 'PINK',
        'EMAIL' => 'test@test.ru',
        'PERSONAL_BIRTHDAY' => '2020-11-10',
        'PERSONAL_GENDER' => 'M',
        'PERSONAL_PHOTO' => base64_encode(file_get_contents(__DIR__.'/avatar.png'))
    ))
);
$botId = $result['result'];




