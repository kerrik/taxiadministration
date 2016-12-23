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

$tango->set_property('title', "Bilar");
$tango->set_property('title_append', "Administrera bilar");

include_once TANGO_FUNCTIONS_PATH . "cab_funct.php";

$cab = new CCab();

save_cab();

$tango->set_property('main', cabinfo());

include_once 'footer.php';
include_once (TANGO_THEME_PATH);

function cabinfo() {
//fyller $tango med lite data att skriva ut...
    global $cab;
    global $user;
    $selected_cab = (isset($_POST['use_cab'])) ? $_POST['use_cab'] : $_SESSION['user'];
////#####################################################################

    $content = "<div id='form-cab'>";
    $content .= "<form action='' method='post'>";
    $content .= "<fieldset>";
    $content .= "<legend>Förare</legend>";
    $content .= "<p>";
    if ($selected_cab == -1) {
        $content .= "<div class='cab-form-row'>\n";
        $content .= "<div class='cab-form-label'><label>Inloggning  </label></div>";
        $content .= "<div class='cab-form-input'><input type='text' name='acronym' value=''></div></br>\n";
        $content .= "</div>\n";
        $content .= "<div class='cab-form-row'>\n";
        $content .= "<div class='cab-form-label'><label>Namn  </label></div>";
        $content .= "<div class='cab-form-input'><input type='text' name='name' value=''></br>\n";
        $content .= "</div>\n";
        $content .= "<div class='cab-form-row'>\n";
        $content .= "<div class='cab-form-label'><label>Password  </label></div>";
        $content .= "<div class='cab-form-input'><input type='text' name='password' value=''></div></br>\n";
        $content .= "</div>\n";
        $content .= "<div class='cab-form-row'>\n";
        $content .= "<div class='cab-form-label'><label>Repetera  </label></div>";
        $content .= "<div class='cab-form-input'><input type='text' name='password_check' value=''></div></br>\n";
        $content .= "</div>";
    } else {
        $content .= "<div class='cab-form-row'>\n";
        $content .= "<select name='use_cab'>";
        if ($user->role() == 1 AND $selected_cab != -1) {
            $content .= "<option value='-1'>Ny bil</option>\n";
        }
        foreach ($cab->cabs() as $cabdata) {
            $mark_selected = ($cabdata->cab == $selected_cab) ? 'SELECTED' : '';
            $content .= "<option value='{$cabdata->id}' {$mark_selected}>{$cabdata->cab}</option>\n";
        }
        $content .= "</select>";
        $content .= "</div";
        $content .= "<div class='cab-form-label'><input type='submit' value='Visa'></br>\n";
        $content .= "</div>\n";
        $content .= "</fieldset>\n";
        $content .= "<div id='form-cabinfo'></br>\n";
        $content .= "<form action='' method='post'></br>\n";
        $content .= "<fieldset></br>\n";
        $content .= "<legend>Förarinfo</legend>\n";
    }
    foreach ($cab->cab_data($selected_cab) as $cabdata) {
//        dump($cabdata);
        $content .= "<div class='cab-form-row'>\n";
        $content .= "<div class='cab-form-label'><label>{$cabdata->data_descr}  </label></div>";
        $content .= "<div class='cab-form-label'>"
                . "<input type='text' name='{$cabdata->data_descr}' value='{$cabdata->value}'></br>\n";
        $content .= "</div>\n";
    }
    if ($cab->role() == 1) {

        $content .= "<div class='cab-form-row'>\n";
        $content .= "<button type='submit'  name='save' value='TRUE'>Sparad</button></br>\n";
        $content .= "</div>\n";
    }
    $content .= "";
    $content .= "</fieldset>";
    $content .= "</form>";
    $content .= "</div>";

    return $content;
}
