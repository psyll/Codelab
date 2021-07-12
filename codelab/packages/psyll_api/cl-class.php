<?php

	namespace Codelab;

class PsyllAPI
{
	// In ##################################################################
	public static function status()
    {
		$headers = @get_headers(CL_PACKAGES['psyll_api']['config']['url']);
		if (strpos($headers[0], '200') === false) :
			return false;
        endif;
		return true;
	}
	// In ##################################################################
	public static function query($module = null, $parameters = null)
    {
		$query = '';
		if ($module != null) :
			$query .= "/" . $module;
        endif;
		if ($parameters != null) :
			$query .= "/" . $parameters;
        endif;
		$apiURL = trim(CL_PACKAGES['psyll_api']['config']['url'], '/') . '/' . CL_PACKAGES['psyll_api']['config']['key'] . $query;
		$response = file_get_contents($apiURL);
		$response = json_decode($response, true);
		return $response;
	}
}