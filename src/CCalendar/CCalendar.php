<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CCalendar
 *
 * @author peder
 */
class CCalendar {

    public $datum = array();

    public function __construct() {
        $this->dates = $this->parse_days();
//      $this->get_drivers( true );
//      $this->fetch_calendar() ;
    }

// end construct

    public function parse_days() {
        $mo = 0;
        $yr = 0;
        $dates = array();
        if (isset($_GET['txi_date'])) {
            list($yr, $mo, $da) = explode('-', $_GET['txi_date']);
            $dates = array('day' => intval($da),
                'month' => intval($mo),
                'year' => intval($yr));
        } else {
            $dates = array('day' => date('d'),
                'month' => date('m'),
                'year' => date('Y'));
        }
        $dates['days_in_month'] = cal_days_in_month(CAL_GREGORIAN, $dates['month'], $dates['year']);
        $dates['year_month'] = $dates['year'] . '-' . sprintf('%02s', $dates['month']);

        $dates['offset'] = date('w', mktime(0, 0, 0, $mo, 1, $yr));
        // we must have a value in range 1..7
        if ($dates['offset'] == 0)
            $dates['offset'] = 7;
        $foo = $dates['year'] . '-' . $dates['month'] . '-1';
        $dates['date_array'] = $this->array_with_dates($foo, $dates['offset']);
        $this->datum = $dates;
        return $dates;
    }

//end parse days

    public function array_with_dates($date, $offset) {
        $newdate = array();
        for ($datum = (-1 * $offset ) + 1; $datum < 43 - $offset; $datum++) {
            $find_day = $datum . ' day';
            $newdate1 = strtotime($find_day, strtotime($date));
            $newdate1 = date('Y-m-d', $newdate1);
            list($yr, $mo, $da) = explode('-', $newdate1);
            $newdate[$newdate1] = $dates['offset'] = date('W', mktime(0, 0, 0, $mo, $da, $yr));
            ;
        }

        return $newdate;
    }

    ########################################################################
    #
     # Prints the name of the day. Expects tu have the argument for short or full
    # name and day of the month.
    #
     #########################################################################

    public function day_name($short, $day) {

        $day_length = (!$short) ? 'l' : 'D';
        $day = date($day_length, mktime(0, 0, 0, $this->datum['month'], $day, $this->datum['year']));
        $day . "\n";
        $day = (!strpos($day, 195) ? substr($day, 0, 2) : substr($day, 0, 3));
        switch ($day) {
        case "Mo";
            $day = "M&aring;";
            break;
        case 'Tu';
            $day = "Ti";
            break;
        case "We";
            $day = "On";
            break;
        case "Th";
            $day = "To";
            break;
        case "Fr";
            $day = "Fr";
            break;
        case "Sa";
            $day = "L&ouml;";
            break;
        case "Su";
            $day = "S&ouml;";
            break;
        }
        return $day;
    }

//end txi_day_name
    ########################################################################
    #
       # Prints the year
    #
      ########################################################################

    public function out_year() {
       return $this->dates['year'];
    }

//end txi_year
    //########################################################################
    //Prints a link to the previous month
    //########################################################################

    public function out_link_prev_month() {
        return ('<a href="?txi_date=' . date('Y-m-d', mktime(0, 0, 0, $this->datum['month'], 0, $this->datum['year'])) . '">&laquo;</a>');
    }

//end
    #######################################################################
    #
      # Prints a link to the next month
    #
      ########################################################################

    public function out_link_next_month() {
        return '<a href="?txi_date=' . date('Y-m-d', mktime(0, 0, 0, $this->datum['month'] + 1, 1, $this->datum['year'])) . '">&raquo;</a>';
    }

//end next_month

    public function txi_month_name($short) {
        $day_length = (!$short) ? 'F' : 'M';
        $mont_name = date($day_length, mktime(0, 0, 0, $this->datum['month'], $this->datum['day'], $this->dates['year']));
        return ucfirst($mont_name);
    }

//end txi_month_name

    public function out_txi_date() {
        return "$this->datum['year']-$this->datum['month']-$this->datum['day']";
    }

//end txi_date

    public function fetch_calendar(){
      global $db;
      
      $sql = "SELECT cab,
                  pass AS pass,
                  start_date AS start_date,
                  driver AS driver,
                  id ,
                  start_time,
                  end_time
              FROM cab_pass
              WHERE start_date LIKE ?
              AND type = 1
              ORDER BY cab, start_date;";
      
      

        $row = $db->query_DB($sql, array($this->datum['year_month']."-%"), FALSE);
        if ($row) {
            do {
                $calendar_data[] = $row;
                $row = $db->fetch_DB();
            } while (!$row == false);
        }
        return $calendar_data;
    }  

}
