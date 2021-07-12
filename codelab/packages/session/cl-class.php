<?php

	/*
		CODELAB
		Homepage: https://psyll.com/products/codelab
		© Jaroslaw Szulc <jarek@psyll.com>
		© Psyll.com <info@psyll.com>
		This file is part of the Codelab package.
		Distributed under the PPCL license (http://psyll.com/license/ppcl)
	*/
namespace Codelab;
class session {
    public static function set(string $name, $value = null){
        $_SESSION[CL_PACKAGES['session']['config']['sessionName']][$name] = $value;
    }
    public static function add(string $name, $value = null){
        $_SESSION[CL_PACKAGES['session']['config']['sessionName']][$name][microtime()] = $value;
    }
    public static function get(string $name = null){
        if ($name == null):
            return $_SESSION[CL_PACKAGES['session']['config']['sessionName']];
        else:
            if (isset($_SESSION[CL_PACKAGES['session']['config']['sessionName']][$name])):
              return $_SESSION[CL_PACKAGES['session']['config']['sessionName']][$name];
            else:
                return false;
            endif;
        endif;
    }
    public static function delete(string $name = null){
        if ($name == null):
            $_SESSION[CL_PACKAGES['session']['config']['sessionName']] = array();
        else:
            unset($_SESSION[CL_PACKAGES['session']['config']['sessionName']][$name]);
        endif;
    }
}
