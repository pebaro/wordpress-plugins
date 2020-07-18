<?php
/**
 * =============================================================================
 * --------------------------------------------------------------------------
 * Plugin Name: _ImgTec Live Search
 * Plugin URI: https://www.imgtec.com
 * Description: Live search with ability to save searches using the Rest API.
 * Version: 2.0
 * Author: Rob Masters
 * Author URI: https://www.imgtec.com
 * --------------------------------------------------------------------------
 * =============================================================================
 */

# ============================
# exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit; 


# ===================
# define constants
define( 'LIVESEARCH_VERSION', 2.0 );
define( 'LIVESEARCH__FILE__', __FILE__ );
define( 'LIVESEARCH_PLUGIN_BASE', plugin_basename( LIVESEARCH__FILE__ ) );
define( 'LIVESEARCH_PATH', plugin_dir_path( LIVESEARCH__FILE__ ) );
define( 'LIVESEARCH_URL', plugins_url( '/', LIVESEARCH__FILE__ ) );
define( 'LIVESEARCH_IMAGES_URL', LIVESEARCH_URL . '_img/' );
define( 'LIVESEARCH_TEXTDOMAIN', 'it-live-search' );


# ==============================
# get file relative to plugin
function it_livesearch_get_path( $path ){
    return LIVESEARCH_PATH . $path;
}


# ===============================
# function for including files
function it_livesearch_include_file( $file ){
    $path = it_livesearch_get_path( $file );

    # include the file if it exists
    if ( file_exists( $path ) ) include_once( $path );
}


# ==========================================
# check if required plugins are installed
if ( ! function_exists( 'it_is__imgtec_required_installed' ) ){
    function it_is__imgtec_required_installed(){
        $file_path = '_imgtec-required/imgtec-required.php';
        $installed_plugins = get_plugins();
        return isset( $installed_plugins[ $file_path ] );
    }
}
if ( ! function_exists( 'it_is_acf_pro_installed' ) ){
    function it_is_acf_pro_installed(){
		$file_path = 'advanced-custom-fields-pro/acf.php';
        $installed_plugins = get_plugins();
        return isset( $installed_plugins[ $file_path ] );
    }
}


# ===============================================================
# notices for when required plugins aren't installed or active
if ( ! function_exists( 'it_acf_pro_plugin_failure' ) ){
    function it_acf_pro_plugin_failure(){
        $screen = get_current_screen();

        if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) return;

        $acf_plugin = 'advanced-custom-fields-pro/acf.php';

        if ( it_is_acf_pro_installed() ){
            if ( ! current_user_can( 'activate_plugins' ) ) return;
    
            $acf_activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $acf_plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $acf_plugin );
            $acf_message  = '<p>' . __( 'YO HO Brothers & Sisters - You need to ACTIVATE the Advanced Custom Fields Pro plugin for ImgTec Live Search to work fully', 'it-live-search' ) . '</p>';
            $acf_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $acf_activation_url, __( 'Activate Advanced Custom Fields Pro', 'it-live-search' ) ) ;
    
        } else {
            if ( ! current_user_can( 'install_plugins' ) ) return;
    
            $acf_install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&amp;plugin=advanced-custom-fields-pro' ), 'install-plugin_advanced-custom-fields-pro' );
            $acf_message  = '<p>' . __( 'YO HO Brothers & Sisters - You need to INSTALL the Advanced Custom Fields Pro plugin for ImgTec Live Search to work fully', 'it-live-search' ) . '</p>';
            $acf_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $acf_install_url, __( 'Install Advanced Custom Fields Pro', 'it-live-search' ) ) . '</p>';
        }
    
        echo '<div class="error"><p>' . $acf_message . '</p></div>';
    }
}
if ( ! function_exists( 'it__imgtec_required_plugin_failure' ) ){
    function it__imgtec_required_plugin_failure(){
        $screen = get_current_screen();

        if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) return;

        $it_required_plugin = '_imgtec-required/imgtec-required.php';

        if ( it_is_acf_pro_installed() ){
            if ( ! current_user_can( 'activate_plugins' ) ) return;
    
            $it_required_activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $it_required_plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $it_required_plugin );
            $it_required_message  = '<p>' . __( 'YO HO Brothers & Sisters - You need to ACTIVATE the ImgTec Required plugin for ImgTec Live Search to work fully', 'it-live-search' ) . '</p>';
            $it_required_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $it_required_activation_url, __( 'Activate ImgTec Required', 'it-live-search' ) ) ;
    
        } else {
            if ( ! current_user_can( 'install_plugins' ) ) return;
    
            $it_required_install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&amp;plugin=_imgtec-required' ), 'install-plugin__imgtec-required' );
            $it_required_message  = '<p>' . __( 'YO HO Brothers & Sisters - You need to INSTALL the ImgTec Required plugin for ImgTec Live Search to work fully', 'it-live-search' ) . '</p>';
            $it_required_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $it_required_install_url, __( 'Install ImgTec Required', 'it-live-search' ) ) . '</p>';
        }
    
        echo '<div class="error"><p>' . $it_required_message . '</p></div>';
    }
}


# ========================================
# make sure relevant plugins are active
if ( ! function_exists( 'it_imgtec_livesearch_load' ) ){
    function it_imgtec_livesearch_load() {

        # load localization file
        load_plugin_textdomain( LIVESEARCH_TEXTDOMAIN );

        # ImgTec Required && Advanced Custom Fields Pro
        if ( ! is_plugin_active( '_imgtec-required/imgtec-required.php' ) && ! is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ){
            add_action( 'admin_notices', 'it__imgtec_required_plugin_failure' );
            add_action( 'admin_notices', 'it_acf_plugin_failure' );
            return;
        }

        # just ImgTec Required
        if ( ! is_plugin_active( '_imgtec-required/imgtec-required.php' ) ){
            add_action( 'admin_notices', 'it__imgtec_required_plugin_failure' );
            return;
        }
        # just Advanced Custom Fields Pro
        if ( ! is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ){
            add_action( 'admin_notices', 'it_acf_pro_plugin_failure' );
            return;
        }

        # include main plugin file
        it_livesearch_include_file( 'plugin.php' );
    }
}
add_action( 'plugins_loaded', 'it_imgtec_livesearch_load' );

