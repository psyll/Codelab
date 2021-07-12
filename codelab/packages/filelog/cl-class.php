<?php
namespace Codelab;

class Filelog
{
	public static function create(string $source, string $message)
	{
		$logsDirPath = CL_PATH . DIRECTORY_SEPARATOR . trim(CL_PACKAGES['filelog']['config']['path'], '/');
		if (!file_exists($logsDirPath)) {
			mkdir($logsDirPath, 0777, true);
		}
		$logsPath = $logsDirPath . DIRECTORY_SEPARATOR .  date('Y-m-d') . '-'. $source . '.log';
		$fp = fopen($logsPath, 'a');//opens file in append mode
		fwrite($fp, date('Y-m-d H:i:s') . '|' . $message . PHP_EOL);
		fclose($fp);
	}
}
