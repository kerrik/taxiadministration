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

include_once TANGO_FUNCTIONS_PATH . "driver_funct.php";

$tango->set_property('main', driverinfo());

include_once 'footer.php';
include_once (TANGO_THEME_PATH);

function driverinfo() {
//fyller $tango med lite data att skriva ut...
    global $user;
    $driver = save_driver();
    $selected_driver = $driver->id;
//#####################################################################

    $content = "<div id='form-driver'>";
    $content .= "<form action='' method='post'>";
    $content .= "<fieldset>";
    $content .= "<legend>Förare</legend>";
    $content .= "<p>";
    if ($selected_driver < 0) {
        $content .= "<input type='hidden' name='use_driver' value= -2>\n";
        $content .= "<div class='driver-form-row'>\n";
        $content .= "<div class='driver-form-label'><label>Inloggning  </label></div>\n";
        $content .= "<div class='driver-form-input'><input type='text' name='acronym' value='{$driver->new_driver->acronym}'></div></br>\n";
        $content .= "</div>\n";
        $content .= "<div class='driver-form-row'>\n";
        $content .= "<div class='driver-form-label'><label>Namn  </label></div>";
        $content .= "<div class='driver-form-input'><input type='text' name='name' value='{$driver->new_driver->name}'></br>\n";
        $content .= "</div>\n";
        $content .= "<div class='driver-form-row'>\n";
        $content .= "<div class='driver-form-label'><label>Password  </label></div>";
        $content .= "<div class='driver-form-input'><input type='text' name='password' value=''></div></br>\n";
        $content .= "</div>\n";
        $content .= "<div class='driver-form-row'>\n";
        $content .= "<div class='driver-form-label'><label>Repetera  </label></div>";
        $content .= "<div class='driver-form-input'><input type='text' name='password_check' value=''></div></br>\n";
        $content .= "</div>";
    } else {
// Här börjar rutintn för inloggad förare        
        $content .= "<div class='driver-form-row'>\n";
        $content .= "<select name='use_driver'>";
// Om inloggad är admin val för ny förare
        if ($user->role() == 1 AND $selected_driver != -1) {
            $content .= "<option value='-1'>Ny förare</option>\n";
        }
// Dörarna läggs in i select-kontrollen. Inloggad markeras som vald
        foreach ($user->users() as $user_data_id=>$userdata) { 
            $mark_selected = ($user_data_id == $selected_driver) ? 'SELECTED' : '';
            $content .= "<option value='{$user_data_id}' {$mark_selected}>{$userdata['name']}</option>\n";
        }
        $content .= "</select>";
        $content .= "</div>";
        $content .= "<div class='driver-form-label'><input type='submit' value='Visa'></br>\n";
        $content .= "</div>\n";
        $content .= "</fieldset>\n";
        $content .= "<div id='form-driverinfo'></br>\n";
        $content .= "<form action='' method='post'></br>\n";
        $content .= "<fieldset></br>\n";
        $content .= "<legend>Förarinfo</legend>\n";
    }
//här kommer fälten från user-posten
    foreach ($user->user_data($selected_driver) as $userdata) {
        $content .= "<div class='driver-form-row'>\n";
        $content .= "<div class='driver-form-label'><label>{$userdata->user_data_descr}  </label></div>";
        $content .= "<div class='driver-form-label'>";
        $content .= "<input type='text' name='{$userdata->user_data_descr}' value='{$userdata->value}'></br>\n";
        $content .= "</div>\n";
    }
    if ($user->role() == 1) {

        $content .= "<div class='driver-form-row'>\n";
        $content .= "<button type='submit'  name='save' value='1'>Spara</button></br>\n";
        $content .= "</div>\n";
    }
    $content .= "";
    $content .= "</fieldset>";
    $content .= "</form>";
    $content .= "</div>";

    return $content;
}
