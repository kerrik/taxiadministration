<?php

if ($_SERVER['REQUEST_URI'] === '/' || stristr($_SERVER['REQUEST_URI'], '/?') != FALSE){
        include 'webroot/start.php';
} elseif (stristr($_SERVER['REQUEST_URI'], '.php') != FALSE){
    include 'webroot/' .  stristr($_SERVER['REQUEST_URI'], '.php', true) . '.php';
    echo 'här';
}else{
    $include = (stristr($_SERVER['REQUEST_URI'], '?', true) ? stristr($_SERVER['REQUEST_URI'], '?', true) : $_SERVER['REQUEST_URI']);
    include "webroot/{$include}.php";
}