<?php
namespace Codelab;

class DB
{
    private $connection = false;

    private $default = [
        'select'    => '*',
        'limit'     => 1000,
    ];

    public function __construct($host = null, $user = null, $pass = null, $db = null, $port = null, $encode = null)
    {
        if ($host == null) {
            $host = CL_DB['host'];
        }
        if ($user == null) {
            $user = CL_DB['user'];
        }
        if ($pass == null) {
            $pass = CL_DB['pass'];
        }
        if ($db == null) {
            $db = CL_DB['db'];
        }
        if ($port == null) {
            $port = CL_DB['port'];
        }
        if ($encode == null) {
            $encode = CL_DB['encode'];
        }
        $this->connectionData = array('host' => $host, 'user' => $user, 'pass' => $pass, 'db' => $db, 'port' => $port , 'encode' => $encode);
    }
    public function __destruct()
    {
        if (is_resource($this->connection)) {
            mysqli_close($this->connection);
        }
    }
    public function connect()
    {
        if (!is_resource($this->connection) || empty($this->connection)) {
            $connection = mysqli_connect($this->connectionData['host'], $this->connectionData['user'], $this->connectionData['pass'], $this->connectionData['db'], $this->connectionData['port']);
            if ($connection) {
                mysqli_set_charset($connection, $this->connectionData['encode']);
                $this->connection = $connection;
            } else {
                die('[Codelab error] Could not connect to MySQL database');
            }
        }
        return $this->connection;
    }
    public function query(string $query)
    {
        return mysqli_query($this->connection, $query);
    }
    public function get(string $table, array $parameters = [])
    {
        // # Select
        if (!isset($parameters['select']) or $parameters['select'] == '') :
            $parameters['select'] = $this->default['select'];
        endif;
        // # Where
        if (isset($parameters['where']) and  $parameters['where'] != '') :
            $where = ' WHERE ' . $parameters['where'];
        endif;
        // # Order
        if (isset($parameters['order']) and $parameters['order']  != '') :
            $order = ' ORDER BY ' . $parameters['order'];
        endif;
        // # Limit
        if (isset($parameters['limit']) and $parameters['limit'] != '') :
            $limit = ' LIMIT ' . $parameters['limit'];
        else :
            $limit = ' LIMIT ' . $this->default['limit'];
        endif;
        // # Offset
        if (isset($parameters['offset']) and $parameters['offset'] != '') :
            $offset = ' OFFSET ' . $parameters['offset'];
        endif;
        $query = "SELECT " . $parameters['select'] ." FROM `" . $table ."`" . @$where. @$order. @$limit. @$offset;
        $query = $this->query($query);
        // Single row
        if (isset($parameters['limit']) and $parameters['limit'] == 1) :
            return  mysqli_fetch_assoc($query);
        // Multiple rows
        else :
            $data = [];
            while ($row = mysqli_fetch_assoc($query)) {
                $data[] = $row;
            }
            return  $data;
        endif;
    }
}
