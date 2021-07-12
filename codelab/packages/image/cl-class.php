<?php
namespace Codelab;

class Image
{
	public static function checkGD(bool $throwException = true): bool
	{
        // Require GD library
        if (extension_loaded('gd')) {
            return true;
		}
        return false;
	}
}
