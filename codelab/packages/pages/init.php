<?php
DEFINE('pageQuery', array_filter(explode('/', ltrim(strtok($_SERVER['REQUEST_URI'], '?'), dirname($_SERVER["SCRIPT_NAME"])))));
$pagesParms = array(
    'table' => 'pages',
    'columns' => array('id', 'name', 'alias', 'catch','themePath', 'metaTags'),
 );
// ### Create catch list
$pages = clDB::get($pagesParms);
$catchList = array();
foreach ($pages as $key => $pagesData):
    $catch = $pagesData['catch'];
    if (strpos($catch, '["') !== false AND strpos($catch, '"]') !== false):
        $catch = json_decode($catch, true);
    else:
        $catch = array($catch);
    endif;
    if (!is_array($catch)):
        cl::log('pages', 'error', ' [' .$pagesData['id'] . '] catch invalid  [' . $pagesData['catch'] . ']') ;
        unset($pages[$key]);
    else :
        foreach ($catch as $keyCatch => $valueCatch):
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
                $catchList[$key] = [
                    'id'=>$key,
                    'catch'=>$valueCatchArray,
                    'strength' => $strength,
                    'alias' => $pages[$key]['alias'],
                    'themePath' => $pages[$key]['themePath'],
                    'metaTags' => $pages[$key]['metaTags'],
                ];
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
else:
    DEFINE('page', ['alias' => 'error']);
endif;
