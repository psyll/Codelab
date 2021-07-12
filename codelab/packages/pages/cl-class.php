<?php

	/*
		CODELAB
		Homepage: https://psyll.com/products/codelab
		© Jaroslaw Szulc <jarek@psyll.com>
		© Psyll.com <info@psyll.com>
		This file is part of the Codelab package.
		Distributed under the PPCL license (http://psyll.com/license/ppcl)
	*/
namespace Codelab;
use Codelab;
use CodelabDB;

class page {

	public static function themeView(){
		$pageView = CL_PATH . DIRECTORY_SEPARATOR . trim(CL_PACKAGES['pages']['config']['themePath'], '/') . DIRECTORY_SEPARATOR . trim(CL_PACKAGES['pages']['config']['themeName'], '/') . DIRECTORY_SEPARATOR ."view".DIRECTORY_SEPARATOR .page['themeView'] . DIRECTORY_SEPARATOR .  'view.php';
		if (file_exists($pageView) AND is_file($pageView)):
			include($pageView);
			Codelab::log('page', 'success', 'Page view loaded [' . $pageView  . ']');
		else:
			Codelab::log('page', 'error', 'Page view file not found [' . $pageView  . ']');
		endif;
	}
}
class pages {

	public static function list(){
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