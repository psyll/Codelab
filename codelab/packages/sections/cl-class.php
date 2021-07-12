<?php
	/*
		CODELAB
		Homepage: https://psyll.com/products/codelab
		© Jaroslaw Szulc <jarek@psyll.com>
		© Psyll.com <info@psyll.com>
		This file is part of the Codelab package.
		Distributed under the PPCL license (http://psyll.com/license/ppcl)
	*/
namespace Codelab;
use Codelab;
class sections {
	public static function control(){
		foreach (sections as $key_sections => $value_sections):
			if (isset($value_sections['control'])):
			// Section found
				$sectionControl = CL_PATH . DIRECTORY_SEPARATOR . trim(CL_PACKAGES['sections']['config']['path'], '/') . DIRECTORY_SEPARATOR . $value_sections['view'] . DIRECTORY_SEPARATOR . 'control.php';
				//echo $sectionView  . '<hr>';
				if (file_exists($sectionControl) AND is_file($sectionControl)):
					$thisURL = wa_url . '/' .  trim(CL_PACKAGES['sections']['config']['url'], '/') . '/' . $value_sections['control'];
					include($sectionControl);
					Codelab::log('sections', 'success', 'Section control loaded [' . $sectionControl  . ']');
				endif;
			endif;
		endforeach;
	}
	public static function view($data){
		if (is_array($data)):
			foreach ($data as $key => $sectionRequire):
				foreach (sections as $key_sections => $value_sections):
					// Section found
					if ($sectionRequire == $value_sections['view']):
						$sectionView = CL_PATH . DIRECTORY_SEPARATOR . trim(CL_PACKAGES['sections']['config']['path'], '/') . DIRECTORY_SEPARATOR . $value_sections['view'] . DIRECTORY_SEPARATOR . 'view.php';
						if (file_exists($sectionView) AND is_file($sectionView)):
							include($sectionView);
							Codelab::log('sections', 'success', 'Section view loaded [' . $sectionView  . ']');
						else:
							Codelab::log('sections', 'error', 'Section view file not found [' . $sectionView  . ']');
						endif;
						break;
					endif;
				endforeach;
			endforeach;
		else:
			foreach (sections as $key_sections => $value_sections):
				// Section found
				if ($data == $value_sections['position']):
					$sectionView = CL_PATH . DIRECTORY_SEPARATOR . trim(CL_PACKAGES['sections']['config']['path'], '/') . DIRECTORY_SEPARATOR . $value_sections['view'] . DIRECTORY_SEPARATOR . 'view.php';
					//echo $sectionView  . '<hr>';
					if (file_exists($sectionView) AND is_file($sectionView)):
						$thisURL = wa_url . '/' .  trim(CL_PACKAGES['sections']['config']['url'], '/') . '/' . $value_sections['view'];
						include($sectionView);
						Codelab::log('sections', 'success', 'Section view loaded [' . $sectionView  . ']');
					else:
						Codelab::log('sections', 'error', 'Section view file not found [' . $sectionView  . ']');
					endif;
				endif;
			endforeach;
		endif;
	}
}