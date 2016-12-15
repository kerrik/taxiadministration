<?php
/** Det här är mitt första försök till em me-sida med tango
 * 
 * Tango är en struktur för websidor skapad på kursen ooophp av mig
 * Peder Nordenstad.
 */

// Ikluderar config.php. som sätter igång allt.

include( __DIR__ . '/config.php');


//fyller $tango med lite data att skriva ut...

$tango->set_property('title', "Två tangeros ");
$tango->set_property('title_append', "En tangoupplevelse utöver det vanliga");


/**
 * Du är inte nöjd med det sidhuvud som automatiskt skapas av CTango?
 * Fritt fram att göra vad du vill. Mallen här nedan är precis vad som
 * skrivs ut av systemet automatiskt baserat på inlagda värden
 */
//$header = "<img class='sitelogo left' src='" . $tango->logo() . "' alt=''/>n";
//$header .= "<div class='sitetitle left'>" . $tango->title() . "</div>\n";
//$header .= "<div class='siteslogan left'>" . $tango->title_append() . "</div>\n";
//$tango->set_property('header', $header);

$tango->set_property('main', <<<EOD
        <h1>Sovplatser</h1>
        <div class='text'>
        
   <p>
   Vi har
   <ul>
   <li>13 sängplatser i dubbel/trippelsäng</li>
   <li>Ytterligare en dubbelsäng om man vill sova i sjöboden</li>
   <li>Vid behov/önskemål en dubbelsäng i mindre båt</li>
   <li>10 sängplatser i enkelsäng</li>
   <li>9 platser för eget sovunderlag, ev fler om man vill tränga ihop sig
   <li>Plats för ett antal båtar vid brygga. </li>
   <li>Gott om plats för tält mm</li>
   </ul>
   </p>
   <p>Gå in på menyvalet Svinåker så kan du se hur det ser ut.</p>
        

        
        </div>
EOD
);

$tango->set_property('footer', <<<EOD
        <div class='sitefooter left'>
            &copy;Peder Nordenstad <a href='mailto:peder@nordenstad.se'>(peder@nordenstad.se)</a>
        </div>
EOD
);

include_once (TANGO_THEME_PATH);
        
