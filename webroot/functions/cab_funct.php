<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of cab_funct
 *
 * @author peder
 */
function save_cab() {
    global $db;
    global $cab;
    echo 'session';
    dump($_SESSION);
    if (empty($_SESSION['cab'])){$_SESSION['cab'] = $cab->first_cab();}
    dump($_SESSION);
    $return = (isset($_POST['use_cab'])) ? $_POST['use_cab'] : $_SESSION['cab'];
    if (!isset($_POST['save'])) {
        return (isset($_POST['use_cab'])) ? $_POST['use_cab'] : $_SESSION['cab'];
    }
    if ($_POST['save']) {
        echo 'spara posten';
        $sql = "INSERT INTO Cab (cab) VALUES ('820);";
        $cab_array[] = $_POST['cab'];
        $succed = $db->DB_execute($sql, $cab_array, FALSE);
        if ($succed) {
            echo 'jag lyckades';
            $id = $db->id_new_post();
            $_POST['use_cab'] = $id;
            $sql = "INSERT INTO cab_data (cab, cab_data_id, value) VALUES (?, ?, ?)";
            foreach ($cab->cab_data() as $row) {
//                dump($_POST);
                echo $row->cab_data_descr;
                if (!empty($_POST[$row->cab_data_descr])) {
//                dump($_POST);
                    unset($cab_array);
                    $cab_array[] = $id;
                    $cab_array[] = $row->cab_data_id;
                    $cab_array[] = $_POST[$row->cab_data_descr];
                    $succed = $db->DB_execute($sql, $cab_array, FALSE);
                }
            }
            $cab->get_cabs();
        }
    return $id;
        
    }
}
