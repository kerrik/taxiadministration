<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CYoutubeinfo
 *
 * @author peder
 */
class CYoutubeinfo {
    public function __construct() {
        $subdir = __DIR__ .'/subclass';
        $classes = array_diff( scandir( $subdir ),  array( '..', '.'));
        $subdir .= '/';
        
        
        
        foreach ($classes as $class ){
            if (is_dir($subdir . $class)){
                include $subdir .$class . 'php';
                echo $class;
            }
        }
        $this->fetch_webpage();
    }
    
    private function fetch_webpage(){
       if (isset( $_POST['Submit_URL'])){
           $parsed_url = parse_url( $_POST['URL']);
            $videoTitle = file_get_contents("http://loamansson.se/utveckling/rip.php?{$parsed_url['query']}");
            if ($videoTitle) {
            // look for that title tag and get the insides
            preg_match("/<headline>(.+?)<\/headline>/is", $videoTitle, $titleOfVideo);
            echo "<headline>{$titleOfVideo[1]}</headline>";
            } else {
            echo "<title>fdgfsggdf</title>";
            }
            
       } 
    } // end fetch_webpage()
}
