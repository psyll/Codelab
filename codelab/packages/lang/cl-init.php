<?php


$packageConfig = CL_PACKAGES['lang']['config'];

if ($packageConfig['init'] == true):
    Codelab::log('lang', 'success', 'LOAD');

    // Check if language code valid

    if (empty(PAGE_QUERY) OR !isset(PAGE_QUERY[0]) OR !in_array(PAGE_QUERY[0], $packageConfig['languages'])):
        if (isset($packageConfig['errorRedirect']) AND $packageConfig['errorRedirect'] != ''):
            header('Location: ' . $packageConfig['errorRedirect']);
        else:
            Codelab::log('lang', 'error', 'Language load error');
        endif;
    endif;
    DEFINE('LANG', strtolower(PAGE_QUERY[0]));

endif;
