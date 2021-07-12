<?php
/**file
 * @name        Codelab
 * @version     1.0
 * @author      Jarek Szulc <jarek@psyll.com> <https://psyll.com/profile/jarek>
 * @author      Psyll.com Dev <dev@psyll.com>
 * @link        Project Homepage http://psyll.com/products/codelab
 * @link        Project Codumentation http://psyll.com/products/codelab
 * @license     https://psyll.com/license/ppcl-psyll-public-code-license Psyll Public Code License
 * @copyright   2021 Psyll.com
 */
// ################################################
// ##### System defines
// ################################################
// ##### Load start
DEFINE("CL_START", microtime());
// ##### Set version
DEFINE("CL_VERSION", "1.0");
// ##### Set codename
DEFINE("CL_CODENAME", "alpha");
// ##### Define codelab path
DEFINE("CL_PATH", __DIR__);
DEFINE("CL_DOMAIN", $_SERVER["HTTP_HOST"]);
// ##### CL_PROTOCOL [GLOBAL DEFINE]
if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "off") :
    DEFINE("CL_PROTOCOL", "https");
else :
    DEFINE("CL_PROTOCOL", "http");
endif;
DEFINE("CL_QUERY", $_SERVER['REQUEST_URI']);
DEFINE('CL_URL', CL_PROTOCOL . "://" . CL_DOMAIN . CL_QUERY);
// ################################################
// ##### Load config file
// ################################################
$CL_CONFIGPath = CL_PATH . DIRECTORY_SEPARATOR;
$CL_CONFIG = [];
$CL_CONFIGSource = false;
if (file_exists($CL_CONFIGPath . "cl-config.dev.json") and is_file($CL_CONFIGPath . "cl-config.dev.json")) :
    $CL_CONFIGSource = "cl-config.dev.json";
elseif (file_exists($CL_CONFIGPath . "cl-config.json") and is_file($CL_CONFIGPath . "cl-config.json")) :
    $CL_CONFIGSource = "cl-config.json";
endif;
if ($CL_CONFIGSource != false) :
    // Get "package.json" file and convert to array
    $CL_CONFIGData = json_decode(file_get_contents($CL_CONFIGPath . $CL_CONFIGSource), true);
    // Check if "package.json" file content is valid json
    if (is_array($CL_CONFIGData)) :
            $CL_CONFIG = $CL_CONFIGData;
            Codelab::log("cl", "success", "Codelab config file  loaded [" . $CL_CONFIGSource . "]");
    else :
            $errorMessage = "Main config file is not valid [" . $CL_CONFIGSource . "]";
            Codelab::log("cl", "error", $errorMessage);
    endif;
endif;
DEFINE("CL_CONFIG", $CL_CONFIG);
// ################################################
// ##### Session start
// ################################################
if (session_status() === PHP_SESSION_NONE) :
    session_start();
endif;
$_SESSION["clLog"] = [];
class Codelab
{
    // In ##################################################################
    public static function packageInstalled(string $packageName)
    {
        if (isset(CL_PACKAGES[strtolower($packageName)])) :
            return true;
        else :
            return false;
        endif;
    }
    public static function packageConfigRead(string $packageDir)
    {
        // Create packages path
        $packagePath = CL_PATH . DIRECTORY_SEPARATOR . "packages" . DIRECTORY_SEPARATOR . $packageDir;
        $packageConfigSource = false;
        if (file_exists($packagePath . DIRECTORY_SEPARATOR . "config.dev.json") and is_file($packagePath . DIRECTORY_SEPARATOR . "config.dev.json")) :
            $packageConfigSource = "config.dev.json";
        elseif (file_exists($packagePath . DIRECTORY_SEPARATOR . "config.json") and is_file($packagePath . DIRECTORY_SEPARATOR . "config.json")) :
            $packageConfigSource = "config.json";
        endif;
        if ($packageConfigSource != false) :
            // Get "package.json" file and convert to array
            $packageConfig = json_decode(
                file_get_contents(
                    $packagePath . DIRECTORY_SEPARATOR . $packageConfigSource
                ),
                true
            );
            // Check if "package.json" file content is valid json
            if (is_array($packageConfig)) :
                return $packageConfig;
            else :
                Codelab::log(
                    $packageDir,
                    "error",
                    "[" . $packageConfigSource . "] file invalid"
                );
                return false;
            endif;
        endif;
    }
    // In ##################################################################
    public static function requireAjax()
    {
        if (!self::isAjax()) :
            die("Codelab Error: Ajax required");
        endif;
    }
    // In ##################################################################
    public static function isAjax()
    {
        if (empty($_SERVER["HTTP_X_REQUESTED_WITH"]) or strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) != "xmlhttprequest") :
            return false;
        endif;
        return true;
    }
    // In ##################################################################
    public static function requirePost()
    {
        if (!self::isPost()) :
            die("Codelab Error: POST required");
        endif;
    }
    // In ##################################################################
    public static function isPost()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") :
            return true;
        endif;
        return false;
    }
    public static function headerStatus(int $statusCode)
    {
        static $status_codes = null;
        if ($status_codes === null) {
            $status_codes = [
                100 => "Continue",
                101 => "Switching Protocols",
                102 => "Processing",
                200 => "OK",
                201 => "Created",
                202 => "Accepted",
                203 => "Non-Authoritative Information",
                204 => "No Content",
                205 => "Reset Content",
                206 => "Partial Content",
                207 => "Multi-Status",
                300 => "Multiple Choices",
                301 => "Moved Permanently",
                302 => "Found",
                303 => "See Other",
                304 => "Not Modified",
                305 => "Use Proxy",
                307 => "Temporary Redirect",
                400 => "Bad Request",
                401 => "Unauthorized",
                402 => "Payment Required",
                403 => "Forbidden",
                404 => "Not Found",
                405 => "Method Not Allowed",
                406 => "Not Acceptable",
                407 => "Proxy Authentication Required",
                408 => "Request Timeout",
                409 => "Conflict",
                410 => "Gone",
                411 => "Length Required",
                412 => "Precondition Failed",
                413 => "Request Entity Too Large",
                414 => "Request-URI Too Long",
                415 => "Unsupported Media Type",
                416 => "Requested Range Not Satisfiable",
                417 => "Expectation Failed",
                422 => "Unprocessable Entity",
                423 => "Locked",
                424 => "Failed Dependency",
                426 => "Upgrade Required",
                500 => "Internal Server Error",
                501 => "Not Implemented",
                502 => "Bad Gateway",
                503 => "Service Unavailable",
                504 => "Gateway Timeout",
                505 => "HTTP Version Not Supported",
                506 => "Variant Also Negotiates",
                507 => "Insufficient Storage",
                509 => "Bandwidth Limit Exceeded",
                510 => "Not Extended",
            ];
        }
        if (11 == 22) {
        }
        if ($status_codes[$statusCode] !== null) :
            $status_string = $statusCode . " " . $status_codes[$statusCode];
            header(
                $_SERVER["SERVER_PROTOCOL"] . " " . $status_string,
                true,
                $statusCode
            );
            Codelab::log(
                "cl",
                "success",
                "header status set as [" . $status_string . "]"
            );
        else :
            Codelab::log(
                "cl",
                "error",
                "header status not allowed [" . $statusCode . "]"
            );
        endif;
    }
    public static function headers(string $headerName = null)
    {
        $headers = [];
        if ($headerName == null) :
            foreach (headers_list() as $header) :
                $headerArray = explode(":", $header);
                $headers[$headerArray[0]] = substr(
                    $header,
                    strlen($headerArray[0]) + 2
                );
            endforeach;
            return $headers;
        else :
            foreach (headers_list() as $header) :
                $headerArray = explode(":", $header);
                if (strtolower($headerArray[0]) == strtolower($headerName)) :
                    return substr($header, strlen($headerArray[0]) + 2);
                endif;
            endforeach;
        endif;
    }
    public static function log(string $source, string $type, string $message)
    {
        $_SESSION["clLog"][microtime()] = [
            "source" => $source,
            "type" => $type,
            "message" => $message,
        ];
    }
    public static function logs()
    {
        return $_SESSION["clLog"];
    }
    public static function output()
    {
        $logs = self::logs();
        echo '<div class="clLogs" style="background:#1f2f49;border:1px solid black;padding:4px;color:white;font-family:Courier New,monospace;font-size:14px;line-height:16px;margin:0">';
        echo '<div class="clLogs_header" style="color:white;background:#101826;padding:4px 8px;font-size:22px;line-height:22px;">Codelab output</div>';
        foreach ($logs as $key => $value) :
            echo '<div class="clLogs_log clLogs_log_' .
                $value["type"] .
                '" style="';
            if ($value["type"] == "success") :
                echo "background:#24491f;";
            elseif ($value["type"] == "error") :
                echo "background:#511c1c;";
            elseif ($value["type"] == "warning") :
                echo "background:#77390c;";
            endif;
            echo 'color:white;display:grid;grid-template-columns:1fr 1fr 3fr;border-bottom:1px solid #1b2942;padding:2px 4px;">';
            echo '<div class="clLogs_source" style="font-weight:900">' .
                $value["source"] .
                "</div>";
            echo '<div class="clLogs_type" style="">' .
                $value["type"] .
                "</div>";
            $value["message"] = str_replace(
                ["[", "]"],
                ['<span style="color:#ffac10">[', "]</span>"],
                $value["message"]
            );
            echo '<div class="clLogs_message" style="">' .
                $value["message"] .
                "</div>";
            echo "</div>";
        endforeach;
        echo "</div>";
    }
}
// ################################################
// ##### Database
// ################################################
global $CodelabDB;
if (@CL_CONFIG["DB"]["connect"] == true) :
    $CodelabDB = @mysqli_connect(
        @CL_CONFIG["DB"]["host"],
        @CL_CONFIG["DB"]["user"],
        @CL_CONFIG["DB"]["pass"],
        @CL_CONFIG["DB"]["name"],
        @CL_CONFIG["DB"]["port"]
    );
    if (!mysqli_connect_errno()) :
        if (isset(CL_CONFIG["DB"]["characters"])) :
            $charset = CL_CONFIG["DB"]["characters"];
            if ($charset != "" and $charset != null and $charset != false) :
                mysqli_query(
                    $CodelabDB,
                    "SET names = '" .
                        $charset .
                        "', character_set_results = '" .
                        $charset .
                        "', character_set_client = '" .
                        $charset .
                        "', character_set_connection = '" .
                        $charset .
                        "', character_set_database = '" .
                        $charset .
                        "', character_set_server = '" .
                        $charset .
                        "'"
                );
                mysqli_set_charset($CodelabDB, "utf8");
            endif;
        endif;
        Codelab::log(
            "CodelabDB",
            "success",
            "Database connected [" . CL_CONFIG["DB"]["host"] . "]"
        );
    else :
        Codelab::log(
            "CodelabDB",
            "error",
            "Database connection error [" . CL_CONFIG["DB"]["host"] . "]"
        );
    endif;
endif;
class CodelabDB
{
    public static function connected()
    {
        global $CodelabDB;
        if (isset($CodelabDB) and !empty($CodelabDB)) :
            return true;
        endif;
        return false;
    }
    public static function disconnect()
    {
        global $CodelabDB;
        if (isset($CodelabDB) and !empty($CodelabDB)) :
            mysqli_close($CodelabDB);
            Codelab::log("CodelabDB", "warning", "CodelabDB disconnect");
            unset($CodelabDB);
        endif;
    }
    public static function escape(string $string)
    {
        global $CodelabDB;
        if (!self::connected()) :
            die("Database no connected");
        endif;
        if ($string != null and !is_numeric($string) and $string != "") :
            return mysqli_escape_string($CodelabDB, $string);
        endif;
        return $string;
    }
    public static function query(string $query)
    {
        global $CodelabDB;
        if (self::connected()) :
            Codelab::log("CodelabDB", "info", "Query [" . $query . "]");
            return mysqli_query($CodelabDB, $query);
        endif;
    }
    public static function fetch($results)
    {
        if (self::connected()) :
            return mysqli_fetch_array($results);
        endif;
    }
    public static function columns($table)
    {
        if (self::connected()) :
            $result = self::query(
                "SHOW COLUMNS FROM `" . self::escape($table) . "`"
            );
            $output = [];
            while ($row = self::fetch($result)) :
                array_push($output, $row["Field"]);
            endwhile;
            return $output;
        endif;
    }
    public static function get(array $param, $single = false)
    {
        if (self::connected()) :
            if (!isset($param["table"])) :
                die("CodelabDB::get table not defined");
            endif;
            if (!isset($param["limit"])) :
                $param["limit"] = 100;
            endif;
            if (!isset($param["offset"])) :
                $param["offset"] = 0;
            endif;
            if (!isset($param["order"])) :
                $param["order"] = "id ASC";
            endif;
            if (!isset($param["columns"]) or $param["columns"] == "*") :
                $param["columns"] = self::columns($param["table"]);
            //elseif (is_array($param['columns'])):
            //$columns = $param['columns'];
            //die('2');
            elseif (!is_array($param["columns"])) :
                $param["columns"] = explode(",", $param["columns"]);
            endif;
            array_push($param["columns"], "id");
            $param["columns"] = array_unique($param["columns"]);
            $param["columns"] = array_filter($param["columns"]);
            $columns = "";
            foreach ($param["columns"] as $column) :
                $columns .= "`" . $column . "`,";
            endforeach;
            $columns = rtrim($columns, ",");
            $where = "";
            if (isset($param["where"]) and $param["where"] != "") :
                $where = "WHERE " . $param["where"];
            endif;
            $query =
                "SELECT " .
                $columns .
                " FROM `" .
                $param["table"] .
                "` " .
                $where .
                " ORDER BY " .
                $param["order"] .
                "  LIMIT " .
                $param["limit"] .
                " OFFSET " .
                $param["offset"];
            //echo $query . '<br />';
            //global $answer;
            //$answer['glob'] = $query;
            $logMessage = "Get [" . $query . "]";
            //   clLog::create('DB', 'info', $logMessage);
            $result = self::query($query, false);
            $output = [];
            $i = 0;
            while ($row = self::fetch($result)) :
                $output[$row["id"]]["clOrder"] = $i;
                foreach ($param["columns"] as $column) :
                    if ($single == true) :
                        $output[$column] = $row[$column];
                    else :
                        $output[$row["id"]][$column] = $row[$column];
                    endif;
                endforeach;
                $i++;
            endwhile;
            return $output;
        endif;
    }
    public static function insert(string $table, array $columns)
    {
        if (self::connected()) :
            $keys = "";
            $values = "";
            foreach ($columns as $key => $value) :
                $keys .= "`" . $key . "`,";
                if ($value == null) :
                    $values .= "null,";
                else :
                    $value = addslashes($value);
                    $values .= "'" . $value . "',";
                endif;
            endforeach;
            $keys = trim($keys, ",");
            $values = trim($values, ",");
            $query =
                "INSERT INTO `" .
                $table .
                "` (" .
                $keys .
                ") VALUES (" .
                $values .
                ")";
            //echo $query . '<br>';
            $logMessage = "Insert [" . $query . "]";
            // clLog::create('DB', 'info', $logMessage);
            $result = self::query($query, false);
        endif;
    }
    public static function delete(string $table, $id)
    {
        // single id or array ex. array(1,35,65)
        if (self::connected()) :
            if (is_array($id) and !empty($id)) :
                foreach ($id as $key => $value) :
                    $query =
                        "DELETE FROM `" .
                        $table .
                        "` WHERE id = " .
                        self::escape($value);
                    $logMessage = "Delete [" . $query . "]";
                    // clLog::create('DB', 'info', $logMessage);
                    self::query($query, false);
                endforeach;
                return true;
            // clLog::create('DB', 'info', $logMessage);
            else :
                $query =
                    "DELETE FROM `" .
                    $table .
                    "` WHERE id = " .
                    self::escape($id);
                $logMessage = "Delete [" . $query . "]";
                self::query($query, false);
                return true;
            endif;
        endif;
    }
    public static function insertID()
    {
        if (self::connected()) :
            global $DB;
            return mysqli_insert_id($DB);
        endif;
    }
    public static function ids($table, $where = null)
    {
        if (self::connected()) :
            $param = [
                "table" => $table,
                "columns" => ["id"],
            ];
            if ($where != null) :
                $param["where"] = $where;
            endif;
            $results = self::get($param);
            if (empty($results)) :
                return [];
            endif;
            $output = [];
            foreach ($results as $key => $value) :
                array_push($output, $value["id"]);
            endforeach;
            return $output;
        endif;
    }
    public static function update(string $table, string $where, array $fields)
    {
        if (self::connected()) :
            $output = "";
            foreach ($fields as $key => $value) :
                $output .= "`" . $key . "`=";
                $output .= '"' . self::escape($value) . '",';
            endforeach;
            $output = trim($output, ",");
            $query = "UPDATE `" . $table . "` ";
            $query .= "SET " . $output . " ";
            $query .= "WHERE " . $where;
            //echo $query;
            $logMessage = "Update [" . $query . "]";
            //   clLog::create('DB', 'info', $logMessage);
            self::query($query, false);
        endif;
    }
}
function CL_PACKAGES_sortItem(
    $pointer,
    &$dependency,
    &$order,
    &$pre_processing,
    &$reportError
) {
    if (in_array($pointer, $pre_processing)) :
        return false;
    else :
        $pre_processing[] = $pointer;
    endif;
    if (isset($dependency[$pointer])) :
        if (is_array($dependency[$pointer])) :
            foreach ($dependency[$pointer] as $master) :
                if (isset($dependency[$master])) :
                    if (!CL_PACKAGES_sortItem($master, $dependency, $order, $pre_processing, $reportError)) :
                        $reportError = [$pointer, $master];
                        return false;
                    endif;
                endif;
                if (!in_array($master, $order)) {
                    $order[] = $master;
                }
                $preProcessingKey = array_search($master, $pre_processing);
                if ($preProcessingKey !== false) {
                    unset($pre_processing[$preProcessingKey]);
                }
            endforeach;
        else :
            $master = $dependency[$pointer];
            if (isset($dependency[$master])) :
                if (!CL_PACKAGES_sortItem($master, $dependency, $order, $pre_processing, $reportError)) :
                    $reportError = [$pointer, $master];
                    return false;
                endif;
            endif;
            if (!in_array($master, $order)) {
                $order[] = $master;
            }
            $preProcessingKey = array_search($master, $pre_processing);
            if ($preProcessingKey !== false) {
                unset($pre_processing[$preProcessingKey]);
            }
        endif;
    endif;
    if (!in_array($pointer, $order)) {
        $order[] = $pointer;
    }
    $preProcessingKey = array_search($pointer, $pre_processing);
    if ($preProcessingKey !== false) {
        unset($pre_processing[$preProcessingKey]);
    }
    return true;
}
function CL_PACKAGES_sort($data, $dependency, &$reportError = null)
{
    $order = [];
    $pre_processing = [];
    foreach ($data as $item) :
        if (!CL_PACKAGES_sortItem($item, $dependency, $order, $pre_processing, $reportError)) :
            return false;
        endif;
    endforeach;
    return $order;
}
// ################################################
// ##### Initial logs
// ################################################
Codelab::log("cl", "info", "Codelab init");
Codelab::log("cl", "info", "[CL_START] defined: " . CL_START);
Codelab::log("cl", "info", "[CL_VERSION] defined: " . CL_VERSION);
Codelab::log("cl", "info", "[CL_CODENAME] defined: " . CL_CODENAME);
Codelab::log("cl", "info", "[CL_PATH] defined: " . CL_PATH);
// ################################################
// ##### Packages
// ################################################
// Create packages path
$packagesPath = CL_PATH . DIRECTORY_SEPARATOR . "packages";
if (!is_dir($packagesPath)) :
    mkdir($packagesPath, 0777, true);
endif;
// Create all packages dirs list
$packagesDirs = array_filter(
    glob($packagesPath . DIRECTORY_SEPARATOR . "*"),
    "is_dir"
);
unset($packagesPath);
// ### Build packages list array
$packagesList = [];
$packageOrder = 1;
$packagesDependiences = [];
$packagesItems = [];
foreach ($packagesDirs as $packageDir) :
    $packageErrors = [];
    // Get package folder name
    $packageDirname = basename($packageDir);
    // Get "package.json" file path
    $packageFile_JSON = $packageDir . DIRECTORY_SEPARATOR . "cl-package.json";
    // Check if "package.json" exist
    // "package.json" file exists
    if (file_exists($packageFile_JSON) and is_file($packageFile_JSON)) :
        // Get "package.json" file and convert to array
        $package_JSON = json_decode(file_get_contents($packageFile_JSON), true);
        // Check if "package.json" file content is valid json
        if (!is_array($package_JSON)) :
            $packageErrorMessage = "cl-package.json file is not valid json";
            Codelab::log($packageDirname, "error", $packageErrorMessage);
            $packageErrors[] = $packageErrorMessage;
        // is valid json
        // Check for required package name
        // Check for required package version
        else :
            if (!isset($package_JSON["name"])) :
                $packageErrorMessage = "package name is not valid";
                Codelab::log($packageDirname, "error", $packageErrorMessage);
                $packageErrors[] = $packageErrorMessage;
            endif;
            if (!isset($package_JSON["version"])) :
                $packageErrorMessage = "package version is not valid";
                Codelab::log($packageDirname, "error", $packageErrorMessage);
                $packageErrors[] = $packageErrorMessage;
            endif;
        endif;
    else :
        $packageErrorMessage = "The packages.json file is missing";
        $packageErrors[$packageDirname] = $packageErrorMessage;
        Codelab::log($packageDirname, "error", $packageErrorMessage);
    endif;
    // Insert package into packages list
    $packagesList[$packageDirname] = $package_JSON;
    $filesReady = "";
    // Package has no errors
    if (empty($packageErrors)) :
        // Package.json file valid = enable
        // Set load order if package dont have "reqire"
        if (!isset($package_JSON["require"]) or empty($package_JSON["require"])) :
            $packagesDependiences[$packageDirname] = [];
        else :
            foreach ($package_JSON["require"] as $requireName => $requireVersion) :
                $packagesDependiences[$packageDirname][] = $requireName;
            endforeach;
        endif;
        $packagesItems[] = $packageDirname;
    // Package has errors
    else :
        $packagesList[$packageDirname]["errors"] = $packageErrors;
    endif;
    $packageConfigSource = false;
    $filesReady = "";
    if (file_exists($packageDir . DIRECTORY_SEPARATOR . "cl-config.dev.json") and is_file($packageDir . DIRECTORY_SEPARATOR . "cl-config.dev.json")) :
        $packageConfigSource = "cl-config.dev.json";
        $filesReady .= "[cl-config.dev.json]";
    elseif (file_exists($packageDir . DIRECTORY_SEPARATOR . "cl-config.json") and is_file($packageDir . DIRECTORY_SEPARATOR . "cl-config.json")) :
        $packageConfigSource = "cl-config.json";
        $filesReady .= "[cl-config.json]";
    endif;
    if ($packageConfigSource != false) :
        // Get "package.json" file and convert to array
        $packageConfig = json_decode(
            file_get_contents(
                $packageDir . DIRECTORY_SEPARATOR . $packageConfigSource
            ),
            true
        );
        // Check if "package.json" file content is valid json
        if (is_array($packageConfig)) :
            //Codelab::log($packageDirname, 'info', '[' . $packageConfigSource. '] file loaded');
            $packagesList[$packageDirname]["config"] = $packageConfig;
        else :
            Codelab::log(
                $packageDirname,
                "error",
                "[" . $packageConfigSource . "] file invalid"
            );
            $packagesList[$packageDirname]["errors"][] =
                $packageConfigSource . " file is not valid json";
        endif;
    endif;
    $packagesList[$packageDirname]["dir"] = $packageDirname;
    $packagesList[$packageDirname]["path"] = $packageDir;
    $packageFile_INIT = $packageDir . DIRECTORY_SEPARATOR . "cl-init.php";
    if (file_exists($packageFile_INIT) and is_file($packageFile_INIT)) :
        $filesReady .= "[cl-init.php]";
        $packagesList[$packageDirname]["init"] = $packageFile_INIT;
    endif;
    $packageFile_CLASS = $packageDir . DIRECTORY_SEPARATOR . "cl-class.php";
    if (file_exists($packageFile_CLASS) and is_file($packageFile_CLASS)) :
        $filesReady .= "[cl-class.php]";
        $packagesList[$packageDirname]["class"] = $packageFile_CLASS;
    endif;
    Codelab::log($packageDirname, "info", "Package files ready " . $filesReady);
endforeach;
unset($packagesDirs);
// ################################################
// ##### Check dependiendiences
// ################################################
// Check if all dependiendiences exists
foreach ($packagesList as $packageName => $packageData) :
    if (isset($packageData["require"])) :
        foreach ($packageData["require"] as $dependiencyName => $dependiencyVersion) :
            // Dependency name not exists
            if (!isset($packagesList[$dependiencyName])) :
                $errorMessage = 'require package "' . $dependiencyName .'" does not exists';
                Codelab::log($packageName, "error", $errorMessage);
                $packagesList[$packageName]["errors"][] = $errorMessage;
            // Dependency exists - check version
            else :
                $versionCompare = version_compare($dependiencyVersion, $packagesList[$dependiencyName]["version"], ">");
                if (isset($packagesList[$dependiencyName]["version"]) and $versionCompare) :
                    $errorMessage =
                        "Required package [" .
                        $dependiencyName .
                        " " .
                        $dependiencyVersion .
                        "] does not match installed version [" .
                        $packagesList[$dependiencyName]["version"] .
                        "]";
                    Codelab::log($packageName, "error", $errorMessage);
                    $packagesList[$packageName]["errors"][] = $errorMessage;
                endif;
            endif;
        endforeach;
    endif;
endforeach;
$packagesErrors = [];
$packagesLoadOrder = CL_PACKAGES_sort(
    $packagesItems,
    $packagesDependiences,
    $packagesErrors
);
foreach ($packagesErrors as $packageErrorName) :
    $errorMessage = "require unsolved";
    $packagesList[$packageErrorName]["errors"][] = $errorMessage;
    Codelab::log($packageErrorName, "error", $errorMessage);
endforeach;
// ################################################
// ##### clLoad
// ################################################
$clLoad = false;
$clLoadPackages = false;
if (defined("clLoad")) :
    Codelab::log("cl", "info", "[clLoad] initiated");
    if (!is_array(clLoad)) :
        Codelab::log("cl", "error", "[clLoad] is not valid array");
    else :
        $clLoad = true;
    endif;
    if ($clLoad == true and isset(clLoad["packages"])) :
        // disable all packages
        if (clLoad["packages"] == false) :
            Codelab::log(
                "cl",
                "warning",
                "[clLoad][packages] is set to [false]. Packages will not be loaded"
            );
            $clLoadPackages = []; // error - package dont exists
        // Search for clLoad>package require
        elseif (!is_array(clLoad["packages"])) :
            Codelab::log("cl", "error", "[clLoad][packages] is not valid array");
        else :
            $clLoadPackages = [];
            foreach (clLoad["packages"] as $packageName) :
                if (!isset($packagesList[strtolower($packageName)])) :
                    Codelab::log(
                        "cl",
                        "error",
                        "[clLoad][packages] package not exists [" .
                            $packageName .
                            "]"
                    );
                else :
                    $clLoadPackages[] = strtolower($packageName);
                    if (isset(clLoad["require"]) and clLoad["require"] == true and isset($packagesList[strtolower($packageName)]["require"])) :
                        foreach ($packagesList[strtolower($packageName)]["require"] as $requireName => $requireVersion) :
                            $clLoadPackages[] = $requireName;
                        endforeach;
                    endif;
                endif;
            endforeach;
            if (isset(clLoad["require"]) and clLoad["require"] == true) :
                Codelab::log(
                    "cl",
                    "info",
                    "[clLoad][require] set to [true]. All required packages will bo leaded automaticly"
                );
            endif;
            $clLoadPackagesOutput = "";
            foreach ($clLoadPackages as $clLoadPackageName) :
                $clLoadPackagesOutput .= "[" . $clLoadPackageName . "]";
            endforeach;
            Codelab::log(
                "cl",
                "info",
                "[clLoad][packages] defined as packages list " .
                    $clLoadPackagesOutput
            );
        endif;
    endif;
    if ($clLoad == true and isset(clLoad["config"])) :
        foreach (clLoad["config"] as $packageName => $packageData) :
            if (isset($packagesList[strtolower($packageName)])) :
                foreach ($packageData as $packageData_key => $packageData_value) :
                    $packagesList[strtolower($packageName)]["config"][$packageData_key] = $packageData_value;
                    Codelab::log("cl", "info", "[clLoad][config] overwriten [" . $packageName . "][config][" . $packageData_key ."][" .$packageData_value ."]");
                endforeach; // error - package dont exists
            else :
                Codelab::log(
                    "cl",
                    "error",
                    "[clLoad][config] package not exists [" . $packageName . "]"
                );
            endif;
        endforeach;
    endif;
endif;
if ($clLoad == true and $clLoadPackages != false) :
    foreach ($packagesList as $packageName => $packageData) :
        if (!in_array($packageName, $clLoadPackages)) :
            unset($packagesList[$packageName]);
        endif;
    endforeach;
endif;
// Check if any package has error
$packagesInvalid = "";
$packagesLoadError = false;
foreach ($packagesList as $packageName => $packageData) :
    if (isset($packageData["errors"]) and !empty($packageData["errors"])) :
        $packagesLoadError = true;
        $packagesInvalid = $packageName . ", ";
    endif;
endforeach;
$packagesInvalid = rtrim($packagesInvalid, ", ");
if ($packagesLoadError == true) :
    Codelab::log(
        "cl",
        "error",
        "Codelab will not load the data. Packages not valid [" .
            $packagesInvalid .
            "]"
    );
else :
    Codelab::log("cl", "success", "All packages valid");
    $order = 0;
    foreach ($packagesLoadOrder as $packageName) :
        $packagesList[$packageName]["order"] = $order;
        $order++;
    endforeach;
    function sortByOrder($a, $b)
    {
        return $a["order"] - $b["order"];
    }
    usort($packagesList, "sortByOrder");
    foreach ($packagesList as $packageOrder => $packageData) :
        if (isset($packageData["name"])) :
            $packagesList[strtolower($packageData["name"])] = $packageData;
            unset($packagesList[$packageOrder]);
        else :
            unset($packagesList[$packageOrder]);
        endif;
    endforeach;
endif;
DEFINE("CL_PACKAGES", $packagesList);
Codelab::log("cl", "info", "[CL_PACKAGES] defined as list of all packages");
// No errors found - load packages
if ($packagesLoadError == false) :
    foreach (CL_PACKAGES as $packageName => $packageData) :
        if (isset($packageData["init"])) :
            include $packageData["init"];
            Codelab::log($packageName, 'info', 'package [init] loaded');
        endif;
        if (isset($packageData["class"])) :
            Codelab::log($packageName, 'info', 'package [class] loaded');
            include $packageData["class"];
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
DEFINE("CL_END", microtime());
Codelab::log("cl", "info", "[CL_END] defined: " . CL_END);
// Count load time
$time = explode(" ", CL_START);
$start = $time[1] + $time[0];
$time = explode(" ", CL_END);
$finish = $time[1] + $time[0];
$total_time = round($finish - $start, 4);
Codelab::log("cl", "info", "Codelab load time [" . $total_time . "s]");
