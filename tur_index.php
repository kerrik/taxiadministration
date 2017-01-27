<?php

$db_connect['dsn'] = 'mysql:host=taxiadmin-168979.mysql.binero.se;dbname=168979-taxiadmin;';
$db_connect['username'] = '168979_ax48340';
$db_connect['password'] = 't4x14dm1n';
$db_connect['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

$include = '';
if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    include 'webroot/start.php';
} elseif ($_SERVER['REQUEST_URI'] === '/' || stristr($_SERVER['REQUEST_URI'], '/?') != FALSE) {
    include 'webroot/start.php';
} elseif (stristr($_SERVER['REQUEST_URI'], '.php') != FALSE) {
    include 'webroot/' . stristr($_SERVER['REQUEST_URI'], '.php', TRUE) . '.php';
} else {
    $include = (stristr($_SERVER['REQUEST_URI'], '?', TRUE) ? stristr($_SERVER['REQUEST_URI'], '?', TRUE) : $_SERVER['REQUEST_URI']);
    include "webroot/{$include}.php";
}