<?php
$param = array(
    'table' => 'sections',
    'columns' => array('id', 'name', 'alias', 'pagesInclude', 'pagesExclude',  'sectionPath', 'position', 'ordering', 'alias'),
    'where' => 'active = 1',
    'order' => 'ordering',
    'sort' => 'asc'
);
$results = clDB::get($param);
if (!empty($results)):
    $pageSections = null;
    foreach ($results as $keySections => $valueSecions):
        $section = trim($valueSecions['sectionPath'], '/');
        $path = trim(clPackages['sections']['config']['path'], DIRECTORY_SEPARATOR);
        $sectionPath =  clPath . DIRECTORY_SEPARATOR . $path ;

        $sectionFileView = $sectionPath . DIRECTORY_SEPARATOR . trim($valueSecions['sectionPath'], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'view.php';

        $pagesInclude = json_decode($valueSecions['pagesInclude'],true);
        $pagesExclude = json_decode($valueSecions['pagesExclude'],true);
        if (($valueSecions['pagesInclude'] == '*' OR (is_array($pagesInclude) AND in_array(page['id'],$pagesInclude))) AND (!is_array($pagesExclude) OR !in_array(page['id'],$pagesExclude))):
            if (file_exists($sectionFileView) AND is_file($sectionFileView)):
                $pageSections[$valueSecions['position']][] = array(
                    'id' => $valueSecions['id'],
                    'name' => $valueSecions['name'],
                    'alias' => $valueSecions['alias'],
                    'path' => $sectionPath . DIRECTORY_SEPARATOR .trim($valueSecions['sectionPath'], DIRECTORY_SEPARATOR),
                    'url' => clProtocol . '://' . clDomain . DIRECTORY_SEPARATOR .  trim(clPackages['sections']['config']['url'], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . trim($valueSecions['sectionPath'], DIRECTORY_SEPARATOR),
                    'pages' => array(
                        'include' => $valueSecions['pagesInclude'],
                        'exclude' => $valueSecions['pagesExclude'],
                    ),
                    'position' => $valueSecions['position'],
                    'ordering' => $valueSecions['ordering'],
                );

                //https://psyll.com/sub/sections/header
                //foreach (cl['assets']['auto'] as $sectionsAssetsFileKey => $sectionsAssetsFileValue):
                //    $sectionAssetsFile = clFormat::path($sectionPath . $sectionsAssetsFileValue);
                //    if (file_exists($sectionAssetsFile) AND is_file($sectionAssetsFile)):
                //        clAssets::add($section . '/' . $sectionsAssetsFileValue, 102);
               //     endif;
               // endforeach;
            else:
                cl::log('sections', 'error', 'Section load error [' . $sectionFileView . ']');
            endif;
        endif;
    endforeach;
else:
    cl::log('sections', 'info', 'No sections to load');
endif;
define('sections', $pageSections);
