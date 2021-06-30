<?php
/*
	CODELAB
	© Jaroslaw Szulc <jarek@psyll.com>
	© Psyll.com <info@psyll.com>
	This file is part of the Codelab package.
	Distributed under the PPCL license (http://psyll.com/license/ppcl)
*/
// ################################################
// ##### System defines
// ################################################
// ##### Load start
DEFINE('clLoad_start', microtime());
// ##### Set version
DEFINE('clVersion', '1.0.0');
// ##### Set codename
DEFINE('clCodename', 'alpha');
// ##### Define codelab path
DEFINE('clPath', __DIR__);
// ################################################
// ##### Session start
// ################################################
if(session_id() == ''):
    session_start();
endif;
// ################################################
// ##### Function
// ################################################
$_SESSION['clLog'] = [];
class cl {
	public static function log(string $source, string $type, string $message){
		$_SESSION['clLog'][microtime()] = ['source' => $source, 'type' => $type, 'message' => $message];
	}
	public static function logs(){
		return $_SESSION['clLog'];
	}
	public static function output(){
		$logs = self::logs();
		echo '<div class="clLogs" style="background:#1f2f49;border:1px solid black;padding:4px;color:white;font-family:Courier New,monospace;font-size:14px;line-height:16px;margin:0">';
		echo '<div class="clLogs_header" style="color:white;background:#101826;padding:4px 8px;font-size:22px;line-height:22px;">Codelab output</div>';
			foreach ($logs as $key => $value):
				echo '<div class="clLogs_log" style="';
					if ($value['type'] == 'success'):
						echo 'background:#24491f;';
					elseif ($value['type'] == 'error'):
						echo 'background:#511c1c;';
					endif;
				echo 'color:white;display:grid;grid-template-columns:1fr 1fr 3fr;border-bottom:1px solid #1b2942;padding:2px 4px;">';
					echo '<div class="clLogs_source" style="font-weight:900">' . $value['source'] . '</div>';
					echo '<div class="clLogs_type" style="">' . $value['type'] . '</div>';
					$value['message']  = str_replace(["[", "]"], ['<span style="color:#ffac10">[', ']</span>'], $value['message']);
					echo '<div class="clLogs_message" style="">' . $value['message'] . '</div>';
				echo '</div>';
			endforeach;
		echo '</div>';
	}
}
function clPackages_sortItem($pointer, &$dependency, &$order, &$pre_processing, &$reportError){
    if(in_array($pointer, $pre_processing)):
		 return false;
	else:
		$pre_processing[] = $pointer;
	endif;
    if(isset($dependency[$pointer])):
		if(is_array($dependency[$pointer])):
			foreach($dependency[$pointer] as $master):
				if(isset($dependency[$master])):
					if(!clPackages_sortItem($master, $dependency, $order, $pre_processing, $reportError)):
						$reportError = array($pointer, $master);
						return false;
					endif;
				endif;
				if(!in_array($master,$order)) $order[] = $master;
				$preProcessingKey = array_search($master, $pre_processing);
				if($preProcessingKey !== false) unset($pre_processing[$preProcessingKey]);
			endforeach;
		else:
			$master = $dependency[$pointer];
			if(isset($dependency[$master])):
				if(!clPackages_sortItem($master, $dependency, $order, $pre_processing, $reportError)):
					$reportError = array($pointer, $master);
					return false;
				endif;
			endif;
			if(!in_array($master,$order)) $order[] = $master;
			$preProcessingKey = array_search($master, $pre_processing);
			if($preProcessingKey !== false) unset($pre_processing[$preProcessingKey]);
		endif;
    endif;

    if(!in_array($pointer,$order)) $order[] = $pointer;
    $preProcessingKey = array_search($pointer, $pre_processing);
    if($preProcessingKey !== false) unset($pre_processing[$preProcessingKey]);
    return true;
}
function clPackages_sort($data, $dependency, &$reportError = null){
    $order = array();
    $pre_processing = array();
    foreach($data as $item):
        if(!clPackages_sortItem($item,$dependency,$order, $pre_processing, $reportError)) return false;
	endforeach;
    return $order;
}
// ################################################
// ##### Initial logs
// ################################################
cl::log('cl', 'info', 'Codelab init');
cl::log('cl', 'info', '[clLoad_start] defined: ' . clLoad_start);
cl::log('cl', 'info', '[clVersion] defined: ' . clVersion);
cl::log('cl', 'info', '[clCodename] defined: ' . clCodename);
cl::log('cl', 'info', '[clPath] defined: ' . clPath);
// ################################################
// ##### Packages
// ################################################
// Create packages path
$packagesPath = clPath . DIRECTORY_SEPARATOR . 'packages';



if (!is_dir($packagesPath)):
	mkdir($packagesPath, 0777, true);
endif;

// Create all packages dirs list
$packagesDirs = array_filter(glob($packagesPath . DIRECTORY_SEPARATOR .  '*'), 'is_dir');
unset($packagesPath);
// ### Build packages list array
$packagesList = [];
$packageOrder = 1;
$packagesDependiences = [];
$packagesItems = [];
foreach ($packagesDirs as $packageDir):
	$packageErrors = [];
	// Get package folder name
	$packageDirname = basename($packageDir);
	// Get "package.json" file path
	$packageFile_JSON = $packageDir . DIRECTORY_SEPARATOR . "package.json";
	// Check if "package.json" exist
	// "package.json" file exists
	if (file_exists($packageFile_JSON) AND is_file($packageFile_JSON)):
		// Get "package.json" file and convert to array
		$package_JSON = json_decode(file_get_contents($packageFile_JSON), true);
		// Check if "package.json" file content is valid json
		if (!is_array($package_JSON)):
			$packageErrorMessage = "packages.json file is not valid json";
			cl::log($packageDirname, 'error', $packageErrorMessage);
			$packageErrors[] = $packageErrorMessage;
		// is valid json
		else:
			// Check for required package name
			if (!isset($package_JSON['name'])):
				$packageErrorMessage = "package name is not valid";
				cl::log($packageDirname, 'error', $packageErrorMessage);
				$packageErrors[] = $packageErrorMessage;
			endif;
			// Check for required package version
			if (!isset($package_JSON['version'])):
				$packageErrorMessage = "package version is not valid";
				cl::log($packageDirname, 'error', $packageErrorMessage);
				$packageErrors[] = $packageErrorMessage;
			endif;
		endif;
	else:
		$packageErrorMessage = "The packages.json file is missing";
		$packageErrors[$packageDirname] = $packageErrorMessage;
		cl::log($packageDirname, 'error', $packageErrorMessage);
	endif;
	// Insert package into packages list
	$packagesList[$packageDirname] = $package_JSON;
	// Package has no errors
	if (empty($packageErrors)):
		// Package.json file valid = enable
		// Set load order if package dont have "reqire"
		if (!isset($package_JSON['require']) OR empty($package_JSON['require'])):
			$packagesDependiences[$packageDirname] = [];
		else:
			foreach ($package_JSON['require'] as $requireName => $requireVersion):
				$packagesDependiences[$packageDirname][] = $requireName;
			endforeach;
		endif;
		$packagesItems[] = $packageDirname;
	// Package has errors
	else:
		$packagesList[$packageDirname]['errors'] = $packageErrors;
	endif;
	$packagesList[$packageDirname]['dir'] = $packageDirname;
	$packagesList[$packageDirname]['path'] = $packageDir;
	$packageFile_INIT = $packageDir  . DIRECTORY_SEPARATOR .  "init.php";
	if (file_exists($packageFile_INIT) AND is_file($packageFile_INIT)):
		cl::log($packageDirname, 'info', 'init.php file loaded');
		$packagesList[$packageDirname]['init'] =  $packageFile_INIT;
	endif;
	$packageFile_CLASS = $packageDir  . DIRECTORY_SEPARATOR .  "class.php";
	if (file_exists($packageFile_CLASS) AND is_file($packageFile_CLASS)):
		cl::log($packageDirname, 'info', 'class.php file loaded');
		$packagesList[$packageDirname]['class'] =  $packageFile_CLASS;
	endif;
	$packageFile_CONFIG = $packageDir  . DIRECTORY_SEPARATOR .  "config.json";
	$packageFile_CONFIG_TEST = $packageDir  . DIRECTORY_SEPARATOR .  "config.test.json";

		if (file_exists($packageFile_CONFIG) AND is_file($packageFile_CONFIG)):
			// Get "package.json" file and convert to array
			$packageConfig = json_decode(file_get_contents($packageFile_CONFIG), true);
			// Check if "package.json" file content is valid json
			if (is_array($packageConfig)):
				cl::log($packageDirname, 'info', 'config.json file loaded');
				$packagesList[$packageDirname]['config'] = $packageConfig;
			else:
				cl::log($packageDirname, 'error', 'config.json file invalid');
				$packagesList[$packageDirname]['errors'][] = "config.json  file is not valid json";
			endif;
		endif;
endforeach;
unset($packagesDirs);
// Chekc if all dependiendiences exists
foreach ($packagesList as $packageName => $packageData):
	if (isset($packageData['require'])):
		foreach ($packageData['require'] as $dependiencyName => $dependiencyVersion):
			// Dependency name not exists
			if (!isset($packagesList[$dependiencyName])):
				$errorMessage = 'require package "' . $dependiencyName . '" does not exists';;
				cl::log($packageName, 'error', $errorMessage);
				$packagesList[$packageName]['errors'][] = $errorMessage;
			// Dependency exists - check version
			else:
				if(isset($packagesList[$dependiencyName]['version']) AND version_compare($dependiencyVersion, $packagesList[$dependiencyName]['version'], '>')):
					$errorMessage = "Required package [" . $dependiencyName . " " .  $dependiencyVersion . "] does not match installed version [" . $packagesList[$dependiencyName]['version']  . "]";
					cl::log($packageName, 'error', $errorMessage);
					$packagesList[$packageName]['errors'][] = $errorMessage;
				endif;
			endif;
		endforeach;
	endif;
endforeach;
$packagesErrors = array();
$packagesLoadOrder = clPackages_sort($packagesItems, $packagesDependiences, $packagesErrors);
foreach ($packagesErrors as $packageErrorName):
	$errorMessage = 'require unsolved';
	$packagesList[$packageErrorName]['errors'][] = $errorMessage;
	cl::log($packageErrorName, 'error', $errorMessage);
endforeach;
// Check if any package has error
$packagesInvalid = '';
$packagesLoadError = false;
foreach ($packagesList as $packageName => $packageData):
	if (isset($packageData['errors']) AND !empty($packageData['errors'])):
		$packagesLoadError = true;
		$packagesInvalid = $packageName . ', ';
	endif;
endforeach;
$packagesInvalid = rtrim($packagesInvalid, ', ');

cl::log('cl', 'info', '[clPackages] defined as list of all packages');
// No errors found - load packages

if ($packagesLoadError == true):
	cl::log('cl', 'error', 'Codelab will not load the data. Packages not valid [' . $packagesInvalid . ']');
else:
	cl::log('cl', 'info', 'All packages valid');
	$order = 0;
	foreach ($packagesLoadOrder as $packageName):
		$packagesList[$packageName]['order'] = $order;
		$order++;
	endforeach;
	function sortByOrder($a, $b) {
		return $a['order'] - $b['order'];
	}
	usort($packagesList, 'sortByOrder');
	foreach ($packagesList as $packageOrder => $packageData):
	   	$packagesList[strtolower($packageData['name'])] = $packageData;
	   	unset($packagesList[$packageOrder]);
	endforeach;

endif;
DEFINE('clPackages', $packagesList);
foreach (clPackages as $packageName => $packageData):
	if (isset($packageData['init'])):
		include($packageData['init']);
	endif;
	if (isset($packageData['class'])):
		include($packageData['class']);
	endif;
endforeach;
// ################################################
// ##### Unset all defines
// ################################################
unset($packagesList);
unset($packageOrder);
unset($packagesDependiences);
unset($packagesItems);
unset($packageDir);
unset($packageErrors);
unset($packageDirname);
unset($packageFile_JSON);
unset($package_JSON);
unset($packageErrorMessage);
unset($requireVersion);
unset($requireName);
unset($packageFile_INIT);
unset($packageFile_CLASS);
unset($packageFile_CONFIG);
unset($packageConfig);
unset($packageData);
unset($packageName);
unset($dependiencyVersion);
unset($dependiencyName);
unset($packagesErrors);
unset($packagesLoadOrder);
unset($packagesInvalid);
unset($packagesLoadError);
// ################################################
// ##### End
// ################################################
DEFINE('clLoad_end', microtime());
cl::log('cl', 'info', '[clLoad_end] defined: ' . clLoad_end);
// Count load time
$time = explode(' ', clLoad_start);
$start = $time[1] + $time[0];
$time = explode(' ', clLoad_end);
$finish = $time[1] + $time[0];
$total_time = round(($finish - $start), 4);
cl::log('cl', 'info', 'System loaded in ' . $total_time . 's');

