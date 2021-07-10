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
class image {
public static function checkGD(bool $throwException = true): bool
    {
        // Require GD library
        if(extension_loaded('gd')){
            return true;
        }

        return false;
    }
}