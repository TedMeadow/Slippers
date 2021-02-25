<?php
$BotConfig = Array();
if (file_exists(__DIR__.'/BotConfig.php'))
    include(__DIR__.'/BotConfig.php');
function saveParams($params)
{
    $config = "<?php\n";
    $config .= "\$appsConfig = ".var_export($params, true).";\n";
    $config .= "?>";

    file_put_contents(__DIR__."/BotConfig.php", $config);

    return true;
}