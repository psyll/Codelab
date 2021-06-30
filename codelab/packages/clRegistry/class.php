<?php
	/*
		CODELAB
		Homepage: https://psyll.com/products/codelab
		© Jaroslaw Szulc <jarek@psyll.com>
		© Psyll.com <info@psyll.com>
		This file is part of the Codelab package.
		Distributed under the PPCL license (http://psyll.com/license/ppcl)
	*/
	class clRegistry {
		// In ##################################################################
		public static function read($name, $default = null)
		{
			$return = @clRegistry[$name];
			if ($return == ''){
				return $default;
			} else {
				return $return;
			}
		}
	}

