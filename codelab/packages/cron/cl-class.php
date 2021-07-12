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
	use Codelab;
	class cron {


		// IP ##################################################################
		private static function logIP()
		{
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				return $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				return $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				return $_SERVER['REMOTE_ADDR'];
			}
		}


		public static function log(string $message)
		{
			if (CL_PACKAGES['cron']['config']['logs']['enabled'] == true):
				$logsDirPath = CL_PATH . DIRECTORY_SEPARATOR . trim(CL_PACKAGES['cron']['config']['logs']['folder'], '/');
				if (!file_exists($logsDirPath)) {
				mkdir($logsDirPath, 0777, true);
				}
				$logsPath = $logsDirPath . DIRECTORY_SEPARATOR . CL_PACKAGES['cron']['config']['logs']['filenamePrefix']  . date("Y-m-d") . CL_PACKAGES['cron']['config']['logs']['filenameSuffix'] . '.log';
				$fp = fopen($logsPath, 'a');//opens file in append mode
				fwrite($fp, date('Y-m-d H:i:s') . '|' . self::logIP() . "|" . $message . PHP_EOL);
				fclose($fp);
			endif;
		}




		public static function jobs(bool $doOnly = false)
		{
			$cronJobsFile = CL_PATH . DIRECTORY_SEPARATOR . trim(CL_PACKAGES['cron']['config']['file'], '/');
			if(!is_file($cronJobsFile)):
				file_put_contents($cronJobsFile, '{}');
			endif;
			$cronJOBS = json_decode(file_get_contents($cronJobsFile), true);
			if (!is_array($cronJOBS)):
				Codelab::log('cron', 'error', 'cron jobs file not valid ['.$cronJobsFile.']');
				return false;
			endif;


			foreach ($cronJOBS as $key => $value):

				// Check if enabled
				if (@$value['enabled'] != true):
						unset($cronJOBS[$key]);
						Codelab::log('cron', 'warning', 'job disabled ['.$key.']');
						continue;
				endif;
				// Check if have every
				if (@$value['every'] == ''):
					unset($cronJOBS[$key]);
					Codelab::log('cron', 'error', 'job [every] not est in ['.$key.']');
					continue;
				endif;
				// Check if file exists
				$cronJobFile = CL_PATH . DIRECTORY_SEPARATOR . trim($value['file'], '/');
				if (!file_exists($cronJobFile)):
					unset($cronJOBS[$key]);
					Codelab::log('cron', 'error', 'job file does not exists ['.$cronJobFile.']');
					continue;
				endif;

				// Check if done in lat time
				// never done = do IT
				$do = false;
				if (@$value['_done'] == ''):
					$do = true;
				else:
					$done = $value['_done'];
					$cronJOBS[$key]['_next'] = date('Y-m-d H:i:s', strtotime($done. ' + ' . $value['every']));
					if (strtotime($cronJOBS[$key]['_next']) < strtotime(Codelab\datetime::now())):
						$do = true;
					endif;

				endif;
				if ($doOnly == true AND $do == false):
					unset($cronJOBS[$key]);
					continue;
				endif;
				$cronJOBS[$key]['do'] = $do;
			endforeach;
			return $cronJOBS;
		}
		public static function work()
		{
			self::log('INIT');
			$filestamp= date("Y-m-d");
			$cronJOBS = self::jobs();

			foreach ($cronJOBS  as $key => $jobData):
				if ($jobData['do'] == true):
					$cronJobFile = CL_PATH . DIRECTORY_SEPARATOR .  trim($jobData['file'], '/');
					$wa_cronStatus = 'unknown';
					include($cronJobFile);
					$cronJOBS[$key]['_done'] = Codelab\datetime::now();
					self::log('' . $key . '|' . trim($jobData['file'], '/') .'|' . $wa_cronStatus);
				endif;
				unset($cronJOBS[$key]['do']);
			endforeach;
			$path = CL_PATH . DIRECTORY_SEPARATOR . trim(CL_PACKAGES['cron']['config']['file'], '/');
			file_put_contents($path, json_encode($cronJOBS, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
			return $cronJOBS;
		}
	}


