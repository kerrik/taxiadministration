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
    private $youtubeinfo = null;
    public function __construct() {
        $subdir = __DIR__ .'/subclass';
        $classes = array_diff( scandir( $subdir ),  array( '..', '.'));
        $subdir = $subdir . '/';  
        
        foreach ($classes as $class ){
            if (is_dir($subdir . $class)){
                include $subdir .$class . '/' . $class .'.php';
                echo "$class <br>";
            }
        }
        $this->fetch_webpage();
    }
    
    private function fetch_webpage(){
       if (isset( $_POST['Submit_URL'])){
           $video_id = $this->get_video_id();           
           
        echo "<pre>";
            print_r($video_id);
        echo "</pre>";

            $json_output = file_get_contents("http://gdata.youtube.com/feeds/api/videos{$video_id}?v=2&alt=json");
            $this->youtubeinfo =  json_decode($json_output, true);
       } //end if
        echo "<pre>";
            print_r($this->youtubeinfo);
        echo "</pre>";

        //This gives you the video description
//        $video_description = $json['entry']['media$group']['media$description']['$t'];
//
//        //This gives you the video views count
//        $view_count = $json['entry']['yt$statistics']['viewCount'];
//
//        //This gives you the video title
//        $video_title = $json['entry']['title']['$t'];
    } // end fetch_webpage()
    
    private function get_video_id(){
        if (isset( $_POST['Submit_URL'])){
           $parsed_url = parse_url( $_POST['URL']);
           
        echo "<pre>";
            print_r($parsed_url);
        echo "</pre>";

           if (isset($parsed_url['query'] ) ){
               parse_str( $parsed_url['query']) ;
               $return = '/' . $v;
           } else {        
               $return = $parsed_url['path'] ;
           }
           return $return;
        }
    }
    
    public function title(){
       $return = (isset ( $this->youtubeinfo )? $this->youtubeinfo['entry']['title']['$t'] : false );
       return $return;
    }
}
