<?php
// ################################################
// ##### Errors errors handler
// ################################################
if (isset(clPackages['ErrorsHandler']['config']['PHP_display'])):
	if (clPackages['ErrorsHandler']['config']['PHP_display'] == true):
		ini_set('display_errors', 1);
		error_reporting(E_ALL);
	elseif (clPackages['ErrorsHandler']['config']['PHP_display'] == false):
		error_reporting(0);
		ini_set('display_errors', 0);
	endif;
endif;