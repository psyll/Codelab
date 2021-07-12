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
	class registry {
		// In ##################################################################
		public static function read(string $name, string $default = null)
		{
			if (isset(clRegistry[$name])){
				return clRegistry[$name];
			} else {
				return $default;
			}
		}
	}

