<?php
	/*
		CODELAB
		Homepage: https://psyll.com/products/codelab
		© Jaroslaw Szulc <jarek@psyll.com>
		© Psyll.com <info@psyll.com>
		This file is part of the Codelab package.
		Distributed under the PPCL license (http://psyll.com/license/ppcl)
	*/

	namespace Codelab;
	class crypt {



		public static function in(string $string, array $param = null)
		{
			$config = [
				'key' => CL_PACKAGES['crypt']['config']['key'],
				'iv' => CL_PACKAGES['crypt']['config']['iv'],
				'method' => CL_PACKAGES['crypt']['config']['method']
			];
			if (isset($param['key'])):
				$config['key'] = $param['key'];
			endif;
			if (isset($param['iv'])):
				$config['iv'] = $param['iv'];
			endif;
			if (isset($param['method'])):
				$config['method'] = $param['method'];
			endif;
			$output = false;
			$key = hash('sha256', $config['key']);
			$iv = substr(hash('sha256', $config['iv']), 0, 16);
			$output = openssl_encrypt($string, $config['method'], $config['key'], 0, $iv);
			$output = base64_encode($output);
			return $output;
		}
		public static function out(string $hash, array $param = null)
		{
			$config = [
				'key' => CL_PACKAGES['crypt']['config']['key'],
				'iv' => CL_PACKAGES['crypt']['config']['iv'],
				'method' => CL_PACKAGES['crypt']['config']['method']
			];
			if (isset($param['key'])):
				$config['key'] = $param['key'];
			endif;
			if (isset($param['iv'])):
				$config['iv'] = $param['iv'];
			endif;
			if (isset($param['method'])):
				$config['method'] = $param['method'];
			endif;


			$output = false;
			$iv = substr(hash('sha256', $config['iv']), 0, 16);
			$output = openssl_decrypt(base64_decode($hash), $config['method'], $config['key'], 0, $iv);
			return $output;
		}
	}


