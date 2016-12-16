<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of driver_funct
 *
 * @author peder
 */
function save_driver() {
    global $db;
    global $user;
    if ($_POST['save']) {
        echo 'spara posten';
        $sql = "INSERT INTO User (acronym, name, role, salt) VALUES (?, ?, 10, unix_timestamp());";
        $user_array[] = $_POST['acronym'];
        $user_array[] = $_POST['name'];
        $succed = $db->DB_execute($sql, $user_array, FALSE);
        if ($succed) {
            $id = $db->id_new_post();
            $succed = $db->DB_execute($sql, $user_array, FALSE);
        }
    } else {
        
    }
}
