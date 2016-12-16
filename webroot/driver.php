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

include_once TANGO_FUNCTIONS_PATH. "driver_funct.php";

save_driver();

$tango->set_property('main', driverinfo());

include_once 'footer.php';
include_once (TANGO_THEME_PATH);

function driverinfo() {
//fyller $tango med lite data att skriva ut...
    global $user;

    $selected_driver = (isset($_POST['use_driver'])) ? $_POST['use_driver'] : $_SESSION['user'];
//#####################################################################

    $content = "<div id='form-driver'>";
    $content .= "<form action='' method='post'>";
    $content .= "<fieldset>";
    $content .= "<legend>Förare</legend>";
    $content .="<p>";
    if ($selected_driver == -1) {
        $content .= "<label>Inloggning  </label>";
        $content .= "<input type='text' name='acronym' value=''></br>\n";
        $content .= "<label>Namn  </label>";
        $content .= "<input type='text' name='name' value=''></br>\n";
    } else {
        $content .= "<select name='use_driver'>";
        if ($user->role() == 1 AND $selected_driver != -1) {
            $content .= "<option value='-1'>Ny förare</option>\n";
        }
        foreach ($user->users() as $userdata) {
            $mark_selected = ($userdata->id == $selected_driver) ? 'SELECTED' : '';
            $content .= "<option value='{$userdata->id}' {$mark_selected}>{$userdata->name}</option>\n";
        }

        $content .= "</select>";
        $content .= "<input type='submit' value='Visa'></br>\n";
        $content .= "</fieldset>\n";
        $content .= "<div id='form-driverinfo'></br>\n";
        $content .= "<form action='' method='post'></br>\n";
        $content .= "<fieldset></br>\n";
        $content .= "<legend>Förarinfo</legend>\n";
    }
    echo $selected_driver;
    foreach ($user->user_data($selected_driver) as $userdata) {
//        dump($userdata);
        $content .= "<label>{$userdata->user_data_descr}  </label>";
        $content .= "<input type='text' name='{$userdata->user_data_descr}' value='{$userdata->value}'></br>\n";
    }
    if ($user->role() == 1) {
        $content .= "<button type='submit'  name='save' value='TRUE'>Sparad</button></br>\n";
    }
    $content .= "";
    $content .= "</fieldset>";
    $content .= "</form>";
    $content .= "</div>";

    return $content;
}
