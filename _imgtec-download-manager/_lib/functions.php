<?php
// -------------------------------------
// functions for scheduled operations
// ..................................
// setup some custom schedule settings
function iupdm_cron_schedule_settings( $schedules ){
	$schedules[ 'thirtysecs' ] = array(
		'interval' 	=> 30,
		'display' 	=> __( 'Every Thirty Seconds', IUPDM_TEXTDOMAIN )
	);

	$schedules[ 'daily' ] = array(
		'interval' 	=> 86400,
		'display' 	=> __( 'Once Daily', IUPDM_TEXTDOMAIN )
	);

	return $schedules;
}
// schedule the status change if the action isn't already running
if ( ! wp_next_scheduled( 'iupdm_cron_denied_status_change' ) ) {
    wp_schedule_event( time(), 'daily', 'iupdm_cron_denied_status_change' );
}
 
// schedule the denied status change to history
function iupdm_trigger_denied_status_change() {
	global $post;
	global $wpdb;

	$timestamp 		= time();
	$timecheck 		= time() - 259200;
	$new_status 	= $_POST[ 'new_status' ];

	$denied_requests = $wpdb->get_results(
		"SELECT * FROM `" . $wpdb->prefix . "dm_requests` 
		WHERE request_status = 'denied'"
	);

	foreach ( $denied_requests as $denial ) :
		if ( $timecheck >= $denial->timestamp ) :

			$denial_id			= $denial->ID;
			$user_email 		= $denial->preferred_email;
			$username			= $denial->username;
			$download_title 	= $denial->download_title;
			$download_page 		= $denial->download_page;

			$new_status 		= 'history';
			$new_timestamp 		= time();
			// $new_timestamp 		= date( 'YmdHis', time() );

			$data 				= [ 
				'request_status' 	=> $new_status, 
				'timestamp' 		=> $new_timestamp 
			];
			$where 				= [ 
				'ID' 				=> $denial_id 
			];

			$wpdb->update( $wpdb->prefix . 'dm_requests', $data, $where );

			// email headers
			$headers  = array('Content-Type: text/html; charset=UTF-8');
				
			// subject line
			$subject  = 'New Download Request (' . iupdm_request_table_format_ucwords( $download_title ) . ')';

			// message body
			$message  = '';
			$message .= '<div style="margin: 50px 0px; background-color: #f8f8f8;">';
			$message .= '<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">';
			$message .= '<tr>';
			$message .= '<td align="center">';
			$message .= '<table cellpadding="0" cellspacing="0" border="0" style="border-radius: 10px; border: 1px solid #ddd; width: 650px;" bgcolor="#ffffff">';
			$message .= '<!--[if mso]><table border="0" cellpadding="0" cellspacing="0" width="650" align="center" bgcolor="#ffffff"><![endif]-->';

			$message .= '<tr>';
			$message .= '<td colspan="2" style="padding: 20px 50px 10px 50px; background-color: #ffffff;">';

			$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
			$message .= 'Dear ' . $username;
			$message .= '</p>';

			$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
			$message .= 'Your download request for <a href="' . $download_page . '" target="_blank">' . iupdm_request_table_format_ucwords( $download_title ) . '</a> was denied.';
			$message .= '</p>';

			$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
			$message .= 'If you wish, you can now make a further request for these materials, please ensure you have addressed the concern we have mentioned in the previous email. For example: updating the information in your profile, confirming your academic status, or giving the information on the intended use.';
			$message .= '</p>';

			$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
			$message .= 'We expect to process all requests within 2 working days and you will receive a separate email notifying you of our decision.';
			$message .= '</p>';

			$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
			$message .= 'You can contact us by emailing: <a href="mailto:iup@imgtec.com">iup@imgtec.com</a>';
			$message .= '</p>';

			$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
			$message .= 'Thank you for your patience.';
			$message .= '</p>';

			$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
			$message .= 'Best Regards,<br>';
			$message .= 'The Imagination University Programme Team';
			$message .= '</p>';

			$message .= '</td>';
			$message .= '</tr>';


			// CN translation
			$message .= '<tr>';
			$message .= '<td colspan="2" style="padding: 20px 50px 10px 50px; background-color: #ffffff;">';

			$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
			$message .= '尊敬的 ' . $username;
			$message .= '</p>';

			$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
			$message .= '您的  <a href="' . $download_page . '" target="_blank">' . iupdm_request_table_format_ucwords( $download_title ) . '</a> 下载请求先前已被拒绝。';
			$message .= '</p>';

			$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
			$message .= '您现在可以再次提交请求， 但请您务必参考我们先前和您沟通的邮件， 更新相关的信息或使用目的， 以便我们再次审核。 我们将会在2个工作日内处理您的请求， 我们将会通过另外一封邮件告知您处理结果。';
			$message .= '</p>';

			$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
			$message .= '您可以随时通过邮件联系我们: <a href="mailto:iup@imgtec.com">iup@imgtec.com</a>';
			$message .= '</p>';

			$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
			$message .= '十分感谢您的耐心等待，祝您一切顺利。';
			$message .= '</p>';

			$message .= '<p style="font-family:\'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; font-size: 14px; text-align: left; color: #333333; font-weight: 400; margin: 0px 0px 7px 0px;">';
			$message .= 'Imagination大学项目团队<br>';
			$message .= '敬上';
			$message .= '</p>';

			$message .= '</td>';
			$message .= '</tr>';


			$message .= '<tr>';
			$message .= '<td colspan="2" style="padding: 20px 50px 40px 50px; background-color: #ffffff;">';
			$message .= '<p class="fallback-font" style="font-family: \'Roboto\', Arial, \'Helvetica Neue\', Helvetica, Gotham, sans-serif; text-align: left; line-height: 22px; color: #444; font-size: 14px; font-weight: 400; margin-top: 0px;">';
			$message .= 'This email was sent to you by the <a href="https://university.imgtec.com" style="color: #000000;">Imagination University Programme</a>.';
			$message .= '</p>';
			$message .= '</td>';
			$message .= '</tr>';

			$message .= '<tr>';
			$message .= '<td colspan="2" style="padding: 20px 50px 20px 50px; background-color: #ffffff; border-bottom: 1px solid #efefef;">';
			$message .= '<a href="https://university.imgtec.com">';
			$message .= '<img src="' . plugins_url( '_imgtec-download-manager/_img/iup-logo-375x95.png' ) . '" alt="Imagination Technologies" style=" border: none; width: 190px;">';
			$message .= '</a>';
			$message .= '</td>';
			$message .= '</tr>';

			$message .= '</table>';
			$message .= '</td>';
			$message .= '</tr>';
			$message .= '</table>';
			$message .= '</div>';

			// send the approval confirmation email to the user
			wp_mail( $user_email, $subject, $message, $headers );

		endif;
	endforeach;
}

// ---------------------------------------------
// functions for data display in the backend:
// ..........................................
// replace names or parts of names
function iupdm_string_formatting( $heading ){
	$heading = str_replace( '_', ' ', $heading );
	$heading = str_replace( '-', ' ', $heading );

	return $heading;
}

function iupdm_request_table_format( $data ){
	$data = str_replace( '_', ' ', $data );
	$data = str_replace( '-', ' ', $data );
	$data = str_replace( 'phd', 'PhD', $data );

	return $data;
}

function iupdm_request_table_format_ucwords( $data ){
	$data = str_replace( '_', ' ', $data );
	$data = str_replace( '-', ' ', $data );
	$data = str_replace( 'phd', 'PhD', $data );

	return ucwords( $data );
}

function iupdm_request_table_format_ucfirst( $data ){
	$data = str_replace( '_', ' ', $data );
	$data = str_replace( '-', ' ', $data );
	$data = str_replace( 'phd', 'PhD', $data );

	return ucfirst( $data );
}

function iupdm_slugify_string( $input ){
	$output = str_replace( ' ', '-', $input );
	$output = strtolower( $output );

	return $output;
}

function iupdm_request_table_formatting_choice( $data, $format ){
	$data = str_replace( '_', ' ', $data );
	$data = str_replace( '-', ' ', $data );
	$data = str_replace( 'phd', 'PhD', $data );
	$data = str_replace( 'iup', 'IUP', $data );

	switch ( $format ){
		case 'title' :
			return $data = ucwords( $data );
			break;
		case 'sentence' :
			return $data = ucfirst( $data );
			break;
		case 'lowercase' :
			return $data = strtolower( $data );
			break;
		case 'uppercase' :
			return $data = strtoupper( $data );
			break;
	}
	return $data;
}


function imgtec_font_formatted_strings( $data, $format = null ){

	$data = strtolower( $data );

	// do the character replacements on the formatted string
	$data = str_replace( 'powervr', 'PowerVR', $data );

	$data = str_replace( 'series2nx', 'Series2NX', $data );
	$data = str_replace( 'series3nx', 'Series3NX', $data );

	$data = str_replace( 'series9xtp', 'Series9XTP', $data );
	$data = str_replace( 'series9xmp', 'Series9XMP', $data );
	$data = str_replace( 'series9xep', 'Series9XEP', $data );
	$data = str_replace( 'series9xm', 'Series9XM', $data );
	$data = str_replace( 'series9xe', 'Series9XE', $data );
	$data = str_replace( 'series9xt', 'Series9XT', $data );

	// apply the overall formatting first
	switch ( $format ){
		case 'title' :
			return $data = ucwords( $data );
			break;
		case 'sentence' :
			return $data = ucfirst( $data );
			break;
		case 'lowercase' :
			return $data = strtolower( $data );
			break;
		case 'uppercase' :
			return $data = strtoupper( $data );
			break;
	}

	// return the string with all formatting applied
	return $data;
}

// name of the post type post editing via function iupdm_string_formatting()
function iupdm_cpt_listing_name( $heading ){
	if ( strpos( $heading, 'iup_' ) !== false )
		$heading = str_replace( 'iup_', '', $heading );

	return ucwords( iupdm_string_formatting( $heading ) );
}

// generate the admin/edit buttons for the post type
function iupdm_cpt_listing_buttons( $post_type ){
	$buttons  =
		'<a href="edit.php?post_type=' . $post_type . '">View All</a>' .
		'<a href="edit.php?post_status=publish&amp;post_type=' . $post_type . '">View Published</a>' .
		'<a href="edit.php?post_status=draft&amp;post_type=' . $post_type . '">View Drafts</a>' .
		'<a href="post-new.php?post_type=' . $post_type . '">Add New</a>';

	return $buttons;
}

// get the taxonomies for the post type and output them as buttons
function iupdm_cpt_listing_taxonomies( $type ){
	$taxonomies = get_object_taxonomies( $type );

	if( $taxonomies ){
		foreach ( $taxonomies as $taxonomy ) {
			echo
				'<a href="edit-tags.php?taxonomy=' . $taxonomy . 
				'&amp;post_type=' . $type . '">' . 
				iupdm_cpt_listing_name( $taxonomy ) . '</a>';
		}
	} else {
		echo '<h5 class="none-applied">None applied to ' .
			  iupdm_cpt_listing_name( $type ) . ' post type</h5>';
	}
}

// generate the listings for each of the post types
function iupdm_cpt_listings( $types ){
	foreach ( $types as $type ) {
		echo '<div class="iupdm-cpt-listing"><span class="iupdm-options">';
		echo '<h3>' . iupdm_cpt_listing_name( $type ) . '</h3>';
		echo iupdm_cpt_listing_buttons( $type );
		echo '</span><span class="iupdm-taxonomies">';
		echo '<h4>Taxonomies</h4>';
		echo iupdm_cpt_listing_taxonomies( $type );
		echo '</span></div>';
	}
}

// link to pages attached to a post type
function iupdm_post_type_page_listing( $class, $iupdm_post_type, $page ){
	$link = '<a href="' . 
			admin_url( '/edit.php?post_type=' . $iupdm_post_type . '&page=' . $page ) . 
			'" class="' . $class . '" >' . 
			iupdm_cpt_listing_name( $page ) . 
			'</a>';

	echo $link;
}


// =====> Functions for the Admin Menu Bar <=====

// Create the sub-menu items in the menu from the taxonomies applied to that post type
function iupdm_menu_bar_taxonomies( $iupdm_post_type ){
	global $wp_admin_bar;

	$sub_menu_items = get_object_taxonomies( $iupdm_post_type );

	if ( $sub_menu_items ) {
		foreach ( $sub_menu_items as $sub_menu_item ) {

			$wp_admin_bar_item = $wp_admin_bar->add_menu(
				array(
					'id' 		=> $sub_menu_item,
					'parent' 	=> $iupdm_post_type,
					'title' 	=> __( iupdm_cpt_listing_name( $sub_menu_item ) ),
					'href' 		=> admin_url( '/edit-tags.php?taxonomy=' . $sub_menu_item )
				)
			);
		}
	}
}

// manually add taxonomy to admin menu bar
function iupdm_menu_bar_single_taxonomy( $section, $iupdm_taxonomy ){
	global $wp_admin_bar;

	$wp_admin_bar->add_menu(
		array(
			'id' 		=> $iupdm_taxonomy,
			'parent' 	=> $section,
			'title' 	=> __( iupdm_cpt_listing_name( $iupdm_taxonomy ) ),
			'href' 		=> admin_url( '/edit-tags.php?taxonomy=' . $iupdm_taxonomy )
		)
	);
}

// create multiple taxonomies
function iupdm_menu_bar_section_multiple_taxonomies( $parent, $section, $iupdm_taxonomies ){
	global $wp_admin_bar;

	foreach ( $iupdm_taxonomies as $taxonomy ) {
		$wp_admin_bar->add_menu(
			array(
				'id' 		=> $taxonomy,
				'parent' 	=> $section,
				'title' 	=> __( iupdm_cpt_listing_name( $taxonomy ) ),
				'href' 		=> admin_url( '/edit-tags.php?taxonomy=' . $taxonomy )
			)
		);
	}
}

// Create the post type menu links
function iupdm_menu_bar_post_types( $section, $iupdm_post_types ){
	global $wp_admin_bar;

	foreach ( $iupdm_post_types as $iupdm_post_type ) {

		$wp_admin_bar->add_menu(
			array(
				'id' 		=> $iupdm_post_type,
				'parent' 	=> $section,
				'title' 	=> __( iupdm_cpt_listing_name( $iupdm_post_type ) ),
				'href' 		=> admin_url( '/edit.php?post_type=' . $iupdm_post_type )
			)
		);
		iupdm_menu_bar_taxonomies( $iupdm_post_type );
	}
}

// Create the post type menu links minus the taxonomies as sub-menu items
function iupdm_menu_bar_post_types_minus_taxonomies( $section, $iupdm_post_types ){
	global $wp_admin_bar;

	foreach ( $iupdm_post_types as $iupdm_post_type ) {

		$wp_admin_bar->add_menu(
			array(
				'id' 		=> $iupdm_post_type,
				'parent' 	=> $section,
				'title' 	=> __( iupdm_cpt_listing_name( $iupdm_post_type ) ),
				'href' 		=> admin_url( '/edit.php?post_type=' . $iupdm_post_type )
			)
		);
	}
}

// Create the section titles, linking to the main admin page
function iupdm_menu_bar_sections( $parent, $section, $iupdm_post_types ){
	global $wp_admin_bar;

	$wp_admin_bar->add_menu(
		array(
			'id' 		=> $section,
			'parent' 	=> $parent,
			'title' 	=> __( iupdm_cpt_listing_name( $section ) ),
			'href' 		=> admin_url( '/admin.php?page=_imgtec-download-manager/_admin/download-manager-admin.php' )
		)
	);
	iupdm_menu_bar_post_types( $section, $iupdm_post_types );
}

// Create the section titles, linking to the main admin page - minus taxonomies
function iupdm_menu_bar_sections_minus_taxonomies( $parent, $section, $iupdm_post_types ){
	global $wp_admin_bar;

	$wp_admin_bar->add_menu(
		array(
			'id' 		=> $section,
			'parent' 	=> $parent,
			'title' 	=> __( iupdm_cpt_listing_name( $section ) ),
			'href' 		=> admin_url( '/admin.php?page=_imgtec-download-manager/_admin/download-manager-admin.php' )
		)
	);
	iupdm_menu_bar_post_types_minus_taxonomies( $section, $iupdm_post_types );
}

// single admin page listing
function iupdm_menu_bar_page_listing( $section, $iupdm_post_type, $page ){
	global $wp_admin_bar;

	$wp_admin_bar->add_menu(
		array(
			'id' 		=> $page,
			'parent' 	=> $section,
			'title' 	=> __( iupdm_cpt_listing_name( $page ) ),
			'href' 		=> admin_url( '/edit.php?post_type=' . $iupdm_post_type . '&page=' . $page )
		)
	);
}

// create a heading
function iupdm_menu_bar_heading( $section, $heading ){
	global $wp_admin_bar;

	$wp_admin_bar->add_menu(
		array(
			'id' 		=> $heading,
			'parent' 	=> $section,
			'title' 	=> __( '<span class="iupdm-green-menu-item-small">' . $heading . '</span>' )
		)
	);
}
