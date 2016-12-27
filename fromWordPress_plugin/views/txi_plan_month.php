<?php
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
#                                                                                       #
# Skapar sidan f�r att visa alla bilar en m�nad. Ger m�jlighet f�r                      #
# administrat�r att planera.                                                            #
#                                                                                       #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #


class txi_plan_month{
    use txi_car,
        txi_drivers,
        txi_dates,
        txi_calendar ;

    
    public function __construct(){
        $this->parse_days() ;
        $this->fetch_car() ;
        $this->get_drivers( false ) ;
    }

    public function view_plan_month(){
        global $txi ;
        $this->update_calendar() ;
        $this->create_calendar() ; 
        ?>
            <div id='calendar_heading_driver'>
               <?php $this->select_driver() ?>
            </div>
            <div id='calendar'>
                <div id= 'calendar_heading'>
                   <div class='rubrik'>
                    <div id='calendar_heading_date'>
                       <span class='prev_month'><?php $this->out_link_prev_month()?></span>
                       <?php $this->txi_month_name(0) ?> <?php $this->out_year() ?>
                       <span class='next_month'><?php $this->out_link_next_month()?> </span>
                     </div>
                   </div> <!-- rubrik -->
                </div><!-- calendar_heading -->
                <br />
                <div id='dates'>
                  <div class='bil-rubrik'> </div> <!--just for making space -->
                    <div class='bil-rubrik-tid'> </div>  <!--just for making space -->
                    <?php
                        $this->print_days_in_month()
                    ?>
                  </div> <!--dates-->
                  <?php  $nodak_taxis = $this->fetch_calendar( true ); //parametern säger att alla poster ska tas med
                  foreach ( $this->taxis as $taxi => $taxidata ){  ?>
                    <div class='bil-calendar'>
                        <div class='bil-rubrik'>
                            <?php echo $taxi ?>
                        </div> <!-- div bil-rubrik -->
                        <?php  for ($pass=0 ; $pass < $taxidata['pass'] ; $pass++ ){
                            echo (( $pass==0)?"<div class='bil-day'>":"<div class='bil-night'>");?>
                            <div class='bil-rubrik-tid'>
                                <?php echo (($pass==0)?'Dag':'Natt')?>
                            </div> <!-- bil-day/night -->
                                <?php  $this->tur_cal_print_drivers( $taxi, $pass, $nodak_taxis[$taxi])?>
                            </div> <!-- bil-rubrik-tid -->
                            <?php } ?>
                    </div><!--bil-calendar-->
                  <?php }   ?> <!-- end foreach -->
            </div> <!-- calendar -->
                <form id= 'update_calendar' name= 'update' action="" method="post" >
                  <input type= 'submit' name='update' value='Uppdatera' />
                  </form>
                <form id= 'create_calendar' name= 'create' action="" method="post" >
                  <input type= 'submit' name='create' value='Skapa kalender' />
                  </form>
            <div class="tooltip" id="tip1">
    </div>
    <?php
    }
  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  
  #
  # Functions thats only used in this view. If I need them somewhere 
  # else they are moved to one trait
  #
  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  # 
    
  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  
  #
  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  
   function tur_cal_print_drivers($bil, $pass,$kalendar){
          $post =array() ;
          for ( $counter1= 1 ; $counter1<= $this->datum['days_in_month'] ; $counter1++ ) {
              $date = $this->datum['year'] . '-' . sprintf( "%02s", $this->datum['month'] ) . '-' . sprintf( "%02s", $counter1 ) ;
              $post=$kalendar[$pass][$date] ;
              $duration = $post['start_time'] . '-' . $post['end_time'];
              $txi_driver = ( $post['driver'] )? $this->drivers[$post[driver]]['display_name'] : '-----';
              $txi_driver = ( $post['id'] )? $txi_driver : '';
              $calendar_post= "<div class='calendarpost' data-tooltip='tip1'  calendar-id='". $post['id'] . "' calendar-time='". $duration ."' calendar-type='" . $bil . "'>" . $txi_driver . "</div>";
              echo nl2br($calendar_post); 
          }//end for
      } //end tur_cal_print_days_in_month
  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  
  #
  # Collect data from database for the calendar
  #
  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  
  private function fetch_calendar(){
      global $wpdb;
      $calendar=$wpdb->prefix.'txi_pass';
      
      $sql = "SELECT $calendar.taxi,
                  $calendar.pass AS pass,
                  $calendar.start_date AS start_date,
                  $calendar.driver AS driver,
                  $calendar.id ,
                  $calendar.start_time,
                  $calendar.end_time
              FROM $calendar
              WHERE $calendar.start_date LIKE '" . $this->datum['year_month'] . "-%'
              AND $calendar.type = 1
              ORDER BY taxi, start_date;";
      return $this->fetch_calendar_data( $sql );
    }   
    #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  
    #
    #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  
    function print_days_in_month(){
      for ($counter1=1;$counter1<=$this->datum['days_in_month'];$counter1++){
          echo  "<div class='date' id='day" . $counter1 . "'><span class='left'>" ;
          $this->txi_day_name(true, $counter1) ;
        echo nl2br("</span><span class='right'>" . $counter1 . "</span></div>") ;
    }//end for
    } //end tur_cal_print_days_in_month
    #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  
    #
    # Updates the calendar on changes
    #
    #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #   
    function update_calendar(){
           if (isset($_POST['update'])){
               global $wpdb ;
               $calendar=$wpdb->prefix.'txi_pass';
               $i=count($_POST['tfl']) ;
               for ($ii=0 ; $ii < $i ; $ii++){
                   $wpdb->update(
                           $calendar,
                           array( 'driver'=>$_POST['tfl'][$ii] ),
                           array( 'id'=>$_POST['post_id'][$ii])
                   );
               }


           }  
    } //end update_calendar
    
    #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  
    #
    # Creates a new month in the calendar
    #
    #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  
    function create_calendar() {
        if (isset($_POST['create'])){
            global $wpdb ;
            $calendar=$wpdb->prefix.'txi_pass';
            extract( $this->datum );
            foreach( $this->taxis as $taxi=> $node ){
                $pass_tider = unserialize( $node['pass_time']) ;
                for ( $pass = 0 ; $pass < $node['pass'] ; $pass++){
                    $pass_tid = 'pass' . $pass . '_' ;
                    for ( $datum= 1 ; $datum <= $days_in_month ; $datum++ ){
                        $start_date = $year_month . '-' . sprintf( '%02s', $datum );
                        $day_in_week= jddayofweek ( cal_to_jd( CAL_GREGORIAN, intval( $month ), intval( $datum ), intval( $year ) ) , 0 );
                        if ( $pass_tider[$pass_tid . 'start'] < $pass_tider[$pass_tid . 'stop']){
                            $end_date = $start_date ;
                        }else{
                            $end_date = date ( 'Y-m-d' , strtotime ( '1 day' , strtotime ( $start_date ) ) );
                        } #end if
                        $row  = array(  'taxi'=> $taxi,
                                        'pass'=> $pass,
                                        'start_date'=> $start_date,
                                        'end_date'=> $end_date,
                                        'start_time'=> $pass_tider[$pass_tid . 'start'][$day_in_week] . ':00',
                                        'end_time'=> $pass_tider[$pass_tid . 'stop'][$day_in_week] . ':00',
                                        'type'=> '1' ) ;
                       $wpdb->insert( $calendar, $row );

                    } # end for day counter
                } # end for pass counter
            } # end foreach
        } # end ifset POST['create']
    }   # end create calendar

}
?>