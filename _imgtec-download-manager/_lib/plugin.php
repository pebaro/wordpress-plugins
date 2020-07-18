<?php
// =============================
//    ----- STYLESHEETS -----
// -----------------------------

// =====================
// ADMIN STYLESHEETS:
function iupdm_admin_styles(){
    // ========
    // WP ADMIN
    // // development version - NO CACHING
    // wp_enqueue_style( 'admin-styles', plugins_url( '../_css/admin.css', __FILE__ ), NULL, microtime() );
    // production version - CACHING ENABLED
    wp_enqueue_style( 'admin-styles', plugins_url( '../_css/admin.css', __FILE__ ), NULL, '3.0' );
}

// =========================
// FRONT-END STYLESHEETS:
function iupdm_styles(){
    // =================
    // DOWNLOAD REQUESTS
    if ( is_singular( 'iup_downloads' ) ){
        // // development version - NO CACHING
        // wp_enqueue_style( 'download-request', plugins_url( '../_css/download-request.css', __FILE__ ), NULL, microtime() );
        // production version - CACHING ENABLED
        wp_enqueue_style( 'download-request', plugins_url( '../_css/download-request.css', __FILE__ ), NULL, '3.0' );
    }

    // ==================
    // LICENSE AGREEMENTS
    if ( is_singular( 'iup_licenses' ) ){
        // GENERIC STYLES
        // // development version - NO CACHING
        // wp_enqueue_style( 'generic-styles', plugins_url( '../_css/generic-styles.css', __FILE__ ), NULL, microtime() );
        // production version - CACHING ENABLED
        wp_enqueue_style( 'generic-styles', plugins_url( '../_css/generic-styles.css', __FILE__ ), NULL, '3.0' );


        // LICENSE AGREEMENTS
        // // development version - NO CACHING
        // wp_enqueue_style( 'license-agreement', plugins_url( '../_css/license-agreement.css', __FILE__ ), NULL, microtime() );
        // production version - CACHING ENABLED
        wp_enqueue_style( 'license-agreement', plugins_url( '../_css/license-agreement.css', __FILE__ ), NULL, '3.0' );
    }
} 



// =========================
//    ----- SCRIPTS -----
// -------------------------

// =================
// ADMIN SCRIPTS:
function iupdm_admin_scripts(){

    // =================
    // REQUEST CHANGE
    // // development version - NO CACHING
    // wp_enqueue_script( 'request-change', plugins_url( '../_js/request-change.js', __FILE__ ), array( 'jquery' ), microtime(), true );
    // production version - CACHING ENABLED
    wp_enqueue_script( 'request-change', plugins_url( '../_js/request-change.js', __FILE__ ), array( 'jquery' ), '3.0', true );
    // localize for use with request-change.js
    wp_localize_script( 'request-change', 'requestChange', array(
        'site_root'             => get_site_url(),
        'plugin_root'           => plugins_url( '/' ),
        'images_root'           => plugins_url( '/_img/', __FILE__ ),
        'ajax_url'              => admin_url( 'admin-ajax.php' ),
        'user_ip'               => $_SERVER[ 'REMOTE_ADDR' ],
        'user_id'               => get_current_user_id()
    ) );


    // ============
    // ACCORDIAN
    // // development version - NO CACHING
    // wp_enqueue_script( 'jquery-accordian', plugins_url( '../_js/jquery-accordian.js', __FILE__ ), array( 'jquery' ), microtime(), true );
    // production version - CACHING ENABLED
    wp_enqueue_script( 'jquery-accordian', plugins_url( '../_js/jquery-accordian.js', __FILE__ ), array( 'jquery' ), '3.0', true );


    // =================
    // TABBED CONTENT
    // // development version - NO CACHING
    // wp_enqueue_script( 'jquery-tabs', plugins_url( '../_js/jquery-tabs.js', __FILE__ ), array( 'jquery' ), microtime(), true );
    // production version - CACHING ENABLED
    wp_enqueue_script( 'jquery-tabs', plugins_url( '../_js/jquery-tabs.js', __FILE__ ), array( 'jquery' ), '1.0', true );


    // ========
    // MODAL
    // // development version - NO CACHING
    // wp_enqueue_script( 'jquery-modal', plugins_url( '../_js/jquery-modal.js', __FILE__ ), array( 'jquery' ), microtime(), true );
    // production version - CACHING ENABLED
    wp_enqueue_script( 'jquery-modal', plugins_url( '../_js/jquery-modal.js', __FILE__ ), array( 'jquery' ), '3.0', true );
}

// =====================
// FRONT-END SCRIPTS:
function iupdm_scripts(){
    // ===================
    // download request
    if ( is_singular( 'iup_downloads' ) ){
        // // development version - NO CACHING
        // wp_enqueue_script( 'download-request', plugins_url( '../_js/download-request.js', __FILE__ ), array( 'jquery' ), microtime(), true );
        // production version - CACHING ENABLED
        wp_enqueue_script( 'download-request', plugins_url( '../_js/download-request.js', __FILE__ ), array( 'jquery' ), IUPDM_VERSION, true );
        // localize for use with download-request.js
        wp_localize_script( 'download-request', 'downloadRequest', array(
            'site_root'             => get_site_url(),
            'plugin_root'           => plugins_url( '/' ),
            'images_root'           => plugins_url( '/_img/', __FILE__ ),
            'ajax_url'              => admin_url( 'admin-ajax.php' ),
            'user_ip'               => $_SERVER[ 'REMOTE_ADDR' ],
            'user_id'               => get_current_user_id(),
            'download_id'           => get_the_ID(),
            'download_url'          => get_field( 'iup_download_url' ),
            'download_page'         => get_permalink(),
            'download_title'        => get_the_title(),
            'download_version'      => get_field( 'iup_download_version' ),
            'license_url'           => get_field( 'iup_select_license_agreement' )
        ) );
    }

    // ====================
    // license agreement
    if ( is_singular( 'iup_licenses' ) ){
        // // development version - NO CACHING
        // wp_enqueue_script( 'license-agreement', plugins_url( '../_js/license-agreement.js', __FILE__ ), array( 'jquery' ), microtime(), true );
        // production version - CACHING ENABLED
        wp_enqueue_script( 'license-agreement', plugins_url( '../_js/license-agreement.js', __FILE__ ), array( 'jquery' ), IUPDM_VERSION, true );
        // localize for use with license-agreement.js
        wp_localize_script( 'license-agreement', 'licenseAgreement', array(
            'site_root'             => get_site_url(),
            'plugin_root'           => plugins_url( '/' ),
            'images_root'           => plugins_url( '/_img/', __FILE__ ),
            'ajax_url'              => admin_url( 'admin-ajax.php' ),
            'user_ip'               => $_SERVER[ 'REMOTE_ADDR' ],
            'user_id'               => get_current_user_id(),
            'license_id'            => get_the_ID(),
            'license_title'         => get_the_title(),
            'license_url'           => get_the_permalink( get_the_ID() )
        ) );
    }
} 
 