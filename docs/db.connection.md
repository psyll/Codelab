# Database > Connection

Global database connection settings are retrieved from the `/config/DB.php` configuration file.

```php
DEFINE(
    'CL_DB',
    [
        "host" => "HOSTNAME",
        "user" => "USERNAME",
        "pass" => "PASSWORD",
        "db"   => "DATABASE",
        "port" => "PORT", // default "3306"
        "encode" => "CHARACTERS_ENCODE" // default "UTF-8"
    ]
);
```

After setting all the data in config file, you can connect to the database:

```php
$db = new Codelab\DB();
$db->connect();
```
You can also set the connection data while creating the database object:

```php
$db = new Codelab\DB('HOSTNAME','USERNAME','PASSWORD','DATABASE', 'PORT'=3306,'ENCODE'=>UTF-8);
$db->connect();
```

This way you can connect multiple databases at the same time:

```php
// First database
$db1 = new Codelab\DB('HOSTNAME1','USERNAME1','PASSWORD1','DATABASE1');
$db1->connect();
// Second database
$db2 = new Codelab\DB('HOSTNAME2','USERNAME2','PASSWORD2','DATABASE2');
$db2->connect();
```

Connexct with named arguments (PHP 8.0)

```php
    $db = new Codelab\DB(
        host: "slavlab.atthost24.pl",
        user: "17006_codelab",
        pass: "Ib2KP3s0I!q$1",
        db: "17006_codelab",
        port: "3306",
        encode: "UTF-8"
    );
    ```