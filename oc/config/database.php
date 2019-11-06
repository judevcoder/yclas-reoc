<?php defined('SYSPATH') or die('No direct script access.');
return array
(
    'default' => array(
        'type'       => 'mysqli',
        'connection' => array(
            'hostname'   => 'localhost',
            'username'   => 'root',
            'password'   => 'root',
            'persistent' => FALSE,
            'database'   => 'testdb',
            'variables'  => array('sql_mode'=>'')
            ),
        'table_prefix' => 'yc3_',
        'charset'      => 'utf8mb4',
        'profiling'    => (Kohana::$environment===Kohana::DEVELOPMENT)? TRUE:FALSE,
     ),
);