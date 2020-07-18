<?php
// download request
function iupdm_download_request(){

	global $post;
	global $wpdb;

	$admin_email 			= 'iup@imgtec.com';

	$output 				= [ 'status' => 1 ];
	$timestamp 				= time();
	$user_ip 				= $_SERVER[ 'REMOTE_ADDR' ];
	$user_id 				= absint( $_POST[ 'user_id' ] );
	$download_id 			= absint( $_POST[ 'download_id' ] );
	$download_url 			= $_POST[ 'download_url' ];
	$download_title 		= $_POST[ 'download_title' ];
	$page 					= $_POST[ 'download_page' ];
	$version 				= $_POST[ 'download_version' ];
	$request_purpose 		= $_POST[ 'request_purpose' ];
	$course_name 			= $_POST[ 'course_name' ];
	$project_objective 		= $_POST[ 'project_objective' ];
	$other_reason 			= $_POST[ 'other_reason' ];
	$optional 				= $_POST[ 'optional' ];
	$start_month 			= $_POST[ 'start_month' ];
	$start_year 			= $_POST[ 'start_year' ];
	$number_students 		= absint( $_POST[ 'number_of_students' ] );
	$student_level 			= $_POST[ 'student_level' ];
	$feedback 				= $_POST[ 'feedback' ];
	$feedback_when 			= $_POST[ 'feedback_when' ];
	$comments 				= $_POST[ 'comments' ];
	$approval_admins 		= $_POST[ 'approval_admins' ];
	$request_status 		= $_POST[ 'request_status' ];
	
	// global  = wp_get_current_user();; 
	$user_info 				= wp_get_current_user();
	$user_displayname 		= $user_info->display_name;
	$iup_email 				= $user_info->user_email;

	$request_count 	= $wpdb->get_var(
		"SELECT COUNT(*) FROM `" . $wpdb->prefix . "dm_requests` 
		WHERE download_id='" . $download_id . "' AND user_id='" . $user_id . "'"
	);
	if ( $request_count > 0 ) {
		wp_send_json( $output );
	}
	
	$wpdb->insert(
		$wpdb->prefix . 'dm_requests', [
			'timestamp' 			=> $timestamp,
			'user_ip' 				=> $user_ip,
			'username' 				=> $user_displayname,
			'preferred_email' 		=> $iup_email,
			'user_id' 				=> $user_id,
			'download_id' 			=> $download_id,
			'download_url' 			=> $download_url,
			'download_title' 		=> $download_title,
			'download_page' 		=> $page,
			'download_version' 		=> $version,
			'request_status' 		=> $request_status,
			'request_purpose' 		=> $request_purpose,
			'course_name' 			=> $course_name,
			'project_objective' 	=> $project_objective,
			'other_reason' 			=> $other_reason,
			'optional' 				=> $optional,
			'start_month' 			=> $start_month,
			'start_year' 			=> $start_year,
			'number_of_students' 	=> $number_students,
			'student_level' 		=> $student_level,
			'feedback' 				=> $feedback,
			'feedback_when' 		=> $feedback_when,
			'comments' 				=> $comments,
			'approval_admins' 		=> $admin_email
		], [
			'%s', // timestamp
			'%s', // user_ip
			'%s', // username
			'%s', // preferred_email
			'%d', // user_id
			'%d', // download_id
			'%s', // download_url
			'%s', // download_title
			'%s', // download_page
			'%s', // download_version
			'%s', // request_status
			'%s', // request_purpose
			'%s', // course_name
			'%s', // project_objective
			'%s', // other_reason
			'%s', // optional
			'%s', // start_month
			'%d', // start_year
			'%d', // number_of_students
			'%s', // student_level
			'%s', // feedback
			'%s', // feedback_when
			'%s', // comments
			'%s'  // approval_admins
		]
	);
	$output[ 'status' ] = 2;



	// ======================================
	// ===== REQUEST INFORMATION EMAILS =====
	// ======================================
	// set email headers
	$headers  = array('Content-Type: text/html; charset=UTF-8');

	// ===========================================
	// ===== USER REQUEST CONFIRMATION EMAIL =====
	// - - - - - - - - - - - - - - - - - - - - - -
	// subject line
	$pending_subject  = 'We have received your download request (' . iupdm_request_table_format_ucwords( $download_title ) . ')';

	// message body
	$pending_message  = '<div style="margin: 50px 0px; background-color: #f8f8f8;">';
	$pending_message .= '<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">';
	$pending_message .= '<tr>';
	$pending_message .= '<td align="center">';
	$pending_message .= '<table cellpadding="0" cellspacing="0" border="0" style="border-radius: 10px; border: 1px solid #ddd; width: 650px;" bgcolor="#ffffff">';
	$pending_message .= '<!--[if mso]><table border="0" cellpadding="0" cellspacing="0" width="650" align="center" bgcolor="#ffffff"><![endif]-->';

	$pending_message .= '<tr>';
	$pending_message .= '<td colspan="2" style="padding: 20px 50px 10px 50px; background-color: #ffffff;">';

	$pending_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
	$pending_message .= 'Dear <a href="https://university.imgtec.com/forums/profile/' . $user_info->user_login . '" target="_blank">' . $user_info->user_login . '</a>';
	$pending_message .= '</p>';

	$pending_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
	$pending_message .= 'Your download request for <a href="https://university.imgtec.com/resources/download/' . iupdm_slugify_string( $download_title ) . '">' . $download_title . '</a> has been received. We expect to process all requests within 3 working days and you will receive a separate email notifying you of our decision.';
	$pending_message .= '</p>';

	$pending_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
	$pending_message .= 'You can contact us at email: <a href="mailto:iup@imgtec.com">iup@imgtec.com</a>';
	$pending_message .= '</p>';

	$pending_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
	$pending_message .= 'Thank you for your patience.';
	$pending_message .= '</p>';

	$pending_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
	$pending_message .= 'Best Regards,<br>';
	$pending_message .= 'The Imagination University Programme Team';
	$pending_message .= '</p>';

	$pending_message .= '</td>';
	$pending_message .= '</tr>';


	// CN translation
	$pending_message .= '<tr>';
	$pending_message .= '<td colspan="2" style="padding: 20px 50px 10px 50px; background-color: #ffffff;">';

	$pending_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
	$pending_message .= '尊敬的 <a href="https://university.imgtec.com/forums/profile/' . $user_info->user_login . '" target="_blank">' . $user_info->user_login . '</a>';
	$pending_message .= '</p>';

	$pending_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
	$pending_message .= '我们已经收到您的 <a href="https://university.imgtec.com/resources/download/' . iupdm_slugify_string( $download_title ) . '">' . $download_title . '</a> 下载请求。 我们将会在2个工作日内处理您的请求， 我们将会通过另外一封邮件告知您处理结果。';
	$pending_message .= '</p>';

	$pending_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
	$pending_message .= '您可以随时通过邮件联系我们： <a href="mailto:iup@imgtec.com">iup@imgtec.com</a>';
	$pending_message .= '</p>';

	$pending_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
	$pending_message .= '十分感谢您的耐心等待，祝您一切顺利。';
	$pending_message .= '</p>';

	$pending_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
	$pending_message .= 'Imagination大学项目团队<br>';
	$pending_message .= '敬上';
	$pending_message .= '</p>';

	$pending_message .= '</td>';
	$pending_message .= '</tr>';

	$pending_message .= '<tr>';
	$pending_message .= '<td colspan="2" class="eml-header" style="padding: 20px 50px 20px 50px; background-color: #ffffff; border-bottom: 1px solid #efefef;">';
	$pending_message .= '<a href="https://university.imgtec.com">';
	$pending_message .= '<img src="' . plugins_url( '_imgtec-download-manager/_img/iup-logo-375x95.png' ) . '" alt="Imagination Technologies" style=" border: none; width: 190px;">';
	$pending_message .= '</a>';
	$pending_message .= '</td>';
	$pending_message .= '</tr>';

	$pending_message .= '</table>';
	$pending_message .= '</td>';
	$pending_message .= '</tr>';
	$pending_message .= '</table>';
	$pending_message .= '</div>';

	// send the request confirmation email to the user
	wp_mail( $iup_email, $pending_subject, $pending_message, $headers );




	// ===========================================
	// ===== ADMIN REQUEST INFORMATION EMAIL =====
	// - - - - - - - - - - - - - - - - - - - - - -
	// get current user from wpforo_profiles table
	$wpforo_profile = WPF()->db->get_row("SELECT fields FROM " . WPF()->tables->profiles . " WHERE userid = '" . $user_id . "'", ARRAY_A);
	
	$wpforo_message = $wpforo_profile;

	$message_extra = '';
	foreach ( $wpforo_message as $message => $data ) :
		$decoded  		= json_decode( $data );

		$message_extra .= '<p style="font-size:0.8rem;line-height:0.8rem;font-family:sans-serif;">University: <strong>' . $decoded->iup_university_name . '</strong></p>';
		$message_extra .= '<p style="font-size:0.8rem;line-height:0.8rem;font-family:sans-serif;">Faculty: <strong>' . $decoded->iup_department . '</strong></p>';
		$message_extra .= '<p style="font-size:0.8rem;line-height:0.8rem;font-family:sans-serif;">Country: <strong>' . $decoded->iup_country . '</strong></p>';
		$message_extra .= '<p style="font-size:0.8rem;line-height:0.8rem;font-family:sans-serif;">University Email: <strong><a href="mailto:' . $decoded->iup_email_address . '" target="_blank">' . $decoded->iup_email_address . '</a></strong></p>';
	endforeach;

	// intelligent subject line for request email
	$subject = 'Request: ';
	// loop profile to add university and country
	foreach ( $wpforo_profile as $profile_field => $data ) :
		$decoded  = json_decode( $data );

		$subject .= ucwords( $decoded->last_name ) . ', ';
		$subject .= ucwords( $decoded->first_name ) . ' / ';
		$subject .= ucwords( $decoded->iup_university_name ) . ' / ';
		$subject .= ucwords( $decoded->iup_city ) . ', ';
		$subject .= ucwords( $decoded->iup_country ) . ' / ';
	endforeach;
	$subject .= iupdm_request_table_format_ucwords( $request_purpose ) . ' / ';
	$subject .= iupdm_request_table_format_ucwords( $download_title );
	
	// ---------------------------------
	// message body for request email
	$message  = '<p style="font-size:0.8rem;line-height:0.8rem;font-family:sans-serif;"><a href="https://university.imgtec.com/forums/profile/' . $user_info->user_login . '" target="_blank">' . $user_info->user_login . '</a> has requested to download [<a href="https://university.imgtec.com/resources/download/' . iupdm_slugify_string( $download_title ) . '">' . $download_title . '</a>]</p>';
	
	$message .= '-- -- -- -- --<br>';

	$message .= $message_extra;
	$message .= '<p style="font-size:0.8rem;line-height:0.8rem;font-family:sans-serif;">Personal Email: <strong><a href="mailto:' . $user_info->user_email . '">' . $user_info->user_email . '</a></strong></p>';
	
	$message .= '-- -- -- -- --<br>';
	
	$message .= '<p style="font-size:0.9rem;line-height:1.1rem;font-family:sans-serif;font-weight:bold;">INTENDED USE...</p>';

	if ( $request_purpose == 'course-labs' ) : 
		$message .= '<p style="font-size:0.8rem;line-height:0.8rem;font-family:sans-serif;">Course: &nbsp; <strong>' . iupdm_request_table_format_ucwords( $course_name ) . '</strong></p>';
		$optional 
			? $message .= '<p style="font-size:0.8rem;line-height:0.8rem;font-family:sans-serif;">Optional or Mandatory: &nbsp; <strong>Optional</strong></p>' 
			: $message .= '<p style="font-size:0.8rem;line-height:0.8rem;font-family:sans-serif;">Optional or Mandatory: &nbsp; <strong>Mandatory</strong></p>';
		$message .= '<p style="font-size:0.8rem;line-height:0.8rem;font-family:sans-serif;">Start Date: &nbsp; <strong>' . ucfirst( $start_month ) . ' ' . $start_year . '</strong></p>';

	elseif ( $request_purpose == 'student-projects' ) :
		$message .= '<p style="font-size:0.8rem;line-height:0.8rem;font-family:sans-serif;">Project Objective: &nbsp; <strong>' . iupdm_request_table_format_ucfirst( $project_objective ) . '</strong></p>';

	else :
		$message .= '<p style="font-size:0.8rem;line-height:0.8rem;font-family:sans-serif;">Reason: &nbsp; <strong>' . iupdm_request_table_format_ucfirst( $other_reason ) . '</strong></p>';

	endif;

	$message .= '<p style="font-size:0.8rem;line-height:0.8rem;font-family:sans-serif;">Number of students: &nbsp; <strong>' . $number_students . '</strong></p>';
	$message .= '<p style="font-size:0.8rem;line-height:0.8rem;font-family:sans-serif;">Student level: &nbsp; <strong>' . iupdm_request_table_format_ucfirst( $student_level ) . '</strong></p>';

	$feedback 
		? $message .= '<p style="font-size:0.8rem;line-height:0.8rem;font-family:sans-serif;">Did this user agree to give feedback: &nbsp; <strong>Yes</strong></p>' 
		: $message .= '<p style="font-size:0.8rem;line-height:0.8rem;font-family:sans-serif;">Did this user agree to give feedback: &nbsp; <strong>No</strong></p>';

	$message .= '<p style="font-size:0.8rem;line-height:0.8rem;font-family:sans-serif;">(if the user agreed to give feedback) This is when they will provide the feedback: &nbsp; <strong>' . iupdm_request_table_format_ucwords( $feedback_when ) . '</strong></p>';
	$message .= '<p style="font-size:0.8rem;line-height:0.8rem;font-family:sans-serif;">Comments / Additional Information: &nbsp; <strong>' . iupdm_request_table_format_ucfirst( $comments ) . '</strong></p>';

	$message .= '-- -- -- -- --<br>';
	
	$message .= '<p style="font-size:0.8rem;line-height:0.8rem;font-family:sans-serif;">To approve, deny or review this request visit the [<a href="https://university.imgtec.com/wp-admin/admin.php?page=_imgtec-download-manager%2F_admin%2Fdownload-manager-admin.php" target="_blank">Download Requests Panel</a>]</p>';


	// send the request email to the administrator
	wp_mail( 'iup@imgtec.com', $subject, $message, $headers );


	wp_die();
}
