<?php
	namespace Codelab;

class Registry
{
	// In ##################################################################
	public static function read(string $name, string $default = null)
	{
		if (isset(REGISTRY[$name])) {
			return REGISTRY[$name];
		} else {
			return $default;
		}
	}
}
