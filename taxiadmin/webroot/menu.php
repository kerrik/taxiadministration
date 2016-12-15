<?php
$main_menu = array(
  // Use for styling the menu
  'class' => 'pagemenu',
 
  // Here comes the menu strcture
  'items' => array(
    // This is a menu item
    'home'  => array(
      'text'  =>'Hem',   
      'url'   =>'start',  
      'title' => 'Hem', 
      'slug' => null,
      'view' => null  
    ),
    'driver'  => array(
      'text'  =>'Föraradministration',   
      'url'   =>'driver',  
      'title' => 'Administrera förare', 
      'slug' => null,
      'view' => null  
    ),
    'map'  => array(
      'text'  =>'Karta',   
      'url'   =>'map',  
      'title' => 'Karta', 
      'slug' => null,
      'view' => null  
    ),
    'login'  => array(
      'text'  =>'Login',   
      'url'   =>'login',  
      'title' => 'Login', 
      'slug' => null,
      'view' => null  
    ),
    
      
//    // This is a menu item
//    'blog'  => array(
//      'text'  =>'Blog',   
//      'url'   =>'blog.php',   
//      'title' => 'Blog. Kmom04',
//      'slug' => null,
//      'view' => 'alla',  
// 
//      // Here we add the submenu, with some menu items, as part of a existing menu item
//      'submenu' => array(
// 
//        'items' => array(
//          // This is a menu item of the submenu
//          'alla'  => array(
//            'text'  => 'Visa alla',   
//            'url'   => 'blog.php',  
//            'title' => 'Visa alla poster',
//      'slug' => null,
//            'view' => 'alla'  
//          ),
// 
//          // This is a menu item of the submenu
//          'ny 2'  => array(
//            'text'  => 'Ny',   
//            'url'   => 'blog.php',  
//            'title' => 'Lägg till ny',
//            'class' => 'italic',
//            'slug' => null,
//            'view' => 'new'  
//          ),
//        ),
//      ),
    ),
      
    
 
  // This is the callback tracing the current selected menu item base on scriptname
  'callback' => function($url, $view) {
    if(basename($_SERVER['SCRIPT_FILENAME']) == $url) {
        if( isset($_GET['view']) && isset( $view)&& $view !== $_GET['view']){
            return false;
        }
      return true;
    }
  }
);
