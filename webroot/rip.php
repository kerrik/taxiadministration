<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
ini_set('display_errors', 'On');
        if (isset( $_GET['v'])){
           $foo = "https://www.youtube.com/watch?v={$_GET['v']}";
            $videoTitle = file_get_contents( $foo );
            if ($videoTitle) {
//                echo $videoTitle;
                $needle = 'eow-title"';
                echo "needle $needle\n";
                $start = strpos( $videoTitle, $needle);
                $start = strpos( $videoTitle, 'title=', $start);
                echo "start $start\n";
                
                $stop = strpos( $videoTitle, '>', $start);
                $stop= $stop-8;
                echo "stop $stop\n";
                $titleOfVideo = substr( $videoTitle, $start+7, $stop-$start);
            // look for that title tag and get the insides
//            preg_match("/<span id=\"eow-title\" class=\"watch-title \" title=\"(.+?)\" dir=/is", $videoTitle, $titleOfVideo);
            echo"<headline>{$titleOfVideo}</headline>";
            } else {
            echo "<headline>fdgfsggdf</headline>";
            }
        }
        ?>
    </body>
</html>
