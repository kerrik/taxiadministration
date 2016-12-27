<?php
// En hjälpfunktion för at skapa etiketterna
function tur_post_type_labels( $singular, $plural = '' )
{
    if( $plural == '') $plural = $singular .'s';

    return array(
        'name' => _x( $plural, 'post type general name' ),
        'singular_name' => _x( $singular, 'post type singular name' ),
        'add_new' => __( 'Add New' ),
        'add_new_item' => __( 'Add New '. $singular ),
        'edit_item' => __( 'Edit '. $singular ),
        'new_item' => __( 'New '. $singular ),
        'view_item' => __( 'View '. $singular ),
        'search_items' => __( 'Search '. $plural ),
        'not_found' =>  __( 'No '. $plural .' found' ),
        'not_found_in_trash' => __( 'No '. $plural .' found in Trash' ),
        'parent_item_colon' => ''
    );
}

// Skapar boxarna på adminsidan

function taxi_inner_custom_box( $post,$args ) {
        //print_r($args);
	    wp_nonce_field( plugin_basename( __FILE__ ), 'imdburl_noncename' );

	    echo '<label for="imdburl_new_field">';
	 _e($args['args']['label'], 'imdburl_textdomain' );
	 echo '</label> ';

	    echo '<input id="imdburl_new_field" type="text" name="imdburl_new_field" value="" size="25" />';
	}

function imdburl_save_postdata( $post_id ) {

	    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	        return;

	    if ( !wp_verify_nonce( $_POST['imdburl_noncename'], plugin_basename( __FILE__ ) ) )
	            return;

	    if ( 'page' == $_POST['post_type'] )
	        {
	    if ( !current_user_can( 'edit_page', $post_id ) )
	                return;
	        }
	    else
	    {
	    if ( !current_user_can( 'edit_post', $post_id ) )
	                return;
	    }

	    $mydata = $_POST['imdburl_new_field'];

	    add_post_meta($post_id, imdburl_new_field, $mydata, true);

	    }

//Här skapas posttypen taxi. Den innehåller grundddata för bilarna

add_action( 'init', 'tur_create_taxi' );
function tur_create_taxi() {
        $args = array(
        'labels' => tur_post_type_labels( 'Taxi','Taxi ' ),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title',
            'editor',
            'author',
            'thumbnail',
            'excerpt',
            'comments'
        )
    );

        register_post_type( 'taxi', $args );
}

//add filter to ensure the text Driver, or driver, is displayed when user updates a driver
add_filter('post_updated_messages', 'tur_updated_driver');
function tur_updated_driver( $messages ) {
        global $post, $post_ID;

        $messages['taxi'] = array(
                0 => '', // Unused. Messages start at index 1.
                1 => sprintf( __('Taxi updated. <a href="%s">View driver</a>'), esc_url( get_permalink($post_ID) ) ),
                2 => __('Custom field updated.'),
                3 => __('Custom field deleted.'),
                4 => __('Book updated.'),
                /* translators: %s: date and time of the revision */
                5 => isset($_GET['revision']) ? sprintf( __('Taxi restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
                6 => sprintf( __('Book published. <a href="%s">View taxi</a>'), esc_url( get_permalink($post_ID) ) ),
                7 => __('Taxi saved.'),
                8 => sprintf( __('Taxi submitted. <a target="_blank" href="%s">Preview driver</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
                9 => sprintf( __('Taxi scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview driver</a>'),
                // translators: Publish box date format, see php.net/date
                date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
                10 => sprintf( __('Taxi draft updated. <a target="_blank" href="%s">Preview taxi</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
        );

        return $messages;
}
   // add_action( 'add_meta_boxes', 'imdburl_add_custom_box' );
   //	    add_action( 'save_post', 'imdburl_save_postdata' );

	function imdburl_add_custom_box() {

	    add_meta_box(
	        'driver_tfl',
	        __( 'TFL nummer', 'tflnummer_textdomain' ),
	        'taxi_inner_custom_box',
	        'driver' ,
	        'side',
	        'core',
            array('label'=>'TFL-number')
	    );
        add_meta_box(
	        'driver_mail',
	        __( 'Mail adress', 'drivermail_textdomain' ),
	        'taxi_inner_custom_box',
	        'driver' ,
	        'side',
	        'core' ,
            array('label'=>'Email')
	    );
	}

//Här skapas posttypen Taxi_kalender, som innehåller kalenderposter för bilarna
//Kalenderposterna innehåller också kördatan

add_action( 'init', 'create_taxi_kalender' );

function create_taxi_kalender() {
        $args = array(
        'labels' => tur_post_type_labels( 'Kalenderpost','Kalenderpost' ),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title',
            'editor',
            'author',
            'thumbnail',
            'excerpt',
            'comments'
        )
    );

        register_post_type( 'taxi_kalender', $args );
}

//add filter to ensure the text Driver, or driver, is displayed when user updates a driver
add_filter('post_updated_messages', 'taxi_updated_kalender');

function taxi_updated_kalender( $messages ) {
        global $post, $post_ID;

        $messages['kalender'] = array(
                0 => '', // Unused. Messages start at index 1.
                1 => sprintf( __('Kalender updated. <a href="%s">View driver</a>'), esc_url( get_permalink($post_ID) ) ),
                2 => __('Custom field updated.'),
                3 => __('Custom field deleted.'),
                4 => __('Kalender updated.'),
                /* translators: %s: date and time of the revision */
                5 => isset($_GET['revision']) ? sprintf( __('Kalender restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
                6 => sprintf( __('Kalender published. <a href="%s">View taxi</a>'), esc_url( get_permalink($post_ID) ) ),
                7 => __('Kalender saved.'),
                8 => sprintf( __('Kalender submitted. <a target="_blank" href="%s">Preview driver</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
                9 => sprintf( __('Kalender scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview driver</a>'),
                // translators: Publish box date format, see php.net/date
                date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
                10 => sprintf( __('Kalender draft updated. <a target="_blank" href="%s">Preview taxi</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
        );

        return $messages;
}


add_action( 'add_meta_boxes', 'taxi_kalender_add_custom_box' );
   //	    add_action( 'save_post', 'imdburl_save_postdata' );

function taxi_kalender_add_custom_box() {

   add_meta_box(
       'taxi_kalender_startdatum',
       __( 'Startdatum', 'startdatum_textdomain' ),
       'taxi_inner_custom_box',
       'taxi_kalender' ,
       'side',
       'core',
          array('label'=>'Startdatum')
   );
      add_meta_box(
       'taxi_kalender_starttid',
       __( 'Starttid', 'starttid_textdomain' ),
       'taxi_inner_custom_box',
       'taxi_kalender' ,
       'side',
       'core' ,
          array('label'=>'Starttid')
   );
      add_meta_box(
       'taxi_kalender_slutdatum',
       __( 'Slutdatum', 'slutdatum_textdomain' ),
       'taxi_inner_custom_box',
       'taxi_kalender' ,
       'side',
       'core' ,
          array('label'=>'Slutdatum')
   );
      add_meta_box(
       'taxi_kalender_sluttid',
       __( 'Sluttid', 'sluttid_textdomain' ),
       'taxi_inner_custom_box',
       'taxi_kalender' ,
       'side',
       'core' ,
          array('label'=>'Sluttid')
   );
      add_meta_box(
       'taxi_kalender_förare',
       __( 'Förare', 'starttid_textdomain' ),
       'taxi_inner_custom_box',
       'taxi_kalender' ,
       'side',
       'core' ,
          array('label'=>'Förare')
   );
      add_meta_box(
       'taxi_kalender_passnr',
       __( 'Passnr', 'passnr_textdomain' ),
       'taxi_inner_custom_box',
       'taxi_kalender' ,
       'side',
       'core' ,
          array('label'=>'Passnr')
   );
      add_meta_box(
       'taxi_kalender_',
       __( 'Inkört', 'inkort_textdomain' ),
       'taxi_inner_custom_box',
       'taxi_kalender' ,
       'side',
       'core' ,
          array('label'=>'Inkört')
   );
      add_meta_box(
       'taxi_kalender_utlagg',
       __( 'Utlägg', 'utlagg_textdomain' ),
       'taxi_inner_custom_box',
       'taxi_kalender' ,
       'side',
       'core' ,
          array('label'=>'Utlägg')
   );
      add_meta_box(
       'taxi_kalender_felslag',
       __( 'Felslag', 'felslag_textdomain' ),
       'taxi_inner_custom_box',
       'taxi_kalender' ,
       'side',
       'core' ,
          array('label'=>'Felslag')
   );
      add_meta_box(
       'taxi_kalender_mankredit',
       __( 'Manuell kredit', 'mankredit_textdomain' ),
       'taxi_inner_custom_box',
       'taxi_kalender' ,
       'side',
       'core' ,
          array('label'=>'Manuell kredit')
   );
      add_meta_box(
       'taxi_kalender_kontant',
       __( 'Kontant', 'kontant_textdomain' ),
       'taxi_inner_custom_box',
       'taxi_kalender' ,
       'side',
       'core' ,
          array('label'=>'kontant')
   );
      add_meta_box(
       'taxi_kalender_redovisat',
       __( 'Redovisat', 'redovisat_textdomain' ),
       'taxi_inner_custom_box',
       'taxi_kalender' ,
       'side',
       'core' ,
          array('label'=>'Redovisat')
   );
      add_meta_box(
       'taxi_kalender_',
       __( '', '_textdomain' ),
       'taxi_inner_custom_box',
       'taxi_kalender' ,
       'side',
       'core' ,
          array('label'=>'')
   );
      add_meta_box(
       'taxi_kalender_budget',
       __( 'Budget', 'budget_textdomain' ),
       'taxi_inner_custom_box',
       'taxi_kalender' ,
       'side',
       'core' ,
          array('label'=>'Budget')
   );
}




?>