<?php
namespace Codelab;

class DB
{
    private $connection = false;
    private $default = [
        'select'    => '*',
        'limit'     => 1000,
    ];
    public function __construct(
        string $host = null,
        string $user = null,
        string $pass = null,
        string $db = null,
        int $port = null,
        string $encode = null
    ) {
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
        $this->connectionData = array(
            'host' => $host,
            'user' => $user,
            'pass' => $pass,
            'db' => $db,
            'port' => $port ,
            'encode' => $encode);
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
            $connection = mysqli_connect(
                $this->connectionData['host'],
                $this->connectionData['user'],
                $this->connectionData['pass'],
                $this->connectionData['db'],
                $this->connectionData['port']
            );
            if ($connection) {
                mysqli_set_charset($connection, $this->connectionData['encode']);
                $this->connection = $connection;
            } else {
                die('[Codelab error] Could not connect to MySQL database');
            }
        }
        return $this->connection;
    }
    public function escape(string $string): string
    {
        return mysqli_real_escape_string($this->connection, $string);
    }
    public function query(
        string $query,
        ? bool $fetch = false
    ) {
        $query = mysqli_query($this->connection, $query);
        if ($fetch == true) {
            return $this->fetch($query);
        } else {
            return $query;
        }
    }
    public function fetch($result)
    {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }
    public function get(
        string $table,
        ? string $select = null,
        ? string $where = null,
        ? string $order = null,
        ? int $limit = null,
        ? int $offset = null
    ) {
        // # Select
        if (!isset($select) or $select  == '') {
            $select  = $this->default['select'];
        }
        // # Where
        if (isset($where) and $where  != '') {
            $where = ' WHERE ' . $where;
        }
        // # Order
        if (isset($order) and $order  != '') {
            $order = ' ORDER BY ' . $order;
        }
        // # Limit
        if (isset($limit) and $limit  != '') {
            $limitOutput = ' LIMIT ' . $limit;
        } else {
            $limitOutput = ' LIMIT ' . $this->default['limit'];
        }
        // # Offset
        if (isset($offset) and $offset  != '') {
            $offset = ' OFFSET ' . $offset;
        }
        $query = "SELECT " . $select  ." FROM `" . $table ."`" . $where. $order. $limitOutput. $offset;
        $query = $this->query($query);
        // Single row
        if (isset($limit) and $limit == 1) :
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
