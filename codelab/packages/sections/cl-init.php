<?php
$param = array(
    'table' => 'sections',
    'columns' => array('id', 'name', 'alias', 'pagesInclude', 'pagesExclude',  'view', 'position', 'ordering', 'alias'),
    'where' => 'active = 1',
    'order' => 'ordering',
    'sort' => 'asc'
);
$results = CodelabDB::get($param);
$pageSections = [];
if (!empty($results)):

    foreach ($results as $keySections => $valueSecions):
        $section = trim($valueSecions['view'], '/');
        $path = trim(CL_PACKAGES['sections']['config']['path'], DIRECTORY_SEPARATOR);
        $sectionPath =  CL_PATH . DIRECTORY_SEPARATOR . $path ;

        $view = trim($valueSecions['view'], DIRECTORY_SEPARATOR);
        if ($view != ''):
            $sectionFileView = $sectionPath . DIRECTORY_SEPARATOR . $view . DIRECTORY_SEPARATOR . 'view.php';
            $pagesInclude = json_decode($valueSecions['pagesInclude'],true);
            $pagesExclude = json_decode($valueSecions['pagesExclude'],true);
            if (($valueSecions['pagesInclude'] == '*' OR (is_array($pagesInclude) AND in_array(PAGE['id'],$pagesInclude))) AND (!is_array($pagesExclude) OR !in_array(PAGE['id'],$pagesExclude))):

                if (file_exists($sectionFileView) AND is_file($sectionFileView)):
                    $sectionFileControl = $sectionPath . DIRECTORY_SEPARATOR . $view . DIRECTORY_SEPARATOR . 'control.php';
                    $control = false;
                    if (file_exists($sectionFileControl) AND is_file($sectionFileControl)):
                        $control = true;
                    endif;
                    $pageSections[] = array(
                        'id' => $valueSecions['id'],
                        'view' => $view,
                        'control' => $control,
                        'name' => $valueSecions['name'],
                        'alias' => $valueSecions['alias'],
                        'path' => $sectionPath . DIRECTORY_SEPARATOR .trim($valueSecions['view'], DIRECTORY_SEPARATOR),
                        'url' => CL_PROTOCOL . '://' . CL_DOMAIN . DIRECTORY_SEPARATOR .  trim(CL_PACKAGES['sections']['config']['url'], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . trim($valueSecions['view'], DIRECTORY_SEPARATOR),
                        'pages' => array(
                            'include' => $valueSecions['pagesInclude'],
                            'exclude' => $valueSecions['pagesExclude'],
                        ),
                        'position' => $valueSecions['position'],
                        'ordering' => $valueSecions['ordering'],

                    );

                else:
                    Codelab::log('sections', 'error', 'Section load error [' . $sectionFileView . ']');
                endif;
            endif;
        else:
            Codelab::log('sections', 'error', 'Section has no view selected [' . $results[$keySections]['id'] . '][' . $results[$keySections]['name'] . ']');
        endif;
    endforeach;
else:
    Codelab::log('sections', 'info', 'No sections to load');
endif;
define('sections', $pageSections);
