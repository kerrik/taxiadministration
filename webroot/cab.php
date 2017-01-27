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
$tango->set_property('style', array('less', 'webroot/css/test.less'));
$tango->set_property('style', array('css', 'webroot/js/jquery/css/jquery.ui.timepicker.css'));
$tango->set_property('style', array('css', 'webroot/js/jquery/css/jquery-ui-1.10.0.custom.min.css'));
$tango->js_include("https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js");
$tango->js_include('webroot/js/jquery/include/ui-1.10.0/jquery.ui.core.min.js');
$tango->js_include('webroot/js/jquery/jquery.ui.timepicker.js');
$tango->js_include('webroot/js/jquery.timeentry/jquery.timeentry.js');
$tango->js_include('webroot/js/jquery.timeentry/jquery.timeentry-sv.js');
$tango->js_include('webroot/js/caradmin.js');
include_once TANGO_FUNCTIONS_PATH . "cab_funct.php";


$tango->set_property('main', cabinfo());

include_once 'footer.php';
include_once (TANGO_THEME_PATH);

function cabinfo() {
//fyller $tango med lite data att skriva ut...
    global $user;
    $current_cab = new CCab;

    $selected_cab = $current_cab->id();

//    $selected_cab = (isset($_POST['use_cab'])) ? $_POST['use_cab'] : $_SESSION['cab'];
////#####################################################################

    $content = "<div id='form-block'>\n";
    $content .= "<form id='cab-info' action='' method='post'>\n";
    $content .= "<fieldset>\n";
    $content .= "<legend>\nBilinfo\n</legend>\n";
    if ($selected_cab < 0) {
        $content .= "<input type='hidden' name='use_car' value=-2>\n";
    } else {
        $content .= "<div class='cab-form-row'>\n";
        $content .= "<div class='cab-form-label'>\n";
        $content .= "<select id='select-cab' name='current_cab'>\n";
        if ($user->role() == 1 AND $selected_cab != -1) {
            $content .= "<option value='-1'>Ny bil</option>\n";
        }
        $test = $current_cab->cabs();
        foreach ($current_cab->cabs() as $cabdata) {
            $mark_selected = ($cabdata->id == $selected_cab) ? 'SELECTED' : '';
            $content .= "<option value='{$cabdata->id}' {$mark_selected}>{$cabdata->cab}</option>\n";
        }
    $content .= "</select>\n";
    $content .= "</div>\n";
    $content .= "</div>\n";
    }
    $content .= "<div class='cab-form-block left'>\n";
    foreach ($current_cab->cab_data($selected_cab) as $cabdata) {
        $content .= "<div class='driver-form-row'>\n";
        $content .= "<div class='driver-form-label'>\n<label>\n{$cabdata->data_descr}  \n</label>\n</div>\n";
        $content .= "<div class='driver-form-label'>\n";
        $content .= "<input type='text' name='value[]' value='{$cabdata->value}'>\n";
        $content .= "<input type='hidden' name='key[]' value='{$cabdata->data_descr}'>\n";
        $content .= "<input type='hidden' name='user_data_id[]' value='{$cabdata->car_id}'>\n";
        $content .= "<input type='hidden' name='post_id[]' value='{$cabdata->id}'>\n";
        $content .= "</div>\n</div>\n";
    }
    $content .= "</div>\n";
    $content .= "<div class='cab-form-block left'>\n";
    include_once TANGO_VIEWS_PATH . "cab_pass.php";
    $content .= "</div>\n";
    if ($user->role() == 1) {

        $content .= "<div class='cab-form-row'>\n";
        $content .= "<button type='submit'  name='save' value='TRUE'>Spara</button></br>\n";
        $content .= "</div>\n";
    }
    $content .= "";
    $content .= "</fieldset>\n";
    $content .= "</form>\n";
    $content .= "</div>\n";
//    $cab->pass_time($selected_cab);
    return $content;
}
