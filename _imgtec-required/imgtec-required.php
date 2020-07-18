<?php
/**
 * Plugin Name: _ImgTec (required)
 * Plugin URI: https://www.imgtec.com
 * Description: Custom functionality and data for both the front-end & back-end of WordPress.
 * Version: 3.2
 * Author: Rob Masters
 * Author URI: https://www.imgtec.com
 */

// define constants
define( 'IT_VERSION', 5.2 );
define( 'IT__FILE__', __FILE__ );
define( 'IT_PLUGIN_BASE', plugin_basename( IT__FILE__ ) );
define( 'IT_PATH', plugin_dir_path( IT__FILE__ ) );
define( 'IT_URL', plugins_url( '/', IT__FILE__ ) );
define( 'IT_IMAGES_URL', IT_URL . 'images/' );
define( 'IT_TEXTDOMAIN', 'imgtec-required' );

// get file relative to plugin
function it_get_path( $path ){
    return IT_PATH . $path;
}

// function for including files
function it_include_file( $file ){
    $path = it_get_path( $file );

    // include the file if it exists
    if ( file_exists( $path ) ) include_once( $path );
}


// custom branding for WP Admin
function imgtec_wpadmin_branding(){
	echo '<style type="text/css">#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before { background-image: url('.plugins_url( '_imgtec-required/images/imgtec-brand-icon.png' ).') !important; background-position: 0 0; background-repeat: no-repeat !important; color: rgba(0, 0, 0, 0); } #wpadminbar #wp-admin-bar-wp-logo:hover > .ab-item .ab-icon { background-position: 0 0; background-repeat: no-repeat !important; }</style>';
}

// admin page link
function imgtec_required_admin_page_link( $links, $file ){
	static $imgtec_required_plugin = null;

	if ( is_null( $imgtec_required_plugin ) ) {
		$imgtec_required_plugin = plugin_basename( __FILE__ );
	}
	if ( $file == $imgtec_required_plugin ) {
		$admin_link = '<a style="color:#7d0572;font-weight:bold;" href="admin.php?page=_imgtec-required/admin.php">' . __( '<i class="fa fa-laptop" aria-hidden="true"></i> Admin', IT_TEXTDOMAIN ) . '</a>';
		array_unshift( $links, $admin_link );
	}
	return $links;
}



// ====================
// the plugin files:
// -----------------

// plugin root
it_include_file( 'search-excludes.php' ); // exclude page from search

// lib folder
it_include_file( 'lib/hooks.php' ); 									// plugin hooks
it_include_file( 'lib/functions.php' ); 								// general plugin functions
it_include_file( 'lib/theme-functions.php' ); 							// general theme functions
it_include_file( 'lib/partners-data-table.php' );  						// data table Partners post type
it_include_file( 'lib/scripts.php' ); 									// plugin scripts/styles
it_include_file( 'lib/menus.php' ); 									// admin menus
it_include_file( 'lib/imgtec-posts.php' ); 								// all CPTs (imgtec)
it_include_file( 'lib/imgtec-taxonomies.php' ); 						// all custom taxonomies (imgtec)
it_include_file( 'lib/events-data-table.php' ); 						// data table for all events
it_include_file( 'lib/webinars-data-table.php' ); 						// data table for all webinars
it_include_file( 'lib/presentations-data-table.php' ); 					// data table for all presentations
it_include_file( 'lib/press-releases-data-table.php' ); 				// data table for press releases
it_include_file( 'lib/staff-profiles-data-table.php' ); 				// data table for staff profiles

// widgets folder
it_include_file( 'widgets/contact-info-events.php' ); 					// events contact info widget
it_include_file( 'widgets/contact-blog-editor.php' ); 					// blog editor contact info widget
it_include_file( 'widgets/contact-info-public-relations.php' ); 		// PR contact info widget
it_include_file( 'widgets/blog-author.php' ); 							// blog author widget
it_include_file( 'widgets/blog-tag.php' ); 								// blog tag widget
it_include_file( 'widgets/popular-posts.php' ); 						// popular posts widget
it_include_file( 'widgets/featured-posts.php' ); 						// featured posts widget
it_include_file( 'widgets/in-the-news-posts.php' ); 					// in the news posts widget
it_include_file( 'widgets/press-release-posts.php' ); 					// press release posts widget
it_include_file( 'widgets/ecosystem-news-posts.php' ); 					// ecosystem news posts widget
it_include_file( 'widgets/forum-widget.php' ); 							// ecosystem news posts widget

// shortcodes folder
it_include_file( 'shortcodes/product-demo-sub-heading.php' ); 			// demo sub-heading
it_include_file( 'shortcodes/product-demo-acf-data.php' ); 				// demo acfs
it_include_file( 'shortcodes/press-kit-request-form.php' ); 			// press kit

// processing folder
it_include_file( 'processing/request-press-kit.php' ); 					// request press kit
it_include_file( 'processing/change-press-kit-request-status.php' ); 	// request status change



// ===============
// PLUGIN HOOKS
// ------------
register_activation_hook( IT__FILE__, 'it_activate_plugin' ); 			// upon activation
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); 	// remove prefetching

// ===========
// actions:
// --------
add_action( 'admin_enqueue_scripts', 'imgtec_custom_wp_admin_styles' ); 							// stylesheets
add_action( 'wp_enqueue_scripts', 'imgtec_front_end_styles' ); 										// stylesheets
add_action( 'admin_enqueue_scripts', 'imgtec_custom_wp_admin_scripts' ); 							// scripts
add_action( 'wp_enqueue_scripts', 'imgtec_front_end_scripts' ); 									// stylesheets
add_action( 'wp_before_admin_bar_render', 'imgtec_wpadmin_branding' ); 								// custom branding
add_action( 'init', 'create_imgtec_post_types' ); 													// custom post types
add_action( 'init', 'create_imgtec_taxonomies', 0 ); 												// custom taxonomies
add_action( 'manage_webinars_posts_custom_column', 'webinars_manage_columns', 10, 2 ); 				// webinars columns
add_action( 'manage_staff_profiles_posts_custom_column', 'staff_profiles_manage_columns', 10, 2 ); 	// staff columns
add_action( 'manage_press_releases_posts_custom_column', 'press_releases_manage_columns', 10, 2 ); 	// press columns
add_action( 'manage_presentations_posts_custom_column', 'presentations_manage_columns', 10, 2 ); 	// presentations columns
add_action( 'manage_partners_posts_custom_column', 'partners_manage_columns', 10, 2 ); 				// partners columns
add_action( 'manage_our_events_posts_custom_column', 'our_events_manage_columns', 10, 2 ); 			// events columns
add_action( 'wp_head', 'imgtec_track_post_views'); 													// track post views
add_action( 'wp_ajax_it_presskit_request', 'it_presskit_request' );               					// request logged in
add_action( 'wp_ajax_nopriv_it_presskit_request', 'it_presskit_request' );               			// request logged out
add_action( 'wp_ajax_itpk_change_request_status', 'itpk_change_request_status' );     				// status change
add_action( 'it_cron_denied_status_change', 'it_trigger_denied_status_change' );  					// move to history
add_action( 'it_cron_approved_status_change', 'it_trigger_approved_status_change' );  				// move to history
add_action( 'admin_menu', 'register_imgtec_custom_menu_page' ); 									// register admin page
add_action( 'admin_menu', 'add_sub_menu_custom_posts' ); 											// add sub menu
add_action( 'wp_before_admin_bar_render', 'admin_menu_bar_cpt_menu', 100 ); 						// add to menu bar

// ===========
// filters:
// --------
add_filter( 'plugin_action_links', 'imgtec_required_admin_page_link', 10, 2 ); 	// admin page link
add_filter( 'manage_webinars_posts_columns', 'webinars_columns' ); 				// webinars columns
add_filter( 'manage_staff_profiles_posts_columns', 'staff_profiles_columns' ); 	// staff columns
add_filter( 'manage_press_releases_posts_columns', 'press_releases_columns' ); 	// press columns
add_filter( 'manage_presentations_posts_columns', 'presentations_columns' ); 	// presentations columns
add_filter( 'manage_edit-partners_columns', 'partners_edit_columns' ); 			// partners columns
add_filter( 'manage_our_events_posts_columns', 'our_events_columns' ); 			// events columns
add_filter( 'generate_rewrite_rules', 'taxonomy_slug_rewrite' ); 				// taxonomy rewrite rules
add_filter( 'menu_order', 'remove_custom_menu_items' ); 						// menu order
add_filter( 'custom_menu_order', 'toggle_imgtec_menu_order' ); 					// toggle menu order
add_filter( 'cron_schedules', 'it_cron_schedule_settings' ); 					// schedules
add_filter( 'wp_mail_from_name', 'it_email_sender_name' ); 						// email sender name


// ==============
// shortcodes:
// -----------
add_shortcode( 'it_product_demo_sub_heading', 'it_demo_sub_heading' ); 			// demo sub-heading
add_shortcode( 'it_product_demo_acf_data', 'it_product_demo_acf_data_func' ); 	// demo acfs
add_shortcode( 'it_press_kit_request_form_sc', 'it_presskit_request_form' ); 	// press kit
