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
    $return = [];
    $return['new_driver']= check_password();
    $return['id'] = (isset($_POST['use_driver'])) ? $_POST['use_driver'] : $_SESSION['user'];
    $return=(object)$return;
    dump($return);
    if (!isset($_POST['save'])) {
        return $return;
    }
    if (!empty($_POST['password']) && !$return->new_driver->return) {
        $return->id = -2;
        return $return;
    }
    if ($_POST['save']) {
        echo 'spara posten';
        $sql = "INSERT INTO User (acronym, name, role, salt) VALUES (?, ?, 10, unix_timestamp());";
        $user_array[] = $_POST['acronym'];
        $user_array[] = $_POST['name'];
        $succed = $db->DB_execute($sql, $user_array, FALSE);
        if ($succed) {
            echo 'jag lyckades';
            $id = $db->id_new_post();
            $_POST['use_driver'] = $id;
            $sql = "INSERT INTO user_data (user, user_data_id, value) VALUES (?, ?, ?)";
            foreach ($user->user_data() as $row) {
                echo $row->user_data_descr;
                if (!empty($_POST[$row->user_data_descr])) {
                    unset($user_array);
                    $user_array[] = $id;
                    $user_array[] = $row->user_data_id;
                    $user_array[] = $_POST[$row->user_data_descr];
                    $succed = $db->DB_execute($sql, $user_array, FALSE);
                }
            }
            $user->get_users();
        }
    return $return;
        
    }
}

function check_password() {
    echo 'kollar här';
//    dump($_POST);
    global $new_driver;
        $new_driver['name']='';
        $new_driver['acronym']='';
        $new_driver['return'] = FALSE;
    if ($_POST['password'] === $_POST['password_check']){
        $return = TRUE;
    }else{
        $new_driver['name']=$_POST['name'];
        $new_driver['acronym']=$_POST['acronym']; 
        $new_driver['return'] = FALSE;
    }
    return (object)$new_driver;
}
