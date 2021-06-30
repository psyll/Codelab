<?php

   class DB {
	   public static function disconnect(){
		global $DB;
		  if (isset($DB) AND !empty($DB)):
			   mysqli_close($DB);
			   unset($DB);
		  endif;
	   }
	   public static function escape($string)
	   {
		   global $DB;
		if ($string != null AND !is_numeric($string) AND $string != ''):
		   $return = mysqli_escape_string($DB, $string);
		   return $return;
		else:
		   return $string;
		endif;
	   }
	   public static function query($query, $log = true)
	   {
		   global $DB;
		   if ($log == true):
			   $logMessage = 'Query [' . $query . ']';
			//   clLog::create('DB', 'info', $logMessage);
		   endif;
		   return mysqli_query($DB, $query);
	   }
	   public static function fetch($results)
	   {

		   return mysqli_fetch_array($results);
	   }
	   public static function columns($table)
	   {
		global $DB;
		   $table = clPackages['DB']['config']['prefix'] . '_' . $table;
		   $result = DB::query("SHOW COLUMNS FROM `" . DB::escape($table) . "`");
		   $output = array();
		   while($row = DB::fetch($result)) :
			   array_push($output,$row['Field']);
		   endwhile;
		   return $output;
	   }
	   public static function get($param, $single = false){

		   if (!isset($param['table'])):
			   die('DB::get table not defined');
		   endif;
		   $table = $param['table'] ;
		   $param['table'] = clPackages['DB']['config']['prefix'] . '_' . $param['table'];
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
			   $param['columns'] = DB::columns($param['table']);
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
		   $result = DB::query($query, false);
		   $output = array();
		   $i = 0;
		   while($row = DB::fetch($result)) :
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

	 }
	   public static function insert($table, $columns)
	   {
		   $table = clPackages['DB']['config']['prefix'] . '_' . $table;
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
		   $result = DB::query($query, false);
	   }
	   public static function delete($table, $id) // single id or array ex. array(1,35,65)
	   {
		   $table = clPackages['DB']['config']['prefix'] . '_' . $table;
		   if (is_array($id) AND !empty($id)):
				foreach($id as $key => $value):
				   $query = 'DELETE FROM `' . $table . '` WHERE id = ' . DB::escape($value);
				   $logMessage = 'Delete [' . $query . ']';
		//		   clLog::create('DB', 'info', $logMessage);
				   DB::query($query, false);
				endforeach;
			   return true;
		   else:
			   $query = 'DELETE FROM `' . $table . '` WHERE id = ' . DB::escape($id);
			   $logMessage = 'Delete [' . $query . ']';
		//	   clLog::create('DB', 'info', $logMessage);
			   DB::query($query, false);
			   return true;
		   endif;
	 }
	   public static function insertID()
	   {
		   global $DB;
		   return mysqli_insert_id($DB);
	   }
	   public static function ids($table, $where = null) // return team groups array
	   {

		   // get pageData
		   $param = array(
			   'table'  => $table,
			   'columns' => ['id'],
		   );
		   if ($where != null):
			   $param['where'] = $where;
		   endif;
		   $results = DB::get($param);
		   if (empty($results)):
			   return array();
		   endif;
		$output = [];
		foreach ($results as $key => $value):
		   array_push($output,  $value['id']);
		endforeach;
		   return $output;

	   }
	 public static function update($table, $where, $array)
	 {
		$table = clPackages['DB']['config']['prefix'] . '_' . $table;
		$output  = '';
		foreach ($array as $key => $value):
		   $output .= "`" . $key . '`=';
		   $output .= '"' . DB::escape($value) . '",';
		endforeach;
		$output    = trim($output,",");
		$query = "UPDATE `" . $table . "` ";
		$query .= "SET " . $output . " ";
		$query .= "WHERE " . $where;
		   //echo $query;
		   $logMessage = 'Update [' . $query . ']';
		//   clLog::create('DB', 'info', $logMessage);
		DB::query($query, false);
	 }
   }
