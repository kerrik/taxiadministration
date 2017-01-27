<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$content .= "\n<!-- Här börjar rutinten för att skapa inmatningsfält för pass -->\n\n";
//
//$content .= "<div class='cab-form-row'>\n";
//$content .= "<div class='cab-form-label'>\n<label>\nAntal pass \n</label>\n</div>\n";
//$content .= "<div class='cab-form-field'>\n";
//$content .= "<select name='cab_pass'>";
//$content .= "<option value=1>1</option>\n";
//$content .= "<option value=2 selected>2</option>\n";
//$content .= "<option value=3>3</option>\n";
//$content .= "</select>\n";
//$content .= "</div>\n";
//$content .= "</div><!-- end cab-form-row -->\n";


$tider = $current_cab->pass_time();
$pass = 0;
$day = 0;
$content .= "<div class='cab-form-row'>\n<div class='field'>\n";
for ($pass = 0; $pass < 2; $pass++) {
    $pass_etikett = $pass + 1;
    $content .= "<div id='pass{$pass}' class='cab-pass-row'>\n";
    $content .= "Pass " . $pass_etikett;
    $content .= "\n</div>\n";
}
$content .= "</div>\n</div>\n";
for ($day = 0; $day < 7; $day++) {
    $content .= "<div class='cab-form-row'>\n";
    for ($pass = 0; $pass < 2; $pass++) {
        $content .= "<div class='cab-pass-row'>";
        $content .= "<input type='text' name='pass{$pass}_start[{$day}]' class='pass' value='" . $tider["pass{$pass}_start"][$day] . "'>\n";
        $content .= "<input type='text' name='pass{$pass}_stop[{$day}]' class='pass' value='" . $tider["pass{$pass}_stop"][$day] . "'>\n";
        $content .= "</div>\n";
    } //end for day;
    $content .= "</div>\n";
} //end for pass
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "";
$content .= "";

//        echo '' ;
//            echo '' ;
//            _e( 'Pass: ' ) ;
//            echo ' ' .$pass +1 . '</div>' ;
//        } //end for pass
//        echo '</br>' ;
//        $tider = unserialize( $this->current_car['pass_time'] );
//              echo '';
//              echo '' ;
//              echo '' ;
//              echo '' ;
//            echo '</br>' ;
//        echo '</div></div>' ;

$content .= "\n<!-- Här slutar rutinten för att skapa inmatningsfält för pass -->\n\n";
