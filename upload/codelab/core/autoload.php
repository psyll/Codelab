<?php
namespace Codelab;

function Autoload($className)
{
	$parts = explode('\\', $className);
	$class = end($parts);
	$namespace = implode('\\', array_slice($parts, 0, count($parts)-1));
	if (strtolower($namespace) == 'codelab') {
		include_once(CL_PATH . DS . 'class' . DS . $class . '.php');
	} else {

		$autoloadsArray = CL_AUTOLOAD;
		$autloadPathes = array_change_key_case($autoloadsArray);
		echo '<hr>' . $namespace . '<pre>';
		print_r($autloadPathes);
		echo '</pre>';
		if (isset($autloadPathes[strtolower($namespace)])) :
			include_once(CL_PATH_APP . DS . trim($autloadPathes[strtolower($namespace)], DS) . DS . $class . '.php');
		endif;
	}
}
spl_autoload_register("Codelab\Autoload");
