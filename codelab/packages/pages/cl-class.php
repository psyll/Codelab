<?php
namespace Codelab;

use Codelab;
use CodelabDB;

class Page
{

	public static function themeView()
	{
		$pageView = CL_PATH . DIRECTORY_SEPARATOR . trim(CL_PACKAGES['pages']['config']['themePath'], '/')
					. DIRECTORY_SEPARATOR . trim(CL_PACKAGES['pages']['config']['themeName'], '/')
					. DIRECTORY_SEPARATOR ."view".DIRECTORY_SEPARATOR .PAGE['themeView'] . DIRECTORY_SEPARATOR .  'view.php';
		if (file_exists($pageView) and is_file($pageView)) :
			include($pageView);
			Codelab::log('page', 'success', 'Page view loaded [' . $pageView  . ']');
		else :
			Codelab::log('page', 'error', 'Page view file not found [' . $pageView  . ']');
		endif;
	}
}
class Pages
{

	public static function list()
	{
		$param = array(
			'table' => 'pages',
		   	'columns' => "*", // OR active,email // OR * = blank
			'offset' => 0,
			'order' => 'ordering ASC',
		);
		$results = CodelabDB::get($param);
		return $results;
	}
}
