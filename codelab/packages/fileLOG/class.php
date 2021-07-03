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
class fileLOG {
  public static function create(string $source, string $message)
  {
      $logsDirPath = clPath . DIRECTORY_SEPARATOR . trim(clPackages['filelog']['config']['path'], '/');
      if (!file_exists($logsDirPath)) {
        mkdir($logsDirPath, 0777, true);
      }
      $logsPath = $logsDirPath . DIRECTORY_SEPARATOR .  date('Y-m-d') . '-'. $source . '.log';
      $fp = fopen($logsPath, 'a');//opens file in append mode
      fwrite($fp, date('Y-m-d H:i:s') . '|' . $message . PHP_EOL);
      fclose($fp);

  }
}