<?php

require_once(__DIR__.'/BotConfigSaver.php');
require_once(__DIR__.'/../API/crestcurrent.php');

$handlerBackUrl = ($_SERVER['SERVER_PORT']==443||$_SERVER["HTTPS"]=="on"? 'https': 'http')."://".$_SERVER['SERVER_NAME'].(in_array($_SERVER['SERVER_PORT'], Array(80, 443))?'':':'.$_SERVER['SERVER_PORT']);
$_REQUEST['auth']['domain'] = $_POST['domain'];
$result = CRestCurrent::call('event.bind', Array(
    'EVENT' => $_POST['activity'],
    'HANDLER' => $handlerBackUrl.'/Bot/BotHandler.php'
));
$result = CRestCurrent::call('imbot.register',Array(
    'CODE' => 'Slippers',
    'TYPE' => 'B',
    'EVENT_HANDLER' => $handlerBackUrl.'/Bot/BotHandler.php',
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
$BotConfig[$_REQUEST['auth']['domain']]['BotID'] = $botId;
$BotConfig[$_REQUEST['auth']['domain']]['Filter'] = $_POST['filter'];
saveParams($BotConfig);



