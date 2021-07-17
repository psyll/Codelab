<?php
include('../app/App.php');
echo '<pre>';
print_r($_GET);
echo '</pre><hr>';
print_r(CL_ROUTE_TABLE);

echo '<hr>';
echo $_SERVER['REQUEST_METHOD'];
/*
$AppInfo = new App\Info();
$AppInfo->get();

echo '<hr>';


$FooBar = new App\Foo\Bar();
$FooBar->create();
echo '<hr>';
$db = new Codelab\DB();
$db->connect();
$data = $db->get(
    table: 'users',
    select: 'id,email',
    where: 'id!="1986"',
    limit: 10,
    offset: 0,
    order: 'id DESC',
);
echo '<pre>';
print_r($data);
echo '</pre>';
echo '<hr>';
*/
