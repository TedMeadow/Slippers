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
    'CODE' => 'SlippersBot',
    'TYPE' => 'B',
    'EVENT_HANDLER' => $handlerBackUrl.'/Bot/BotHandler.php',
    'PROPERTIES' => Array(
        'NAME' => 'SlippersBot',
        'COLOR' => 'PINK',
        'EMAIL' => 'slippersbot@gmail.com',
        'PERSONAL_BIRTHDAY' => '2021-02-25',
        'PERSONAL_GENDER' => 'M',
        'PERSONAL_PHOTO' => base64_encode(file_get_contents(__DIR__.'/avatar.png'))
    ))
);
$botId = $result['result'];
$result = CRestCurrent::call('imbot.command.register', Array(
    'BOT_ID' => $botId,
    'COMMAND' => 'callhasmade',
    'HIDDEN' => 'Y',
    'EVENT_COMMAND_ADD' => $handlerBackUrl.'/Bot/BotHandler.php'
));
$commandId = $result['result'];
$BotConfig[$_REQUEST['auth']['domain']]['botId'] = $botId;
$BotConfig[$_REQUEST['auth']['domain']]['filter'] = $_POST['filter'];
$BotConfig[$_REQUEST['auth']['domain']]['activity'] = $_POST['activity'];
$BotConfig[$_REQUEST['auth']['domain']]['callhasmade'] = $commandId;
$BotConfig[$_REQUEST['auth']['domain']]['savedMessage'] = Array();
saveParams($BotConfig);



