<?php
require_once (__DIR__.'/API/crestcurrent.php');

$result = CRestCurrent::installApp();
if($result['rest_only'] === false):?>
	<head>
		<script src="//api.bitrix24.com/api/v1/"></script>
		<?php if($result['install'] == true):?>
			<script>
				BX24.init(function(){
					BX24.installFinish();
				});
			</script>
		<?php endif;?>
	</head>
	<body>
		<?php if($result['install'] == true):?>
			installation has been finished
		<?php else:?>
			installation error
		<?php endif;?>
	</body>
<?php endif;
$handlerBackUrl = ($_SERVER['SERVER_PORT']==443||$_SERVER["HTTPS"]=="on"? 'https': 'http')."://".$_SERVER['SERVER_NAME'].(in_array($_SERVER['SERVER_PORT'], Array(80, 443))?'':':'.$_SERVER['SERVER_PORT']);
$result = CRestCurrent::call('event.bind', Array(
	'EVENT' => 'OnAppUpdate',
    'HANDLER' => $handlerBackUrl.'/update.php'
));
$result = CRestCurrent::call('event.bind', Array(
	'EVENT' => 'OnAppUninstall',
    'HANDLER' => $handlerBackUrl.'/update.php'
));
$result = CRestCurrent::call('event.bind', Array(
	'EVENT' => 'OnAppPayment',
    'HANDLER' => $handlerBackUrl.'/update.php'
));
$result = CRestCurrent::call('event.bind', Array(
	'EVENT' => 'OnAppMethodConfirm',
    'HANDLER' => $handlerBackUrl.'/update.php'
));