<?php
/**
 * hooks for the custom data functions and functionality
 * -----------------------------------------------------
 */

// plugin activation tasks
function it_activate_plugin(){
	// check wordpress is minimum version 5.0
	if ( version_compare( get_bloginfo( 'version' ), '5.0', '<' ) ){
		wp_die( __( 'You need to update WordPress to use this plugin' ), IT_TEXTDOMAIN );
	}

	global $wpdb;

	// enable updates to wpdb
	require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

	// create table for download requests
	$presskit_requests_tbl = "CREATE TABLE `" . $wpdb->prefix . "presskit_requests` (
		`ID` BIGINT(20) NOT NULL AUTO_INCREMENT,
		`timestamp` VARCHAR(24) NOT NULL COLLATE 'utf8_bin',
		`user_ip` VARCHAR(16) NOT NULL COLLATE 'utf8_bin',
		`kit_request` VARCHAR(24) NOT NULL COLLATE 'utf8_bin',
		`access_code` VARCHAR(24) NOT NULL COLLATE 'utf8_bin',
		`first_name` VARCHAR(24) NOT NULL COLLATE 'utf8_bin',
		`last_name` VARCHAR(24) NOT NULL COLLATE 'utf8_bin',
		`email_address` VARCHAR(100) NOT NULL COLLATE 'utf8_bin',
		`company` VARCHAR(50) NOT NULL COLLATE 'utf8_bin',
		`message` VARCHAR(255) NOT NULL COLLATE 'utf8_bin',
		PRIMARY KEY (`ID`)
	) ENGINE=MyISAM " . $wpdb->get_charset_collate() . ";";

	dbDelta( $presskit_requests_tbl );
}

// Function to change sender name
function it_email_sender_name( $original_email_from ) {
    return 'Imagination Technologies';
}

// setup some custom schedule settings
function it_cron_schedule_settings( $schedules ){
	$schedules[ 'thirtysecs' ] = array(
		'interval' 	=> 30,
		'display' 	=> __( 'Every Thirty Seconds', IT_TEXTDOMAIN )
	);

	$schedules[ 'daily' ] = array(
		'interval' 	=> 86400,
		'display' 	=> __( 'Once Daily', IT_TEXTDOMAIN )
	);

	$schedules[ 'two_minutes' ] = array(
		'interval' 	=> 120,
		'display' 	=> __( 'Every 2 Minutes', IT_TEXTDOMAIN )
	);

	$schedules[ 'five_minutes' ] = array(
		'interval' 	=> 300,
		'display' 	=> __( 'Every 5 Minutes', IT_TEXTDOMAIN )
	);

	return $schedules;
}
// schedule the status change if the action isn't already running
if ( ! wp_next_scheduled( 'it_cron_denied_status_change' ) ) {
    wp_schedule_event( time(), 'daily', 'it_cron_denied_status_change' );
}
 
// schedule the denied status change to archived
function it_trigger_denied_status_change() {
	global $post;
	global $wpdb;

	$timestamp 		= time();
	$timecheck 		= time() - 600;
	$new_status 	= $_POST[ 'new_status' ];

	$denied_requests = $wpdb->get_results(
		"SELECT * FROM `" . $wpdb->prefix . "presskit_requests` 
		WHERE kit_request='denied'"
	);

	foreach ( $denied_requests as $denial ) :

		$denial_timestamp = $denial->timestamp;

		if ( $timecheck >= $denial_timestamp ) :

			$request_id			= $denial->ID;
			$new_status 		= 'archived';
			$new_timestamp 		= time();

			$data 				= [ 
				'kit_request' 		=> $new_status, 
				'timestamp' 		=> $new_timestamp 
			];
			$where 				= [ 
				'ID' 				=> $request_id 
			];

			$wpdb->update( $wpdb->prefix . 'dm_requests', $data, $where );

		endif;
	endforeach;
}

// schedule the status change if the action isn't already running
if ( ! wp_next_scheduled( 'it_cron_approved_status_change' ) ) {
    wp_schedule_event( time(), 'daily', 'it_cron_approved_status_change' );
}
// schedule the approved status change to archived
function it_trigger_approved_status_change() {
	global $post;
	global $wpdb;

	$timestamp 		= time();
	$timecheck 		= time() - 30;
	$new_status 	= $_POST[ 'new_status' ];

	$approved_requests = $wpdb->get_results(
		"SELECT * FROM `" . $wpdb->prefix . "presskit_requests` 
		WHERE kit_request='approved'"
	);

	foreach ( $approved_requests as $approval ) :

		$approval_timestamp = $approval->timestamp;

		if ( $timecheck >= $approval_timestamp ) :

			$request_id			= $approval->ID;
			$new_status 		= 'archived';
			$new_timestamp 		= time();

			$data 				= [ 
				'kit_request' 		=> $new_status, 
				'timestamp' 		=> $new_timestamp 
			];
			$where 				= [ 
				'ID' 				=> $request_id 
			];

			$wpdb->update( $wpdb->prefix . 'dm_requests', $data, $where );

		endif;
	endforeach;
}
