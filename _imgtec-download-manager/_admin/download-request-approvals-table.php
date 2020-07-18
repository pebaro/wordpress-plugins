<table id="iupdm-rt-approvals-data" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th style="width:7%;padding-left:5px;">IP Address</th>
			<th style="width:8%;">Approved</th>
			<th style="width:10%;">User</th>
			<th style="width:20%;">Email</th>
			<th style="width:28%;">Download Title</th>
			<th style="width:8%;">Request Info</th>
			<th style="width:8%;">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$requestsQuery 		= "SELECT * FROM " . $wpdb->prefix . "dm_requests WHERE request_status='approved'";
		$totalRequestsQuery = "SELECT COUNT(1) FROM (${requestsQuery}) AS combined_table";
		$totalRequests 		= $wpdb->get_var( $totalRequestsQuery );
		$requestsPerPage 	= 12;
		$requestsPage 		= isset( $_GET[ 'cpage' ] ) ? abs( ( int ) $_GET[ 'cpage' ] ) : 1;
		$requestsOffset 	= ( $requestsPage * $requestsPerPage ) - $requestsPerPage;
		$requestsResult 	= $wpdb->get_results( $requestsQuery . " ORDER BY timestamp DESC LIMIT ${requestsOffset}, ${requestsPerPage}" );
		$totalRequestsPages = ceil( $totalRequests / $requestsPerPage );

		$requestsPageHTML 	= '';

		if ( $totalRequestsPages > 1 ){
			$requestsPageHTML = '<div id="iupdm-approved-requests-pagination"><span>Approvals Page ' . $requestsPage . ' of ' . $totalRequestsPages . '</span> &nbsp;&nbsp; ' . paginate_links( 
				array(
					'base' 			=> add_query_arg( 'cpage', '%#%' ),
					'format' 		=> '',
					'prev_text' 	=> __('&laquo;'),
					'next_text' 	=> __('&raquo;'),
					'total' 		=> $totalRequestsPages,
					'current' 		=> $requestsPage
				)
			) . '</div>';
		}
		echo $requestsPageHTML;

		foreach ( $requestsResult as $result ) :
			$request_info = [];

			if ( $result->request_purpose ) {
				array_push( 
					$request_info, '<span class="iupdm-rt-questions">Request Purpose:</span>' . iupdm_request_table_format_ucwords( $result->request_purpose )
				);
			}
			if ( $result->course_name != '' ) {
				array_push( 
					$request_info, '<span class="iupdm-rt-questions">Course Name:</span>' . iupdm_request_table_format_ucwords( $result->course_name )
				);
			}
			if ( $result->project_objective != '' ) {
				array_push( 
					$request_info, '<span class="iupdm-rt-questions">Project Objective:</span>' . iupdm_request_table_format_ucfirst( $result->project_objective )
				);
			}
			if ( $result->other_reason != '' ) {
				array_push( 
					$request_info, '<span class="iupdm-rt-questions">Other Reason:</span>' . iupdm_request_table_format_ucfirst( $result->other_reason )
				);
			}
			if ( $result->optional != '' ) {
				array_push( 
					$request_info, '<span class="iupdm-rt-questions">Optional:</span>' . iupdm_request_table_format_ucfirst( $result->optional )
				);
			}
			if ( $result->start_month != null && $result->start_year != null ) {
				array_push( 
					$request_info, '<span class="iupdm-rt-questions">Start Date:</span>' . iupdm_request_table_format( $result->start_month ) . '&nbsp;&nbsp;' . $result->start_year
				);
			}
			if ( $result->number_of_students != 0 ) {
				array_push( 
					$request_info, '<span class="iupdm-rt-questions">No. Students:</span>' . $result->number_of_students
				);
			}
			if ( $result->student_level != null ) {
				array_push( 
					$request_info, '<span class="iupdm-rt-questions">Student Level:</span>' . iupdm_request_table_format_ucfirst( $result->student_level )
				);
			}
			if ( $result->feedback != '' ) {
				array_push( 
					$request_info, '<span class="iupdm-rt-questions">Feedback Agreed:</span>' . iupdm_request_table_format_ucfirst( $result->feedback )
				);
			}
			if ( $result->feedback_when != '' ) {
				array_push( 
					$request_info, '<span class="iupdm-rt-questions">Feedback When:</span>' . iupdm_request_table_format_ucfirst( $result->feedback_when )
				);
			}
			if ( $result->comments != '' ) {
				array_push( 
					$request_info, '<span class="iupdm-rt-questions">Comments / Info:</span>' . iupdm_request_table_format_ucfirst( $result->comments )
				);
			}

			$formatted_request_info  = '';
			foreach ( $request_info as $question_and_answer ) :
				$formatted_request_info .= '<p class="iupdm-rt-q-and-a">' . $question_and_answer . '</p>';
			endforeach;

			// create select field for actions
			$actions_select  = '<form id="status-change-' . $result->download_id . '">';
			$actions_select .= 		'<select data-userid="' . $result->user_id . '" data-downloadid="' . $result->download_id . '" class="iupdm-rt-actions-select">';
			$actions_select .= 			'<option value="">change status...</option>';
			$actions_select .= 			'<option value="approved">Approve Request</option>';
			$actions_select .= 			'<option value="denied">Deny Request</option>';
			$actions_select .= 			'<option value="review">Review With Team</option>';
			$actions_select .= 		'</select>';
			$actions_select .= '</form>';

			echo '<tr>';
			echo 	'<td style="padding-left:5px;">' . $result->user_ip . '</td>';
			echo 	'<td>' . date( 'd/m/Y  H:i:s', $result->timestamp ) . '</td>';
			echo 	'<td>' . $result->username . '</td>';
			echo 	'<td><a class="iupdm-rt-link" href="mailto:' . $result->preferred_email . '">' . $result->preferred_email . '</a></td>';
			echo 	'<td class="titletest">' . $result->download_title;
			echo 	' &nbsp;&nbsp; <a class="iupdm-rt-link" href="' . $result->download_url . '" target="_blank">Package<img src="' . plugins_url( '_imgtec-download-manager/_img/download-arrow.svg' ) . '" class="iupdm-view-icon"></a></td>';
			echo 	'<td class="request_info">';
			echo 		'<a href="#" class="iupdm-open-modal iupdm-rt-link">';
			echo 			'Request Information<img src="';
			echo 			plugins_url( '_imgtec-download-manager/_img/view.svg' );
			echo 			'" class="iupdm-view-icon">';
			echo 		'</a>';
			echo 		'<div class="iupdm-modal">';
			echo 			'<div class="iupdm-modal-content">';
			echo 				'<span class="iupdm-modal-close">&times;</span>';
			echo 				'<h2><strong>Request Status:</strong> ' . iupdm_request_table_format_ucfirst( $result->request_status ) . '</h2>';
			echo 				'<hr>';
			echo 				'<div class="iupdm-modal-user-info">';
			echo 					'<ul>';
			echo 						'<li><strong>Download:</strong> ' . $result->download_title . '</li>';
			echo 						'<li><strong>User:</strong> ' . $result->username . '</li>';
			echo 						'<li><strong>User Email:</strong> ' . $result->preferred_email . '</li>';
			echo 						'<li><strong>Status Changed:</strong> ' . date( 'd/m/Y  H:i:s', $result->timestamp ) . '</li>';
			echo 					'</ul>';
			echo 				'</div>';
			echo 				'<div class="iupdm-modal-request-info">';
			echo 					$formatted_request_info . '<br>';
			echo 					'<p>';
			echo 						'<strong>Change Request Status:</strong><br>';
			echo 						$actions_select;
			echo 					'</p>';
			echo 				'</div>';
			echo 				'<hr>';
			echo 			'</div>';
			echo 		'</div>';
			echo 	'</td>';
			echo 	'<td>' . $actions_select . '</td>';
			echo '</tr>';
		endforeach;
		?>
	</tbody>
</table>