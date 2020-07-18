<?php
/**
 * shortcode to build the request form for the press kit
 * https://cdn2.imgtec.com/documents/press_kit_2020.zip
 * 
 *   -----------------------
 *   do following checks:
 *   --------------------
 * - are they logged in
 * - if logged in get the user object
 * - check their user privilege level against bypass roles
 * - skip the form if the user has relevant role
 */

function it_presskit_request_form( $atts ){

	global $post;
	global $wpdb;


	#####################
	##### FORM HTML #####
	#####################
	$form_HTML  = '<br><form id="itpk-rf" name="presskitrequestform">';
	$form_HTML .= '<div class="itpk-row">';
	$form_HTML .= '<label for="itpk-firstname" class="itpk-label">';
	$form_HTML .= 'First name <span class="itpk-required">*</span><br>';
	$form_HTML .= '<input required type="text" name="itpkfirstname" id="itpk-firstname" class="itpk-input">';
	$form_HTML .= '</label>';
	$form_HTML .= '</div>';
	$form_HTML .= '<div class="itpk-row">';
	$form_HTML .= '<label for="itpk-lastname" class="itpk-label">';
	$form_HTML .= 'Last name <span class="itpk-required">*</span><br>';
	$form_HTML .= '<input required type="text" name="itpklastname" id="itpk-lastname" class="itpk-input">';
	$form_HTML .= '</label>';
	$form_HTML .= '</div>';
	$form_HTML .= '<div class="itpk-row">';
	$form_HTML .= '<label for="itpk-email" class="itpk-label">';
	$form_HTML .= 'Email address <span class="itpk-required">*</span><br>';
	$form_HTML .= '<input required type="text" name="itpkemail" id="itpk-email" class="itpk-input">';
	$form_HTML .= '</label>';
	$form_HTML .= '</div>';
	$form_HTML .= '<div class="itpk-row">';
	$form_HTML .= '<label for="itpk-company" class="itpk-label">';
	$form_HTML .= 'Publication <span class="itpk-required">*</span><br>';
	$form_HTML .= '<input required type="text" name="itpkcompany" id="itpk-company" class="itpk-input">';
	$form_HTML .= '</label>';
	$form_HTML .= '</div>';
	$form_HTML .= '<div class="itpk-row">';
	$form_HTML .= '<label for="itpk-message" class="itpk-label">';
	$form_HTML .= 'Message';
	$form_HTML .= '<textarea rows="6" cols="20" name="itpkmessage" id="itpk-message" class="itpk-textarea"></textarea>';
	$form_HTML .= '</label>';
	$form_HTML .= '</div>';
	$form_HTML .= '<div id="itpk-buttons-container" class="itpk-row">';
	$form_HTML .= '<input type="submit" id="itpk-submit" class="itpk-button">';
	$form_HTML .= '<input type="reset" id="itpk-reset" class="itpk-button">';
	$form_HTML .= '</div>';
	$form_HTML .= '</form>';
	$form_HTML .= '<div id="itpk-submission-feedback"></div>';
	
	#########################
	##### DOWNLOAD HTML #####
	#########################
	$download_HTML  = '<p>You will not be able to share this download as access is uniquely connected to you and the machine you used to request this download.<br>';
	$download_HTML .= 'Access will last for 7 days only, after which you will be required to make a new request for this package.<br>';
	$download_HTML .= 'If you delete the cookies from your browser you will need to make another request as this download will no longer work.</p><br>';
	$download_HTML .= '<p><a style="background-color: #FF1256;" class="elementor-button elementor-size-sm elementor-animation-" role="button" href="https://imagination-technologies-cloudfront-assets.s3.eu-west-1.amazonaws.com/website-files/presskit/press-kit.zip">Download Press Kit</a></p>';


	// CHECK FOR COOKIE AND IT'S VALUE IN THE DATABASE
	if ( isset( $_COOKIE[ 'itpk_download_access' ] ) ) :
		$access_code = $_COOKIE[ 'itpk_download_access' ];
	endif;

	$pk_requests = $wpdb->get_row(
		"SELECT * FROM `" . $wpdb->prefix . "presskit_requests` 
		WHERE access_code='" . $access_code . "'"
	);
	
	// roles that do not require a request form submission
	$bypass_roles = [ 'administrator', 'editor', 'author' ]; 
	// is the user logged in
	$is_logged_in = is_user_logged_in();
	// get the user object if the user is logged in
	$is_logged_in == 1 ? $active_user = wp_get_current_user() : ''; 
	

	if ( $pk_requests->kit_request !== 'approved' ) : // if there isn't an existing approval

		if ( ! empty( $active_user ) ) : // if the user is logged out

			if ( ! array_intersect( $bypass_roles, $active_user->roles ) ) : // can user bypass the form

				$request_form  = '<p>If you have have already been approved to access our press kit and you’re seeing the request form instead of the download button, it will be for one of the following reasons outlined in the email you received with your download link. If this is the case, please re-submit the form below.</p>';
				// ===========================
				// CREATE THE REQUEST FORM
				$request_form .= $form_HTML;
				// FORM HTML
				return $request_form;

			else : // give access to press kit

				// ============================
				// DISPLAY THE DOWNLOAD HTML
				$download_presskit  = $download_HTML;
				// DOWNLOAD HTML
				return $download_presskit;

			endif;

		else : // if not logged in

			$request_form  = '<p>If you have have already been approved to access our press kit and you’re seeing the request form instead of the download button, it will be for one of the following reasons outlined in the email you received with your download link. If this is the case, please re-submit the form below.</p>';
			// ===========================
			// CREATE THE REQUEST FORM
			$request_form .= $form_HTML;
			// FORM HTML
			return $request_form;

		endif;

	else :  // give access to press kit

		// ============================
		// DISPLAY THE DOWNLOAD HTML
		$download_presskit  = $download_HTML;
		// DOWNLOAD HTML
		return $download_presskit;

	endif;
}