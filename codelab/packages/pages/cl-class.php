<?php

	/*
		CODELAB
		Homepage: https://psyll.com/products/codelab
		© Jaroslaw Szulc <jarek@psyll.com>
		© Psyll.com <info@psyll.com>
		This file is part of the Codelab package.
		Distributed under the PPCL license (http://psyll.com/license/ppcl)
	*/
namespace cl;
use cl;
use clDB;

class page {

	public static function themeView(){
		$pageView = clPath . DIRECTORY_SEPARATOR . trim(clPackages['pages']['config']['themePath'], '/') . DIRECTORY_SEPARATOR . trim(clPackages['pages']['config']['themeName'], '/') . DIRECTORY_SEPARATOR ."view".DIRECTORY_SEPARATOR .page['themeView'] . DIRECTORY_SEPARATOR .  'view.php';
		if (file_exists($pageView) AND is_file($pageView)):
			include($pageView);
			cl::log('page', 'success', 'Page view loaded [' . $pageView  . ']');
		else:
			cl::log('page', 'error', 'Page view file not found [' . $pageView  . ']');
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
		$results = clDB::get($param);
		return $results;
	}
}