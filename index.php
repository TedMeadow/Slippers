<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div id="auth-data">OAuth 2.0 data from REQUEST:
		<pre><?php
			print_r($_REQUEST);
			?>
		</pre>
	</div>
	<div id="name">
		<?php
		require_once (__DIR__.'/API/crestcurrent.php');

		$result = CRest::call('user.current');
	    $result = CRestCurrent::call('user.current');

		echo 'Здравствуйте, '. $result['result']['NAME'].' '.$result['result']['LAST_NAME'];
		?>
	</div>
    <form action='/Bot/BotInit.php' method="post">
        <p>Активность:
            <select name="activity">
                <option value="ONCRMDEALADD">Добавление сделки в CRM</option>
            </select> 
        </p>
        <p>Фильтр имен сущностей:<input type="text" name="filter"></p>
        <p><?php
            echo '<input type="hidden" name="domain" value="'.htmlspecialchars($_REQUEST['auth']['domain']). '" />'. "\n";
        ?></p>
        
        <p><input type="submit" /></p>
    </form>
</body>
</html>