<?php
##########################################################################################
# En class för att skapa sidan f�r f�rarkalender
# Ing�r som en del i projektet Taxiadmin
# sidan visas genom att man l�gger in kortkoden [txi_driver_cal] p� en tom sida
##########################################################################################

class txi_driver_cal{
    use txi_dates, 
            txi_drivers ;

    private $calendar ;
    
    public function __construct() {
      add_shortcode( 'txi_driver_cal', 'txi_view_driver_cal') ;
      $this->dates= $this->parse_days() ;
      $this->get_drivers( true );
      $this->fetch_calendar() ;

    } // end construct
    function view_driver_cal() {
        global $txi ;
        #print_r( $this->dates );
        
        ?>
         <div id='calendar'>
                <div id= 'calendar_heading'>
                   <div class='rubrik'>
                    <div id='calendar_heading_date'>
                       <span class='prev_month'><?php $this->out_link_prev_month()?></span>
                       <?php $txi->txi_month_name(0) ?> <?php $this->out_year() ?>
                       <span class='next_month'><?php $this->out_link_next_month()?> </span>
                     </div>
                   </div> <!-- rubrik -->
                </div><!-- calendar_heading -->
                <br />
                    <div class='bil-calendar'>
                        <?php
                
                            for ($day=0 ; $day<=7; $day++ ){
                                    switch( $day ){
                                        case 0;
                                            echo "<div class='driver-cal-day'></div>";
                                            break;
                                        case 1;
                                            echo "<div class='driver-cal-day'>M&aring;</div>";
                                            break;
                                        case 2;
                                            echo"<div class='driver-cal-day'>Ti</div>";
                                            break;
                                        case 3;
                                            echo"<div class='driver-cal-day'>On</div>";
                                            break;
                                        case 4;
                                            echo"<div class='driver-cal-day'>To</div>";
                                            break;
                                        case 5;
                                            echo"<div class='driver-cal-day'>Fr</div>";
                                            break;
                                        case 6;
                                            echo"<div class='driver-cal-day'>L&ouml;</div>";
                                            break;
                                        case 7;
                                            echo"<div class='driver-cal-day'>S&ouml;</div>";
                                            break;
                                    } # end switch day 0 
                               }
                               ?><br> <?php ;
                               $dag_i_veckan = 0 ;   
                               foreach( $this->calendar as $datum=>$node ) {
                                    if ($dag_i_veckan ==0 ){
                                        echo "<div class='driver-cal-day'>" . $node['week'] . "</div>" ;
                                        $dag_i_veckan++ ;
                                    }
                                    echo "<div class='driver-cal-day' txi_date='$datum'>" . $node['day_in_month'] . $node[upptagen] . "</div>" ;
                                    $dag_i_veckan++ ;
                                    if( $dag_i_veckan == 8 ){
                                        ?><br> <?php ;
                                        $dag_i_veckan = 0 ;
                                    }
                                }
                            ?>
                    </div><!--bil-calendar-->
                <form id= 'update_calendar' name= 'update' action="" method="post" >
                  <!--input type= 'submit' name='update' value='Uppdatera' / -->
                  </form>
            </div> <!-- calendar -->
            <?php
    } // end view_driver_cal
    function fetch_calendar(){
      $days_left = 44 - ( $this->datum['offset'] + $this->datum['days_in_month'] ) ;
      $start_date = strtotime( ((-1 * $this->datum['offset'])+1) . ' day', strtotime ( $this->datum['year_month'] . '-01' ) );
      $start_date = date( 'Y-m-d', $start_date) ;
      $end_date = strtotime(  $days_left . ' day', strtotime ( $this->datum['year_month'] . '-' . $this->datum['days_in_month'] ) );
      $end_date = date( 'Y-m-d', $end_date) ;
      global $wpdb;
      $select_driver= "AND driver like '" . $this->current_user['txi_tfl'] . "'"   ;
      $calendar=$wpdb->prefix.'txi_pass';
        
      $sql = "SELECT 
                  $calendar.start_date AS start_date,
                  $calendar.taxi,
                  $calendar.pass AS pass,
                  $calendar.driver AS driver,
                  $calendar.id ,
                  $calendar.start_time,
                  $calendar.end_time
              FROM $calendar
              WHERE $calendar.start_date >= '$start_date'
              AND   $calendar.end_date <= '$end_date'
              AND $calendar.type = 1
              $select_driver
              ORDER BY start_date;"; 
      global $wpdb;
      $result = $wpdb->get_results( $sql, OBJECT_K );
      foreach( $this->datum['date_array'] as $index=>$node ){
          $this->calendar[$index]= array(
              'start_time'=>(isset( $result[$index] ) ? $result[$index]->start_time : '' ) ,
              'end_time'=>(isset( $result[$index] ) ? $result[$node]->end_time : '' ) ,
              'driver'=>(isset( $result[$index] ) ? $result[$index]->driver : '' ) ,
              'id'=>(isset( $result[$index] ) ? $result[$index]->id : '' ) ,
              'taxi'=>(isset( $result[$index] ) ? $result[$index]->taxi : '' ) ,
              'upptagen'=>(isset( $result[$index] ) ? '*' : '' ) ,  
              'day_in_month'=> substr( $index, 8),
              'week'=> $node  
            ) ; 
        }
    }
    

} // end class
?>