<?php

$packageConfig = clPackages['lang']['config'];
if ($packageConfig['enabled'] == true):
    // No languages set - redirect to default
    if (empty(pageQuery) AND isset($packageConfig['default'])):
        header('Location: ' . wa_url . '/' . $packageConfig['default']);
    endif;
    // Check if language code valid
    if (!in_array(pageQuery[0], $packageConfig['languages'])):
        header('Location: ' . wa_url . '/' . $packageConfig['default']);
    endif;
    DEFINE('lang', strtolower(pageQuery[0]));
endif;
