<?php

namespace Codelab;

use Codelab;
use CodelabDB;

class Analysis
{
	public static function create(string $type, $description = null)
	{
		$browser = Codelab\spy::browser();
		$insertParam = array(
			'type' => $type,
			'description' => $description,
			'session' => session_id(),
			'datetime' => date('Y-m-d H:i:s'),
			'protocol' => CL_PROTOCOL,
			'domain' => CL_DOMAIN,
			'url' => CL_URL,
			'query' => CL_QUERY,
			'ip' => spy::ip(),
			'os'  => spy::os(),
			'browser' => $browser['agent'] ,
			'browserName' => $browser['name'],
			'browserVersion' => $browser['version'],
			'referrer' => @$_SERVER['HTTP_REFERER']
		);
		if (isset($_GET)) :
			$insertParam['get'] = json_encode($_GET);
		endif;
		if (isset($_POST)) :
			$insertParam['post'] = json_encode($_POST);
		endif;
		if (isset($_FILES)) :
			$insertParam['files'] = json_encode($_FILES);
		endif;
		if (Codelab::packageInstalled('users') and !isset(Codelab::packageInstalled('users')['errors'])) :
			$insertParam['usersID'] = Codelab\Users::id();
		endif;
		CodelabDB::insert('analisys', $insertParam);
		Codelab::log('analysis', 'success', 'analisys created ['.$type. ']');
	}
}
