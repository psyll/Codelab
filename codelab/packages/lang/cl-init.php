<?php


$packageConfig = CL_PACKAGES['lang']['config'];

if ($packageConfig['init'] == true):
    Codelab::log('lang', 'success', 'LOAD');

    // Check if language code valid

    if (empty(pageQuery) OR !isset(pageQuery[0]) OR !in_array(pageQuery[0], $packageConfig['languages'])):
        if (isset($packageConfig['errorRedirect']) AND $packageConfig['errorRedirect'] != ''):
            header('Location: ' . $packageConfig['errorRedirect']);
        else:
            Codelab::log('lang', 'error', 'Language load error');
        endif;
    endif;
    DEFINE('lang', strtolower(pageQuery[0]));

endif;
