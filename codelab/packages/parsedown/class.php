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
	use Parsedown;
	class md {
		public static function parse(string $content){
			$Parsedown = new Parsedown();
			return $Parsedown->text($content); # prints: <p>Hello <em>Parsedown</em>!</p>
		}
	}




