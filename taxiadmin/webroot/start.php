<?php
/** Det här är mitt första försök till em me-sida med tango
 * 
 * Tango är en struktur för websidor skapad på kursen ooophp av mig
 * Peder Nordenstad.
 */

// Ikluderar config.php. som sätter igång allt.

include( __DIR__ . '/config.php');

if($user->logged_in()){
    $logged_in = <<<EOF
        <form method=post>
            <input type="submit" value="Logout" name= "logout" id='logout' />
        </form>
EOF
    ; // end first if
}else { 
    $logged_in = "<a  href='login'>Login</a>";
}

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
                  
        <div>
        <h1>Tangomarathon på Svinnock 2016</h1>
        <p>
		<h2>Lördag 6/8 14.00 spelar vi upp till 24 timmars tango på 
		<a href='https://www.google.se/maps/dir//SVIN%C3%85KER,+ORN%C3%96,+130+55+Orn%C3%B6/@59.1009679,18.499898,12z/data=!4m13!1m4!3m3!1s0x46f585c19d55723b:0x60a57ddeef5bc121!2zU1ZJTsOFS0VSLCAxMzAgNTUgT3Juw7Y!3b1!4m7!1m0!1m5!1m1!1s0x46f585c19d55723b:0x60a57ddeef5bc121!2m2!1d18.4586724!2d59.1061315'>
		Svinåkers gård</a>, Ornö.</h2>
		</p>
        <p>
		Låt detta bli sensommarens stora tangohändelse. <a href='https://www.google.se/maps/place/59%C2%B006%2719.5%22N+18%C2%B027%2733.8%22E/@59.1054162,18.4593889,2203m/data=!3m2!1e3!4b1!4m2!3m1!1s0x0:0x0'>
		Svinnock</a> är en gammal gård på Norra Ornöö. Ett antal hus vid kanten av en insjö, promenadavstånd till havsbad och båtplatser. Här ska vi för tredje året i rad dansa tango,
		umgås och njuta av den svenska sensommaren.
		<p>
		Dansar gör vi på det stora trädäcket utanför huvudbyggnaden, och på den gamla höskullen där ett fint dansgolv är
		inlagt av <a href='https://www.facebook.com/vilhelm.herlin?fref=ts'>Vilhelm Herlin<a>, som äger gården och driver 
		den tillsammans med sin familj.
		</p>
        <p>DJs som är bokade hittils är<br>
        <a href='https://www.facebook.com/gunnar.gelin'</a>Gunnar Gelin</a><br>
        <a href='https://www.facebook.com/jessica.carleson.5'>Jessica Carleson</a><br>
        <a href='https://www.facebook.com/peder.nordenstad'>Peder Nordenstad</a><br>
        <a href='https://www.facebook.com/vilhelm.herlin'>Vilhelm Herlin</a><br>
		<a href='https://www.facebook.com/lena.lindh'>Lena Lindh</a>
		<p/>
        
        <p>
		Det blir fler, vi väntar på bekräftelse. Kolla här för uppdatering.
		</p>
		<p>
		Milongapaketet kostar 250:- och innefattar lätt vegetarisk lunch på lördagen, fika, mackor och frukt
		under dygnet samt frukost på söndag morgon.	
		<br>
		Vi kommer även att ordna gemensam grillmiddag för de som önskar, kött och/eller fisk. 130:-<br>
		Söndagslunch serveras till hågade för 30:-
		<br>
		Vin/öl får man ta med sig själv.
		</p>        
        <p>
		<h2>Boende</h2>
		</p>
        <p>Övernattningsmöjligheter finns för den som inte tänker vara vaken och dansa hela tiden. 
        I husen kan vi ordna 23 platser i sängar och 9 golvplatser på medhavd madrass/liggunderlag.<a href='http://2tangeros.se/baddar'>Länk sovplatser</a><br>
        Säng/madrass-plats kostar 125:-.<br>
        Dessutom kan du tälta,
		<a href='https://www.google.se/maps/place/59%C2%B006%2745.0%22N+18%C2%B027%2706.2%22E/@59.112487,18.451726,551m/data=!3m2!1e3!4b1!4m2!3m1!1s0x0:0x0'>
        komma med båt</a> eller husbil/husvagn. Bryggan rymmer ett antal större båtar, djupet räcker för segelbåt
		</p>
        
        
        <p><h2> Anmälan</h2></p>
        <p>Du anmäler dig genom att skicka ett mail med ditt namn och önskan om sovplats till 
        <a href="mailto:boka@2tangeros.se?Subject=Boka%20tangaomaraton" target="_top">boka @ 2tangeros.se</a>.
		Ange även om du ska vara med på den gemensam middagen och söndagslunchen
		</p>
		<p>
		Milongapasset kostar 250:- och summan betalas in på in på SEB 5254 29 105 37 senast 15/7. Ange namn på de deltagare som inkluderas i
		betalningen.
        Anmäl dig tidigt så har du större möjlighet att välja var/hur du vill bo. På <a href='http://www.svinåker.se/#svinaker'>svinåker.se</a>
        hittar du de hus som finns. Vi har räknat med sängplatserna i viss mån måste kompletteras med medhavda madrasser/liggunderlag för fler sovgplatser.
		<a href='#link1'>*</a>
        <br>Anmälan är bindande efter 16/7
		</p>      
        <p>Max antal delstagare är 50 st, det är vad vårt dansgolv klarar.Vi kommer försöka se till att fördelningen förare/följare blir acceptabel, så i värsta fall kan du bli satt på 
        väntelista.
		</p>
        <p>
		Med hopp om att vi ses på Svinnock
		</p>
		<p>
		Vilhelm och Peder
		</p>
		<p>
		</p>
		<p id='link1'>
		<h3></h3> * Fotnot: Sidan är den som används för uthyrning via Airbnb. Vill du stanna längre, dvs före eller efter vårt tangomataton, kan du boka boendet via dem.
		För boende under tangodygnet behöver du bara tala om hur och var du vill bo i ditt mail.
		</p>
		
		
        
        </div>
		<div id='aside'>
		<p>
		<img src='http://2tangeros.se/webroot/img/svinnock1.jpg'>
		<img src='http://2tangeros.se/webroot/img/svinnock2.jpg'>
		<img src='http://2tangeros.se/webroot/img/svinnock3.jpg'>
		<img src='http://2tangeros.se/webroot/img/svinnock4.jpg'>
		</p>
		<p><iframe width="230"  src="https://www.youtube.com/embed/Ou5XEUFMLZo" frameborder="0" allowfullscreen></iframe>
		</p>
		<p><a href= 'https://www.facebook.com/peder.nordenstad/media_set?set=a.10207168221744835.1261361652&type=3'>
		Bilder på Fb </a>
		</p>
		</div>
EOD
);

$tango->set_property('footer', <<<EOD
        <div class='sitefooter left'>
            &copy;Peder Nordenstad <a href='mailto:peder@nordenstad.se'>(peder@nordenstad.se)</a>
        </div>
         <div class='right sitefooter'>
            $logged_in
        </div>
EOD
);


include_once (TANGO_THEME_PATH);
        
