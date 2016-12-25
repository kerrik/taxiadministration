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
        $sql = 'SELECT * FROM Cab ORDER BY cab;';
        $row = $db->query_DB($sql, array(), FALSE);
        if ($row) {
            $this->first_cab = $row;
            do {
                $this->cabs[] = $row;
                $row = $db->fetch_DB();
            } while (!$row == false);
        }
//        print_a($this->cabs, 'get_cabs');
    }
    
    

    private function get_cab_data($id) {
        // Hämtar alla data för en användare
        global $db;
        $new_driver = (isset($_POST['new_driver'])) ? TRUE : FALSE;
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
        if ($id == '-1' && $new_driver) {
            foreach ($cab_data as $row) {
                $row->value = $_POST[$row->cab_data_descr];
            }
        }
//        dump($cab_data);
        return $cab_data;
    }

    // Kollar i $_SESSION om någon är inloggad och hämtar uppgifterna därifrån
   

//end logincheck()
    //metod för inloggning
    public function login() {
        global $db;
        $sql = "SELECT id FROM User WHERE acronym = ? AND password = md5(concat(?, salt))";
        $this->cab = $db->query_DB($sql, array($_POST['acronym'], $_POST['password']), FALSE);
        if (isset($this->cab->id)) {
            $_SESSION['cab'] = $this->cab->id;
        }
    }

// end login()
//    metod för utloggning
    public function logged_in() {
        return $this->cab->logged_in;
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
