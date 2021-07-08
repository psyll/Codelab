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
	class datetime {



		public static function now()
		{
			return  date('Y-m-d H:i:s');
		}
		public static function date()
		{
			return  date('Y-m-d');
		}
		public static function time()
		{
			return  date('H:i:s');
		}








	}


