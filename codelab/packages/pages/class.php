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
class page {
	public static function themeView(){
		$pageView = clPath . DIRECTORY_SEPARATOR . trim(clPackages['pages']['config']['path'], '/') . DIRECTORY_SEPARATOR . page['themeView'] . DIRECTORY_SEPARATOR . 'view.php';
		if (file_exists($pageView) AND is_file($pageView)):
			include($pageView);
			cl::log('page', 'success', 'Page view loaded [' . $pageView  . ']');
		else:
			cl::log('page', 'error', 'Page view file not found [' . $pageView  . ']');
		endif;
	}
}
class pages {

}