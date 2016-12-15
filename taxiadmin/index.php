<?php
if ( $_SERVER['REQUEST_URI'] === '/'){    
    include 'webroot/start.php';
}else{    
    $include = (stristr($_SERVER['REQUEST_URI'],'?', true)?stristr($_SERVER['REQUEST_URI'],'?', true): $_SERVER['REQUEST_URI']);
    include "webroot/{$include}.php";
}