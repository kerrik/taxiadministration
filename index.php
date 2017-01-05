<?php
$include = '';
if (isset($_POST['logout'])) {
            unset($_SESSION['user']);
        include 'webroot/start.php';
}elseif ($_SERVER['REQUEST_URI'] === '/' || stristr($_SERVER['REQUEST_URI'], '/?') != FALSE){
        include 'webroot/start.php';
} elseif (stristr($_SERVER['REQUEST_URI'], '.php') != FALSE){
    include 'webroot/' .  stristr($_SERVER['REQUEST_URI'], '.php', TRUE) . '.php';
    echo 'här';
}else{
    $include = (stristr($_SERVER['REQUEST_URI'], '?', TRUE) ? stristr($_SERVER['REQUEST_URI'], '?', TRUE) : $_SERVER['REQUEST_URI']);
    include "webroot/{$include}.php";
}