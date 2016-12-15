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


//fyller $tango med lite data att skriva ut...

$tango->set_property('title', "Förare");
$tango->set_property('title_append', "Administrera förare");

//#####################################################################

$content = "<div id='form-driver'>";
$content .= "<form method=post>";
$content .= "<fieldset>";
$content .= "<legend>Förare</legend>";
$content .="<p>";
$content .= "<select name='drivers'>";
foreach ($user->users() as $userdata){
    $content .= "<option value='{$userdata->id}'>{$userdata->name}</option>";    
}
$content .= "</select>";
$content .= "</p>";
$content .= "</fieldset>";
$content = "<div id='form-driverinfo'>";
$content .= "<form method=post>";
$content .= "<fieldset>";
$content .= "<legend>Förarinfo</legend>";
$content .="<p>";
$content .= "<label>TFL</label>";
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "</fieldset>";
$content .= "</form>";
$content .= "</div>";
        
$tango->set_property('main', $content);




include_once 'footer.php';
include_once (TANGO_THEME_PATH);
        
