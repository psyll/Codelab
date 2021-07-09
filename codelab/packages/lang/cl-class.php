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
    public static function pageURL($id_or_alias)
    {
            if ($id_or_alias == 'index'):
                return '/' . lang;
            endif;


            if (is_numeric($id_or_alias)):
                $catches = json_decode(pages[$id_or_alias]['catch']);
                foreach ($catches as $catch):
                    $catch = trim($catch, '/');
                    $catchArray = explode('/', $catch);
                    if ($catchArray[0] == lang):
                        return '/' . $catch;
                    endif;
                endforeach;
            elseif (is_string($id_or_alias)):
                foreach (pages as $pageID => $pageData):
                   if ($pageData['alias'] == $id_or_alias):
                    $catches = json_decode(pages[$pageID]['catch']);
                    foreach ($catches as $catch):
                        $catch = trim($catch, '/');
                        $catchArray = explode('/', $catch);
                        if ($catchArray[0] == lang):
                            return '/' . $catch;
                        endif;
                    endforeach;
                   endif;
                 endforeach;
            endif;
            return '/' .lang;
    }
    public static function display($translations)
    {
        $translations = array_change_key_case($translations);

        $code = strtolower(lang);
        if (isset($translations[$code])):
            return $translations[$code];
        else:
            return 'lang::display error';
        endif;
    }
}