<?php
/*
 * Scripts & Styles for the imgtec plugin
 */

// =============================
// =====> Register Styles <=====
// =============================

#: WordPress admin :#
function imgtec_custom_wp_admin_styles(){
	wp_register_style('custom_wp_admin_css', plugin_dir_url( __FILE__ ) . '../css/main.css');
	wp_enqueue_style('custom_wp_admin_css');
}

#: front-end :#
function imgtec_front_end_styles(){

    // PRESS KIT
	if ( is_page( 'press-kit' ) ){
		// // development version - CACHING DISABLED
		// wp_enqueue_style( 'press-kit', IT_URL . 'css/press-kit.css', NULL, microtime() );
		// production version - CACHING ENABLED
		wp_enqueue_style( 'press-kit', IT_URL . 'css/press-kit.css', NULL, '3.0' );
	}
}



// ==============================
// =====> Register Scripts <=====
// ==============================

#: WordPress admin :#
function imgtec_custom_wp_admin_scripts(){
	// activate non default activated features in bootstrap
	wp_register_script( 'bootstrap_features_wp_admin',
		plugin_dir_url( __FILE__ ) . '../js/bootstrap-features.js',
		array(), 2.3, true );

	wp_enqueue_script( 'bootstrap_features_wp_admin',
		plugin_dir_url( __FILE__ ) . '../js/bootstrap-features.js',
		array('jQuery'), 2.3, true );

	// =================
    // TABBED CONTENT
    // // development version - NO CACHING
    // wp_enqueue_script( 'jquery-tabs', plugins_url( '../js/jquery-tabs.js', __FILE__ ), array( 'jquery' ), microtime(), true );
    // production version - CACHING ENABLED
    wp_enqueue_script( 'jquery-tabs', plugins_url( '../js/jquery-tabs.js', __FILE__ ), array( 'jquery' ), '1.0', true );


    // ========
    // MODAL
    // // development version - NO CACHING
    // wp_enqueue_script( 'jquery-modal', plugins_url( '../js/jquery-modal.js', __FILE__ ), array( 'jquery' ), microtime(), true );
    // production version - CACHING ENABLED
    wp_enqueue_script( 'jquery-modal', plugins_url( '../js/jquery-modal.js', __FILE__ ), array( 'jquery' ), '3.0', true );


    // ===========================
    // PRESS KIT REQUEST CHANGE
    // // development version - NO CACHING
    // wp_enqueue_script( 'press-kit-request-status-change', plugins_url( '../js/press-kit-request-status-change.js', __FILE__ ), array( 'jquery' ), microtime(), true );
    // production version - CACHING ENABLED
    wp_enqueue_script( 'press-kit-request-status-change', plugins_url( '../js/press-kit-request-status-change.js', __FILE__ ), array( 'jquery' ), '3.0', true );
    // localize for use with press-kit-request-status-change.js
    wp_localize_script( 'press-kit-request-status-change', 'PKRequestChange', array(
        'site_root'      => get_site_url(),
        'plugin_root'    => plugins_url( '/' ),
        'images_root'    => plugins_url( '/images/', __FILE__ ),
        'ajax_url'       => admin_url( 'admin-ajax.php' ),
        'user_ip'        => $_SERVER[ 'REMOTE_ADDR' ]
    ) );

}

#: front-end :#
function imgtec_front_end_scripts(){

    // PRESS KIT
    if ( is_page( 'press-kit' ) ) :
        // ====================
        // PRESS KIT REQUEST
        // // development version - NO CACHING
        // wp_enqueue_script( 'press-kit-request', plugins_url( '../js/press-kit-request.js', __FILE__ ), array( 'jquery' ), microtime(), true );
        // production version - CACHING ENABLED
        wp_enqueue_script( 'press-kit-request', plugins_url( '../js/press-kit-request.js', __FILE__ ), array( 'jquery' ), '3.0', true );
        // localize for use with press-kit-request.js
        wp_localize_script( 'press-kit-request', 'PKRequest', array(
            'ajax_url'  => admin_url( 'admin-ajax.php' ),
            'user_ip'   => $_SERVER[ 'REMOTE_ADDR' ]
        ) );
    endif;

}
