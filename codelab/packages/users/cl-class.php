<?php
namespace Codelab;

use CodelabDB;

class Users
{
	public static function passwordHash($password)
	{
		return Crypt::in(password_hash($password, PASSWORD_DEFAULT));
	}
	private static function validEmail($string)
	{
		if (filter_var($string, FILTER_VALIDATE_EMAIL)) {
			return true;
		} else {
			return false;
		}
	}
	private static function loginTokenCreate($id)
	{
		$token = array(
        'id' => $id,
        'session' =>  session_id(),
        'datetime' => date("Y-m-d H:i:s")
		);
		$token = json_encode($token);
		$token = Crypt::in($token);
		return $token;
	}
	private static function loginLogInsert($status, $message = null, $teamID = null)
	{
		$insert = array(
        'status' => $status,
        'teamID' => $teamID,
        'message' => CodelabDB::escape($message),
        'datetime' => date("Y-m-d H:i:s"),
        'ip' => CodelabDB::escape(spy::ip()),
        'os' => CodelabDB::escape(spy::os()),
        'browser_name' => CodelabDB::escape(spy::browser()['name']),
        'browser_version' => CodelabDB::escape(spy::browser()['version']),
        'user_agent' => CodelabDB::escape($_SERVER['HTTP_USER_AGENT'])
		);
		if ($status == false) :
			$insert['status'] = '0';
		elseif ($status == true) :
			$insert['status'] = '1';
		endif;
		CodelabDB::insert('users_auth', $insert);
	}
	private static function loginResponse($status, $message = null, $teamID = null, $insertDB = true)
	{
		if ($insertDB == true) :
			self::loginLogInsert($status, $message, $teamID);
		endif;
		return (json_encode(array('status' => $status, 'message' => $message)));
	}
	public static function login(string $email, string $password)
	{
		if (self::logged()) :
			return (self::loginResponse(false, 'already logged', self::id(), false));
		endif;
		$securityTime = CL_PACKAGES['users']['config']['login_time'];
		$securityLimit =  CL_PACKAGES['users']['config']['login_attempts'];
		$spyIP = spy::ip();
		$paramLogs = array(
        'table' => 'users_auth',
        'columns' => ['id', 'status', 'ip', 'datetime'],
        'where' => "status = '0' AND ip = '" . $spyIP ."'",
        'limit' => $securityLimit,
        'order' => "id DESC"
		);
		$resultsLogs = CodelabDB::get($paramLogs, false);
		if (!empty($resultsLogs) and count($resultsLogs) == $securityLimit) :
			$blockedUntil = end($resultsLogs)['datetime'];
			$logEndDatetime = strtotime($blockedUntil);
			if ($logEndDatetime >= strtotime('-' . $securityTime . ' minutes')) :
				return (self::loginResponse(false, 'access blocked', null, false));
			endif;
		endif;
		// Check if username empty
        if ($email == '' or !self::validEmail($email)) :
            return (self::loginResponse(false, 'email invalid'));
        endif;
		// Check if password empty
        if ($password == '') :
            return (self::loginResponse(false, 'password required'));
        endif;
		// Check password length max
        $pass_maxChars = CL_PACKAGES['users']['config']['password_length_max'];
        if (strlen($password) > $pass_maxChars) :
            return (self::loginResponse(false, 'password too long'));
        endif;
		// Check password length min
        $pass_minChars = CL_PACKAGES['users']['config']['password_length_min'];
        if (strlen($password) < $pass_minChars) :
            return (self::loginResponse(false, 'password too short'));
        endif;
		// Check if user exists
        $param = array(
            'table' => 'users',
            'columns' => ['id', 'active', 'email', 'password'],
            'where' => 'email="' . CodelabDB::escape($email) . '"',
            'limit' => 1,
        );
        $results = CodelabDB::get($param, true);
        if (empty($results)) :
            return (self::loginResponse(false, 'account does not exist'));
        else :
				// Get user id
				$userID = $results['id'];
			if ($results['active'] != '1') :
				return (self::loginResponse(false, 'account inactive' . $email, $userID));
            endif;
                // Check Password
			if (!password_verify($password, Crypt::out(@$results['password']))) :
				return (self::loginResponse(false, 'password invalid', $userID));
			endif;
                // Logged
                $token = self::loginTokenCreate($userID);

                Session::set('user', array(
                    'id' => $results['id'],
                    'token' => $token,
                ));
					$update = array(
                    'token' => $token
					);
					CodelabDB::update('users', 'id="' . $results['id']. '"', $update);

					return (self::loginResponse(true, 'logged', $userID));
        endif;
		// Check if password match
			return false;
	}
	public static function logout()
	{
		$insert = array(
        'status' => '-1',
        'teamID' => self::id(),
        'message' => CodelabDB::escape('Logout'),
        'datetime' => date("Y-m-d H:i:s"),
        'ip' => CodelabDB::escape(spy::ip()),
        'os' => CodelabDB::escape(spy::os()),
        'browser_name' => CodelabDB::escape(spy::browser()['name']),
        'browser_version' => CodelabDB::escape(spy::browser()['version']),
        'user_agent' => CodelabDB::escape($_SERVER['HTTP_USER_AGENT'])
		);
		CodelabDB::insert('team_login', $insert);
		CodelabDB::update('team', 'id = "' . self::id() . '"', array('token' => ''));
		Session::delete('user');
	}

	public static function logged()
	{

		if (!isset(Session::get('user')['token'])) :
			return false;
		endif;
		$token = Session::get('user')['token'];
		$tokenDecode = Crypt::out($token);
		$tokenDecode = json_decode($tokenDecode, true);
		// Check if user exists
		$param = array(
            'table' => 'users',
            'columns' => ["id", "token", "active"],
            'where' => 'id="' . CodelabDB::escape(@$tokenDecode['id']) . '"',
            'limit' => 1,
		);
		$results = CodelabDB::get($param, true);
		if (empty($results)) :
			return false;
		endif;
		if ($token == '' or $results['token'] == '' or $token != $results['token'] or $results['active'] != '1') :
			return false;
		endif;
		return true;
	}
	public static function data($userID = null)
	{
		if ($userID == null) :
			$userID = self::id();
		endif;
		$param = array(
        'table' => 'users',
        'columns' => "*",
        'where' => 'id="' . CodelabDB::escape(@$userID) . '"',
        'limit' => 1,
		);
		$results = CodelabDB::get($param, true);
		$prefereces = json_decode($results['preferences'], true);
		if (!is_array($prefereces)) :
			$prefereces = [];
	    endif;
		arsort($prefereces);
		$results['preferences'] = $prefereces;
		$accessPrivate = json_decode($results['accessPrivate'], true);
		;
		if (!is_array($accessPrivate)) :
			$accessPrivate = [];
	    endif;
		asort($accessPrivate);
		$results['access']['private'] = $accessPrivate;

		unset($results['accessPrivate']);
		$paramGroup = array(
		'table' => 'users_groups',
		'columns' => ['id', 'access'], // OR active,email // OR * = blank
		'where' => 'id="' . $results['group'] . '"',
		'limit' => 1,
		);
		$resultsGroup = CodelabDB::get($paramGroup, true);
		$groupAccess = json_decode($resultsGroup['access'], true);
		if (!is_array($groupAccess)) :
			$groupAccess = [];
	    endif;
		asort($groupAccess);
		$results['access']['group'] = $groupAccess;
		$accessTotal = array_merge($accessPrivate, $groupAccess);
		if (!is_array($accessTotal)) :
			$accessTotal = [];
	    endif;
		$results['access']['total'] = $accessTotal;

		asort($results['access']['total']);
		return $results;
	}

	public static function id()
	{
		if (isset(Session::get('user')['id'])) {
			 return Session::get('user')['id'];
		} else {
			return false;
		}
	}
	public static function preference(string $name, $userID = null)
	{
		if ($userID == null) :
			$userID = self::id();
	    endif;
		$preferences = self::data($userID)['preferences'];
		if (isset($preferences[$name])) :
			echo $preferences[$name];
	    endif;
		return false;
	}
	public static function preferenceSet(string $name, string $value, $userID = null)
	{
		if ($userID == null) :
			$userID = self::id();
	    endif;

		$preferences = self::data($userID)['preferences'];
		$preferences[$name] = $value;
		$preferencesEncode = json_encode($preferences);
		$update = [
        'preferences' => $preferencesEncode
		];
		CodelabDB::update('users', 'id = "' . $userID . '"', $update);
		$user =  Session::get('user');
		$user['preferences'] = $preferences;
		Session::set('user', $user);
	}
}


class UsersGroups
{
		// ROW ##################################################################
	public static function list() // return team groups array
    {
		// get pageData
		$param = array(
			'table'  => 'users_groups',
			'columns' => ['name'],
		);
		$groups = CodelabDB::get($param);
		if (empty($groups)) :
			return array();
        endif;
		return $groups;
	}
		// ROW ##################################################################
	public static function ids() // return team groups array
    {
		// get pageData
		$param = array(
			'table'  => 'cl-team_groups',
			'columns' => ['id'],
		);
		$groups = CodelabDB::get($param);
		if (empty($groups)) :
			return array();
        endif;
		$output = [];
		foreach ($groups as $key => $value) :
			array_push($output, $value['id']);
        endforeach;
		return $output;
	}
}
