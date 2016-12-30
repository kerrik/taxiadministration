<?php

/*
  Copyright (C) 2016 peder

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY;
  without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program. If not, see <http://www.gnu.org/licenses/>.

  #########################################################################
 */

// Ikluderar config.php. som sätter igång allt.

include( __DIR__ . '/config.php');
$tango->set_property('title', "Planering");
$tango->set_property('title_append', "Planera bilar");
$tango->set_property('style', array('css', 'webroot/css/old.css'));
$tango->js_include("https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js");
$tango->js_include('webroot/js/jquery/jquery.ui.timepicker.js');
$tango->js_include('webroot/js/jquery/include/ui-1.10.0/jquery.ui.core.min.js');
$tango->js_include('webroot/js/taxi_js.js');
include_once TANGO_FUNCTIONS_PATH . "cab_funct.php";


$dates = new CDates();

$tango->set_property('main', test());

include_once 'footer.php';
include_once (TANGO_THEME_PATH);

/// inget under här kommer med. Dumdjävel.

function test() {
    $cal = new CCalendar();
    $cab = new CCab;
    $cab_data = $cal->fetch_calendar(true);

    $cont = "<div id='form-cab'>\n";
    $cont .= "<div class='cab-form-row'>\n";
    $cont .= "<div id='calendar'>\n";
    $cont .= "<div id= 'calendar_heading'>\n";
    $cont .= "<div class='rubrik'>\n";
    $cont .= "<div id='calendar_heading_date'>\n";
    $cont .= "<span class='prev_month left'>\n";
    $cont .= $cal->out_link_prev_month() . "\n";
    $cont .= "</span>\n";
    $cont .= "<span class='left'>\n";
    $cont .= $cal->txi_month_name(0);
    $cont .= $cal->out_year() . "\n";
    $cont .= "</span>\n";
    $cont .= "<span class='next_month left'>\n";
    $cont .= $cal->out_link_next_month();
    $cont .= "</span>\n";
    $cont .= "</div><!-- #calendar_heading_date -->\n";
    $cont .= "</div><!-- .rubrik -->\n";
    $cont .= "</div><!-- #calendar_heading -->\n";
    $cont .= "<div id='dates'>\n";
    $cont .= "<div class='bil-rubrik'>\n";
    $cont .= "</div> <!--just for making space -->\n";
    for ($counter1 = 1; $counter1 <= $cal->datum['days_in_month']; $counter1++) {
        $cont .= "<div class='date' id='day" . $counter1 . "'>\n<span class='left'>\n";
        $cont .= $cal->day_name(true, $counter1) . "\n";
        $cont .= "</span><span class='right'>{$counter1}</span>\n</div>\n";
    }//end for
    $cont .= "</div> <!--dates-->\n";
    foreach ($cab->cabs() as $cab => $cab_data) {
        $cont .= "<div class='bil-calendar'>\n";
        $cont .= "<div class='bil-rubrik'>\n";
        $cont .= "{$cab}" . "\n";
    $cont .= "</div><!-- .rubrik -->";
        for ($pass = 0; $pass < $cab_data->pass; $pass++) {
            $cont .= "<div class='bil-rubrik-tid'>\n";
            $cont .= ( $pass == 0) ? "<div class='bil-day'>" : "<div class='bil-night'>";
            $cont .= "\n";
            $cont .= ($pass == 0) ? 'Dag' : 'Natt';
            $cont .= "</div>\n";
            $cont .= tur_cal_print_drivers($cab, $pass, $nodak_taxis[$cab]);
            $cont .= "</div><!-- .bil-day/bil-night -->\n";
            $cont .= "";
            $cont .= "";
        } //end for
        $cont .= "</div><!-- .bil-calendar -->\n";
    } //end foreach
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "";
    $cont .= "</div><!-- #calendar -->\n";
    $cont .= "</div><!-- .form_row -->\n";

    return $cont;
}

function tur_cal_print_drivers($bil, $pass, $kalendar) {
    global $user;
    global $dates;

    $post = array();
    for ($counter1 = 1; $counter1 <= $dates->datum['days_in_month']; $counter1++) {
        $date = $dates->datum['year'] . '-' . sprintf("%02s", $dates->datum['month']) . '-' . sprintf("%02s", $counter1);
        $post = $kalendar[$pass][$date];
        $duration = $post['start_time'] . '-' . $post['end_time'];
//        $txi_driver = ( $post['driver'] ) ? $user->users[driver]->acronym : '-----';
        $txi_driver = ( $post['driver'] ) ? "nisse\n" : "-----";
//        $txi_driver = ( $post['id'] ) ? $txi_driver : '';
        $calendar_post = "<div class='calendarpost' data-tooltip='tip1'  calendar-id='" . $post['id'] . "' calendar-time='" . $duration . "' calendar-type='" . $bil . "'>\n" . $txi_driver . "</div>\n";
        return $calendar_post;
    }//end for
}

//end tur_cal_print_days_in_month