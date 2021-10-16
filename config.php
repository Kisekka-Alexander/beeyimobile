<?php
//This is the config.php file
define('CLIENT_ID','**********************************************');
define('CLIENT_SECRET','*************************');
define('CALLBACK_URL','https://login.salesforce.com/');
define('CACHE_DIR', 'cache');
define('LOGIN_URL','https://test.salesforce.com');
define('USERNAME','**********************');
define('PASSWORD','*************************');

//constants
define('AT_USERNAME','sandbox');
define('AT_APIKEY','sandbox');
define('AT_ENVIRONMENT','sandbox');

//database
define("DB_SVR" , 'us-cdbr-east-04.cleardb.com');
define("DB_USER" ,'b376dadf004332');
define("DB_PW" , '85e2d67e');
define("DB_NAME" , 'heroku_5443e697ebea265');


/*

///// HEROKU DB

//Get Heroku ClearDB connection information
$cleardb_url      = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server   = $cleardb_url["us-cdbr-east-04.cleardb.com"];
$cleardb_username = $cleardb_url["b376dadf004332"];
$cleardb_password = $cleardb_url["85e2d67e"];
$cleardb_db       = substr($cleardb_url["heroku_5443e697ebea265"],1);


$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'    => '',
    'hostname' => $cleardb_server,
    'username' => $cleardb_username,
    'password' => $cleardb_password,
    'database' => $cleardb_db,
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
*/