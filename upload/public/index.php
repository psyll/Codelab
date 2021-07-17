<?php
include('../app/App.php');
echo '<pre>';
print_r($_GET);
echo '</pre>';


$AppInfo = new App\Info();
$AppInfo->get();

$FooBar = new App\Foo\Bar();
$FooBar->create();

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
