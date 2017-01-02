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
    global $user;
    $cal = new CCalendar();
    $cab = new CCab;
    $cab_data = $cal->calendar_data();

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
    $cont .= "<<select id='current_driver' name='driver' size='1'>>";
// Dörarna läggs in i select-kontrollen. Inloggad markeras som vald
    foreach ($user->users() as $user_data_id => $userdata) {
        $cont .= "<option value='{$user_data_id}' >{$userdata['display_name']}</option>\n";
    }
    $cont .= "</select>";
    $cont .= "</div><!-- .rubrik -->\n";
    $cont .= "</div><!-- #calendar_heading -->\n";
    $cont .= $cal->the_calendar['cab'];
    $cont .= $cal->the_calendar['pass_name'];
    foreach ($cal->the_calendar['pass'] as $calendar_row) {
        $cont .= $calendar_row;
    }
//        
//        $cont .= "</div><!-- .bil-calendar -->\n";
//    } //end foreach
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
        $calendar_post = "<div class='calendarpost' data-tooltip='tip1'  calendar-id='" . $counter1 . "' calendar-time='" . $duration . "' calendar-type='" . $bil . "'>\n" . $txi_driver . "</div>\n";
        return $calendar_post;
    }//end for
}

//end tur_cal_print_days_in_month