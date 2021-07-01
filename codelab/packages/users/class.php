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

use clDB;

class users {


    public static function passwordHash($password){
        return crypt::in(password_hash($password, PASSWORD_DEFAULT));
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
        clDB::insert('clLog_auth', $insert);
}
   private static function _loginResponse($status, $message = null, $teamID = null, $insertDB = true){
        if ($insertDB == true):
            self::_loginLogInsert($status, $message, $teamID);
        endif;
        return (json_encode(array('status' => $status, 'message' => $message)));
    }
    public static function login($email, $password){
        if (self::logged()):
            return (self::_loginResponse(false, 'already logged', self::id(), false));
        endif;
        $securityTime = registry::read('users.login.security.time', 15);
        $securityLimit =  registry::read('users.login.security.limit', 15);
        $spyIP = spy::ip();
        $paramLogs = array(
            'table' => 'users_log_auth',
            'columns' => ['id', 'status', 'ip', 'datetime'],
            'where' => "status = '0' AND ip = '" . $spyIP ."'",
            'limit' => $securityLimit,
            'order' => "id DESC"
        );
        $resultsLogs = clDB::get($paramLogs, false);
        if (count($resultsLogs) == $securityLimit):
            $blockedUntil = end($resultsLogs)['datetime'];
            $logEndDatetime = strtotime($blockedUntil);
            if($logEndDatetime >= strtotime('-' . $securityTime . ' minutes')):
                return (self::_loginResponse(false, 'Access temporarily blocked until ' .  date('Y-m-d H:i:s', strtotime($blockedUntil  . ' + ' . $securityTime . ' minute')) . '.', null, false));
            endif;
        endif;
        // Check if username empty
            if ($email == '' OR !valid::email($email)):
                return (self::_loginResponse(false, 'Incorrect email address format'));
            endif;
        // Check if password empty
            if ($password == ''):
                return (self::_loginResponse(false, 'Log in with empty password is not allowed'));
            endif;
        // Check password length max
            $pass_maxChars = registry::read('password.length.max', 120);
            if (strlen($password) > $pass_maxChars):
                return (self::_loginResponse(false, 'Incorrect password format. Maximum ' . $pass_maxChars  . ' characters'));
            endif;
        // Check password length min
            $pass_minChars = registry::read('password.length.min', 8);
            if (strlen($password) < $pass_minChars):
                return (self::_loginResponse(false, 'Incorrect password format. Minimum ' . $pass_minChars . ' characters'));
            endif;
        // Check if user exists
            $param = array(
              'table' => 'users',
              'columns' => ['id', 'active', 'email', 'password', 'preferences'],
              'where' => 'email="' . clDB::escape($email) . '"',
              'limit' => 1,
            );
            $results = clDB::get($param, true);
            if (empty($results)):
                return (self::_loginResponse(false, 'User account does not exist'));
            else:
                // Get user id
                $userID = $results['id'];
                if ($results['active'] != '1'):
                    return (self::_loginResponse(false, 'User account is inactive' . $email, $userID));
                endif;
                    // Check Password
                    if (!password_verify($password,crypt::out(@$results['password']))):
                        return (self::_loginResponse(false, 'Incorrect password', $userID));
                    endif;
                    // Logged
                    $token = self::_loginTokenCreate($userID);
                    $preferences = json_decode($results['preferences'], true);
                    session::set('user', array(
                        'id' => $results['id'],
                        'email' => $results['email'],
                        'token' => $token,
                        'preferences' => $preferences,
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
        clDB::insert('clLog_auth', $insert);
        clDB::update('cl-team', 'id = "' . self::id() . '"', array('token' => ''));
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
              'columns' => array('id', 'token', 'active'),
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
    public static function id(){
        if (isset(session::get('user')['id'])){
             return session::get('user')['id'];
        } else{
            return false;
        }
     }

     public static function preference($preferenceName){
        $user = session::get('user');
        if (isset($user['preferences'][$preferenceName])){
             return $user['preferences'][$preferenceName];
        } else{
            return false;
        }
     }
     public static function preferenceSet($preferenceName, $preferenceValue){
        $preferences = session::get('user')['preferences'];
        $preferences[$preferenceName] = $preferenceValue;
        $preferencesEncode = json_encode($preferences);
        $update = [
            'preferences' => clDB::escape($preferencesEncode)
        ];
        clDB::update('cl-team', 'id = "' . self::id() . '"', $update);
        $user =  session::get('user');
        $user['preferences'] = $preferences;
        session::set('user', $user);
     }
	// ROW ##################################################################
	public static function timezones() // return timezones array
	{
		// get pageData
		$param = array(
			'table'  => 'clTimezones',
			'columns' => ['identifier', 'name'],
		);
		$timezones = clDB::get($param);
		if (empty($timezones)):
			return array();
		endif;
		return $timezones;
	}
		// ROW ##################################################################
		public static function groups() // return team groups array
		{
			// get pageData
			$param = array(
				'table'  => 'cl-team_groups',
				'columns' => ['name'],
			);
			$groups = clDB::get($param);
			if (empty($groups)):
				return array();
			endif;
			return $groups;
		}
		// ROW ##################################################################
		public static function groupsIDs() // return team groups array
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