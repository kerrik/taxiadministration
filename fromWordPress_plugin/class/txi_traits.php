<?php

trait txi_dates{
     
    private $datum=array();

    function parse_days(){
        $mo = 0 ;
        $yr = 0 ;
        $dates= array() ;
        if ( isset( $_GET['txi_date'] ) ) {
            list($yr, $mo, $da) = explode('-', $_GET['txi_date']);
            $dates= array( 'day'=> intval($da),
                            'month'=> intval($mo),
                            'year'=> intval($yr) );
        }else{
            $dates= array( 'day'=> date('d'),
                            'month'=> date('m') ,
                            'year'=> date('Y') );
        }
        $dates['days_in_month'] = cal_days_in_month( CAL_GREGORIAN,  $dates['month'], $dates['year'] ) ;
        $dates['year_month'] = $dates['year'] . '-' . sprintf( '%02s', $dates['month'] ) ;
        
        $dates['offset'] = date('w', mktime(0,0,0,$mo,1,$yr));
        // we must have a value in range 1..7
        if ( $dates['offset'] == 0) $dates['offset'] = 7;
        $foo = $dates['year'] . '-' . $dates['month'] . '-1' ;
        $dates['date_array'] = $this->array_with_dates( $foo, $dates['offset'] ) ;
        $this->datum= $dates ;
        return $dates ;
    } //end parse days
    
    function array_with_dates( $date, $offset ){
        $newdate = array() ;
        for ($datum = (-1 * $offset )+1 ; $datum < 43 - $offset; $datum++){
           $find_day = $datum . ' day' ;  
           $newdate1 = strtotime ( $find_day , strtotime( $date ) ) ;
           $newdate1 = date ( 'Y-m-d' , $newdate1 ) ;
           list($yr, $mo, $da) = explode('-', $newdate1); 
           $newdate[$newdate1] = $dates['offset'] = date('W', mktime(0,0,0,$mo, $da ,$yr));
          ;
        }
        
        return $newdate ; 
    }
     ########################################################################
     #
     # Prints the name of the day. Expects tu have the argument for short or full
     # name and day of the month.
     #
     #########################################################################
      function txi_day_name( $short,$day){

        $day_length=(!$short)? 'l' : 'D';
        $name_of_day= __( date( $day_length,mktime(0,0,0,$this->datum['month'],$day, $this->datum['year'] ) ) ) ;
        $name_of_the_day=(!strpos($name_of_day, 195)?  substr($name_of_day, 0, 2) :  substr($name_of_day, 0, 3)) ;
        echo $name_of_the_day ;
      }//end txi_day_name

       ########################################################################
       #
       # Prints the year
       #
      ########################################################################
      function out_year(){ _e( $this->dates['year'] ) ;
      }//end txi_year

      //########################################################################

      //Prints a link to the previous month

      //########################################################################

      function out_link_prev_month(){
          echo('<a href="?txi_date='.date('Y-m-d', mktime(0,0,0,$this->datum['month'],0,$this->datum['year'])).'">&laquo;</a>');
      }//end

      #######################################################################
      #
      # Prints a link to the next month
      #
      ########################################################################
       function out_link_next_month(){
        echo('<a href="?txi_date='.date('Y-m-d', mktime(0,0,0,$this->datum['month']+1,1,$this->datum['year'])).'">&raquo;</a>');
      }//end next_month
      
       function txi_month_name($short ){
        $day_length=(!$short)? 'F' : 'M';
        $mont_name = __ ( date( $day_length, mktime( 0, 0, 0, $this->datum['month'], $this->datum['day'],  $this->dates['year'] ) ) ) ;
        echo ucfirst( $mont_name) ;
        
      }//end txi_month_name
       function out_txi_date(){
          echo "$this->datum['year']-$this->datum['month']-$this->datum['day']";
    }//end txi_date
    }
#   #   #   #   #   #   #   #   #   #   #   #   #   #   #   #   #   #   #   #
#
#   trait drivers
#      
#   #   #   #   #   #   #   #   #   #   #   #   #   #   #   #   #   #   #   #
trait txi_drivers{
    private $drivers= array() ;
    private $current_user = array() ;
    
    private function get_drivers( $current_user_update ){
        $current_user_id = get_current_user_id() ;
        $result=get_users(array( 'meta_key' => 'txi_role', 'meta_query' => array( 'txi_role') )) ;
        #$driver['driver_name']='-----' ;
        #$driver['id']='0' ;
        #$this->drivers['0']=$driver ;
        foreach ( $result  as $foo ) {
            $user_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $foo->ID ) );
            $user_meta['first_name']=$foo->first_name ;
            $user_meta['ID']=$foo->ID ;
            $user_meta['user_login'] = $foo->user_login ;
            $user_meta['user_email'] = $foo->user_email ;
            $user_meta['display_name'] = $foo->display_name ;
            
            
            # TFL-number are saved in the field nickname att this point
            $this->drivers[$user_meta['txi_tfl']]= $user_meta ;
            $this->current_user = ( $current_user_update ? $user_meta : $this->current_user ) ;
        }  // end foreach 
       
    }
    function select_driver(){
        if (is_user_logged_in()){
            echo '<select id="current_driver" name="driver" size="1">';
             foreach ($this->drivers as $tfl=>$driver){
                //echo $tfl;
                if ( $tfl <> '0' ){
                  echo '<option value="'.$tfl . '">' . $driver['display_name'] . '</option>' ;
                }
            }
            echo '</select>';
        }
    }
    
   }
  
  trait txi_car{
      private $taxis = array() ;
      function fetch_car(){
        global $wpdb ;
        $car=$wpdb->prefix . 'txi_car' ;
        $sql="SELECT  car AS taxi,
                      id,
                      tel,
                      regnr,
                      pass,
                      pass_time,
                      start_date,
                      end_date
              FROM $car
              WHERE car <> '0'
              ORDER BY car;";
        $result = $wpdb->get_results($sql, ARRAY_A) ;
        foreach( $result as $node ) {
          $this->taxis[$node['taxi']] = array('id'=> $node['id'],
                                              'tel'=> $node['tel'],
                                              'regnr'=> $node['regnr'],
                                              'pass'=> $node['pass'],
                                              'pass_time'=> $node['pass_time'],
                                              'start_date'=> $node['start_date'],
                                              'end_date'=> $node['end_date'] ) ;        
        } # end foreach   
        return $this->taxis;
      }
  }
trait txi_calendar{
    private $calendar = array() ;
    
    private function fetch_calendar_data( $sql ){
      global $wpdb;

      $mysqldata = $wpdb->get_results( $sql, OBJECT );
      //due to my inability to get it working with the objec i create an array
      //that formats the data the way i like,
      //########################################################################
      $result=array();
      foreach ($mysqldata as $node){
        //Change the databasequery to a multidim array
        if (!isset($result[$node->taxi][$node->pass])){
          $result[$node->taxi][$node->pass]=array();
        }//end if
        $result[$node->taxi][$node->pass][$node->start_date]=array( 'id' => $node->id ,
                                                                    'driver' => $node->driver ,
                                                                    'start_time' => substr( $node->start_time, 0, 5 ) ,
                                                                    'end_time' => substr( $node->end_time, 0, 5 ) );
      }//end foreach
      $this->calendar= $result ;
      return $this->calendar;
    }   
}
?>
