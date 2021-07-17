<?php
    // ##############################################
    // DISPLAY ERRRORS
    // ##############################################
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    // ##############################################
    // SYSTEM DEFINES
    // ##############################################
    DEFINE('CL_VERSION', '1.0');
    define('DS', DIRECTORY_SEPARATOR);
    DEFINE('CL_PATH', __DIR__);
    // ##############################################
    // LOAD CODELAB CORE
    // ##############################################
    $importCore = [
        'Path',
        'Autoload',
        'Route'
    ];
    foreach ($importCore as $import) :
        $importPath = CL_PATH . DS . 'core' . DS  . $import . '.php';
        if (!file_exists($importPath) or !is_file($importPath)) :
            die('[Codelab error] core file is missing: ' . $importPath);
        endif;
        include($importPath);
    endforeach;
    // ##############################################
    // LOAD APP CONFIG
    // ##############################################
    $importConfig = [
        'Autoload',
        'DB',
    ];
    $configFolder = 'config';
    if (file_exists(CL_PATH_APP . DS. 'config.dev')) :
        $configFolder = 'config.dev';
    endif;
    foreach ($importConfig as $import) :
        $importPath = CL_PATH_APP . DS. $configFolder . DS . $import . '.php';
        if (!file_exists($importPath) or !is_file($importPath)) :
            die('[Codelab error] config file is missing: ' . $importPath);
        endif;
        include($importPath);
    endforeach;
