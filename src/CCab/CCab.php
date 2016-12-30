<?php

/**
 * CUser är en class för att hålla ordning på om en användare är inloggad eller 
 * inte, sköta in och utloggningar samt i förlägningen kunna ge all behövd
 * användarinformation
 *
 * @author peder
 */
class CCab{

    private $cab = null;
    private $cabs = array();
    private $cab_data = array();
    private $first_cab = null;

    public function __construct() {
        global $db;
        $db->create_db(TANGO_SOURCE_PATH . 'CCab/dbcreate.php');
        // convert $cabs to objekt ...
        $this->cab = (object) $this->cab;
        $this->get_cabs();
    }

//end __construct

    public function get_cabs() {
        // Fyller $cabs med alla användare
        global $db;
        $sql = 'SELECT * FROM cab ORDER BY cab;';
        $row = $db->query_DB($sql, array(), FALSE);
        if ($row) {
            $this->first_cab = $row;
            do {
                $this->cabs[] = $row;
                $row = $db->fetch_DB();
            } while (!$row == false);
        }
    }
    
    

    private function get_cab_data($id) {
        // Hämtar alla data för en bil
        global $db;
        $new_cab = (isset($_POST['new_cab'])) ? TRUE : FALSE;
        $sql = 'SELECT 
                  data_value.id,
                  data_descr,
                  value,
                  value_dec FROM
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
                $cab_data[] = $row;
                $row = $db->fetch_DB();
            } while (!$row == false);
        }
        if ($id < 0) {
            foreach ($cab_data as $row) {
                $row->value = $_POST[$row->cab_data_descr]; 
            }
        }
        return $cab_data;
    }

    private function cab_create_pass_fields() {
        $pass = 0;
        $day = 0;
        echo '<div class="fieldrow"><div class="field">';
        for ($pass = 0; $pass < 2; $pass++) {
            echo '<div id="pass' . $pass . '" class="pass-head">';
            _e('Pass: ');
            echo ' ' . $pass + 1 . '</div>';
        } //end for pass
        echo '</br>';
        $tider = unserialize($this->current_car['pass_time']);
        for ($day = 0; $day < 7; $day++) {
            for ($pass = 0; $pass < 2; $pass++) {
                echo '<div class="pass-head">';
                echo '<input type="text" name="pass' . $pass . '_start[' . $day . ']" class="pass" value="' . $tider['pass' . $pass . '_start'][$day] . '">';
                echo '<input type="text" name="pass' . $pass . '_stop[' . $day . ']" class="pass" value="' . $tider['pass' . $pass . '_stop'][$day] . '">';
                echo '</div>';
            } //end for pass
            echo '</br>';
        } //end for day
        echo '</div></div>';
    }
  
    public function pass_time() {   
        
        $return = unserialize($this->first_cab->pass_time);
//        $return = unserialize($this->cab->pass_time);
//        print_a($return, 'passets info');
        return $return; 
    }
    public function id() {
        return $this->cab->id;
    }

    public function name() {
        return $this->cab->name;
    }

    public function acronym() {
        return $this->cab->acronym;
    }

    public function role() {
        return $this->cab->role;
    }

    public function cabs() {
        
        return $this->cabs;
    }
    public function first_cab() {
        return $this->first_cab->id;
    }

    public function cab_data($id = -1) {
        if ($id) {
            $return = $this->get_cab_data($id);
        }
        return $return;
    }

}
