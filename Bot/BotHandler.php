<?php

require_once(__DIR__.'/BotConfigSaver.php');
require_once(__DIR__.'/../API/crestcurrent.php');

switch($_REQUEST['event'])
{
    case 'ONIMBOTJOINCHAT':
        $chatId = 'chat'.$_REQUEST['PARAMS']['DIALOG_ID'];
        $botId = $_REQUEST['PARAMS']['BOT_ID'];
        $domain = $_REQUEST['BOT'][$botId]['AUTH']['domain'];
        $result = CRestCurrent::call('imbot.message.add', Array(
            'BOT_ID' => $botId,
            'DIALOG_ID' => $chatId,
            'MESSAGE' => 'Спасибо за установку! Теперь бот будет работать в этом чате! :)',
        ));
        $BotConfig[$domain]['chatId'] = $chatId;
        saveParams($BotConfig);
        break;
    
    case 'ONCRMDEALADD':
        $result = CRestCurrent::call('crm.deal.add', Array(
            'ID' => $_REQUEST['data']['FIELDS']['ID']
        ));
        $deal = $result['result'];
        $domain = $_REQUEST['auth']['domain'];

        if(strpos($deal['TITLE'], $BotConfig[$domain]['filter']) !== false)
        {
            $result = CRestCurrent::call('crm.contact.get', Array('ID' => $deal['CONTACT_ID']));
            $contact = $result['result'];
            $dealTitle = $deal['TITLE'];
            $dealLink = 'https://'. $domain. '/crm/deal/details/'. $_REQUEST['data']['FIELDS']['ID'].'/';
            $result = CRestCurrent::call('imbot.message.add', Array(
                'DIALOG_ID' => $BotConfig[$domain]['chatId'],
                'MESSAGE' => "[URL=$dealLink]$dealTitle [/URL]",
                'ATTACH' => Array(
                    Array('GRID' => Array(
                        Array(
                            'VALUE' => $deal['COMMENTS'],
                            'DISPLAY'=>'COLUMN'
                        ),
                    )),
                    Array('DELIMITER' => Array(
                        'COLOR' => '#c6c6c6'
                    )),

                    Array('GRID' => Array(
                        Array(
                            "VALUE" => $contact['NAME'].' '.$contact['LAST_NAME'],
                            "DISPLAY" => "COLUMN",
                        ),
                        Array(
                            "VALUE" => $contact['EMAIL'][0]['VALUE'],
                            "DISPLAY" => "COLUMN",
                        ),
                        Array(
                            "VALUE" => $contact['PHONE'][0]['VALUE'],
                            "DISPLAY" => "COLUMN",
                        ),
                    )),

                ),
                'KEYBOARD' => array(
                    array(
                        'TEXT' => 'Позвонить',
                        'COMMAND' => 'callhasmade',
                        'COMMAND_PARAMS' => 'who',
                        'ACTION' => 'CALL',
                        'ACTION_VALUE' => $contact['PHONE'][0]['VALUE'],
                        "BG_COLOR" => "#2a4c7c",
                        "TEXT_COLOR" => "#fff",
                        'DISPLAY' => 'LINE',
                    ),
                )
            ));
            $messageId = $result['result'];
            $savedMessage = $BotConfig[$domain]['savedMessage'];
            $savedMessage->append($messageId);
            $BotConfig[$domain]['savedMessage'] = $savedMessage;
            saveParams($BotConfig);

        }
        break;
    
    case 'ONIMCOMMANDADD':
        foreach($_REQUEST['data']['COMMAND'] as $command)
        {
            if ($command['COMMAND'] == 'callhasmade')
            {
                $user = $_REQUEST['data']['USER'];
                $name = $user['NAME'];
                $gender = $user['GENDER'];
                $message = $name. ($gender == 'M'? 'взял': 'взяла'). "звонок!\n". date("H:i:s");
                $result = CRestCurrent::call('imbot.command.answer', Array(
                    'COMMAND' => 'callhasmade',
                    'MESSAGE_ID' => $command['MESSAGE_ID'],
                    'MESSAGE' => $message,                  

                ));
            }
        }


        

}