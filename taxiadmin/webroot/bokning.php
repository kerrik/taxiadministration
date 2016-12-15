<?php
/** Det här är mitt första försök till em me-sida med tango
 * 
 * Tango är en struktur för websidor skapad på kursen ooophp av mig
 * Peder Nordenstad.
 */

// Ikluderar config.php. som sätter igång allt.

include( __DIR__ . '/config.php');


//fyller $tango med lite data att skriva ut...

$tango->set_property('title', "Tango, webbsidor som en dans");
$tango->set_property('title_append', "En webmall skapad på kursen ooophp på BTH");


/**
 * Du är inte nöjd med det sidhuvud som automatiskt skapas av CTango?
 * Fritt fram att göra vad du vill. Mallen här nedan är precis vad som
 * skrivs ut av systemet automatiskt baserat på inlagda värden
 */
//$header = "<img class='sitelogo left' src='" . $tango->logo() . "' alt=''/>n";
//$header .= "<div class='sitetitle left'>" . $tango->title() . "</div>\n";
//$header .= "<div class='siteslogan left'>" . $tango->title_append() . "</div>\n";
//$tango->set_property('header', $header);
$sql= "SELECT * \n";
$sql.= "FROM  email \n";
$sql .= "WHERE  search='{$_GET['bokning']}' \n";
$booking_head = $db->query_DB($sql, array( $_GET['bokning']));
$booking_head=$booking_head[0];

$anmalan = visa_data($booking_head);

$tango->set_property('main', <<<EOD
<div class='text'>
<div class='deltagartext'>
<h1>Anmälan</h1>
<h2>Det här är hur jag tolkat din anmälan.</h2>
<p>Om något, mot förmodan, gud förbjude osv inte stämmer kontakta mig via mail
   på <a href= 'mailto:boka@2tangeros.se'> boka@2tangeros.se. </a>
</p>
</div>
{$anmalan}

<div class='deltagartext'>
<p>Beloppet betalas till SEB 5254 29 105 37 eller Swisha till 076 255 60 70.<br>
Ange anmälningsid som du ser här på sidan.<br>
Betalningen ska finnas på kontot senast 15/7 för att du ska vara säker på din plats.
</p>
<p>Har du bokat boende? Vi har ett begränsat antal sängplatser, några behöver ha egen
 madrass/liggunderlag med sig för att det ska räcka. Har du möjlighet att ta med det? 
 Meddela om du tar med är du snäll.
 </p>
 <p>
 Åker du bil till Ornö, glöm inte att boka plats på färjan <a href='http://ornosjotrafik.se'>
 "http://ornosjotrafik.se</a><br>
Tar du dig till Ornö med buss eller Waxholmsbåt meddela oss när du anländer till ön, så ska 
vi på något sätt ordna så du blir hämtad.
</p>
<p>Boendet på Svinnock är enkelt. Inga duschar, tvagning i sjön. Rinnande vatten finns vid husen, 
 toaletten är torrdass med vatten och handfat för hygienen. Vedeldad bastu vid sjön för 
     den som är sugen. Den är varm hela tiden.
</p>

</div>
</div>
EOD
);

$tango->set_property('footer', <<<EOD
        <div class='sitefooter left'>
            &copy;Peder Nordenstad <a href='mailto:peder@nordenstad.se'>(peder@nordenstad.se)</a>
        </div>
        <div class='right sitefooter'>
            <a  href='http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance'>Unicorn</a> | <a href='https://github.com/kerrik/ooophp'>tango på GitHub</a>
        </div>
EOD
);

include_once (TANGO_THEME_PATH);
        
function visa_data($booking_head){
    global $db;
    $sql= "SELECT deltagare.* \n";
    $sql.= "FROM deltagare \n";
    $sql .= "WHERE deltagare.id_email = {$booking_head->id} ;";
    

    $bokningar = $db->query_DB($sql, array( $_GET['bokning']));
    $sql= "SELECT * ";
    $sql.= "FROM choises; ";

    $priser = $db->query_DB($sql, array( $_GET['bokning']));
    $priser=fixapriser($priser);
    $total = array();
    $counter = 0;
    $retur= "";
    $retur .= "<div class='deltagarform'>"; 
    $retur .= "Anmälningsid = {$booking_head->email}<br>";
    foreach ($bokningar as $bokning){
        
       $retur .=  "<form action='' method=get>\n";
       $retur .= "<div class='raddeltagare'>\n" ;
       $retur .= "<div class='deltagarerad'>Deltagare: </div>"
               . "<div class='radiodeltagare'><input type=text name= 'namn' value='{$bokning->namn}'><br></div></div>\n";  
       
       $option_vald = ikryssad($bokning->pass);
       $skrivpris = ($bokning->crew ==0 ? skrivpriset( $priser[1], $option_vald) :0);
       $total[$counter] += $skrivpris;
       
       $retur .= "<div class='raddeltagare'>\n" ;
       $retur .= "<div class='deltagarerad'>Milongapass </div>" 
               . "<div class='radiodeltagare'><input type=checkbox name='pass' value='1' {$option_vald}'></div>"
               . "<div class='radpris'><label >{$skrivpris}:-</label></div></div>\n";
       
       $option_vald = ikryssad($bokning->middag);
       $skrivpris = ($bokning->crew ==0 ?skrivpriset( $priser[2], $option_vald) : 0);
       $total[$counter] += $skrivpris;
       
       $retur .= "<div class='raddeltagare'>\n" ;
       $retur .= "<div class='deltagarerad'>Middag </div>"
               . "<div class='radiodeltagare'><input type=checkbox name='middag' value='middag' {$option_vald}></div>"
               . "<div class='radpris'><label >{$skrivpris}:-</label></div></div>\n";
        
       $option_vald = ikryssad($bokning->lunch);
       $skrivpris = ($bokning->crew ==0 ?skrivpriset( $priser[3], $option_vald) : 0);
       $total[$counter] += $skrivpris;
       
       $retur .= "<div class='raddeltagare'>\n" ;
       $retur .= "  <div class='deltagarerad'>Lunch söndag </div>"
               . "  <div class='radiodeltagare'><input type=checkbox name='lunch' value='lunch' {$option_vald}></div> "
               . "<div class='radpris'><label >{$skrivpris}:-</label></div></div>\n";
        
       $option_vald = ikryssad($bokning->follow);
       
       $retur .= "<div class='raddeltagare'>\n" ;
       $retur .= "<div class='deltagarerad'>Följare </div>"
               . "<div class='radiodeltagare'><input type=checkbox name='follow' value='follow ' {$option_vald}></div></div>";
       
       $option_vald = ikryssad($bokning->lead);
       
       $retur .= "<div class='raddeltagare'>\n" ;
       $retur .= "<div class='deltagarerad'>Förare </div>"
               . "<div class='radiodeltagare'><input type=checkbox name='lead' value='lead' {$option_vald}></div></div>";;
       
       $option_vald = ikryssad($bokning->sova);
       $skrivpris = ($bokning->crew ==0 ?skrivpriset( $priser[4], $option_vald) : 0);
       $total[$counter] += $skrivpris;
       
       $retur .= "<div class='raddeltagare'>\n" ;
       $retur .= "<div class='deltagarerad'>Sovplats </div>"
               . "<div class='radiodeltagare'><input type=checkbox name='sova' value='sova' {$option_vald}></div>"
               . "<div class='radpris'><label >{$skrivpris}:-</label></div></div>";
       
       $retur .= "<div class='raddeltagare'>\n" ;
       $retur .= "<div class='deltagarerad'>Summa </div>"
               . "<div class='radpris'><label >{$total[$counter]}:-</label></div></div>";
       
       $retur .= "<div class='raddeltagare'>\n" ;
       $retur .= "<div class='deltagarerad'>Anteckning: </div>"
               . "<div class='radiodeltagare'><textarea name= 'namn'>{$bokning->not}</textarea></div></div>";  
    
       $retur .= "<div class='raddeltagare'></div>\n" ;
       global $user;
       if ($user->logged_in()){
           $retur .= "<input type='hidden' name='mail' value='{$bokning->search}'>\n"
                     . "<input type='submit' name='save_post' value='Spara'>\n";
       }
       $retur .= "</form>";
       
       ++$counter;
       
    }
    
    
    $retur .= "</div>";
    
    return $retur;
   }
   
   function ikryssad($kryss){
       $result = ( $kryss >0 ? 'checked' : FALSE);
       return $result;
   }
   
    function fixapriser($old_priser){
        foreach($old_priser as $pris){
            $return[$pris->choise] = $pris->price;
        }
        return $return;
    }   
    function skrivpriset( $pris, $option){
        $result = ($option == 'checked' ? $pris : 0);   
        return $result;
    }
   