<?php

if (clPackages['pages']['config']['init'] == true):


        $pageQuery = strtok($_SERVER['REQUEST_URI'], '?');
        $pageQuery = substr($pageQuery, strlen(dirname($_SERVER["SCRIPT_NAME"])));
        $pageQuery = explode('/', $pageQuery);
        $pageQuery = array_filter($pageQuery);
        $pageQuery = array_values($pageQuery);
        ksort($pageQuery);
        DEFINE('pageQuery', $pageQuery);
        $pagesParms = array(
            'table' => 'pages',
            'columns' => '*',
        );
        // ### Create catch list
        $pages = clDB::get($pagesParms);
        DEFINE('pages', $pages);


        if (clPackages['pages']['config']['offline'] == true):
            $offlineParms = array(
                'table' => 'pages',
                'columns' => '*',
                'where' => 'catch = "offline"'
            );
            // ### Create catch list
            $offline = clDB::get($offlineParms, true);
            if (!empty($offline)):
                DEFINE('page', $offline);
            else:
                DEFINE('page', ['alias' => 'error', 'id' => '-1']);
            endif;
        else:
            if (empty(pageQuery)):
                $homepageParms = array(
                    'table' => 'pages',
                    'columns' => '*',
                    'where' => 'catch = "index"'
                );
                // ### Create catch list
                $homepage = clDB::get($homepageParms, true);
                if (!empty($homepage)):
                    DEFINE('page', $homepage);
                endif;
            else:
                $catchList = array();
                foreach ($pages as $key => $pagesData):
                    $catch = $pagesData['catch'];
                    if (strpos($catch, '["') !== false AND strpos($catch, '"]') !== false):
                        $catch = json_decode($catch, true);
                    endif;
                    if ($catch == 'index' OR $catch == 'error' OR $catch == 'offline'):
                        unset($pages[$key]);
                    elseif (!is_array($catch)):
                        cl::log('pages', 'error', ' [' .$pagesData['id'] . '] catch invalid  [' . $pagesData['catch'] . ']') ;
                        unset($pages[$key]);
                    else :
                        foreach ($catch as $keyCatch => $valueCatch):
                            $valueCatch = trim($valueCatch, '/');
                            // ### Check if catch match
                            $valueCatchArray = explode('/', $valueCatch);
                            // Check if same count
                            if (count(pageQuery) != count($valueCatchArray)):
                                continue;
                            endif;
                            $checkValid = true;
                            $strength = 0;
                            for ($i=0; $i < count(pageQuery); $i++):
                                if (strtolower(pageQuery[$i]) == strtolower($valueCatchArray[$i])):
                                    $strength = $strength + 2;
                                elseif ($valueCatchArray[$i] == '*'):
                                    $strength = $strength + 1;
                                else:
                                    $checkValid = false;
                                endif;
                            endfor;
                            if ($checkValid == true):
                                $catchList[$key] = $pages[$key];
                                $catchList[$key]['strength'] = $strength;
                            endif;
                        endforeach;
                    endif;
                endforeach;
                function catchListOrder($a, $b) {
                    return $a["strength"] + $b["strength"];
                }
                usort($catchList, "catchListOrder");
                if (isset($catchList[0])):
                    DEFINE('page', $catchList[0]);
                endif;
            endif;
        endif;
        if (!defined('page')):
            $erroPageParms = array(
                'table' => 'pages',
                'columns' => '*',
                'where' => 'catch = "error"'
            );
            // ### Create catch list
            $erroPage = clDB::get($erroPageParms, true);
            if (!empty($erroPage)):
                DEFINE('page', $erroPage);
            else:
                DEFINE('page', ['alias' => 'error', 'id' => '-1']);
            endif;
        endif;
    endif;