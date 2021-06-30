<?php
/*
	  CODELAB
	  © Jaroslaw Szulc <jarek@psyll.com>
	  © Psyll.com <info@psyll.com>
	  This file is part of the Codelab package.
    Distributed under the PPCL license (http://psyll.com/license/ppcl)
*/
class fileLOG {
  public static function create(string $source, string $message)
  {
      $logsPath = clPath . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR .  date('Y-m-d') . '['. $source . '].log';
      $fp = fopen($logsPath, 'a');//opens file in append mode
      fwrite($fp, date('Y-m-d H:i:s') . '|' . $message . PHP_EOL);
      fclose($fp);

    //  clSession::add('clLogs', ['source' => $source, 'type' => $type, 'message' => $message]);
  }
}