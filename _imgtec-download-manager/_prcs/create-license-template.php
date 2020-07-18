<?php
// filter content for single downloads
function iupdm_license_template( $content ){
	if ( ! is_singular( 'iup_licenses' ) ) : 
		return $content; 
	endif;

	global $post;

	$license_content 	= ''; 										// content string
	$non_approval_roles = [ 'administrator', 'editor', 'author' ]; 	// approval not needed
	$is_logged_in 		= is_user_logged_in(); 						// ? logged in
	
	$license_content .= '<div id="iupdm-single-la">';
	$license_content .= 	'<div class="iupdm-single-la-content">';
	$license_content .= 		the_field( 'iup_license_content' );
	$license_content .= 	'</div>';
	$license_content .= 	'<form id="iupdm-laf" name="iupdmLAF"></form>';
	$license_content .= '</div>';
	

	return $license_content;
}
?>