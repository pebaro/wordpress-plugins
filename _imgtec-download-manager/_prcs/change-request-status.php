<?php

// change request status
function iupdm_change_request_status(){
	global $post;
	global $wpdb;

	// $timestamp 	= date( 'YmdHis', time() );
	$timestamp 	= time();

	$user_id 	= $_POST[ 'user_id' ];
	$download_id 	= $_POST[ 'download_id' ];
	$new_status 	= $_POST[ 'new_status' ];
	$user_info 	= wp_get_current_user();
	$first_name 	= $user_info->user_firstname;
	$login 		= $user_info->user_login;

	$data 		= [ 'request_status' => $new_status, 'timestamp' => $timestamp ];
	$where 		= [ 'user_id' => $user_id, 'download_id' => $download_id ];

	$wpdb->update( $wpdb->prefix . 'dm_requests', $data, $where );

	$download_title = $wpdb->get_var(
		"SELECT download_title FROM `" . $wpdb->prefix . "dm_requests` 
		WHERE user_id = '" . $user_id . "' 
		AND download_id='" . $download_id . "'"
	);

	$download_page = $wpdb->get_var(
		"SELECT download_page FROM `" . $wpdb->prefix . "dm_requests` 
		WHERE user_id = '" . $user_id . "' 
		AND download_id='" . $download_id . "'"
	);

	$user_email = $wpdb->get_var(
		"SELECT preferred_email FROM `" . $wpdb->prefix . "dm_requests` 
		WHERE user_id = '" . $user_id . "' 
		AND download_id='" . $download_id . "'"
	);

	$user_reg_info = $wpdb->get_var(
		"SELECT fields FROM `" . $wpdb->prefix . "wpforo_profiles` 
		WHERE userid = '" . $user_id . "'"
	);


	// set email headers
	$headers  = array('Content-Type: text/html; charset=UTF-8');

	if ( $new_status == 'approved' ) : 
		// ====================================================
		// ===== USER REQUEST APPROVED CONFIRMATION EMAIL =====
		// ====================================================
		// subject line
		$approved_subject  = 'Your Download request has been approved (' . iupdm_request_table_format_ucwords( $download_title ) . ')';

		// message body
		$approved_message  = '<div style="margin: 50px 0px; background-color: #f8f8f8;">';
		$approved_message .= '<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">';
		$approved_message .= '<tr>';
		$approved_message .= '<td align="center">';
		$approved_message .= '<table cellpadding="0" cellspacing="0" border="0" style="border-radius: 10px; border: 1px solid #ddd; width: 650px;" bgcolor="#ffffff">';
		$approved_message .= '<!--[if mso]><table border="0" cellpadding="0" cellspacing="0" width="650" align="center" bgcolor="#ffffff"><![endif]-->';

		$approved_message .= '<tr>';
		$approved_message .= '<td colspan="2" style="padding: 20px 50px 10px 50px; background-color: #ffffff;">';

		$approved_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$approved_message .= 'Dear <a href="https://university.imgtec.com/forums/profile/' . $user_info->user_login . '" target="_blank">' . $user_info->user_login . '</a>';
		$approved_message .= '</p>';

		$approved_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$approved_message .= 'Your download request for <a href="' . $download_page . '" target="_blank">' . iupdm_request_table_format_ucwords( $download_title ) . '</a> has been approved.';
		$approved_message .= '</p>';

		$approved_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$approved_message .= 'To download the file <a href="https://cdn2.imgtec.com/university/Intro_to_mobile_graphics.zip" target="_blank">click here</a>';
		$approved_message .= '</p>';

		$approved_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$approved_message .= 'Any questions?<br>';
		$approved_message .= 'We welcome your feedback and comments on our IUP Forums:<br>';
		$approved_message .= '<a href="https://university.imgtec.com/forums/" target="_blank">https://university.imgtec.com/forums/</a>';
		$approved_message .= '</p>';

		$approved_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$approved_message .= 'There are useful resources that can be accessed here:<br>';
		$approved_message .= '<a href="https://university.imgtec.com/resources/" target="_blank">Teaching resouce page</a>';
		$approved_message .= '</p>';

		$approved_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$approved_message .= 'Please keep in touch and let us know how your project or new course develops!';
		$approved_message .= '</p>';

		$approved_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$approved_message .= 'Wishing you lots of success&hellip;<br>';
		$approved_message .= 'Best Regards,<br>';
		$approved_message .= 'The Imagination University Programme Team';
		$approved_message .= '</p>';

		$approved_message .= '</td>';
		$approved_message .= '</tr>';


		// CN translation
		$approved_message .= '<tr>';
		$approved_message .= '<td colspan="2" style="padding: 20px 50px 10px 50px; background-color: #ffffff;">';

		$approved_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$approved_message .= '尊敬的 <a href="https://university.imgtec.com/forums/profile/' . $user_info->user_login . '" target="_blank">' . $user_info->user_login . '</a>';
		$approved_message .= '</p>';

		$approved_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$approved_message .= '您的 ' . iupdm_request_table_format_ucwords( $download_title ) . ' 下载请求已通过，请点击此<a href="' . $download_page . '" target="_blank">链接</a>下载文件。';
		$approved_message .= '</p>';

		$approved_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$approved_message .= '若有任何疑问， 我们十分欢迎您在IUP论坛提供您的高见和建议:<br>';
		$approved_message .= '<a href="https://university.imgtec.com/forums/" target="_blank">https://university.imgtec.com/forums/</a>';
		$approved_message .= '</p>';

		$approved_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$approved_message .= '除此之外， 我们还有很多有价值的资源供您使用， 例如<a href="https://university.imgtec.com/resources/" target="_blank">教学视频</a>';
		$approved_message .= '</p>';

		$approved_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$approved_message .= '如果您在国内下载教材的过程中遇到了问题， 个别宽带供应商会出现下载较慢的问题， 我们建议您尝试更换至其他网络或尝试使用家用宽带下载。';
		$approved_message .= '</p>';

		$approved_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$approved_message .= '若问题还未解决， 烦请通过邮件与我们联系， 我们会在两个工作日内回复并协助解决您的问题。';
		$approved_message .= '</p>';

		$approved_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$approved_message .= '联系方式： <a href="mailto:iup@imgtec.com" target="_blank">iup@imgtec.com</a>';
		$approved_message .= '</p>';

		$approved_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$approved_message .= '我们欢迎您与我们保持联系， 并愿您一切顺利！';
		$approved_message .= '</p>';

		$approved_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$approved_message .= '即颂文绥';
		$approved_message .= '</p>';

		$approved_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$approved_message .= 'Imagination大学项目团队';
		$approved_message .= '</p>';

		$approved_message .= '</td>';
		$approved_message .= '</tr>';

		$approved_message .= '<tr>';
		$approved_message .= '<td colspan="2" class="eml-header" style="padding: 20px 50px 20px 50px; background-color: #ffffff; border-bottom: 1px solid #efefef;">';
		$approved_message .= '<a href="https://university.imgtec.com">';
		$approved_message .= '<img src="' . plugins_url( '_imgtec-download-manager/_img/iup-logo-375x95.png' ) . '" alt="Imagination Technologies" style=" border: none; width: 190px;">';
		$approved_message .= '</a>';
		$approved_message .= '</td>';
		$approved_message .= '</tr>';

		$approved_message .= '</table>';
		$approved_message .= '</td>';
		$approved_message .= '</tr>';
		$approved_message .= '</table>';
		$approved_message .= '</div>';

		// send the approval confirmation email to the user
		wp_mail( $user_email, $approved_subject, $approved_message, $headers );
		
	elseif ( $new_status == 'denied' ) :
		// ====================================================
		// ===== USER REQUEST DENIED CONFIRMATION EMAIL =====
		// ====================================================
		// subject line
		$denied_subject  = 'Your Download Request Has Been Denied (' . iupdm_request_table_format_ucwords( $download_title ) . ')';

		// message body
		$denied_message  = '<div style="margin: 50px 0px; background-color: #f8f8f8;">';
		$denied_message .= '<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">';
		$denied_message .= '<tr>';
		$denied_message .= '<td align="center">';
		$denied_message .= '<table cellpadding="0" cellspacing="0" border="0" style="border-radius: 10px; border: 1px solid #ddd; width: 650px;" bgcolor="#ffffff">';
		$denied_message .= '<!--[if mso]><table border="0" cellpadding="0" cellspacing="0" width="650" align="center" bgcolor="#ffffff"><![endif]-->';

		$denied_message .= '<tr>';
		$denied_message .= '<td colspan="2" style="padding: 20px 50px 10px 50px; background-color: #ffffff;">';

		$denied_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$denied_message .= 'Dear <a href="https://university.imgtec.com/forums/profile/' . $user_info->user_login . '" target="_blank">' . $user_info->user_login . '</a>';
		$denied_message .= '</p>';

		$denied_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$denied_message .= 'Your download request for <a href="' . $download_page . '" target="_blank">' . iupdm_request_table_format_ucwords( $download_title ) . '</a> has been denied.';
		$denied_message .= '</p>';

		$denied_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$denied_message .= 'The likely reasons include:<br>';
		$denied_message .= '<ul>';
		$denied_message .= '<li>Your registration details are incomplete</li>';
		$denied_message .= '<li>You do not appear to be in academia</li>';
		$denied_message .= '<li>You have given little or no detail about your intended use of the materials</li>';
		$denied_message .= '<li>It appears that the request is for commercial use or for a competitor</li>';
		$denied_message .= '</ul>';
		$denied_message .= '</p>';

		$denied_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$denied_message .= 'If you feel that this action is unfair, please click “reply” to this e-mail and let us know why.';
		$denied_message .= '</p>';

		$denied_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$denied_message .= 'If we agree with you, it is likely we will ask you to update your registration to ensure it is complete and truthful, and to submit a new request with sufficient detail about the intended use.';
		$denied_message .= '</p>';

		$denied_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$denied_message .= 'Best Regards,<br>';
		$denied_message .= 'The Imagination University Programme Team';
		$denied_message .= '</p>';

		$denied_message .= '</td>';
		$denied_message .= '</tr>';


		// CN translation
		$denied_message .= '<tr>';
		$denied_message .= '<td colspan="2" style="padding: 20px 50px 10px 50px; background-color: #ffffff;">';

		$denied_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$denied_message .= '尊敬的 <a href="https://university.imgtec.com/forums/profile/' . $user_info->user_login . '" target="_blank">' . $user_info->user_login . '</a>';
		$denied_message .= '</p>';

		$denied_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$denied_message .= '您的 <a href="' . $download_page . '" target="_blank">' . iupdm_request_table_format_ucwords( $download_title ) . '</a> 下载请求已被拒绝。';
		$denied_message .= '</p>';

		$denied_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$denied_message .= '被拒绝的原因可能为以下之一:<br>';
		$denied_message .= '<ul>';
		$denied_message .= '<li>您的注册信息并非完整</li>';
		$denied_message .= '<li>您被认为非学术界人士</li>';
		$denied_message .= '<li>您提供的教材使用目的缺乏关键信息</li>';
		$denied_message .= '<li>您的请求似乎用于商业用途或竞争对手</li>';
		$denied_message .= '</ul>';
		$denied_message .= '</p>';

		$denied_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$denied_message .= '如果您觉得我们做出了错误的判断， 烦请您回复此邮件并告知我们理由。';
		$denied_message .= '</p>';

		$denied_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$denied_message .= '如果我们同意您的说法， 我们很可能会请您更新您的注册信息， 以确保信息是完整和真实的， 并请您再次提交包含关键信息的下载请求。';
		$denied_message .= '</p>';

		$denied_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$denied_message .= '十分感谢您的理解， 祝您一切顺利。';
		$denied_message .= '</p>';

		$denied_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$denied_message .= 'Imagination大学项目团队<br>';
		$denied_message .= '敬上';
		$denied_message .= '</p>';

		$denied_message .= '</td>';
		$denied_message .= '</tr>';

		// logo etc
		$denied_message .= '<tr>';
		$denied_message .= '<td colspan="2" class="eml-header" style="padding: 20px 50px 20px 50px; background-color: #ffffff; border-bottom: 1px solid #efefef;">';
		$denied_message .= '<a href="https://university.imgtec.com">';
		$denied_message .= '<img src="' . plugins_url( '_imgtec-download-manager/_img/iup-logo-375x95.png' ) . '" alt="Imagination Technologies" style=" border: none; width: 190px;">';
		$denied_message .= '</a>';
		$denied_message .= '</td>';
		$denied_message .= '</tr>';

		$denied_message .= '</table>';
		$denied_message .= '</td>';
		$denied_message .= '</tr>';
		$denied_message .= '</table>';
		$denied_message .= '</div>';
	
		// send the approval confirmation email to the user
		wp_mail( $user_email, $denied_subject, $denied_message, $headers );

	elseif ( $new_status == 'review' ) :
		// ====================================================
		// ===== USER REQUEST DENIED CONFIRMATION EMAIL =====
		// ====================================================
		// subject line
		$review_subject  = 'Your Download Request is now under review by the team (' . iupdm_request_table_format_ucwords( $download_title ) . ')';

		// message body
		$review_message  = '<div style="margin: 50px 0px; background-color: #f8f8f8;">';
		$review_message .= '<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">';
		$review_message .= '<tr>';
		$review_message .= '<td align="center">';
		$review_message .= '<table cellpadding="0" cellspacing="0" border="0" style="border-radius: 10px; border: 1px solid #ddd; width: 650px;" bgcolor="#ffffff">';
		$review_message .= '<!--[if mso]><table border="0" cellpadding="0" cellspacing="0" width="650" align="center" bgcolor="#ffffff"><![endif]-->';

		$review_message .= '<tr>';
		$review_message .= '<td colspan="2" style="padding: 20px 50px 10px 50px; background-color: #ffffff;">';

		$review_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$review_message .= 'Dear <a href="https://university.imgtec.com/forums/profile/' . $user_info->user_login . '" target="_blank">' . $user_info->user_login . '</a>';
		$review_message .= '</p>';

		$review_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$review_message .= 'Your download request for <a href="' . $download_page . '" target="_blank">' . iupdm_request_table_format_ucwords( $download_title ) . '</a> is now under review by the team.';
		$review_message .= '</p>';

		$review_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$review_message .= 'We would like to make sure every download has a valid teaching or project purpose. We need to make some further checks of the details you have provided.';
		$review_message .= '</p>';

		$review_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$review_message .= 'We will get back to you within 3 working days and you will receive a separate email from us to know our decision.';
		$review_message .= '</p>';

		$review_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$review_message .= 'If you would like to add some additional information about your request and your intended use of these materials, please email: <a href="mailto:iup@imgtec.com" target="_blank">iup@imgtec.com</a>';
		$review_message .= '</p>';

		$review_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$review_message .= 'Thank you for your patience.';
		$review_message .= '</p>';

		$review_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$review_message .= 'Best Regards,<br>';
		$review_message .= 'The Imagination University Programme Team';
		$review_message .= '</p>';

		$review_message .= '</td>';
		$review_message .= '</tr>';


		// CN translation
		$review_message .= '<tr>';
		$review_message .= '<td colspan="2" style="padding: 20px 50px 10px 50px; background-color: #ffffff;">';

		$review_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$review_message .= '尊敬的 <a href="https://university.imgtec.com/forums/profile/' . $user_info->user_login . '" target="_blank">' . $user_info->user_login . '</a>';
		$review_message .= '</p>';

		$review_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$review_message .= '我们团队正在审核您的 <a href="' . $download_page . '" target="_blank">' . iupdm_request_table_format_ucwords( $download_title ) . '</a> 下载请求。';
		$review_message .= '</p>';

		$review_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$review_message .= '我们希望每一个下载都是有益于教学和项目开发， 基于此目的我们需要进一步核实您的信息。';
		$review_message .= '</p>';

		$review_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$review_message .= '我们将会在3个工作日内答复您， 您将会收到另外一封邮件告知您我们的决定。';
		$review_message .= '</p>';

		$review_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$review_message .= '如果您想告知我们更多关于您的信息或使用目的， 请通过邮件联系我们: <a href="mailto:iup@imgtec.com" target="_blank">iup@imgtec.com</a>';
		$review_message .= '</p>';

		$review_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$review_message .= '我们十分感谢您的耐心， 祝您一切顺利';
		$review_message .= '</p>';

		$review_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$review_message .= 'Imagination大学项目团队<br>';
		$review_message .= '敬上';
		$review_message .= '</p>';

		$review_message .= '</td>';
		$review_message .= '</tr>';

		// logo etc
		$review_message .= '<tr>';
		$review_message .= '<td colspan="2" class="eml-header" style="padding: 20px 50px 20px 50px; background-color: #ffffff; border-bottom: 1px solid #efefef;">';
		$review_message .= '<a href="https://university.imgtec.com">';
		$review_message .= '<img src="' . plugins_url( '_imgtec-download-manager/_img/iup-logo-375x95.png' ) . '" alt="Imagination Technologies" style=" border: none; width: 190px;">';
		$review_message .= '</a>';
		$review_message .= '</td>';
		$review_message .= '</tr>';

		$review_message .= '</table>';
		$review_message .= '</td>';
		$review_message .= '</tr>';
		$review_message .= '</table>';
		$review_message .= '</div>';
	
		// send the approval confirmation email to the user
		wp_mail( $user_email, $review_subject, $review_message, $headers );

	elseif ( $new_status == 'history' ) :
		// ====================================
		// ===== USER - NEW REQUEST EMAIL =====
		// ====================================
		// subject line
		$history_subject  = 'New Download Request (' . iupdm_request_table_format_ucwords( $download_title ) . ')';

		// message body
		$history_message  = '<div style="margin: 50px 0px; background-color: #f8f8f8;">';
		$history_message .= '<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">';
		$history_message .= '<tr>';
		$history_message .= '<td align="center">';
		$history_message .= '<table cellpadding="0" cellspacing="0" border="0" style="border-radius: 10px; border: 1px solid #ddd; width: 650px;" bgcolor="#ffffff">';
		$history_message .= '<!--[if mso]><table border="0" cellpadding="0" cellspacing="0" width="650" align="center" bgcolor="#ffffff"><![endif]-->';

		$history_message .= '<tr>';
		$history_message .= '<td colspan="2" style="padding: 20px 50px 10px 50px; background-color: #ffffff;">';

		$history_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$history_message .= 'Dear <a href="https://university.imgtec.com/forums/profile/' . $user_info->user_login . '" target="_blank">' . $user_info->user_login . '</a>';
		$history_message .= '</p>';

		$history_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$history_message .= 'Your download request for <a href="' . $download_page . '" target="_blank">' . iupdm_request_table_format_ucwords( $download_title ) . '</a> was denied.';
		$history_message .= '</p>';

		$history_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$history_message .= 'If you wish, you can now make a further request for these materials, please ensure you have addressed the concern we have mentioned in the previous email. For example: updating the information in your profile, confirming your academic status, or giving the information on the intended use.';
		$history_message .= '</p>';

		$history_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$history_message .= 'We expect to process all requests within 2 working days and you will receive a separate email notifying you of our decision.';
		$history_message .= '</p>';

		$history_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$history_message .= 'You can contact us by emailing: <a href="mailto:iup@imgtec.com">iup@imgtec.com</a>';
		$history_message .= '</p>';

		$history_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$history_message .= 'Thank you for your patience.';
		$history_message .= '</p>';

		$history_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$history_message .= 'Best Regards,<br>';
		$history_message .= 'The Imagination University Programme Team';
		$history_message .= '</p>';

		$history_message .= '</td>';
		$history_message .= '</tr>';


		// CN translation
		$history_message .= '<tr>';
		$history_message .= '<td colspan="2" style="padding: 20px 50px 10px 50px; background-color: #ffffff;">';

		$history_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$history_message .= '尊敬的 <a href="https://university.imgtec.com/forums/profile/' . $user_info->user_login . '" target="_blank">' . $user_info->user_login . '</a>';
		$history_message .= '</p>';

		$history_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$history_message .= '您的  <a href="' . $download_page . '" target="_blank">' . iupdm_request_table_format_ucwords( $download_title ) . '</a> 下载请求先前已被拒绝。';
		$history_message .= '</p>';

		$history_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$history_message .= '您现在可以再次提交请求， 但请您务必参考我们先前和您沟通的邮件， 更新相关的信息或使用目的， 以便我们再次审核。 我们将会在2个工作日内处理您的请求， 我们将会通过另外一封邮件告知您处理结果。';
		$history_message .= '</p>';

		$history_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$history_message .= '您可以随时通过邮件联系我们: <a href="mailto:iup@imgtec.com">iup@imgtec.com</a>';
		$history_message .= '</p>';

		$history_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$history_message .= '十分感谢您的耐心等待，祝您一切顺利。';
		$history_message .= '</p>';

		$history_message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
		$history_message .= 'Imagination大学项目团队<br>';
		$history_message .= '敬上';
		$history_message .= '</p>';

		$history_message .= '</td>';
		$history_message .= '</tr>';

		$history_message .= '<tr>';
		$history_message .= '<td colspan="2" style="padding: 20px 50px 20px 50px; background-color: #ffffff; border-bottom: 1px solid #efefef;">';
		$history_message .= '<a href="https://university.imgtec.com">';
		$history_message .= '<img src="' . plugins_url( '_imgtec-download-manager/_img/iup-logo-375x95.png' ) . '" alt="Imagination Technologies" style=" border: none; width: 190px;">';
		$history_message .= '</a>';
		$history_message .= '</td>';
		$history_message .= '</tr>';

		$history_message .= '</table>';
		$history_message .= '</td>';
		$history_message .= '</tr>';
		$history_message .= '</table>';
		$history_message .= '</div>';

		// send the approval confirmation email to the user
		wp_mail( $user_email, $history_subject, $history_message, $headers );

	endif;

	wp_die();
}

