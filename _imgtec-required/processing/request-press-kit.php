<?php
/**  -----------------
 *   REQUEST PRESS KIT
 *   -----------------
 *
 *   file handles the following aspects:
 *
 *   1. the user request for the press kit
 *   2. sending of request confirmation email to user
 *   3. notification of request sent to the administrator
 */

function it_presskit_request(){

	global $post;
	global $wpdb;

	$admin_email 	= 'jo.jones@imgtec.com';

	$output 		= [ 'status' => 1 ];

	$timestamp 		= time();
	$user_ip 		= $_SERVER[ 'REMOTE_ADDR' ];

	$kit_request 	= $_POST[ 'kit_request' ];
	$access_code 	= $_POST[ 'access_code' ];
	$first_name 	= $_POST[ 'first_name' ];
	$last_name 		= $_POST[ 'last_name' ];
	$email_address 	= $_POST[ 'email_address' ];
	$company 		= $_POST[ 'company' ];
	$message 		= $_POST[ 'message' ];

	$request_count 	= $wpdb->get_var(
		"SELECT COUNT(*) FROM `" . $wpdb->prefix . "presskit_requests`
		WHERE email_address='" . $email_address . "'"
	);

	if ( $request_count > 0 ) :
		wp_send_json( $output );
	endif;

	$wpdb->insert(
		$wpdb->prefix . 'presskit_requests', [
			'timestamp' 		=> $timestamp,
			'user_ip' 			=> $user_ip,
			'kit_request' 	  	=> $kit_request,
			'access_code' 		=> $access_code,
			'first_name' 		=> $first_name,
			'last_name' 		=> $last_name,
			'email_address' 	=> $email_address,
			'company' 			=> $company,
			'message' 			=> $message
		], [
			'%s', // timestamp
			'%s', // user_ip
			'%s', // kit_request
			'%s', // access code
			'%s', // first_name
			'%s', // last_name
			'%s', // email_address
			'%s', // company
			'%s'  // message
		]
	);
	$output[ 'status' ] = 2;


	// email headers for both emails...
	$headers  = array('Content-Type: text/html; charset=UTF-8');

	
	// ============================================= //
	// ===== REQUEST CONFIRMATION EMAIL (USER) ===== //

	// subject line...
	$user_subject  = 'Press Kit Requested - Imagination Technologies';

	// message body...
	$user_message  = '<div style="margin: 50px 0px; background-color: #f8f8f8;">';
	$user_message .= '<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">';
	$user_message .= '<tr>';
	$user_message .= '<td align="center">';
	$user_message .= '<table cellpadding="0" cellspacing="0" border="0" style="border-radius: 10px; border: 1px solid #ddd; width: 650px;" bgcolor="#ffffff">';
	$user_message .= '<!--[if mso]><table border="0" cellpadding="0" cellspacing="0" width="650" align="center" bgcolor="#ffffff"><![endif]-->';

	$user_message .= '<tr>';
	$user_message .= '<td colspan="2" style="padding: 60px 50px 10px 50px; background-color: #ffffff;">';

	$user_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 15px 0px;">';
	$user_message .= 'Dear ' . $first_name;
	$user_message .= '</p>';

	$user_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 37px 0px;">';
	$user_message .= 'Thank you for your interest in Imagination Technologies, we’re just processing your request for our press kit.';
	$user_message .= '</p>';

	$user_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 37px 0px;">';
	$user_message .= 'To ensure a smooth download if your request is approved, please ensure you stick to the following:';
	$user_message .= '<ul>';
	$user_message .= '<li>Do not delete the cookies from your browser until after you have downloaded our press kit</li>';
	$user_message .= '<li>Make sure you use the same machine to download that you used to request this package</li>';
	$user_message .= '<li>Use the download link within 5 days of receiving the approval to download</li>';
	$user_message .= '</ul>';
	$user_message .= '</p>';

	$user_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 30px 0px 7px 0px;">';
	$user_message .= 'If your request is urgent, please contact Jo Jones on +44(0)1923 260511 / +44(0)7802 490347 or <a href="mailto:jo.jones@imgtec.com">jo.jones@imgtec.com</a>';
	$user_message .= '</p>';

	$user_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
	$user_message .= 'Kind Regards,<br>';
	$user_message .= 'Jo Jones<br>';
	$user_message .= 'Technology Communications Manager';
	$user_message .= '</p>';

	$user_message .= '</td>';
	$user_message .= '</tr>';

	$user_message .= '<tr>';
	$user_message .= '<td colspan="2" class="eml-header" style="padding: 20px 50px 20px 50px; background-color: #ffffff; border-bottom: 1px solid #efefef;">';
	$user_message .= '<a href="https://www.imgtec.com">';
	$user_message .= '<img src="' . plugins_url( '_imgtec-required/images/Imagination_Logo.svg' ) . '" alt="Imagination Technologies" style=" border: none; width: 190px;">';
	$user_message .= '</a>';
	$user_message .= '</td>';
	$user_message .= '</tr>';

	$user_message .= '</table>';
	$user_message .= '</td>';
	$user_message .= '</tr>';
	$user_message .= '</table>';
	$user_message .= '</div>';

	// send the request confirmation email to the user...
	wp_mail( $email_address, $user_subject, $user_message, $headers );

	

	// ============================================== //
	// ===== REQUEST CONFIRMATION EMAIL (ADMIN) ===== //

	// subject line... 
	$admin_subject  = 'Press Kit Request: ';
	$admin_subject .= ucwords( $first_name ) . ' ' . ucwords( $last_name ) . ' ';
	$admin_subject .= '[' . ucwords( $company ) . ']';

	// message body...
	$admin_message  = '<p>Imagination Press Kit has been requested by:</p>';
	$admin_message .= '<p><strong>Full name:</strong> ' . $first_name . ' ' . $last_name . '</p>';
	$admin_message .= '<p><strong>Email address:</strong> <a href="mailto:' . $email_address . '">' . $email_address . '</a></p>';
	$admin_message .= '<p><strong>Publication:</strong> ' . $company . '</p>';
	
	if ( $message !== '' ) :
		$admin_message .= '<br><p><strong>Message:</strong> ';
		$admin_message .= $message . '</p>';
	endif;

	$admin_message .= '<br><p>To approve this request make sure you are first logged in to the company website and then <a href="https://www.imgtec.com/wp-admin/admin.php?page=_imgtec-required/admin/press-kit-requests.php">visit the press kit requests panel</a> to change the status of the "Kit Request" for this user to "Approved"</p>';

	// send the request notification email to the administrator...
	wp_mail( $admin_email, $admin_subject, $admin_message, $headers );

	// =====================
	// stop processing...
	wp_die();	
}
