<?php
namespace Codelab;

class Lang
{
    public static function pageURL($id_or_alias)
    {
		if ($id_or_alias == 'index') :
			return '/' . LANG;
        endif;
		if (is_numeric($id_or_alias)) :
			$catches = json_decode(PAGES[$id_or_alias]['catch']);
			foreach ($catches as $catch) :
				$catch = trim($catch, '/');
				$catchArray = explode('/', $catch);
				if ($catchArray[0] == LANG) :
					return '/' . $catch;
                endif;
            endforeach;
        elseif (is_string($id_or_alias)) :
			foreach (PAGES as $pageID => $pageData) :
				if ($pageData['alias'] == $id_or_alias) :
					$catches = json_decode(PAGES[$pageID]['catch']);
					foreach ($catches as $catch) :
						$catch = trim($catch, '/');
						$catchArray = explode('/', $catch);
						if ($catchArray[0] == LANG) :
							return '/' . $catch;
                        endif;
                    endforeach;
                endif;
            endforeach;
        endif;
            return '/' .LANG;
    }
    public static function display(array $translations)
    {
        $translations = array_change_key_case($translations);
        $code = strtolower(LANG);
        if (isset($translations[$code])) :
            return $translations[$code];
        else :
            return 'Lang::display error';
        endif;
    }
}
