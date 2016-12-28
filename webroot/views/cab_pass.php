<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$content .= "\n<!-- Här börjar rutinten för att skapa inmatningsfält för pass -->\n\n";

$content .= "<div class='cab-form-row'>\n";
$content .= "<div class='cab-form-label'>\n<label>\nAntal pass \n</label>\n</div>\n";
$content .= "<div class='cab-form-field'>\n";
$content .= "<select name='cab_pass'>";
$content .= "<option value=1>1</option>\n";
$content .= "<option value=2 selected>2</option>\n";
$content .= "<option value=3>3</option>\n";
$content .= "</select>\n";
$content .= "</div>";


$tider = $cab->pass_time();
dump($tider);
$pass = 0;
$day = 0;
$content.= "<div class='cab-form-row>'<div id='car-pass-{$pass}' class='car-pass-head'>'";

//        echo '<div class="fieldrow"><div class="field">' ;
//        for ( $pass= 0 ; $pass < 2 ; $pass++ ){
//            echo '<div id="pass' . $pass . '" class="pass-head">' ;
//            _e( 'Pass: ' ) ;
//            echo ' ' .$pass +1 . '</div>' ;
//        } //end for pass
//        echo '</br>' ;
//        $tider = unserialize( $this->current_car['pass_time'] );
//        for ( $day= 0 ; $day < 7 ; $day++ ){
//            for ( $pass= 0 ; $pass < 2 ; $pass++ ){
//              echo '<div class="pass-head">';
//              echo '<input type="text" name="pass' . $pass . '_start['. $day . ']" class="pass" value="' . $tider['pass' . $pass . '_start'][$day] .'">' ;
//              echo '<input type="text" name="pass' . $pass . '_stop['. $day . ']" class="pass" value="' . $tider['pass' . $pass . '_stop'][$day] .'">' ;
//              echo '</div>' ;
//            } //end for pass
//            echo '</br>' ;
//        } //end for day
//        echo '</div></div>' ;

$content .= "\n<!-- Här slutar rutinten för att skapa inmatningsfält för pass -->\n\n";
