<?php
// download request
function iupdm_license_agreement(){

	global $post;
	global $wpdb;

	$output 		= [ 'status' => 1 ];
	$user_id 		= $_POST[ 'user_id' ];
	$license_id 		= $_POST[ 'license_id' ];
	$license_title 		= $_POST[ 'license_title' ];
	$license_url 		= $_POST[ 'license_url' ];
	$terms_agreed 		= $_POST[ 'terms_agreed' ];
	$username 		= $_POST[ 'username' ];
	$preferred_email 	= $_POST[ 'preferred_email' ];
	
	// global $current_user; 
	$user_info 		= wp_get_current_user();
	$user_displayname 	= $user_info->display_name;
	$iup_email 		= $user_info->user_email;
	$userid 		= get_current_user_id();

	$agreement_count 	= $wpdb->get_var(
		"SELECT COUNT(*) FROM `" . $wpdb->prefix . "dm_agreements` 
		WHERE license_id='" . $license_id . "' AND user_id='" . $user_id . "'"
	);
	if ( $agreement_count > 0 ) {
		wp_send_json( $output );
	}


	$wpdb->insert(
		$wpdb->prefix . 'dm_agreements', [
			'user_id' 		=> $user_id,
			'license_id' 		=> $license_id,
			'license_title' 	=> $license_title,
			'license_url' 		=> $license_url,
			'terms_agreed' 		=> $terms_agreed,
			'username' 		=> $user_displayname,
			'preferred_email' 	=> $iup_email
		], [
			'%d', '%d', '%s', '%s', '%s', '%s', '%s'
		]
	);
	$output[ 'status' ] = 2;



	$all_agreements_meta = [];

	$existing_agreements_meta = get_user_meta( get_current_user_id(), 'license_agreements' );

	$new_agreements_meta = [
		'license_id' 	=> $license_id,
		'terms_agreed' 	=> $terms_agreed
	];

	$existing_agreements_meta !== null
		? array_push( $all_agreements_meta, [ $existing_agreements_meta, $new_agreements_meta ] )
		: array_push( $all_agreements_meta, $new_agreements_meta );
	
	update_user_meta( get_current_user_id(), 'license_agreements', $all_agreements_meta, false );



	wp_send_json( $output );

	wp_die();
}
