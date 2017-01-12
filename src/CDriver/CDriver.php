<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CDriver
 *
 * @author peder
 */
class CDriver {

    private $driver = '';

    public function __construct() {
        dump($_POST);
        $this->driver = (object) $this->driver;
        if (isset($_POST['save'])) {
            $this->check_password();
//            $this->save_driver();
        } else {
            $this->driver->id = (isset($_POST['use_driver'])) ? $_POST['use_driver'] : $_SESSION['user'];
        }
        $this->driver();
        dump($this->driver, 'CDriver->driver');
    }

    private function driver() {
        dump($this->driver->id, 'ID');
        if ($this->driver->id < 0) {
            $this->new_driver();
        } else {
            global $user;
            $use_driver = $user->show_user($this->driver->id);
            $this->driver->name = $use_driver->name;
            $this->driver->display_name = $use_driver->display_name;
        }
    }

    private function new_driver() {
        $this->driver->name = (empty($_POST['name'])) ? '' : $_POST['name'];
        $this->driver->acronym = (empty($_POST['acronym'])) ? '' : $_POST['acronym'];
        $this->driver->display_name = (empty($_POST['display_name'])) ? '' : $_POST['display_name'];
    }

    function save_driver() {
        global $db;
        global $user;
        $return->id = (isset($_POST['use_driver'])) ? $_POST['use_driver'] : $_SESSION['user'];
        if (!isset($_POST['save'])) {
            return $return;
        }
        if (!$return->new_driver->return) {
            $return->id = -2;
            return $return;
        }
        if ($_POST['save'] == 1) {
            echo 'spara posten';
            $sql = "INSERT INTO User (acronym, name, display_name, role, salt) VALUES (?, ?, 10, unix_timestamp());";
            $user_array[] = $_POST['acronym'];
            $user_array[] = $_POST['name'];
            $user_array[] = $_POST['display_name'];
            $succed = $db->DB_execute($sql, $user_array, TRUE);
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

    private function check_password() {
        // Kollar om password är samma i boda fälten
        echo 'Heeee';
        if (!empty($_POST['password']) && $_POST['password'] === $_POST['password_check']) {
            $this->driver->id = -1;
            return TRUE; // Sätter $driver->new_driver till TRUE om password stämmer
//        }elseif (!isset ($_POST['password'])) {         
//         return TRUE; // Sätter $driver->new_driver till TRUE om password inte ska uppdateras  
        }
        $this->driver->id = -2;
        return FALSE; // Sätter $driver->new_driver till FALSE om password inte stämmer
    }
    public function name() {
        return $this->driver->name;
    }
    public function display_name() {
        return $this->driver->display_name;
    }
    public function driver_data() {
        global $user;
        return true;
    }

}
