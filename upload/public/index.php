PUBLIC INDEX
<hr>
<?php
    include('../Codelab.php');
    // ##############################################
    // Connect database
    // ##############################################

    $db = new Codelab\DB();
    $db->connect();


    $data = $db->get('testTable', [
        'select' => 'username,birthYear',
        'where' => 'birthYear="1986"',
        'limit' => 10,
        'offset' => 0,
        'order' => 'id DESC',
    ]);

    echo '<pre>';
    print_r($data);
    echo '</pre>';

