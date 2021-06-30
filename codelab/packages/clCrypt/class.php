<?php
	/*
		CODELAB
		Homepage: https://psyll.com/products/codelab
		© Jaroslaw Szulc <jarek@psyll.com>
		© Psyll.com <info@psyll.com>
		This file is part of the Codelab package.
		Distributed under the PPCL license (http://psyll.com/license/ppcl)
	*/
	class clCrypt {
		public static function in(string $string)
		{
			$output = false;
			$key = hash('sha256', clPackages['clCrypt']['config']['key']);
			$iv = substr(hash('sha256', clPackages['clCrypt']['config']['iv']), 0, 16);
			$output = openssl_encrypt($string, clPackages['clCrypt']['config']['method'], clPackages['clCrypt']['config']['key'], 0, $iv);
			$output = base64_encode($output);
			return $output;
		}
		public static function out(string $hash)
		{
			$output = false;
			$iv = substr(hash('sha256', clPackages['clCrypt']['config']['iv']), 0, 16);
			$output = openssl_decrypt(base64_decode($hash), clPackages['clCrypt']['config']['method'], clPackages['clCrypt']['config']['key'], 0, $iv);
			return $output;
		}
	}