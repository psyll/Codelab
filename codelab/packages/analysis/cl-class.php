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
	use cl,clDB;
	class analysis {

		public static function create(string $type, $description = null)
		{
			$browser = cl\spy::browser();
			$insertParam = array(
				'type' => $type,
				'description' => $description,
				'session' => session_id(),
				'datetime' => date('Y-m-d H:i:s'),
				'ip' => spy::ip(),
				'os'  => spy::os(),
				'browser' => $browser['agent'] ,
				'browserName' => $browser['name'],
				'browserVersion' => $browser['version']
			);
			if (cl::packageInstalled('users') AND !isset(cl::packageInstalled('users')['errors'])):
				$insertParam['usersID'] = cl\users::id();
			endif;
			clDB::insert('analisys', $insertParam);
			cl::log('analysis', 'success', 'analisys created');
		}
	}