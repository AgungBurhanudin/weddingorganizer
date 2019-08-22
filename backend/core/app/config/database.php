<?php

$password = 'admin';
$host = 'localhost';
//coba test
return array(

    'default' => array(
        'driver' => 'mysqli',
        'host' => $host,
        'port' => 3306,
        'user' => 'root',
        'password' => $password,
        'database' => 'testing',
        'tablePrefix' => '',
        'charset' => 'utf8',
        'collate' => 'utf8_general_ci',
        'persistent' => false,
        'pdo' => false
    ),

    'alamat' => array(
        'driver' => 'pgsql',
        'host' => $host,
        'port' => 5432,
        'user' => 'postgres',
        'password' => $password,
        'database' => 'alamat',
        'tablePrefix' => '',
        'charset' => 'utf8',
        'collate' => 'utf8_general_ci',
        'persistent' => false,
        'pdo' => false
    ),

    'xbilling' => array(
        'driver' => 'pgsql',
        'host' => $host,
        'port' => 5432,
        'user' => 'postgres',
        'password' => $password,
        'database' => 'xbilling',
        'tablePrefix' => '',
        'charset' => 'utf8',
        'collate' => 'utf8_general_ci',
        'persistent' => false,
        'pdo' => false
    ),

    'xbmt' => array(
        'driver' => 'pgsql',
        'host' => $host,
        'port' => 5432,
        'user' => 'postgres',
        'password' => $password,
        'database' => 'xbmt',
        'tablePrefix' => '',
        'charset' => 'utf8',
        'collate' => 'utf8_general_ci',
        'persistent' => false,
        'pdo' => false
    ),

    'xhrd' => array(
        'driver' => 'pgsql',
        'host' => $host,
        'port' => 5432,
        'user' => 'postgres',
        'password' => $password,
        'database' => 'xhrd',
        'tablePrefix' => '',
        'charset' => 'utf8',
        'collate' => 'utf8_general_ci',
        'persistent' => false,
        'pdo' => false
    ),

    'xposo' => array(
        'driver' => 'pgsql',
        'host' => $host,
        'port' => 5432,
        'user' => 'postgres',
        'password' => $password,
        'database' => 'xposo',
        'tablePrefix' => '',
        'charset' => 'utf8',
        'collate' => 'utf8_general_ci',
        'persistent' => false,
        'pdo' => false
    ),
    
    'xva' => array(
        'driver' => 'pgsql',
        'host' => $host,
        'port' => 5432,
        'user' => 'postgres',
        'password' => $password,
        'database' => 'xva',
        'tablePrefix' => '',
        'charset' => 'utf8',
        'collate' => 'utf8_general_ci',
        'persistent' => false,
        'pdo' => false
    ),

    'openfire' => array(
        'driver' => 'pgsql',
        'host' => 'localhost',
        'port' => 5432,
        'user' => 'openfire',
        'password' => 'openapi',
        'database' => 'openfire',
        'tablePrefix' => '',
        'charset' => 'utf8',
        'collate' => 'utf8_general_ci',
        'persistent' => false,
        'pdo' => false
    ),

    'sekolah' => array(
        'driver' => 'pgsql',
        'host' => $host,
        'port' => 5432,
        'user' => 'postgres',
        'password' => $password,
        'database' => 'xsekolah',
        'tablePrefix' => '',
        'charset' => 'utf8',
        'collate' => 'utf8_general_ci',
        'persistent' => false,
        'pdo' => false
    )

);
