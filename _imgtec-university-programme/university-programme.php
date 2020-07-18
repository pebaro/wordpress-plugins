<?php
/**
 * ===================================================================================
 * --------------------------------------------------------------------------------
 * Plugin Name: _ImgTec University Programme
 * Plugin URI: https://university.imgtec.com
 * Description: Custom data for the IUP: Actions, Filters, CPTs, Taxonomies, Etc.
 * Version: 3.1
 * Author: Rob Masters
 * Author URI: https://university.imgtec.com
 * --------------------------------------------------------------------------------
 * ===================================================================================
 */
 // exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) exit; 
 // ......................................



/* ===============
 * SETUP PLUGIN
 * ===============
 */
// define constants
define( 'IUP_VERSION', 3.1 );
define( 'IUP__FILE__', __FILE__ );
define( 'IUP_PLUGIN_BASE', plugin_basename( IUP__FILE__ ) );
define( 'IUP_PATH', plugin_dir_path( IUP__FILE__ ) );
define( 'IUP_URL', plugins_url( '/', IUP__FILE__ ) );
define( 'IUP_IMAGES_URL', IUP_URL . '_img/' );
define( 'IUP_TEXTDOMAIN', 'iup-custom-data' );

// get file relative to plugin
function iup_get_path( $path ){
    return IUP_PATH . $path;
}

// function for including files
function iup_include_file( $file ){
    $path = iup_get_path( $file );

    // include the file if it exists
    if ( file_exists( $path ) ) include_once( $path );
}

// check if required plugins are installed
if ( ! function_exists( 'iup_is_acf_pro_installed' ) ){
    function iup_is_acf_pro_installed(){
		$file_path = 'advanced-custom-fields-pro/acf.php';
        $installed_plugins = get_plugins();
        return isset( $installed_plugins[ $file_path ] );
    }
}

// notices for when required plugins aren't installed or active
if ( ! function_exists( 'iup_acf_pro_plugin_failure' ) ){
    function iup_acf_pro_plugin_failure(){
        $screen = get_current_screen();

        if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
                return;
        }
        $acf_plugin = 'advanced-custom-fields-pro/acf.php';

        if ( iup_is_acf_pro_installed() ){
            if ( ! current_user_can( 'activate_plugins' ) ){ 
                return;
            }
            $acf_activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $acf_plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $acf_plugin );
            $acf_message  = '<p>' . __( 'You need to ACTIVATE the Advanced Custom Fields Pro plugin for ImgTec University Programme plugin to work fully', IUP_TEXTDOMAIN ) . '</p>';
            $acf_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $acf_activation_url, __( 'Activate Advanced Custom Fields Pro', IUP_TEXTDOMAIN ) ) ;
        } else {
            if ( ! current_user_can( 'install_plugins' ) ){ 
                return;
            }
            $acf_install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&amp;plugin=advanced-custom-fields-pro' ), 'install-plugin_advanced-custom-fields-pro' );
            $acf_message  = '<p>' . __( 'You need to INSTALL the Advanced Custom Fields Pro plugin for ImgTec University Programme plugin to work fully', IUP_TEXTDOMAIN ) . '</p>';
            $acf_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $acf_install_url, __( 'Install Advanced Custom Fields Pro', IUP_TEXTDOMAIN ) ) . '</p>';
        }
        echo '<div class="error"><p>' . $acf_message . '</p></div>';
    }
}

// make sure relevant plugins are active
if ( ! function_exists( 'iup_load' ) ){
    function iup_load() {
        // load localization file
        load_plugin_textdomain( IUP_TEXTDOMAIN );

        // to use is_plugin_active
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        // just Advanced Custom Fields Pro
        if ( ! is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ){
            add_action( 'admin_notices', 'iup_acf_pro_plugin_failure' );
            return;
        }
    }
}



/* ==================
 * PLUGIN INCLUDES
 * ==================
 */
iup_include_file( '_lib/plugin.php' );
iup_include_file( '_lib/functions.php' );
iup_include_file( '_lib/hooks.php' );
iup_include_file( '_lib/posts.php' );
iup_include_file( '_lib/taxonomies.php' );
iup_include_file( '_admin/admin-init.php' );



/* ===============
 * PLUGIN HOOKS   
 * ===============
 */
register_activation_hook( IUP__FILE__, 'iup_activate_custom_data' );            // activate

add_action( 'plugins_loaded', 'iup_load' );                                     // dependancies
add_action( 'admin_enqueue_scripts', 'iup_admin_styles' );                      // admin styles
add_action( 'init', 'iup_custom_posts_init', 1 );                               // post types
add_action( 'init', 'iup_custom_taxonomies', 1 );                               // taxonomies
add_action( 'user_register', 'iup_new_user_registers' );                        // log user
add_action( 'wp_login', 'iup_check_first_user_login', 10, 2 );                  // first login
add_action( 'admin_menu', 'iup_register_custom_menu_page' );                    // register page
add_action( 'admin_menu', 'iup_custom_sub_menu' );                              // sub-menu
add_action( 'wp_before_admin_bar_render', 'iup_wpadmin_branding' );             // admin icon
add_action( 'wp_before_admin_bar_render', 'iup_admin_menu_bar_menu', 100 );     // admin menu
add_action( 'profile_update', 'iup_user_profile_update', 10, 2 );               // update notification

add_filter( 'plugin_action_links', 'iup_admin_page_link', 10, 2 );              // admin link
add_filter( 'menu_order', 'iup_remove_custom_menu_items' );                     // remove defaults
add_filter( 'custom_menu_order', 'iup_toggle_menu_order' );                     // toggle order
add_filter( 'admin_footer_text', 'iup_custom_admin_footer' );                   // admin footer
add_filter( 'update_footer', 'iup_change_footer_version_number', 999 );         // footer version



/* ====================
 * PLUGIN SHORTCODES
 * ====================
 */
