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

        $this->driver = (object) $this->driver;
        $this->extract_post();
        if (isset($this->driver->save)) {
            $this->check_password();
//            $this->save_driver();
        } else {
            $this->driver->id = (isset($this->driver->use_driver)) ? $this->driver->use_driver : $_SESSION['user'];
        }
        if (!empty($this->driver->save) && $this->driver->save == 1) {
            $this->save_driver();
        }
        $this->driver();
    }

    private function driver() {
        if ($this->driver->id < 0) {
            $this->new_driver();
        } else {
            global $user;
            $use_driver = $user->show_user($this->driver->id);
            $this->driver->name = $use_driver->name;
            $this->driver->display_name = $use_driver->display_name;
//            unset $_POST;
        }
    }

    private function new_driver() {
        $this->driver->name = (empty($this->driver->name) OR $this->driver->id == -1) ? '' : $this->driver->name;
        $this->driver->acronym = (empty($this->driver->acronym) OR $this->driver->id == -1) ? '' : $this->driver->acronym;
        $this->driver->display_name = (empty($this->driver->display_name) OR $this->driver->id == -1) ? '' : $this->driver->display_name;
    }

    private function save_driver() {
        global $db;
        global $user;
        $sql = "INSERT INTO User (acronym, name, display_name, role, password, salt) VALUES (?, ?, ?, ?, ?, unix_timestamp());";
        $user_array[] = $this->driver->acronym;
        $user_array[] = $this->driver->name;
        $user_array[] = $this->driver->display_name;
        $user_array[] = 10;
        $user_array[] = $this->driver->password;
        $succed = $db->DB_execute($sql, $user_array, TRUE);
        if ($succed) {
            $id = $db->id_new_post();
            $this->driver->use_driver = $id;
            $sql = "INSERT INTO user_data (user, user_data_id, value) VALUES (?, ?, ?)";

            $sql = "UPDATE User SET password = md5(concat(?, salt)) WHERE id = ?";
            $passw_array[] = $this->driver->password;
            $passw_array[] = $id;

            $succed = $db->DB_execute($sql, $passw_array, TRUE);
            
            $sql = "INSERT INTO user_data (user, user_data_id, value) VALUES (?, ?, ?)";
            foreach ($user->user_data() as $row) {
                if (!empty($this->driver->{$row->user_data_descr})) {
                    unset($user_array);
                    $user_array[] = $id;
                    $user_array[] = $row->user_data_id;
                    $user_array[] = $this->driver->{$row->user_data_descr};
                    $succed = $db->DB_execute($sql, $user_array, TRUE);
                }
            }
            $user->get_users();
        }
        $this->driver->id = $id;
        return TRUE;
    }

    private function check_password() {
        // Kollar om password är samma i boda fälten
        if (!empty($this->driver->password) && $this->driver->password === $this->driver->password_check) {
            $this->driver->id = -1;
            return TRUE; // Sätter $driver->new_driver till TRUE om password stämmer
//        }elseif (!isset ($this->driver->password)) {         
//         return TRUE; // Sätter $driver->new_driver till TRUE om password inte ska uppdateras  
        }
        $this->driver->id = -2;
        return FALSE; // Sätter $driver->new_driver till FALSE om password inte stämmer
    }

    public function id() {
        return $this->driver->id;
    }

    public function name() {
        return $this->driver->name;
    }

    public function display_name() {
        return $this->driver->display_name;
    }

    public function acronym() {
        return $this->driver->acronym;
    }

    public function driver_data($id) {
        global $user;
        $user_data = $user->user_data($id);
        if ($id < -1) {
            foreach ($user_data as $row) {
                $row->value = $this->driver->{$row->user_data_descr};
            }
        }
        return $user_data;
    }

    private function extract_post() {
        foreach ($_POST as $key => $var) {
            $this->driver->{$key} = $var;
        }
        unset($_POST);
    }

}
