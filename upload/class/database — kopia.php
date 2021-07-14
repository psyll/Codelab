<?php

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
                    "SET names = '" .$charset ."', character_set_results = '" .$charset ."', character_set_client = '" . $charset
                    . "', character_set_connection = '" . $charset ."', character_set_database = '" . $charset . "', character_set_server = '" . $charset . "'"
                );
                mysqli_set_charset($CodelabDB, "utf8");
            endif;
        endif;
        Codelab::log("CodelabDB", "success", "connected [" . CL_CONFIG["DB"]["host"] . "]");
    else :
        Codelab::log("CodelabDB", "error", "connection error [" . CL_CONFIG["DB"]["host"] . "]");
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



    public static function count(string $tableName, string $where = '')
    {
        global $CodelabDB;
        if ($where != '') :
            $where = ' WHERE ' . $where;
        endif;
        return mysqli_num_rows(CodelabDB::query("SELECT `id` FROM `" . $tableName . "`" . $where));
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
            $query ="SELECT " .$columns ." FROM `" .$param["table"] ."` " .$where ." ORDER BY " .$param["order"] ."  LIMIT " .$param["limit"] ." OFFSET " .$param["offset"];
            //echo $query ;
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
                "INSERT INTO `" .$table ."` (" .$keys .") VALUES (" .$values .")";
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