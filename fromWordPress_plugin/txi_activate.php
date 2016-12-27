<?php

#  Functions used to decide what happens when a user activates your plugin

function txi_admin_aktivate_plugin() {
       $txi_options = array(
        'txi_adm_ver' => "0.1.1"
    );
    add_option('txi_settings', $txi_options);
   
    global $wpdb;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    $table = $wpdb->prefix . "txi_car" ;
    $sql = "CREATE TABLE " . $table . "(
        id bigint(20) NOT NULL AUTO_INCREMENT,
        car char(10) NOT NULL,
        regnr tinytext NOT NULL,
        tel tinytext NOT NULL,
        pass int(11) NOT NULL,
        pass_time text NOT NULL,
        start_date date NOT NULL,
        end_date date NOT NULL,
        PRIMARY KEY  (id),
        UNIQUE KEY car (car)
        );";
    
    dbDelta( $sql );
    
    $table = $wpdb->prefix . "txi_pass" ;
    $sql = "CREATE TABLE $table (
         id bigint(20) NOT NULL AUTO_INCREMENT,
        type tinyint(4) NOT NULL,
        taxi text NOT NULL,
        pass tinyint(4) NOT NULL,
        start_date date NOT NULL,
        start_time time NOT NULL,
        end_date date NOT NULL,
        end_time time NOT NULL,
        driver text NOT NULL,
        ink int(11) NOT NULL,
        ink_rapp int(11) NOT NULL,
        kont int(11) NOT NULL,
        kont_rapp int(11) NOT NULL,
        fel int(11) NOT NULL,
        utl int(11) NOT NULL,
        red int(11) NOT NULL,
        man_kred int(11) NOT NULL,
        v_tid int(11) NOT NULL,
        PRIMARY KEY  (id,type)
        );";
    
    dbDelta( $sql );
    
 }
?>
