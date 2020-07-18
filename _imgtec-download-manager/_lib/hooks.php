<?php
/**
 * =================================================
 * custom hooks for use with the download manager
 * ----------------------------------------------
 * add function hooks with all actions and/or filters to this file
 */

// plugin activation tasks
function iupdm_activate_download_manager(){
	// check wordpress is minimum version 5.0
	if ( version_compare( get_bloginfo( 'version' ), '5.0', '<' ) ){
		wp_die( __( 'You need to update WordPress to use this plugin' ), IUPDM_TEXTDOMAIN );
	}

	global $wpdb;

	// enable updates to wpdb
	require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

	// create table for license agreements
	$create_license_agreements_tbl_sql = "CREATE TABLE `" . $wpdb->prefix . "dm_agreements` (
		`ID` BIGINT(10) NOT NULL AUTO_INCREMENT,
		`timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		`user_id` BIGINT(10) NOT NULL,
		`license_id` BIGINT(10) NOT NULL,
		`license_title` VARCHAR(250) NOT NULL COLLATE 'utf8_bin',
		`license_url` VARCHAR(100) NOT NULL COLLATE 'utf8_bin',
		`terms_agreed` VARCHAR(3) NULL COLLATE 'utf8_bin',
		`username` VARCHAR(50) NOT NULL COLLATE 'utf8_bin',
		`preferred_email` VARCHAR(100) NOT NULL COLLATE 'utf8_bin',
		PRIMARY KEY (`ID`)
	) ENGINE=MyISAM " . $wpdb->get_charset_collate() . ";";
	// add licenses table to wpdb
	dbDelta( $create_license_agreements_tbl_sql );

	// create table for download requests
	$create_requests_tbl_sql = "CREATE TABLE `" . $wpdb->prefix . "dm_requests` (
		`ID` BIGINT(20) NOT NULL AUTO_INCREMENT,
		`timestamp` VARCHAR(24) NOT NULL COLLATE 'utf8_bin',
		`user_ip` VARCHAR(16) NOT NULL COLLATE 'utf8_bin',
		`username` VARCHAR(50) NOT NULL COLLATE 'utf8_bin',
		`preferred_email` VARCHAR(100) NOT NULL COLLATE 'utf8_bin',
		`user_id` BIGINT(20) NOT NULL,
		`download_id` BIGINT(20) NOT NULL,
		`download_url` VARCHAR(100) NOT NULL COLLATE 'utf8_bin',
		`download_title` VARCHAR(250) NOT NULL COLLATE 'utf8_bin',
		`download_page` VARCHAR(250) NOT NULL COLLATE 'utf8_bin',
		`download_version` VARCHAR(25) NULL DEFAULT NULL COLLATE 'utf8_bin',
		`approval_admins` VARCHAR(250) NOT NULL COLLATE 'utf8_bin',
		`request_status` VARCHAR(25) NOT NULL COLLATE 'utf8_bin',
		`request_purpose` VARCHAR(24) NOT NULL COLLATE 'utf8_bin',
		`course_name` VARCHAR(50) NULL COLLATE 'utf8_bin',
		`project_objective` VARCHAR(250) NULL COLLATE 'utf8_bin',
		`other_reason` VARCHAR(250) NULL COLLATE 'utf8_bin',
		`optional` VARCHAR(3) NULL COLLATE 'utf8_bin',
		`start_month` VARCHAR(24) NULL COLLATE 'utf8_bin',
		`start_year` VARCHAR(4) NULL COLLATE 'utf8_bin',
		`number_of_students` TINYINT(3) NOT NULL,
		`student_level` VARCHAR(24) NOT NULL COLLATE 'utf8_bin',
		`feedback` VARCHAR(3) NOT NULL COLLATE 'utf8_bin',
		`feedback_when` VARCHAR(50) NULL COLLATE 'utf8_bin',
		`comments` VARCHAR(500) NOT NULL COLLATE 'utf8_bin',
		PRIMARY KEY (`ID`)
	) ENGINE=MyISAM " . $wpdb->get_charset_collate() . ";";
	// $create_requests_tbl_sql = "CREATE TABLE `" . $wpdb->prefix . "dm_requests` (
	// 	`ID` BIGINT(20) NOT NULL AUTO_INCREMENT,
	// 	`timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	// 	`user_ip` VARCHAR(16) NOT NULL COLLATE 'utf8_bin',
	// 	`username` VARCHAR(50) NOT NULL COLLATE 'utf8_bin',
	// 	`preferred_email` VARCHAR(100) NOT NULL COLLATE 'utf8_bin',
	// 	`user_id` BIGINT(20) NOT NULL,
	// 	`download_id` BIGINT(20) NOT NULL,
	// 	`download_url` VARCHAR(100) NOT NULL COLLATE 'utf8_bin',
	// 	`download_title` VARCHAR(250) NOT NULL COLLATE 'utf8_bin',
	// 	`download_page` VARCHAR(250) NOT NULL COLLATE 'utf8_bin',
	// 	`download_version` VARCHAR(25) NULL DEFAULT NULL COLLATE 'utf8_bin',
	// 	`approval_admins` VARCHAR(250) NOT NULL COLLATE 'utf8_bin',
	// 	`request_status` VARCHAR(25) NOT NULL COLLATE 'utf8_bin',
	// 	`request_purpose` VARCHAR(24) NOT NULL COLLATE 'utf8_bin',
	// 	`course_name` VARCHAR(50) NULL COLLATE 'utf8_bin',
	// 	`project_objective` VARCHAR(250) NULL COLLATE 'utf8_bin',
	// 	`other_reason` VARCHAR(250) NULL COLLATE 'utf8_bin',
	// 	`optional` VARCHAR(3) NULL COLLATE 'utf8_bin',
	// 	`start_month` VARCHAR(24) NULL COLLATE 'utf8_bin',
	// 	`start_year` VARCHAR(4) NULL COLLATE 'utf8_bin',
	// 	`number_of_students` TINYINT(3) NOT NULL,
	// 	`student_level` VARCHAR(24) NOT NULL COLLATE 'utf8_bin',
	// 	`feedback` VARCHAR(3) NOT NULL COLLATE 'utf8_bin',
	// 	`feedback_when` VARCHAR(50) NULL COLLATE 'utf8_bin',
	// 	`comments` VARCHAR(500) NOT NULL COLLATE 'utf8_bin',
	// 	PRIMARY KEY (`ID`)
	// ) ENGINE=MyISAM " . $wpdb->get_charset_collate() . ";";
	// add the requests table to wpdb
	dbDelta( $create_requests_tbl_sql );
}

// custom branding for WP Admin
function iupdm_wpadmin_branding(){
	echo '<style type="text/css">//wpadminbar //wp-admin-bar-wp-logo > .ab-item .ab-icon:before { background-image: url('.plugins_url( '_imgtec-download-manager/_img/iup-admin.svg' ).') !important; background-position: 0 0; background-repeat: no-repeat !important; color: rgba(0, 0, 0, 0); } //wpadminbar //wp-admin-bar-wp-logo:hover > .ab-item .ab-icon { background-position: 0 0; background-repeat: no-repeat !important; }</style>';
}

// admin page link
function iupdm_admin_page_link( $links, $file ){
	static $iupdm_plugin = null;

	if ( is_null( $iupdm_plugin ) ) {
		$iupdm_plugin = IUPDM_PLUGIN_BASE;
	}
	if ( $file == $iupdm_plugin ) {
		$admin_link = '<a style="color://7d0572;font-weight:bold;" href="admin.php?page=_imgtec-download-manager/_admin/download-manager-admin.php">' . __( '<i class="fa fa-laptop" aria-hidden="true"></i> Admin', IUPDM_TEXTDOMAIN ) . '</a>';
		array_unshift( $links, $admin_link );
	}
	return $links;
}

// Remove Standard Admin Menu Items for Custom Post Types
function iupdm_remove_custom_menu_items( $menu_order ){

	global $menu;

	foreach ( $menu as $mkey => $m ) {
		$iup_licenses 	= array_search( 'edit.php?post_type=iup_licenses', $m );
		$iup_downloads 	= array_search( 'edit.php?post_type=iup_downloads', $m );

		if( $iup_licenses || $iup_downloads ){
			unset( $menu[ $mkey ] );
		}
	}
	return $menu_order;
}

// toggle menu order
function iupdm_toggle_menu_order(){
	return true;
}

// Register Menu Page
function iupdm_register_custom_menu_page() {

	if ( ! current_user_can( 'administrator', 'editor', 'contributor' ) ) return;

    add_menu_page(
        __( 'Download Manager', IUPDM_TEXTDOMAIN ),
        'Download Manager', 'manage_options',
        '_imgtec-download-manager/_admin/download-manager-admin.php', '',
        plugins_url( '_imgtec-download-manager/_img/iup-admin.svg' ), 3
    );
}

// custom menu
function iupdm_custom_menu_page(){
    esc_html_e( 'Download Manager', IUPDM_TEXTDOMAIN );
}


// custom Sub-Menu
function iupdm_custom_sub_menu(){
	$iupdm_cpts = [
        'iup_downloads', 'iup_licenses'
	];
	foreach ( $iupdm_cpts as $cpt ){
		add_submenu_page( '_imgtec-download-manager/_admin/download-manager-admin.php',
			iupdm_cpt_listing_name( $cpt ), iupdm_cpt_listing_name( $cpt ),
			'edit_pages', 'edit.php?post_type=' . $cpt
		);
	}
}


// Admin Bar Menu
function iupdm_admin_menu_bar_menu(){

	global $wp_admin_bar;
	if( ! current_user_can( 'administrator', 'editor', 'contributor' ) ||
		! is_admin_bar_showing() ||
		! is_object( $wp_admin_bar ) ||
		! function_exists( 'is_admin_bar_showing' ) ||
		! is_admin_bar_showing() )
		: return;
	endif;

	$top_level 			=   'iupdm_admin_menu_bar';
	$download_manager 	= [ 'iup_licenses', 'iup_downloads' ];


	// =======================
	// ACTUAL MENU STARTS HERE
	$wp_admin_bar->add_menu( // Top Level Menu Item
		array(
			'id' 	=> $top_level,
			'title' => __( '<span class="imgtec-green-menu-item">' . 'Download Manager' . '</span>' ),
			'href' 	=> admin_url( '/admin.php?page=_imgtec-download-manager/_admin/download-manager-admin.php' )
		)
	);


	// CPTs Section
	iupdm_menu_bar_sections( $top_level, 'admin', $download_manager );
}
