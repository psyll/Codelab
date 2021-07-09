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
use cl;
use clDB;
class users {


   public static function passwordHash($password){
    return crypt::in(password_hash($password, PASSWORD_DEFAULT));
}
private static function _validEmail($string){
    if (filter_var($string, FILTER_VALIDATE_EMAIL))
    {
        return true;
    } else
    {
        return false;
    }
}
private static function _loginTokenCreate($id){
    $token = array(
        'id' => $id,
        'session' =>  session_id(),
        'datetime' => date("Y-m-d H:i:s")
    );
    $token = json_encode($token);
    $token = crypt::in($token);
    return $token;
}
private static function _loginLogInsert($status, $message = null, $teamID = null){
    $insert = array(
        'status' => $status,
        'teamID' => $teamID,
        'message' => clDB::escape($message),
        'datetime' => date("Y-m-d H:i:s"),
        'ip' => clDB::escape(spy::ip()),
        'os' => clDB::escape(spy::os()),
        'browser_name' => clDB::escape(spy::browser()['name']),
        'browser_version' => clDB::escape(spy::browser()['version']),
        'user_agent' => clDB::escape($_SERVER['HTTP_USER_AGENT'])
    );
    if ($status == false):
        $insert['status'] = '0';
    elseif ($status == true):
        $insert['status'] = '1';
    endif;
    clDB::insert('users_auth', $insert);
}
private static function _loginResponse($status, $message = null, $teamID = null, $insertDB = true){
    if ($insertDB == true):
        self::_loginLogInsert($status, $message, $teamID);
    endif;
    return (json_encode(array('status' => $status, 'message' => $message)));
}





public static function login(string $email, string $password){
    if (self::logged()):
        return (self::_loginResponse(false, 'already logged', self::id(), false));
    endif;
    $securityTime = clPackages['users']['config']['login_time'];
    $securityLimit =  clPackages['users']['config']['login_attempts'];
    $spyIP = spy::ip();
    $paramLogs = array(
        'table' => 'users_auth',
        'columns' => ['id', 'status', 'ip', 'datetime'],
        'where' => "status = '0' AND ip = '" . $spyIP ."'",
        'limit' => $securityLimit,
        'order' => "id DESC"
    );
    $resultsLogs = clDB::get($paramLogs, false);

    if (!empty($resultsLogs) AND count($resultsLogs) == $securityLimit):
        $blockedUntil = end($resultsLogs)['datetime'];
        $logEndDatetime = strtotime($blockedUntil);
        if($logEndDatetime >= strtotime('-' . $securityTime . ' minutes')):
            return (self::_loginResponse(false, 'access blocked', null, false));
        endif;
    endif;
    // Check if username empty
        if ($email == '' OR !self::_validEmail($email)):
            return (self::_loginResponse(false, 'email invalid'));
        endif;
    // Check if password empty
        if ($password == ''):
            return (self::_loginResponse(false, 'password required'));
        endif;
    // Check password length max
        $pass_maxChars = clPackages['users']['config']['password_length_max'];
        if (strlen($password) > $pass_maxChars):
            return (self::_loginResponse(false, 'password too long'));
        endif;
    // Check password length min
        $pass_minChars = clPackages['users']['config']['password_length_min'];
        if (strlen($password) < $pass_minChars):
            return (self::_loginResponse(false, 'password too short'));
        endif;
    // Check if user exists
        $param = array(
          'table' => 'users',
          'columns' => ['id', 'active', 'email', 'password'],
          'where' => 'email="' . clDB::escape($email) . '"',
          'limit' => 1,
        );
        $results = clDB::get($param, true);
        if (empty($results)):
            return (self::_loginResponse(false, 'account does not exist'));
        else:
            // Get user id
            $userID = $results['id'];
            if ($results['active'] != '1'):
                return (self::_loginResponse(false, 'account inactive' . $email, $userID));
            endif;
                // Check Password
                if (!password_verify($password,crypt::out(@$results['password']))):
                    return (self::_loginResponse(false, 'password invalid', $userID));
                endif;
                // Logged
                $token = self::_loginTokenCreate($userID);

                session::set('user', array(
                    'id' => $results['id'],
                    'token' => $token,
                ));
                $update = array(
                    'token' => $token
                );
                clDB::update('users' , 'id="' . $results['id']. '"', $update);

                return (self::_loginResponse(true, 'logged', $userID));
        endif;
    // Check if password match
    return false;
}
public static function logout(){
    $insert = array(
        'status' => '-1',
        'teamID' => self::id(),
        'message' => clDB::escape('Logout'),
        'datetime' => date("Y-m-d H:i:s"),
        'ip' => clDB::escape(spy::ip()),
        'os' => clDB::escape(spy::os()),
        'browser_name' => clDB::escape(spy::browser()['name']),
        'browser_version' => clDB::escape(spy::browser()['version']),
        'user_agent' => clDB::escape($_SERVER['HTTP_USER_AGENT'])
    );
    clDB::insert('team_login', $insert);
    clDB::update('team', 'id = "' . self::id() . '"', array('token' => ''));
    session::delete('user');
}
public static function logged(){
    if (!isset(session::get('user')['token'])):
        return false;
    endif;
    $token = session::get('user')['token'];
    $tokenDecode = crypt::out($token);
    $tokenDecode = json_decode($tokenDecode, true);
    // Check if user exists
    $param = array(
          'table' => 'users',
          'columns' => ["id", "token", "active"],
          'where' => 'id="' . clDB::escape(@$tokenDecode['id']) . '"',
          'limit' => 1,
    );
    $results = clDB::get($param, true);
    if (empty($results)):
        return false;
    endif;
    if ($token == '' OR $results['token'] == '' OR $token != $results['token'] OR $results['active'] != '1'):
        return false;
    endif;
    return true;
}
public static function data($userID = null){
    if ($userID == null):
        $userID = self::id();
    endif;
    $param = array(
        'table' => 'users',
        'columns' => "*",
        'where' => 'id="' . clDB::escape(@$userID) . '"',
        'limit' => 1,
  );
  $results = clDB::get($param, true);
  $prefereces = json_decode($results['preferences'], true);
  if (!is_array($prefereces)):
    $prefereces = [];
  endif;
  arsort($prefereces);
  $results['preferences'] = $prefereces;
  $accessPrivate = json_decode($results['accessPrivate'], true);;
  if (!is_array($accessPrivate)):
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
$resultsGroup = clDB::get($paramGroup, true);
$groupAccess = json_decode($resultsGroup['access'], true);
if (!is_array($groupAccess)):
    $groupAccess = [];
  endif;
asort($groupAccess);
$results['access']['group'] = $groupAccess;
$accessTotal = array_merge($accessPrivate, $groupAccess);
if (!is_array($accessTotal)):
    $accessTotal = [];
  endif;
$results['access']['total'] = $accessTotal;

asort($results['access']['total']);
  return $results;
}

public static function id(){
    if (isset(session::get('user')['id'])){
         return session::get('user')['id'];
    } else{
        return false;
    }
 }
 public static function preference(string $name, string $value, $userID = null){
    if ($userID == null):
        $userID = self::id();
    endif;
    $preferences = self::data($userID)['preferences'];
    if (isset($preferences[$name])):
        echo $preferences[$name];
    endif;
    return false;
 }
 public static function preferenceSet(string $name, string $value, $userID = null){
    if ($userID == null):
        $userID = self::id();
    endif;

    $preferences = self::data($userID)['preferences'];
    $preferences[$name] = $value;
    $preferencesEncode = json_encode($preferences);
    $update = [
        'preferences' => $preferencesEncode
    ];
    clDB::update('users', 'id = "' . $userID . '"', $update);
    $user =  session::get('user');
    $user['preferences'] = $preferences;
    session::set('user', $user);
 }
}

class usersGroups {
		// ROW ##################################################################
		public static function list() // return team groups array
		{
			// get pageData
			$param = array(
				'table'  => 'users_groups',
				'columns' => ['name'],
			);
			$groups = clDB::get($param);
			if (empty($groups)):
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
			$groups = clDB::get($param);
			if (empty($groups)):
				return array();
			endif;
            $output = [];
            foreach ($groups as $key => $value):
               array_push($output,  $value['id']);
            endforeach;
			return $output;
		}
    }