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

$tango->set_property('title', "Förare");
$tango->set_property('title_append', "Administrera förare");

$tango->set_property('style', array('css', 'webroot/js/jquery/include/jquery-ui-1.12.1.custom/jquery-ui.css'));
$tango->js_include("https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js");
$tango->js_include('webroot/js/driver.js');

$tango->set_property('main', driverinfo());

include_once 'footer.php';
include_once (TANGO_THEME_PATH);

function driverinfo() {
//fyller $tango med lite data att skriva ut...
    global $user;
    $current_driver = new CDriver;
    
    $selected_driver = $current_driver->id();
//#####################################################################

    $content = "<div id='form-driver'>\n";
    $content .= "<form id='select-driver' action='' method='post'>\n";
    $content .= "<fieldset>\n";
    $content .= "<legend>\nFörare\n</legend>\n";
    $content .= "<p>\n";
    if ($selected_driver < 0) {
        $content .= "<input type='hidden' name='use_driver' value= -2>\n";
    } else {
// Här börjar rutintn för inloggad förare        
        $content .= "<div class='driver-form-row'>\n";
        $content .= "<select id='use-driver'  name='use_driver'>";
// Om inloggad är admin val för ny förare
        if ($user->role() == 1 AND $selected_driver != -1) {
            $content .= "<option value='-1'>Ny förare</option>\n";
        }
// Dörarna läggs in i select-kontrollen. Inloggad markeras som vald
        foreach ($user->users() as $user_data_id => $driver_data) {
            $mark_selected = ($user_data_id == $selected_driver) ? 'SELECTED' : '';
            $content .= "<option value='{$user_data_id}' {$mark_selected}>{$driver_data['name']}</option>\n";
        }
        $content .= "</select>\n";
        $content .= "</div>\n";
//        $content .= "<div class='driver-form-label'>\n<input id='visa' type='submit' value='Visa'>\n";
//        $content .= "</div>\n";
        $content .= "</fieldset>\n";
        $content .= "<div id='form-driverinfo'>\n";
        $content .= "<form action='' method='post'>\n";
        $content .= "<fieldset>\n";
        $content .= "<legend>Förarinfo</legend>\n";
    }
    $content .= "<div class='driver-form-row'>\n";
    $content .= "<div class='driver-form-label'>\n<label>\nNamn  \n</label>\n</div>\n";
    $content .= "<div class='driver-form-input'>\n<input id='name' type='text' name='name' value='{$current_driver->name()}'>\n";
    $content .= "</div>\n";
    $content .= "<div class='driver-form-row'>\n";
    $content .= "<div class='driver-form-label'>\n<label>\nVisas \n</label>\n</div>\n";
    $content .= "<div class='driver-form-input'>\n<input id='display_name' type='text' name='display_name' value='{$current_driver->display_name()}'>\n\n";
    $content .= "</div>\n";

    if ($selected_driver < 0) {
        $content .= "<div class='driver-form-row'>\n";
        $content .= "<div class='driver-form-label'>\n<label>\nInloggning  \n</label>\n</div>\n";
        $content .= "<div class='driver-form-input'>\n<input id='acronym' type='text' name='acronym' value='{$current_driver->acronym()}'>\n</div>\n\n";
        $content .= "</div>\n";
        $content .= "<div class='driver-form-row'>\n";
        $content .= "<div class='driver-form-label'>\n<label>Password  </label>\n</div>";
        $content .= "<div class='driver-form-input'>\n<input id='password' type='text' name='password' value=''>\n</div>\n\n";
        $content .= "</div>\n";
        $content .= "<div class='driver-form-row'>\n";
        $content .= "<div class='driver-form-label'>\n<label>\nRepetera  \n</label>\n</div>\n";
        $content .= "<div class='driver-form-input'>\n<input id='password_check' type='text' name='password_check' value=''>\n</div>\n\n";
        $content .= "</div>\n";
    }
//här kommer fälten från user-posten
    foreach ($current_driver->driver_data($selected_driver) as $driver_data) {
        $content .= "<div class='driver-form-row'>\n";
        $content .= "<div class='driver-form-label'>\n<label>\n{$driver_data->user_data_descr}  \n</label>\n</div>";
        $content .= "<div class='driver-form-label'>\n";
        $content .= "<input type='text' name='{$driver_data->user_data_descr}' value='{$driver_data->value}'>\n";
        $content .= "</div>\n";
    }
    if ($user->role() == 1) {

        $content .= "<div class='driver-form-row'>\n";
        $content .= "<button id='save' type='submit'  name='save' value='1'>Spara</button>\n";
        $content .= "</div>\n";
    }
    $content .= "";
    $content .= "</fieldset>";
    $content .= "</form>";
    $content .= "</div>";

    return $content;
}
