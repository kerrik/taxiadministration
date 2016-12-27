<?php
# at the moment all scripts ar started. Maby not necessary
function txi_enque_scripts() {
    // Respects SSL, Style.css is relative to the current file
    wp_register_style( 'tur-calendar-style', plugins_url('css/style.css', __FILE__) );
    wp_enqueue_style( 'tur-calendar-style' );
    if( !is_admin() ) { 
        wp_deregister_script('jquery');
        wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"), false, 'latest', false);
        wp_enqueue_script('jquery');
    }
    #wp_register_script( 'txi-timepicker-js', plugins_url('js/jquery/jquery.ui.timepicker.js', __FILE__) );
    wp_register_script( 'txi-timepicker-js', plugins_url('js/jquery/jquery.ui.timepicker.js', __FILE__) );
    wp_enqueue_script( 'txi-timepicker-js' );
    wp_register_script( 'jquery-ui-core-min-js', plugins_url('js/jquery/include/ui-1.10.0/jquery.ui.core.min.js', __FILE__) );
    wp_enqueue_script( 'jquery-ui-core-min-js' );
    #wp_register_style( 'txi-timepicker-style', plugins_url('js/jquery/css/jquery.ui.timepicker.css', __FILE__) );
    wp_register_style( 'txi-timepicker-style', plugins_url('js/jquery/css/jquery.ui.timepicker.css', __FILE__) );
    wp_enqueue_style( 'txi-timepicker-style' );
    wp_register_style( 'jquery-ui-1-10-0.custom-min-css', plugins_url('js/jquery/css/jquery-ui-1.10.0.custom.min.css', __FILE__) );
    wp_enqueue_style( 'jquery-ui-1-10-0.custom-min-css' );
    wp_register_script( 'tur-calendar-js', plugins_url('js/taxi_js.js', __FILE__) );
    wp_enqueue_script( 'tur-calendar-js' );
}

#   #    #   #   #   #   #   #   #   #    #   #   #   #   #   #   #   #    #   #
#
#  start functions for shortcodes defined in txi_admin.php
#
#   #    #   #   #   #   #   #   #   #    #   #   #   #   #   #   #   #    #   #


function txi_view_plan_month(){
    include_once ('class/txi_traits.php');
    include_once ('views/txi_plan_month.php');
    global $txi_plan_month ;
    $txi_plan_month= new txi_plan_month();
    $txi_plan_month->view_plan_month() ;
}
function txi_view_driver_cal(){
    include_once ('class/txi_traits.php');
    include_once ('views/txi_driver_cal.php');
    global $txi ;
    $txi = new txi_driver_cal();
    $txi->view_driver_cal() ;
}
function txi_view_car_admin(){
    include_once ('class/txi_traits.php');
    include_once ('views/txi_car_admin.php');
    global $txi ;
    $txi = new txi_car_admin();
    $txi->view_car_admin() ;
}
function txi_view_driver_admin(){
    include_once ('class/txi_traits.php');
    include_once ('views/txi_driver_admin.php');
    global $txi ;
    $txi = new txi_driver_admin();
    $txi->view_driver_admin() ;
}

?>