<?php
	/*
		CODELAB
		Homepage: https://psyll.com/products/codelab
		© Jaroslaw Szulc <jarek@psyll.com>
		© Psyll.com <info@psyll.com>
		This file is part of the Codelab package.
		Distributed under the PPCL license (http://psyll.com/license/ppcl)
	*/

// $assetsStorage
namespace Codelab;
use Codelab;
	class assets {
		public static function add(array $resources, $priority = 1)
		{
            foreach ($resources as $key => $value):
				if (is_numeric($key)):
					$key = $value;
					$value = $priority;
				endif;
				$fileInfo = pathinfo($key);
				$filename = $fileInfo['filename'];
				if (isset($fileInfo['extension'])):
					$extension = strtolower($fileInfo['extension']);
					$type = '';
					if ($extension == 'css'):
						$type = 'style';
					elseif ($extension == 'js'):
						$type = 'script';
					endif;
					session::add('assetsStorage', [
						'url' => $key,
						'priority' => sprintf('%02d', $value),
						'filename' => $filename,
						'extension' => $extension,
						'type' => $type,
					]);

				endif;
            endforeach;
		}

		private static function  assetsListOrder($a, $b) {
			return $b["priority"] - $a["priority"];
	   }

		public static function get($type = null)
		{
			$assetsStorage = [];
			$filesValidation = false;
			if (CL_PACKAGES['assets']['config']['filesValidation'] == true):
				$filesValidation = true;
				Codelab::log('assets', 'info', '[filesValidation] config enabled');
			endif;
			// set key as url
            foreach (session::get('assetsStorage') as $key => $value):
				$assetsStorage[$value['url']] = $value;
            endforeach;

            foreach ($assetsStorage as $url => $data):
				// If "filesValidation" config enabled = true
				if ($filesValidation == true):
					$urlCURL = curl_init($url);
					curl_setopt($urlCURL, CURLOPT_NOBODY, true);
					curl_exec($urlCURL);
					$retcode = curl_getinfo($urlCURL, CURLINFO_HTTP_CODE);
					// $retcode >= 400 -> not found, $retcode = 200, found.
					curl_close($urlCURL);
					if ($retcode != 200):
						Codelab::log('assets', 'error', 'assets file not valid [' . $url  . ']['.$retcode.']');
						unset($assetsStorage[$url]);
						continue;
					endif;

				endif;
            endforeach;
		   	usort($assetsStorage, "self::assetsListOrder");
			if ($type == null OR $type == 'style'):
				foreach ($assetsStorage as $key => $data):
				if ($data['type'] == 'style'):
						echo '<link rel="stylesheet" href="' . $data['url'] . '">' . PHP_EOL;
						Codelab::log('assets', 'log', 'assets style loaded [' . $data['url']  . '] with priority ['.$data['priority'] .']');
				endif;
				endforeach;
			endif;
			if ($type == null OR $type == 'script'):
				foreach ($assetsStorage as $key => $data):
					if ($data['type'] == 'script'):
						echo '<script src="' . $data['url'] . '"></script>' . PHP_EOL;
						Codelab::log('assets', 'log', 'assets script loaded [' . $data['url']  . '] with priority ['.$data['priority'] .']');
					endif;
				endforeach;
			endif;
		}
	}



