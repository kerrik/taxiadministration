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
        foreach ($classes as $class ){
            echo $class;
        //        include KAL_CLASSES . '/' . $class;
        }
        $this->fetch_webpage();
    }
    
    private function fetch_webpage(){
        dump($_POST);
       if (isset( $_POST['Submit_URL'])){
           $testar = parse_url( $_POST['URL']);
           parse_str($testar['query']);
           echo "Jasså\n";
           $id = $v;
           echo $id;
            // $id = 'YOUTUBE_ID';
            // returns a single line of XML that contains the video title. Not a giant request.
            $videoTitle = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=snippet&id={$id}&key=tangoweb-910");
            // despite @ suppress, it will be false if it fails
            echo $videoTitle;
            if ($videoTitle) {
            // look for that title tag and get the insides
            preg_match("/<title>(.+?)<\/title>/is", $videoTitle, $titleOfVideo);
            return $titleOfVideo[1];
            } else {
            return false;
            }
            // usage:
            // $item = youtube_title('zgNJnBKMRNw'); 
       } 
    } // end fetch_webpage()
}
