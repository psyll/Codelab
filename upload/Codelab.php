
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    // ##############################################
    // Core defines
    // ##############################################
    DEFINE('CL_VERSION', '1.0');
    DEFINE('CL_PATH', __DIR__);
    // ##############################################
    // Import Core Files
    // ##############################################
    $importCore = [
        'config' => [
            'DB',
            'Path',
        ],
        'class' => [
            'DB',
            'Error',
        ],
    ];
    // # Check if dev version avaible
    if (file_exists(CL_PATH) . '/config.dev') :
        $configFolder = 'config.dev';
    endif;
    // # Import config files
    foreach ($importCore['config'] as $import) :
        $importPath = CL_PATH . '/' . $configFolder . '/' . $import . '.php';
        if (!file_exists($importPath) or !is_file($importPath)) :
            die('[Codelab error] config file is missing: ' . $importPath);
        endif;
        include($importPath);
    endforeach;
    // # Import class files
    foreach ($importCore['class'] as $import) :
        $importPath = CL_PATH . '/class/' . $import . '.php';
        if (!file_exists($importPath) or !is_file($importPath)) :
            die('[Codelab error] class file is missing: ' . $importPath);
        endif;
        include($importPath);
    endforeach;
