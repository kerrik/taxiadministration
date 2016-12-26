<?php
/**
 * 
 * Sidfot ....
 * 
 */

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


$tango->set_property('footer', <<<EOD
         <div class='left sitefooter'>\n
            <a  href='http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance'>Unicorn</a>\n | \n<a href='https://github.com/kerrik/ooophp'>tango på GitHub</a>\n
        </div>\n
        <div class='sitefooter left'>\n
            &copy;Peder Nordenstad \n<a href='mailto:peder@nordenstad.se'>(peder@nordenstad.se)</a>\n
        </div>\n
        <div class='right sitefooter'>\n
            $logged_in
        </div>\n
EOD
);
