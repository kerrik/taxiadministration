<?php
class txi_car_admin{
    use txi_car ;
    
    private $current_car = array() ;
    
    function view_car_admin(){
        
        
        ?>
        <?php if ( isset( $_POST['txi_update'] ) ){
          echo 'jippi';
            $this->setup_car_admin(); }   ?>

          <div id='listbox'>
              <?php $this->list_cars()?>
          </div>

          <?php $selected_car=(isset($_GET[lst_car]) ?  $_GET[lst_car] : '');
          echo $selected_car ; ?>
          <div class='txi-form'>
            <form name='select_car' action="" method='post'>
            <div class='fieldrow'>
                <span class='label'>Taxi:</span><span class='field'> <input type="text" name="txi_taxi" value="<?php $this->txi_taxi() ?>"
                <?php echo ( $_GET['new' ] == 'true'  ) ? '' : 'readonly' ?> ></span><br>
            </div>
            <div class='fieldrow'>
                <span class='label'>Regnr:</span><span class='field'> <input type="text" name="txi_regnr" value='<?php $this->txi_regnr() ?>'></span><br>
            </div>
            <div class='fieldrow'>
                <span class='label'>Tel:</span><span class='field'> <input type="text" name="txi_tel" value="<?php $this->txi_tel() ?>"></span><br>
            </div>
            <div class='fieldrow'>
                <span class='label'>Antal pass:</span><span class='field'> <select name="txi_pass">
                                                                              <option value="1">1</option>
                                                                              <option value="2" selected>2</option>
                                                                              <option value="3">3</option>
                                                                            </select></span><br>
            </div>
            <div class='fieldrow'>
                <?php $this->bil_create_pass_fields() ?>
            </div>

            <?php if( $_GET['edit'] || $_GET['new'] ): ?>
            <input  type="submit" name='txi_update' value='Uppdatera'>
            <?php endif ?>
            </form>
          </div><!-- end txi-form -->

        <?php
    }
     function list_cars(){
      $url= get_permalink();
      $result=$this->fetch_car() ;
      echo '<div id="listbox">' ;
      foreach(  $result as $taxi=> $node ){
          echo '<a href="' . $url . '/?taxin=' .
                  $node['id'] . '">' .
                  $taxi .
                  '</a><br/>' ;// Skriver en l�nk i listboxen f�r val av taxi
                  if ( $node['id'] == $_GET['taxin']){
                      $this->current_car = $node ;
                      $this->current_car['taxi'] = $taxi ;
                  }
      }//end foreach
      echo '</div>' ;
      if ( current_user_can( 'administrator' ) ) {
        $node='New';
        echo '<a href="' . $url . '/?new=true">' . $node . '</a><br/>' ;
      }
      if ( current_user_can( 'administrator' && isset( $_GET['taxin'] ) ) ) {
         $node='Edit';
         echo '<a href="' . $url . '/?edit=true&taxin=' .
                  $_GET['taxin'] . '">' . $node . '</a><br/>' ;
      }
    }//end list_cars
    function setup_car_admin(){
        $pass=serialize(array( 'pass0_start' => $_POST['pass0_start'],
                   'pass0_stop' => $_POST['pass0_stop'],
                   'pass1_start' =>  $_POST['pass1_start'],
                   'pass1_stop' => $_POST['pass1_stop'],
                   'pass2_start' =>  $_POST['pass2_start'],
                   'pass2_stop' => $_POST['pass2_stop']));
        $fields = array(
            'car'=>$_POST['txi_taxi'],
            'regnr'=>$_POST['txi_regnr'],
            'tel'=>$_POST['txi_tel'],
            'pass'=>$_POST['txi_pass'],
            'pass_time'=>$pass );
        global $wpdb;
        $bil = $wpdb->prefix . 'txi_car';
        if ( $_GET['edit'] ) {
            $wpdb->update(
                    $bil,
                    $fields,
                    array( 'id'=>$_GET['taxin'])
                    ) ;
        }else{
            $wpdb->insert(
                    $bil,
                    $fields
                    ) ;
        }
        $this->fetch_car();
    }
    function bil_create_pass_fields(){
        $pass= 0 ;
        $day= 0 ;
        echo '<div class="fieldrow"><div class="field">' ;
        for ( $pass= 0 ; $pass < 2 ; $pass++ ){
            echo '<div id="pass' . $pass . '" class="pass-head">' ;
            _e( 'Pass: ' ) ;
            echo ' ' .$pass +1 . '</div>' ;
        } //end for pass
        echo '</br>' ;
        $tider = unserialize( $this->current_car['pass_time'] );
        for ( $day= 0 ; $day < 7 ; $day++ ){
            for ( $pass= 0 ; $pass < 2 ; $pass++ ){
              echo '<div class="pass-head">';
              echo '<input type="text" name="pass' . $pass . '_start['. $day . ']" class="pass" value="' . $tider['pass' . $pass . '_start'][$day] .'">' ;
              echo '<input type="text" name="pass' . $pass . '_stop['. $day . ']" class="pass" value="' . $tider['pass' . $pass . '_stop'][$day] .'">' ;
              echo '</div>' ;
            } //end for pass
            echo '</br>' ;
        } //end for day
        echo '</div></div>' ;
    } // end create_pass_fields
    
    function txi_taxi(){
        $return = ( isset( $this->current_car['taxi'] )? $this->current_car['taxi'] : '' ) ; 
        echo $return ;
    }
    function txi_id(){
        $return = (isset( $this->current_car['id'] )? $this->current_car['id'] : '' ) ; 
        echo $return ;
    }
    function txi_tel(){
       $return = (isset( $this->current_car['tel'] )? $this->current_car['tel'] : '' ) ; 
       echo $return ;
    }
    function txi_regnr(){
       $return = (isset( $this->current_car['regnr'] )? $this->current_car['regnr'] : '' ) ; 
       echo $return ;
    }
    function txi_pass(){
       $return = (isset( $this->current_car['pass'] )? $this->current_car['pass'] : '' ) ; 
       echo $return ;
    }
    function txi_end_date(){
       $return = (isset( $this->current_car['end_date'] )? $this->current_car['end_date'] : '' ) ; 
       echo $return ;
    }
   

}

?>
