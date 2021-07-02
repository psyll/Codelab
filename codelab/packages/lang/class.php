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

class lang {
    public static function display($translations)
    {
        $translations = array_change_key_case($translations);

        $code = strtolower(lang);
        if (isset($translations[$code])):
            return $translations[$code];
        else:
            echo 'clLang::display error';
        endif;
    }
}