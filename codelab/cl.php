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
DEFINE('clDomain', $_SERVER['HTTP_HOST']);
// ##### clProtocol [GLOBAL DEFINE]
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') :
	DEFINE('clProtocol', 'https');
else:
	DEFINE('clProtocol', 'http');
endif;
// ################################################
// ##### Load config file
// ################################################

$clConfigPath = clPath . DIRECTORY_SEPARATOR;
$clConfig = [];
$clConfigSource = false;
if (file_exists($clConfigPath . 'config.dev.json') AND is_file($clConfigPath . 'config.dev.json')):
	$clConfigSource = 'config.dev.json';
elseif (file_exists($clConfigPath . 'config.json') AND is_file($clConfigPath . 'config.json')):
	$clConfigSource = 'config.json';
endif;
if ($clConfigSource != false):

	// Get "package.json" file and convert to array
	$clConfigData = json_decode(file_get_contents($clConfigPath . $clConfigSource), true);
	// Check if "package.json" file content is valid json
	if (is_array($clConfigData)):
		$clConfig = $clConfigData;
		cl::log('cl', 'success', "Codelab config file  loaded [" . $clConfigSource. "]");
	else:
		$errorMessage = "Main config file is not valid [" . $clConfigSource. "]";
		cl::log('cl', 'error', $errorMessage);
	endif;
endif;


DEFINE('clConfig', $clConfig);

// ################################################
// ##### Session start
// ################################################
if (session_status() === PHP_SESSION_NONE):
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
					elseif ($value['type'] == 'warning'):
						echo 'background:orange;';
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
// ################################################
// ##### Database
// ################################################
GLOBAL $clDB;
if (@clConfig['DB']['connect'] == true):
	$clDB = @mysqli_connect(
		@clConfig['DB']['host'],
		@clConfig['DB']['user'],
		@clConfig['DB']['pass'],
		@clConfig['DB']['name'],
		@clConfig['DB']['port']
	);
	if (!mysqli_connect_errno()):
		if (isset(clConfig['DB']['characters'])):
			$charset = clConfig['DB']['characters'];
			if ($charset != '' AND $charset != null AND $charset != false):
				mysqli_query($clDB,"SET names = '" . $charset . "', character_set_results = '" . $charset . "', character_set_client = '" . $charset . "', character_set_connection = '" . $charset . "', character_set_database = '" . $charset . "', character_set_server = '" . $charset . "'");
				mysqli_set_charset($clDB, 'utf8');
			endif;
		endif;

		cl::log('DB', 'success', 'Database connected [' .  clConfig['DB']['host'] . ']') ;
	else:
		cl::log('DB', 'error', 'Database connection error [' .  clConfig['DB']['host'] . ']') ;
	endif;
endif;

class clDB {


	public static function connected(){
		global $clDB;
		if (isset($clDB) AND !empty($clDB)):
		   return true;
	   	endif;
	   	return false;
   }


	public static function disconnect(){
	 	global $clDB;
	   	if (isset($clDB) AND !empty($clDB)):
			mysqli_close($clDB);
			cl::log('clDB', 'warning', 'clDB disconnect');
			unset($clDB);
		endif;
	}
	public static function escape($string)
	{
		global $clDB;
		if (!self::connected()): die('Database no connected'); endif;
	 	if ($string != null AND !is_numeric($string) AND $string != ''):
			return mysqli_escape_string($clDB, $string);;
		endif;
		return $string;
	}
	public static function query($query)
	{
		global $clDB;
		if (self::connected()):
			cl::log('clDB', 'info', 'Query [' . $query . ']');
			return mysqli_query($clDB, $query);
		endif;
	}
	public static function fetch($results)
	{
		if (self::connected()):
		return mysqli_fetch_array($results);
		endif;
	}
	public static function columns($table)
	{

		if (self::connected()):
			$result = self::query("SHOW COLUMNS FROM `" . self::escape($table) . "`");
			$output = array();
			while($row = self::fetch($result)) :
				array_push($output,$row['Field']);
			endwhile;
			return $output;
		endif;
	}
	public static function get($param, $single = false){
		if (self::connected()):
		if (!isset($param['table'])):
			die('clDB::get table not defined');
		endif;
		if (!isset($param['limit'])):
			$param['limit'] = 100;
		endif;
		if (!isset($param['offset'])):
			$param['offset'] = 0;
		endif;
		if (!isset($param['order'])):
			$param['order'] = 'id ASC';
		endif;
		if (!isset($param['columns']) OR $param['columns'] == '*'):
			$param['columns'] = self::columns($param['table']);
	 //elseif (is_array($param['columns'])):
			//$columns = $param['columns'];
			//die('2');
		elseif (!is_array($param['columns'])):
			$param['columns'] = explode(',', $param['columns']);
		endif;
		array_push($param['columns'], 'id');
		$param['columns'] = array_unique($param['columns']);
		$param['columns'] = array_filter($param['columns']);
		$columns = '';
		foreach ($param['columns'] as $column):
			$columns .= '`' . $column . '`,';
		endforeach;
		$columns = rtrim($columns, ',');
		$where = '';
		if (isset($param['where'])):
			$where = 'WHERE ' . $param['where'];
		endif;
		$query = "SELECT " . $columns . " FROM `" . $param['table'] . "` " .  $where . " ORDER BY " . $param['order'] . "  LIMIT " . $param['limit'] . ' OFFSET ' .  $param['offset'];
		//echo $query . '<br />';

		//global $answer;
		//$answer['glob'] = $query;
		$logMessage = 'Get [' . $query . ']';
	 //   clLog::create('DB', 'info', $logMessage);
		$result = self::query($query, false);
		$output = array();
		$i = 0;
		while($row = self::fetch($result)) :
			$output[$row['id']]['clOrder'] = $i;
			foreach ($param['columns'] as $column):
				if ($single == true):
					$output[$column] = $row[$column];
					else:
					$output[$row['id']][$column] = $row[$column];
				endif;
			endforeach;
			$i++;
		endwhile;
		return $output;
	endif;
  }
	public static function insert($table, $columns)
	{
		if (self::connected()):
		$keys    = '';
		$values  = '';
		foreach ($columns as $key => $value):
			$keys .= '`' . $key . '`,';
			if ($value == null):
				$values .= "null,";
			else:
				$value  = addslashes($value);
				$values .= "'" . $value . "',";
			endif;
		endforeach;
		$keys    = trim($keys,",");
		$values  = trim($values,",");
		$query = "INSERT INTO `" . $table . "` (" . $keys . ") VALUES (" . $values . ")";
		//echo $query . '<br>';
		$logMessage = 'Insert [' . $query . ']';
 //	   clLog::create('DB', 'info', $logMessage);
		$result = self::query($query, false);
	endif;
	}
	public static function delete($table, $id) // single id or array ex. array(1,35,65)
	{
		if (self::connected()):
		if (is_array($id) AND !empty($id)):
			 foreach($id as $key => $value):
				$query = 'DELETE FROM `' . $table . '` WHERE id = ' . self::escape($value);
				$logMessage = 'Delete [' . $query . ']';
	 //		   clLog::create('DB', 'info', $logMessage);
				self::query($query, false);
			 endforeach;
			return true;
		else:
			$query = 'DELETE FROM `' . $table . '` WHERE id = ' . self::escape($id);
			$logMessage = 'Delete [' . $query . ']';
	 //	   clLog::create('DB', 'info', $logMessage);
			self::query($query, false);
			return true;
		endif;
	endif;
  }
	public static function insertID()
	{
		if (self::connected()):
		global $DB;
		return mysqli_insert_id($DB);
		endif;
	}
	public static function ids($table, $where = null) // return team groups array
	{
		if (self::connected()):
		// get pageData
		$param = array(
			'table'  => $table,
			'columns' => ['id'],
		);
		if ($where != null):
			$param['where'] = $where;
		endif;
		$results = self::get($param);
		if (empty($results)):
			return array();
		endif;
	 $output = [];
	 foreach ($results as $key => $value):
		array_push($output,  $value['id']);
	 endforeach;
		return $output;
	endif;
	}
  public static function update($table, $where, $array)
  {
	if (self::connected()):
	 $output  = '';
	 foreach ($array as $key => $value):
		$output .= "`" . $key . '`=';
		$output .= '"' . self::escape($value) . '",';
	 endforeach;
	 $output    = trim($output,",");
	 $query = "UPDATE `" . $table . "` ";
	 $query .= "SET " . $output . " ";
	 $query .= "WHERE " . $where;
		//echo $query;
		$logMessage = 'Update [' . $query . ']';
	 //   clLog::create('DB', 'info', $logMessage);
	 self::query($query, false);
	endif;
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



	$packageConfigSource = false;
	if (file_exists($packageDir . DIRECTORY_SEPARATOR. 'config.dev.json') AND is_file($packageDir .  DIRECTORY_SEPARATOR. 'config.dev.json')):
		$packageConfigSource = 'config.dev.json';
	elseif (file_exists($packageDir . DIRECTORY_SEPARATOR. 'config.json') AND is_file($packageDir . DIRECTORY_SEPARATOR. 'config.json')):
		$packageConfigSource = 'config.json';
	endif;

	if ($packageConfigSource != false):
			// Get "package.json" file and convert to array
			$packageConfig = json_decode(file_get_contents($packageDir . DIRECTORY_SEPARATOR. $packageConfigSource), true);
			// Check if "package.json" file content is valid json
			if (is_array($packageConfig)):
				cl::log($packageDirname, 'info', $packageConfigSource. ' file loaded');
				$packagesList[$packageDirname]['config'] = $packageConfig;
			else:
				cl::log($packageDirname, 'error', $packageConfigSource. ' file invalid');
				$packagesList[$packageDirname]['errors'][] = $packageConfigSource. " file is not valid json";
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
	cl::log('cl', 'success', 'All packages valid');
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


if ($packagesLoadError == false):
foreach (clPackages as $packageName => $packageData):
	if (isset($packageData['init'])):
		include($packageData['init']);
	endif;
	if (isset($packageData['class'])):
		include($packageData['class']);
	endif;
endforeach;
endif;
// ################################################
// ##### Unset all Codelab defines
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


