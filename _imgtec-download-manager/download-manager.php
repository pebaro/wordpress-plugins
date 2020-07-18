<?php
/**
 * ========================================================================
 * Plugin Name: _ImgTec Download Manager
 * Plugin URI: https://university.imgtec.com
 * Description: Download manager with approval process for gated content
 * Version: 1.0
 * Author: Rob Masters
 * Author URI: https://university.imgtec.com
 * ========================================================================
 */
 // exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) exit; 



/* ===============
 * SETUP PLUGIN
 * ===============
 */
// define constants
define( 'IUPDM_VERSION', 5.1 );
define( 'IUPDM__FILE__', __FILE__ );
define( 'IUPDM_PLUGIN_BASE', plugin_basename( IUPDM__FILE__ ) );
define( 'IUPDM_PATH', plugin_dir_path( IUPDM__FILE__ ) );
define( 'IUPDM_URL', plugins_url( '/', IUPDM__FILE__ ) );
define( 'IUPDM_IMAGES_URL', IUPDM_URL . '_img/' );
define( 'IUPDM_TEXTDOMAIN', 'iup-download-manager' );

// get file relative to plugin
function iupdm_get_path( $path ){
    return IUPDM_PATH . $path;
}

// function for including files
function iupdm_include_file( $file ){
    $path = iupdm_get_path( $file );

    // include the file if it exists
    if ( file_exists( $path ) ) include_once( $path );
}

// check if required plugins are installed
if ( ! function_exists( 'iupdm_is_acf_pro_installed' ) ){
    function iupdm_is_acf_pro_installed(){
		$file_path = 'advanced-custom-fields-pro/acf.php';
        $installed_plugins = get_plugins();
        return isset( $installed_plugins[ $file_path ] );
    }
}

// notices for when required plugins aren't installed or active
if ( ! function_exists( 'iupdm_acf_pro_plugin_failure' ) ){
    function iupdm_acf_pro_plugin_failure(){
        $screen = get_current_screen();

        if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) return;

        $acf_plugin = 'advanced-custom-fields-pro/acf.php';

        if ( iupdm_is_acf_pro_installed() ){
            if ( ! current_user_can( 'activate_plugins' ) ) return;
            $acf_activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $acf_plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $acf_plugin );
            $acf_message  = '<p>' . __( 'You need to ACTIVATE the Advanced Custom Fields Pro plugin for ImgTec Download Manager to work fully', IUPDM_TEXTDOMAIN ) . '</p>';
            $acf_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $acf_activation_url, __( 'Activate Advanced Custom Fields Pro', IUPDM_TEXTDOMAIN ) ) ;
    
        } else {
            if ( ! current_user_can( 'install_plugins' ) ) {
                return;
            }
            $acf_install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&amp;plugin=advanced-custom-fields-pro' ), 'install-plugin_advanced-custom-fields-pro' );
            $acf_message  = '<p>' . __( 'You need to INSTALL the Advanced Custom Fields Pro plugin for ImgTec Download Manager to work fully', IUPDM_TEXTDOMAIN ) . '</p>';
            $acf_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $acf_install_url, __( 'Install Advanced Custom Fields Pro', IUPDM_TEXTDOMAIN ) ) . '</p>';
        }
        echo '<div class="error"><p>' . $acf_message . '</p></div>';
    }
}

// make sure relevant plugins are active
if ( ! function_exists( 'iupdm_load' ) ){
    function iupdm_load() {
        // load localization file
        load_plugin_textdomain( IUPDM_TEXTDOMAIN );

        // to use is_plugin_active
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        // just Advanced Custom Fields Pro
        if ( ! is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ){
            add_action( 'admin_notices', 'iupdm_acf_pro_plugin_failure' );
            return;
        }
    }
}



/* ==================
 * PLUGIN INCLUDES
 * ==================
 */
iupdm_include_file( '_lib/plugin.php' );
iupdm_include_file( '_lib/hooks.php' );
iupdm_include_file( '_lib/functions.php' );
iupdm_include_file( '_lib/posts.php' );
iupdm_include_file( '_lib/taxonomies.php' );
iupdm_include_file( '_admin/admin-init.php' );
iupdm_include_file( '_prcs/create-download-template.php' );
iupdm_include_file( '_prcs/create-license-template.php' );
iupdm_include_file( '_prcs/download-request.php' );
iupdm_include_file( '_prcs/change-request-status.php' );
iupdm_include_file( '_prcs/license-agreement.php' );



/* ===============
 * PLUGIN HOOKS
 * ===============
 * no wp_ajax_nopriv actions --> ajax below should only fire if/when user is logged in
 */
register_activation_hook( IUPDM__FILE__, 'iupdm_activate_download_manager' );           // activate

add_action( 'plugins_loaded', 'iupdm_load' );                                           // dependencies
add_action( 'admin_enqueue_scripts', 'iupdm_admin_styles' );                            // admin styles
add_action( 'admin_enqueue_scripts', 'iupdm_admin_scripts' );                           // admin scripts
add_action( 'wp_enqueue_scripts', 'iupdm_styles' );                                     // styles
add_action( 'wp_enqueue_scripts', 'iupdm_scripts' );                                    // scripts
add_action( 'init', 'iupdm_download_manager_cpts_init', 1 );                            // post types
add_action( 'init', 'iupdm_download_manager_taxononomies', 1 );                         // taxonomies
add_action( 'admin_init', 'iupdm_admin_init' );                                         // admin init

add_filter( 'the_content', 'iupdm_download_template' );                                 // download template
add_action( 'wp_ajax_iupdm_download_request', 'iupdm_download_request' );               // request ajax
add_filter( 'the_content', 'iupdm_license_template' );                                  // license template
add_action( 'wp_ajax_iupdm_license_agreement', 'iupdm_license_agreement' );             // license ajax
add_action( 'wp_before_admin_bar_render', 'iupdm_wpadmin_branding' );                   // admin icon
add_filter( 'plugin_action_links', 'iupdm_admin_page_link', 10, 2 );                    // admin link
add_filter( 'menu_order', 'iupdm_remove_custom_menu_items' );                           // remove defaults
add_filter( 'custom_menu_order', 'iupdm_toggle_menu_order' );                           // toggle order
add_action( 'admin_menu', 'iupdm_register_custom_menu_page' );                          // register page
add_action( 'admin_menu', 'iupdm_custom_sub_menu' );                                    // sub-menu
add_action( 'wp_before_admin_bar_render', 'iupdm_admin_menu_bar_menu', 100 );           // admin menu
add_action( 'wp_ajax_iupdm_change_request_status', 'iupdm_change_request_status' );     // status change

add_filter( 'cron_schedules', 'iupdm_cron_schedule_settings' );                         // schedules
add_action( 'iupdm_cron_denied_status_change', 'iupdm_trigger_denied_status_change' );  // move to history
