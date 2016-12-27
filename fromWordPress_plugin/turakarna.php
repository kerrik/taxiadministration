<?php
/*
Plugin Name: Taxi Admin
Plugin URI: http://kerrik.se/wordpress/plugin/tur_taxi_admin
Description: Sdministration for Taxi.
Version: 0.1.1
Author: Peder Nordenstad
Author URI: http://Kerrik.se/me
License:  GPL2
*/

define( 'TXI_PLUGIN_PATH', plugin_dir_path(__FILE__) );
require TXI_PLUGIN_PATH . 'txi_activate.php';
include_once TXI_PLUGIN_PATH . 'functions.php';

# called when plugin is activated
register_activation_hook( __FILE__, 'txi_admin_aktivate_plugin' );

# enques scripts
add_action( 'wp_enqueue_scripts', 'txi_enque_scripts' );

add_shortcode( 'txi_plan_month', 'txi_view_plan_month') ;
add_shortcode( 'txi_driver_cal', 'txi_view_driver_cal') ;
add_shortcode( 'txi_car_admin', 'txi_view_car_admin') ;
add_shortcode( 'txi_driver_admin', 'txi_view_driver_admin') ;

global $txi_plan_month;



include ('turakarna_admin.php');
# include ('views/txi_driver.php');
# include ('views/txi_plan_month.php');

# $txi=new txi_calendar;
# $txi_driver_cal= new txi_driver_cal();



 

?>