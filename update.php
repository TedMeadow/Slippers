<?php
require_once (__DIR__.'/API/crestcurrent.php');

switch($_REQUEST['event']){
    case 'ONAPPUPDATE':                             /* Дополнить UPDATE */
        CRestCurrent::setLog([                             
            'request' => $_REQUEST                      
        ], 'ONAPPUPDATE');
        break;

    case 'ONAPPUNISTALL':
        CRestCurrent::setLog([
            'request' => $_REQUEST
        ], 'ONAPPUNISTALL');
        break;
    
    case 'ONAPPPAYMENT':
        CRestCurrent::setLog([
            'request' => $_REQUEST
        ], 'ONAPPPAYMENT');
        break;

    case 'ONAPPMETHODCONFIRM':
        CRestCurrent::setLog([
            'request' => $_REQUEST
        ], 'ONAPPMETHODCONFIRM');
        break;
}