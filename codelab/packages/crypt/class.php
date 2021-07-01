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
	class crypt {
		public static function in(string $string)
		{
			$output = false;
			$key = hash('sha256', clPackages['crypt']['config']['key']);
			$iv = substr(hash('sha256', clPackages['crypt']['config']['iv']), 0, 16);
			$output = openssl_encrypt($string, clPackages['crypt']['config']['method'], clPackages['crypt']['config']['key'], 0, $iv);
			$output = base64_encode($output);
			return $output;
		}
		public static function out(string $hash)
		{
			$output = false;
			$iv = substr(hash('sha256', clPackages['crypt']['config']['iv']), 0, 16);
			$output = openssl_decrypt(base64_decode($hash), clPackages['crypt']['config']['method'], clPackages['crypt']['config']['key'], 0, $iv);
			return $output;
		}
	}


