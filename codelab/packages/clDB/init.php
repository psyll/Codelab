<?php
	GLOBAL $DB;
    if (@clPackages['DB']['config']['init'] == true):
		$DB = @mysqli_connect(
			@clPackages['DB']['config']['host'],
			@clPackages['DB']['config']['user'],
			@clPackages['DB']['config']['pass'],
			@clPackages['DB']['config']['name'],
			@clPackages['DB']['config']['port']
		);
		if (!mysqli_connect_errno()):
			if (isset(clPackages['DB']['config']['characters'])):
				$charset = clPackages['DB']['config']['characters'];
				if ($charset != '' AND $charset != null AND $charset != false):
					mysqli_query($DB,"SET names = '" . $charset . "', character_set_results = '" . $charset . "', character_set_client = '" . $charset . "', character_set_connection = '" . $charset . "', character_set_database = '" . $charset . "', character_set_server = '" . $charset . "'");
					mysqli_set_charset($DB, 'utf8');
				endif;
			endif;
			$logMessage = 'Database connected [' . clPackages['DB']['config']['host'] . ']';
			cl::log('DB', 'success', $logMessage) ;
		else:
			$logMessage = 'Database connection error [' . clPackages['DB']['config']['host'] . ']';
			cl::log('DB', 'error', $logMessage) ;

		endif;
	endif;