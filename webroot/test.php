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
$tango->set_property('style',array('less', 'webroot/css/test.less'));
$tango->js_include("https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"); 
$tango->js_include('webroot/js/jquery/jquery.ui.timepicker.js');
$tango->js_include( 'webroot/js/jquery/include/ui-1.10.0/jquery.ui.core.min.js'); 
$tango->js_include('webroot/js/jquery/jquery.ui.timepicker.js');
$tango->js_include( 'webroot/js/taxi_js.js');
include_once TANGO_FUNCTIONS_PATH . "cab_funct.php";


$tango->set_property('main', test());

include_once 'footer.php';
include_once (TANGO_THEME_PATH);

function test(){
    $cont="Ett testprogram";
    $cont.="<div id='flash'>";
    $cont.="<p id='text' class='red'>Hi this text should be replaced when page and DOM is loaded.</p>";
    $cont.="</div>";
    $cont.="";
    $cont.="";
    $cont.="";
    $cont.="";
    $cont.="";
    $cont.="";
    $cont.="";
    $cont.="";
    $cont.="";
    $cont.="";
    $cont.="";
    
    return $cont;
}



