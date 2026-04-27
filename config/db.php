<?php

$db = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=book_catalog',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

$localDb = __DIR__ . '/db-local.php';
if (is_file($localDb)) {
    $db = array_merge($db, require $localDb);
}

return $db;
