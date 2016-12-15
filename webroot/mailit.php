<?php

// anger en variabel som kan lagra de eventuella felaktigheterna
$errors = array();
// kontrollera om ett Förnamn angivits
//if (!$_POST["fnamn"])
//$errors[] = "- FÖRNAMN";
//// kontrollera om ett Efternamn angivits
//if (!$_POST["enamn"])
//$errors[] = "- EFTERNAMN";
//// kontrollera om en E-postadress angivits
//if (!$_POST["email"])
//$errors[] = "- E-POSTADRESS";
//// kontrollera om ett Meddelande angivits
//if (!$_POST["message"])
//$errors[] = "- inget MEDDELANDE har skrivits!";
//// om felaktig information finns visas detta meddelande
//if (count($errors)>0){
//echo "<strong>Följande information måste anges innan du kan skicka formuläret:</strong><br />";
//foreach($errors as $fel)
//echo "$fel <br />";
//echo "<br />Ange den information som saknas och skicka formuläret igen. Tack! <br />";
//echo "<a href='javascript:history.go(-1)'>klicka här för att komma tillbaka till formuläret</a>";
//}
//else {
// formuläret är korrekt ifyllt och informationen bearbetas
$to = "spam@kerrik.se";
$from = 'boka@2tangeros.se';
$subject = 'Bokningsbekräftelse';
$fnamn = "2tangeros";
$message = "Hej. Bokningsbekräftelse hittar du på http://2tangeros.se/bokning?bokning={$_GET['mail']}\r\n" ;
//$message = wordwrap($message, 70);;

########################################################################
// HEADERS för innehållstyp och textkodning
$headers = "Content-Type: text/plain; charset=utf-8 \r\n"; 
$headers .= "From:" . $from ."\r\n";
$headers .= "MIME-Version: 1.0 \r\n";
########################################################################
if (mail($to, $subject, $message, $headers))
echo nl2br("<h2>Ditt meddelande har skickats!</h2>
<b>mottagare:</b> $to
<b>meddelande:</b>
$message
");
    
//else
//echo "Det gick inte att skicka ditt meddelande";
//} 
