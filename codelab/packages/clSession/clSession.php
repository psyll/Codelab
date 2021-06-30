<?php
/*
	CODELAB
	© Jaroslaw Szulc <jarek@psyll.com>
	© Psyll.com <info@psyll.com>
	This file is part of the Codelab package.
    Distributed under the PPCL license (http://psyll.com/license/ppcl)
*/
session_start();
if (!isset($_SESSION[cl['session']['name']])):
    $_SESSION[cl['session']['name']] = array();
endif;
class clSession {
    public static function set(string $name, $value = null){
        $_SESSION[cl['session']['name']][$name] = $value;
    }
    public static function add(string $name, $value = null){
        $_SESSION[cl['session']['name']][$name][microtime()] = $value;
    }
    public static function get(string $name = null){
        if ($name == null):
            return $_SESSION[cl['session']['name']];
        else:
            if (isset($_SESSION[cl['session']['name']][$name])):
              return $_SESSION[cl['session']['name']][$name];
            else:
                return false;
            endif;
        endif;
    }
    public static function delete(string $name = null){
        if ($name == null):
            $_SESSION[cl['session']['name']] = array();
        else:
            unset($_SESSION[cl['session']['name']][$name]);
        endif;
    }
}
