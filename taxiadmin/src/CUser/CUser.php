<?php



/**
 * CUser är en class för att hålla ordning på om en användare är inloggad eller 
 * inte, sköta in och utloggningar samt i förlägningen kunna ge all behövd
 * användarinformation
 *
 * @author peder
 */
class CUser{
    private $user = null ;
    private $users = array() ;
    
    public function __construct() {
        if(isset($_POST['login'])){ $this->login();}
        if(isset($_POST['logout'])){unset ($_SESSION['user']);}
        global $db;
        $this->get_users() ;
        $this->get_user_data(1) ;
        $this->logincheck() ;
    }//end __construct
    
    // Fyller $users med alla användare
    private function get_users(){
        global $db ;
        $sql = 'SELECT id, acronym, name FROM User;' ;
        $row = $db->query_DB($sql, array(),false) ;
        if( $row ){
            do {
                    $this->users[] = $row ;
                    $row = $db->fetch_DB() ;
            }while( !$row == false );
        }
    }
    
    private function get_user_data( $id ){
        global $db ;
        
        $sql = 'SELECT 
                  user_data_sort,
                  user_data_descr,
                  value,
                  value_dec
                FROM
                  user_data_key
                LEFT JOIN
                 user_data
                ON
                 (user_data_key.user_data_id = user_data.user_data_id)
                ORDER BY
                  user_data_sort
                ;' ; // end $sql
        
        $db->query_DB($sql, array($id));
//        $user_data = $db->query_DB() ;
    }
    
    // Kollar i $_SESSION om någon är inloggad och hämtar uppgifterna därifrån
    public function logincheck(){
        if(isset($_SESSION['user'])){            
            global $db;
            $sql = "SELECT id, acronym, name FROM User WHERE id = ?;";
            $db->query_DB($sql, array($_SESSION['user']));
            $this->user->logged_in = isset($this->user->id)? true: false ;
        }else{
            $user['logged_in'] = false;
            $this->user = (object) $user;
        }
            
        return $this->user->logged_in;      
    }//end logincheck()
    
    //metod för inloggning
    public function login(){
        global $db;
        dump($_POST);
        $sql = "SELECT id, acronym, name FROM User WHERE acronym = ? AND password = md5(concat(?, salt))";
        $this->user = $db->query_DB($sql, array($_POST['acronym'], $_POST['password']),TRUE);
        if(isset($this->user->id)) {
          $_SESSION['user'] = $this->user->id;
          echo 'ska det vara såhär';
        }
    }// end login()
    
//    metod för utloggning
    public function logged_in(){
        return $this->user->logged_in;
    }   
    public function id(){
            return $this->user->id;
    }
    public function name(){
            return $this->user->name;
    }
    public function acronym(){
            return $this->user->acronym;
    }
    public function users(){
        return $this->users;
    }
}
