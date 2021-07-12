<?php

	$ip_allowMYIP = false;
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip_allowMYIP = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_allowMYIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip_allowMYIP = $_SERVER['REMOTE_ADDR'];
    }
	if ($ip_allowMYIP == false OR $ip_allowMYIP == ''):
		die(clPackages['ip-allow']['config']['message']);
	endif;
	if (empty(clPackages['ip-allow']['config']['allow'])):
		die(clPackages['ip-allow']['config']['message']);
	else:
		$allowList = clPackages['ip-allow']['config']['allow'];
		if (!in_array($ip_allowMYIP, $allowList)):
			die(clPackages['ip-allow']['config']['message']);
		endif;
	endif;