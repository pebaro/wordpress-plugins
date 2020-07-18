<?php

// filter content for single downloads
function iupdm_download_template( $content ){


	// return standard content for other post types
	if ( ! is_singular( 'iup_downloads' ) ) : 
		return $content; 
	endif;

	global $post;
	global $wpdb;

	// prepare
	$download_content 	= ''; 																// content string
	$non_approval_roles = [ 'administrator', 'editor', 'author' ]; 							// approval not needed
	$is_logged_in 		= is_user_logged_in(); 												// ? logged in

	// get user object
	$is_logged_in == 1 ? $user = wp_get_current_user() : ''; 								// var_dump($user);
	// get user privilege level
	! empty( $user ) ? $user_roles = $user->roles : ''; 									//var_dump($user_roles);

	// get meta data
	$description 	= get_field( 'iup_download_description' ); 								// main content
	$version 		= get_field( 'iup_download_version' ); 									// version number
	$cdn_url 		= get_field( 'iup_download_url' ); 										// download url
	$license 		= get_field( 'iup_license_agreement_needed' ); 							// ? license needed
	$license_url 	= get_field( 'iup_select_license_agreement' ); 							// license url
	$license_id 	= get_post_meta( get_the_ID(), 'iup_select_license_agreement', true ); 	// license id
	$approval 		= get_field( 'iup_download_approval_needed' ); 							// ? approval needed
	$img 			= get_field( 'iup_download_image' ); 									// download image
	$img_url 		= $img[ 'url' ]; 														// image url
	$img_alt 		= $img[ 'alt' ]; 														// image alt text
	$img_title 		= $img[ 'title' ]; 														// image title

	// get the user object
	$user_obj = wp_get_current_user();
	
	$download_id 	= get_the_ID( $post->ID );
	// query if status is approved
	$status_check = $wpdb->get_var(
		"SELECT request_status FROM `" . $wpdb->prefix . "dm_requests` 
		WHERE user_id = '" . $user_obj->ID . "' 
		AND download_id='" . $download_id . "'"
	);
	
	// query if terms are agreed
	$license_check = $wpdb->get_var(
		"SELECT terms_agreed FROM `" . $wpdb->prefix . "dm_agreements` 
		WHERE user_id = '" . $user_obj->ID . "' 
		AND license_id='" . $license_id . "'"
	);

	if ( $version ) : // pull in the version number if one exists
		$download_content .= '<h2 id="iupdm-single-download-version-no">' . $version . '</h2>';
	endif;

	// start the download content div
	$download_content .= '<div id="iupdm-single-download">';

	// pull the download description
	$download_content .= $description;

	$download_content .= '<div id="iupdm-status-msg-container"></div>';



	if ( $status_check == null || $status_check == 'history' ) : // REQUEST STATUS = NULL

		// ========================================
		// start all the main conditional checks
		// -------------------------------------
		if ( $license == 1 && $approval == 0 ) : // ? is license agreement needed
	
			if ( ! empty( $user ) ) : // ? is user logged in -> get privileges if so
				
				if ( ! array_intersect( $non_approval_roles, $user->roles ) ) : // ? does license apply
	
					if ( $license_check !== 'Yes' ) :
	
						$download_content .= '<div id="iup-agree-license-terms-text">';
						$download_content .= '<p>You need to agree to the license conditions before you can access this download</p>';
						$download_content .= '<a id="iupdm-access-la" href="' . $license_url . '">View License To Agree</a>';
						$download_content .= '</div>';
	
					else :
	
						$download_content .= '<hr style="margin-bottom: 30px !important; opacity: 0.3;">';
						$download_content .= '<a class="button" href="' . $cdn_url . '">Download Now</a>';
	
					endif;
	
					
				else :
	
					$download_content .= '<hr style="margin-bottom: 30px !important; opacity: 0.3;">';
					$download_content .= '<a class="button" href="' . $cdn_url . '">Download Now</a>';
	
				endif;
	
	 
			else : // if not logged in
	
				$download_content .= '<div class="iupdm-login-register-text"><a href="' . get_site_url() . '/forum/?wpforo=signin">Login</a> or <a href="' . get_site_url() . '/forum/?wpforo=signup">Register</a> to request this download</div>';
	
			endif;
	
		elseif ( $license == 1 && $approval == 1 ) : // ? is approval needed
	
			if ( ! empty( $user ) ) : // ? is user logged in -> get privileges if so
	
				if ( ! array_intersect( $non_approval_roles, $user->roles ) ) : // ? does approval apply
	
					if ( $license_check !== 'Yes' ) :
	
						$download_content .= '<div id="iup-agree-license-terms-text">';
						$download_content .= '<p>You need to agree to the license conditions before you can access this download</p>';
						$download_content .= '<a id="iupdm-access-la" href="' . $license_url . '">View License To Agree</a>';
						$download_content .= '</div>';
	
					else :
	
						// container to set where to start removal upon submission
						$download_content .= '<div id="iupdm-remove-post-submission">';
	
						// start request content
						$download_content .= '<h3 id="iupdm-intended-use-heading">Your Intended use of these materials</h3>';

						if ( $status_check == 'history' ) :
							$download_content .= '<p>We have put a significant investment into the creation of these materials. Your last request for this download was denied. Please think carefully about the information you provide if you make another request. Thank you.</p>';
						else : $download_content .= '<p>We have put a significant investment into the creation of these materials. Please tell us how you intend to use them.</p>';
						endif;
	
	
						// ======================
						// ===== START FORM =====
						// ======================
						$download_content .= '<form id="iupdm-rf" name="iupdmRF">';
						
						// ? ======================================
						// ? what will you use this material for
						$download_content .= '<div id="iupdm-rf-request-purpose-container" class="iupdm-rf-question-container">';
						$download_content .= '<p class="iupdm-rf-question">What will you use these materials for?</p>';
						$download_content .= '<select name="iupdmRFRequestPurpose" id="iupdm-rf-request-purpose" class="iupdm-rf-select">';
						$download_content .= '<option value="0">select intended use...</option>';
						$download_content .= '<option value="course-labs">Teaching Course & Labs</option>';
						$download_content .= '<option value="student-projects">Student Projects</option>';
						$download_content .= '<option value="others">Others</option>';
						$download_content .= '</select>';
						$download_content .= '</div>';
	
	
						$download_content .= '</form>';
						// ====================
						// ===== END FORM =====
						// ====================
	
						$download_content .= '</div>';
	
					endif;
	
				else : // display download button
	
					$download_content .= '<hr style="margin-bottom: 30px !important; opacity: 0.3;">';
					$download_content .= '<a class="button" href="' . $cdn_url . '">Download Now</a>';
	
				endif;
	
			else : // if not logged in
	
				$download_content .= '<div class="iupdm-login-register-text"><a href="' . get_site_url() . '/forum/?wpforo=signin">Login</a> or <a href="' . get_site_url() . '/forum/?wpforo=signup">Register</a> to request this download</div>';
	
			endif;
	
		else : // display download button
	
			$download_content .= '<hr style="margin-bottom: 30px !important; opacity: 0.3;">';
			$download_content .= '<a class="button" href="' . $cdn_url . '">Download Now</a>';
	
		endif;

	elseif ( $status_check == 'approved' ) : // REQUEST STATUS = PENDING

		$download_content .= '<hr style="margin-bottom: 30px !important; opacity: 0.3;">';
		$download_content .= '<a class="button" href="' . $cdn_url . '">Download Now</a>';

		$download_content .= '</div>';

	elseif ( $status_check == 'denied' ) : // REQUEST STATUS = DENIED

		$download_content .= '<h4>Your request for this download package has unfortunately been denied</h4>';

		$download_content .= 'You must first wait for a few days before requesting this package again - Thank you!';

		$download_content .= '</div>';

	elseif ( $status_check == 'review' ) : // REQUEST STATUS = REVIEW

		$download_content .= '<h4>Your request for this download package is currently being reviewed</h4>';

		$download_content .= 'The university team are extremely busy, so please be patient and allow a few days for the completion of this review. If your response does not come through to your inbox, please check your junk mail - Thank you!';

		$download_content .= '</div>';

	else : // REQUEST STATUS = PENDING

		$download_content .= '<h4>Your request for this download package is currently pending awaiting a decision</h4>';

		$download_content .= 'The university team are extremely busy, so please be patient and allow a few days for a decision to be made. If your response does not come through to your inbox, please check your junk mail - Thank you!';

		$download_content .= '</div>';

	endif;


	return $download_content;
}

