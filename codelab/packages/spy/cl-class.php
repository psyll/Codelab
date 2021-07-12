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

class spy {
    // IP ##################################################################
    public static function ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return  $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_REAL_IP'])) {
            return $_SERVER['HTTP_X_REAL_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
        return false;
    }
    public static function netMask(string $ipAddress = null)
    {
        if ($ipAddress == null):
            $ipAddress = self::ip();
        endif;
        $ipAddressLong = ip2long($ipAddress);

        $maskLevel1 = 0x80000000;
        $maskLevel2 = 0xC0000000;
        $maskLevel3 = 0xE0000000;

        $resultMask = 0xFFFFFFFF;
        if (($ipAddressLong & $maskLevel1) === 0) {
            $resultMask = 0xFF000000;
        } elseif (($ipAddressLong & $maskLevel2) === $maskLevel1) {
            $resultMask = 0xFFFF0000;
        } elseif (($ipAddressLong & $maskLevel3) === $maskLevel2) {
            $resultMask = 0xFFFFFF00;
        }

        return long2ip($resultMask) ?: null;
    }
    public static function browser(){
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $browsers = array(
                            'Chrome' => array('Google Chrome','Chrome/(.*)\s'),
                            'MSIE' => array('Internet Explorer','MSIE\s([0-9\.]*)'),
                            'Firefox' => array('Firefox', 'Firefox/([0-9\.]*)'),
                            'Safari' => array('Saafari', 'Version/([0-9\.]*)'),
                            'Opera' => array('Opera', 'Version/([0-9\.]*)')
                            );
        $browser_details = array();
        $browser_details['agent'] = $user_agent;
        foreach ($browsers as $browser => $browser_info){
            if (preg_match('@'.$browser.'@i', $user_agent)){
                $browser_details['name'] = $browser_info[0];
                    preg_match('@'.$browser_info[1].'@i', $user_agent, $version);
                $browser_details['version'] = $version[1];
                    break;
            } else {
                $browser_details['name'] = 'Unknown';
                $browser_details['version'] = 'Unknown';
            }
        }
        return $browser_details;
    }
    public static function os()
    {
        $os = null;
        $os_array = array(
                            '/windows nt 10/i'     	=>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
    );
        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $_SERVER['HTTP_USER_AGENT'])) {
                $os = $value;
                break;
            }
        }
        return $os;
    }
}
