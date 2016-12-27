
<?php
class txi_driver_admin{
    use txi_dates, 
            txi_drivers ;
    private $url  ;
    
    public function __construct() {
      add_shortcode( 'txi_driver_cal', 'txi_view_driver_cal') ;
      $current_user_update = ( isset( $_GET['id'] ) ? true : false ) ; 
      echo ($current_user_update ? 'true':'false');
      $this->get_drivers( $current_user_update ) ;
      $this->url = get_permalink() ;
    } // end construct
    
    function view_driver_admin() {
        $this->select_driver() ;
         if ( isset( $_POST['driver_update'] ) ){
            $this->save_driver_admin(); }   
         $txi_hidden = ( isset( $_GET['edit'] ) || isset( $_GET['new'] ) ? 'true' : '' );?>

          <div id='listbox_driver'>
              <?php $this->list_drivers()?>
          </div>

          <?php $selected_car=(isset($_GET[lst_car]) ?  $_GET[lst_car] : '');
          echo $selected_car ; ?>
          <div class='txi-form'>
            <form name='select_car' action="<?php echo $this->url . "?id=" . $this->current_user['ID'] ?>" method='post'>
            <div class='fieldrow'>
                <span class='label'>Användarnamn:</span><span class='field'> <input type="text" name="user_login" value="<?php echo $this->current_user['user_login'] ?>"</span><br>
            </div>
            <div class='fieldrow'>
                <span class='label'>Förnamn:</span><span class='field'> <input type="text" name="first_name" value='<?php echo $this->current_user['first_name'] ?>'></span><br>
            </div>
            <div class='fieldrow'>
                <span class='label'>Efternamn:</span><span class='field'> <input type="text" name="last_name" value='<?php echo $this->current_user['last_name'] ?>'></span><br>
            </div>
            <div class='fieldrow'>
                <span class='label'>Namn i listor:</span><span class='field'> <input type="text" name="display_name" value='<?php echo $this->current_user['display_name'] ?>'></span><br>
            </div>
            <div class='fieldrow'>
                <span class='label'>Mail:</span><span class='field'> <input type="text" name="user_email" value='<?php echo $this->current_user['user_email'] ?>'></span><br>
            </div>
            <div class='fieldrow'>
                <span class='label'>Tel:</span><span class='field'> <input type="text" name="txi_tel" value="<?php echo $this->current_user['txi_tel'] ?>"></span><br>
            </div>
            <div class='fieldrow'>
                <span class='label'>Tfl-nummer:</span><span class='field'> <input type="text" name="txi_tfl" value='<?php echo $this->current_user['txi_tfl'] ?>'></span><br>
            </div>
            <?php if ( $txi_hidden ): ?>
                <div class='fieldrow'>
                    <span class='label'>Password:</span><span class='field'> <input type="password" name="user_pass" value=''></span><br>
                </div>
                <div class='fieldrow'>
                    <span class='label'>Repetera:</span><span class='field'> <input type="password" name="user_pass_rep" value=''></span><br>
                </div>
            <?php endif ; ?>
            <div class='fieldrow'>
                <span class='label'>Administratör:</span><span class='field'> <select name='txi_role' >
                                                                              <option value='1'>Ja</option>
                                                                              <option value='10'>Nej</option>
                                                                              </select>   </span><br>
            </div>
            <div class='fieldrow'>
            <?php if( $_GET['edit'] || $_GET['new'] ): ?>
            <input  type="submit" name='driver_update' value='Uppdatera'>
            <?php endif ?>
            </div>
            </form>
          </div><!-- end txi-form -->

        <?php
    }
    function list_drivers(){
        $url= get_permalink();
        echo '<div id="listbox_driver">' ;
        foreach(  $this->drivers as $id=> $node ){
            echo '<a href="' . $url . '/?id=' .
                    $node['ID'] . '">' .
                    $node['nickname'] .
                    '</a><br/>' ;// Skriver en länk i listboxen för val av taxi
        }//end foreach
        echo '</div>' ;
        if ( current_user_can( 'administrator' ) ) {
            $node='New';
            echo '<a href="' . $url . '/?new=true">' . $node . '</a><br/>' ;
        }
        if ( current_user_can( 'administrator' && isset( $_GET['id'] ) ) ) {
            $node='Edit';
            echo '<a href="' . $url . '/?edit=true&id=' .
                  $_GET['id'] . '">' . $node . '</a><br/>' ;
      }
    }//end list_cars
     function save_driver_admin(){
       
        
        $userdata = array(
                        'user_login'=>$_POST['user_login'],
                        'first_name'=>$_POST['first_name'],
                        'display_name'=>$_POST['display_name'],
                        'last_name'=>$_POST['last_name'],
                        'user_email'=>$_POST['user_email']) ;
        if ( !$_POST['user_pass'] == '' && $_POST['user_pass'] == $_POST['user_pass_rep'] ){
            $userdata['user_pass'] = $_POST['user_pass'] ;
        }
         if ((int)$_GET['id'] > 0 ) {
            $userdata[ID] = $_GET['id'];
        $updated_user = wp_update_user( $userdata ); 
        }else{
            $updated_user = wp_insert_user( $userdata ); 
        }
        echo '<p><p>';
        print_r($userdata);
        echo '<p><p>';
        print_r($updated_user);
        echo '<p><p>';
        update_user_meta( $updated_user, 'txi_tel', $_POST['txi_tel'] ) ;
        update_user_meta( $updated_user, 'txi_tfl', $_POST['txi_tfl'] ) ;
        update_user_meta( $updated_user, 'txi_role', $_POST['txi_role'] ) ;
        $this->get_drivers() ;   
    }
    
}
?>

