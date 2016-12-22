<?php
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

$tango->set_property('title', "Taxiadmin");
$tango->set_property('title_append', "Ett verktyg för din taxirörelse");



//$header = "<img class='sitelogo left' src='" . $tango->logo() . "' alt=''/>n";
//$header .= "<div class='sitetitle left'>" . $tango->title() . "</div>\n";
//$header .= "<div class='siteslogan left'>" . $tango->title_append() . "</div>\n";
//$tango->set_property('header', $header);

$tango->set_property('main', <<<EOD
                  
        <div>
        <h1>Taxiadmin</h1>
        <p>
		<h2>hjälper dig med schemaläggning av bilar och förare</h2>
		</p>
        <p>
		logga in för att sätta igång.
        </p>
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
        
