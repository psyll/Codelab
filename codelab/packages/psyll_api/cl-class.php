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

	class psyll_api {
			// In ##################################################################
			public static function status()
			{
				$headers = @get_headers(clPackages['psyll_api']['config']['url']);
				if(strpos($headers[0],'200') === false):
					return false;
				endif;
				return true;
			}
			// In ##################################################################
			public static function query($module = null, $parameters = null)
			{
				$query = '';
				if ($module != null):
					$query .= "/" . $module;
				endif;
				if ($parameters != null):
					$query .= "/" . $parameters;
				endif;
				$apiURL = trim(clPackages['psyll_api']['config']['url'], '/') . '/' . clPackages['psyll_api']['config']['key'] . $query;
				$response = file_get_contents($apiURL);
				$response = json_decode($response, true);
				return $response;
			}
	}



