<?php

	/*
		CODELAB
		Homepage: https://psyll.com/products/codelab
		© Jaroslaw Szulc <jarek@psyll.com>
		© Psyll.com <info@psyll.com>
		This file is part of the Codelab package.
		Distributed under the PPCL license (http://psyll.com/license/ppcl)
	*/
namespace cl;
use cl;
class sections {

	public static function get($data){
		if (is_array($data)):
			foreach ($data as $key => $sectionRequire):
			   foreach (sections as $key_sections => $value_sections):
					// Section found
					if ($sectionRequire == $value_sections['view']):
						$sectionView = clPath . DIRECTORY_SEPARATOR . trim(clPackages['sections']['config']['path'], '/') . DIRECTORY_SEPARATOR . $value_sections['view'] . DIRECTORY_SEPARATOR . 'view.php';
						if (file_exists($sectionView) AND is_file($sectionView)):
							include($sectionView);
							cl::log('sections', 'success', 'Section view loaded [' . $sectionView  . ']');
						else:
							cl::log('sections', 'error', 'Section view file not found [' . $sectionView  . ']');
						endif;
						break;
					endif;
			   endforeach;
			endforeach;
		else:
			foreach (sections as $key_sections => $value_sections):
				// Section found
				if ($data == $value_sections['position']):
					$sectionView = clPath . DIRECTORY_SEPARATOR . trim(clPackages['sections']['config']['path'], '/') . DIRECTORY_SEPARATOR . $value_sections['view'] . DIRECTORY_SEPARATOR . 'view.php';
					//echo $sectionView  . '<hr>';
					if (file_exists($sectionView) AND is_file($sectionView)):
						$thisURL = wa_url . '/' .  trim(clPackages['sections']['config']['url'], '/') . '/' . $value_sections['view'];
						include($sectionView);
						cl::log('sections', 'success', 'Section view loaded [' . $sectionView  . ']');
					else:
						cl::log('sections', 'error', 'Section view file not found [' . $sectionView  . ']');
					endif;
				endif;
		   endforeach;
		endif;

	}

}