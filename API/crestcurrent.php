<?php

require_once(__DIR__ . '/crest.php');

class CRestCurrent extends CRest
{
	protected static function getSettingData()
	{
		$return = [];
		if(file_exists(__DIR__ . '/DomainSettings/'. $_REQUEST['auth']['domain'] . '.json'))
		{
			$return = static::expandData(file_get_contents(__DIR__ . '/{0}.json'));
			if(defined("C_REST_CLIENT_ID") && !empty(C_REST_CLIENT_ID))
			{
				$return['C_REST_CLIENT_ID'] = C_REST_CLIENT_ID;
			}
			if(defined("C_REST_CLIENT_SECRET") && !empty(C_REST_CLIENT_SECRET))
			{
				$return['C_REST_CLIENT_SECRET'] = C_REST_CLIENT_SECRET;
			}
		}
		return $return;
	}

	protected static function setSettingData($arSettings)
	{
		return  (boolean)file_put_contents(__DIR__ . '/DomainSettings/'. $arSettings['domain'] . '.json', static::wrapData($arSettings));
	}


}