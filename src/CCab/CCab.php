<?php

/**
 * CUser är en class för att hålla ordning på om en användare är inloggad eller 
 * inte, sköta in och utloggningar samt i förlägningen kunna ge all behövd
 * användarinformation
 *
 * @author peder
 */
class CCab {

    private $cab = null;

    public function __construct() {
        $this->cab = (object) $this->cab;
        $this->get_cabs();
        $this->get_cab($this->cab->current_cab);
        $this->get_cab_data($this->cab->current_cab);
//        if(isset($this->cab_save)){};
//        $this->cab->id = (isset($this->cab->use_cab)) ? $this->cab->use_cab : $_SESSION['user'];
//
//        if (!empty($this->driver->save)) {
//            $this->save_driver();
//        }
//        $this->cab();
//        global $db;
//        $db->create_db(TANGO_SOURCE_PATH . 'CCab/dbcreate.php');
//        // convert $cabs to objekt ...
//        $this->cab = (object) $this->cab;
//        $this->get_cabs();
    }
    
    
    private function get_cab($current_cab) {
        // Fyller $cabs med alla användare
        global $db;
        $sql = 'SELECT * FROM cab ORDER BY cab;';
        $row = $db->query_DB($sql, array(), FALSE);
        foreach ($row as $key=>$data){
            $this->cab->{$key}=$data;
        }
        echo 'hepp';
        $this->cab->pass_time = unserialize($this->cab->pass_time);
    }

    private function get_cabs() {
        // Fyller $cabs med alla bilar
        global $db;
        $sql = 'SELECT id, cab FROM cab ORDER BY cab;';
        $row = $db->query_DB($sql, array(), FALSE);
        if ($row) {
            $this->cab->current_cab = $row->id;
            do {
                $cabs[] = $row;
                $row = $db->fetch_DB();
            } while (!$row == false);
        }
        $this->cab->cabs = (object) $cabs;
    }

    private function get_cab_data($id) {
        // Hämtar alla data för en bil
        global $db;
        $new_cab = (isset($_POST['new_cab'])) ? TRUE : FALSE;
        $sql = 'SELECT 
                  parent as car_id,
                  data_value.id,
                  data_descr,
                  value,
                  value_dec 
                FROM
                  (select * from data_key where owner=2) as a
                LEFT JOIN
                 data_value
                ON
                 (data_id = key_id and parent=?)
                ORDER BY
                  data_sort
                ;'; // end $sql

        $row = $db->query_DB($sql, array($id), FALSE);
        if ($row) {
            do {
                $row_data['car_id'] = $row->car_id;
                $row_data['data_descr'] = $row->data_descr;
                $row_data['id'] = $row->id;
                $row_data['value'] = $row->value;
                $row_data['value_dec'] = $row->value_dec;
                $cab_data[$row->data_descr]=(object)$row_data;
                $row = $db->fetch_DB();
            } while (!$row == false);
        }
        $this->cab->cab_data = (object) $cab_data;
        print_a($this->cab);
//        if ($id < 0) {
//            foreach ($cab_data as $row) {
//                $row->value = $_POST[$row->cab_data_descr];
//            }
//        }
//        return $cab_data;
    }

    private function extract_post() {
        if (isset($_POST)) {
            if (!empty($_POST['key'])) {
                $this->extract_post_key();
            }
            unset($_POST['key']);
            unset($_POST['value']);
            unset($_POST['post_id']);
            unset($_POST['user_data_id']);
            foreach ($_POST as $key => $var) {
                $this->cab->{$key} = $var;
            }
            unset($_POST);
        }
    }

    private function extract_post_key() {
        foreach ($_POST['key'] as $index => $key) {
            $user_data['value'] = $_POST['value'][$index];
            $user_data['post_id'] = $_POST['post_id'][$index];
            $user_data['user_data_id'] = $_POST['user_data_id'][$index];
            $this->cab->{$key} = (object) $user_data;
            unset($user_data);
        }
    }

    public function cabs() {
        print_a($this->cab);
        $return = $this->cab->cabs;
        return $return;
    }

    public function id() {
        return $this->cab->current_cab;
    }
    public function cab_data() {
        return $this->cab->cab_data;
        
    }
    public function pass_time() {
        return $this->cab->pass_time;
        
    }
}
