<?php

// change request status
function itpk_change_request_status(){
	global $post;
	global $wpdb;

	// $timestamp 	= date( 'YmdHis', time() );
	$timestamp 		= time();
	$new_status 	= $_POST[ 'new_status' ];
	$email_address 	= $_POST[ 'email_address' ];
	$request_id 	= $_POST[ 'request_id' ];
	$first_name 	= $_POST[ 'first_name' ];

	$data 	= [ 'kit_request' => $new_status, 'timestamp' => $timestamp ];
	$where 	= [ 'ID' => $request_id, 'email_address' => $email_address ];

	$wpdb->update( $wpdb->prefix . 'presskit_requests', $data, $where );


	// set email headers
	$headers  = array('Content-Type: text/html; charset=UTF-8');

	// =========================================
	// ===== REQUEST APPROVED EMAIL (USER) =====
	if ( $new_status == 'approved' ) : 

		// subject line...
		$subject  = 'Download Press Kit - Imagination Technologies';

		// message body...
		$message  = '<div style="margin: 50px 0px; background-color: #f8f8f8;">';
		$message .= '<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">';
		$message .= '<tr>';
		$message .= '<td align="center">';
		$message .= '<table cellpadding="0" cellspacing="0" border="0" style="border-radius: 10px; border: 1px solid #ddd; width: 650px;" bgcolor="#ffffff">';
		$message .= '<!--[if mso]><table border="0" cellpadding="0" cellspacing="0" width="650" align="center" bgcolor="#ffffff"><![endif]-->';

		$message .= '<tr>';
		$message .= '<td colspan="2" style="padding: 60px 50px 10px 50px; background-color: #ffffff;">';

		$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$message .= 'Dear ' . $first_name;
		$message .= '</p>';

		$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 37px 0px;">';
		$message .= 'Thank you for your interest in Imagination Technologies, you now have access to our digital press kit.';
		$message .= '</p>';

		$user_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 37px 0px;">';
		$user_message .= 'If you do not see the download button after clicking the link that follows it will be due to one of these reasons:';
		$user_message .= '<ul>';
		$user_message .= '<li>You deleted the cookies from your browser after completing the request form</li>';
		$user_message .= '<li>You are using a different device to the one you were using when you requested our press kit</li>';
		$user_message .= '<li>More than 5 days have passed since you received this email</li>';
		$user_message .= '</ul>';
		$user_message .= '</p>';
	
		$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 30px 0px 7px 0px;">';
		$message .= 'Click on the following link to download: ';
		$message .= '<a href="https://www.imgtec.com/company/press-kit/">Imagination Technologies Press Kit</a>';
		$message .= '</p>';

		$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$message .= ' If you need any further assistance, please contact Jo Jones on <a href="mailto:jo.jones@imgtec.com">jo.jones@imgtec.com</a>';
		$message .= '</p>';

		$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$message .= 'Kind Regards,<br>';
		$message .= 'Jo Jones<br>';
		$message .= 'Technology Communications Manager';
		$message .= '</p>';

		$message .= '</td>';
		$message .= '</tr>';

		$message .= '<tr>';
		$message .= '<td colspan="2" class="eml-header" style="padding: 20px 50px 20px 50px; background-color: #ffffff; border-bottom: 1px solid #efefef;">';
		$message .= '<a href="https://www.imgtec.com">';
		$message .= '<img src="' . plugins_url( '_imgtec-required/images/Imagination_Logo.svg' ) . '" alt="Imagination Technologies" style=" border: none; width: 190px;">';
		$message .= '</a>';
		$message .= '</td>';
		$message .= '</tr>';

		$message .= '</table>';
		$message .= '</td>';
		$message .= '</tr>';
		$message .= '</table>';
		$message .= '</div>';

		// send the approval notification email to the user...
		wp_mail( $email_address, $subject, $message, $headers );

	elseif ( $new_status == 'denied' ) :

		// subject line...
		$subject  = 'Download Press Kit - Imagination Technologies';

		// message body...
		$message  = '<div style="margin: 50px 0px; background-color: #f8f8f8;">';
		$message .= '<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">';
		$message .= '<tr>';
		$message .= '<td align="center">';
		$message .= '<table cellpadding="0" cellspacing="0" border="0" style="border-radius: 10px; border: 1px solid #ddd; width: 650px;" bgcolor="#ffffff">';
		$message .= '<!--[if mso]><table border="0" cellpadding="0" cellspacing="0" width="650" align="center" bgcolor="#ffffff"><![endif]-->';

		$message .= '<tr>';
		$message .= '<td colspan="2" style="padding: 60px 50px 10px 50px; background-color: #ffffff;">';

		$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 37px 0px;">';
		$message .= 'Dear ' . $first_name;
		$message .= '</p>';

		$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$message .= 'Thank you for your interest in Imagination Technologies, unfortunately your request for our press kit has been denied.';
		$message .= '</p>';

		$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$message .= 'You are welcome to make another request. If you wish to know why your request was denied, please contact Jo Jones on <a href="mailto:jo.jones@imgtec.com">jo.jones@imgtec.com</a>';
		$message .= '</p>';

		$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$message .= 'Kind Regards,<br>';
		$message .= 'Jo Jones<br>';
		$message .= 'Technology Communications Manager';
		$message .= '</p>';

		$message .= '</td>';
		$message .= '</tr>';

		$message .= '<tr>';
		$message .= '<td colspan="2" class="eml-header" style="padding: 20px 50px 20px 50px; background-color: #ffffff; border-bottom: 1px solid #efefef;">';
		$message .= '<a href="https://www.imgtec.com">';
		$message .= '<img src="' . plugins_url( '_imgtec-required/images/Imagination_Logo.svg' ) . '" alt="Imagination Technologies" style=" border: none; width: 190px;">';
		$message .= '</a>';
		$message .= '</td>';
		$message .= '</tr>';

		$message .= '</table>';
		$message .= '</td>';
		$message .= '</tr>';
		$message .= '</table>';
		$message .= '</div>';

		// send the denial notification email to the user...
		wp_mail( $email_address, $subject, $message, $headers );

	endif;

	wp_die();
}

