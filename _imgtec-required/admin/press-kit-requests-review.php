<table id="itpk-rt-pending-data" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th style="width:10%;padding-left:5px;">IP Address</th>
			<th style="width:10%;">Requested</th>
			<th style="width:10%;">Name</th>
			<th style="width:20%;">Email</th>
			<th style="width:15%;">Company</th>
			<th style="width:10%;">Message</th>
			<th style="width:10%;">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$reviewRequestsQuery = $wpdb->get_results(
			"SELECT * FROM " . $wpdb->prefix . "presskit_requests WHERE kit_request='review'"
		);
		// $reviewRequestsQuery 		= "SELECT * FROM " . $wpdb->prefix . "presskit_requests WHERE kit_request='pending'";
		// $totalPendingRequestsQuery = "SELECT COUNT(1) FROM (${pendingRequestsQuery}) AS combined_table";
		// $totalPendingRequests 		= $wpdb->get_var( $totalPendingRequestsQuery );
		// $requestsPendingPerPage 	= 2;
		// $requestsPendingPage 		= isset( $_GET[ 'cpage' ] ) ? abs( ( int ) $_GET[ 'cpage' ] ) : 1;
		// $requestsPendingOffset 	= ( $requetsPendingPage * $requestsPendingPerPage ) - $requestsPendingPerPage;
		// $requestsPendingResult 	= $wpdb->get_results( $reviewRequestsQuery . " ORDER BY timestamp DESC LIMIT ${requestsPendingOffset}, ${requestsPendingPerPage}" );
		// $totalPendingRequestsPages = ceil( $totalPendingRequests / $requestsPendingPerPage );

		// $requestsPendingPageHTML 	= '';

		// if ( $totalPendingRequestsPages > 1 ){
		// 	$requestsPendingPageHTML = '<div id="itpk-pending-requests-pagination"><span>Requests Page ' . $requestsPendingPage . ' of ' . $totalPendingRequestsPages . '</span> &nbsp;&nbsp; ' . paginate_links( 
		// 		array(
		// 			'base' 			=> add_query_arg( 'cpage', '%#%' ),
		// 			'format' 		=> '',
		// 			'prev_text' 	=> __('&laquo;'),
		// 			'next_text' 	=> __('&raquo;'),
		// 			'total' 		=> $totalPendingRequestsPages,
		// 			'current' 		=> $requestsPendingPage
		// 		)
		// 	) . '</div>';
		// }
		// echo $requestsPendingPageHTML;

		foreach ( $reviewRequestsQuery as $result ) :
			$request_message = [];

			if ( $result->first_name && $result->last_name ) {
				array_push( 
					$request_message, '<p class="itpk-modal-info"><strong>Full Name:</strong>' . ucwords( $result->first_name ) . ' ' . ucwords( $result->last_name ) . '</p>'
				);
			}
			if ( $result->email_address ) {
				array_push( 
					$request_message, '<p class="itpk-modal-info"><strong>Email Address:</strong> <a href="' . $result->email_address . '">' . $result->email_address . '</a></p>'
				);
			}
			if ( $result->company ) {
				array_push( 
					$request_message, '<p class="itpk-modal-info"><strong>Company:</strong>' . ucwords( $result->company ) . '</p>'
				);
			}
			if ( $result->message ) {
				array_push( 
					$request_message, '<br><p class="itpk-modal-info"><strong>Message:</strong><br>' . ucfirst( $result->message ) . '</p>'
				);
			}

			$formatted_request_message  = '';
			foreach ( $request_message as $message ) :
				$formatted_request_message .= $message;
			endforeach;


			// create select field for actions
			$actions_select  = '<form id="status-change-' . $result->ID . '">';
			$actions_select .= 		'<select data-emailaddress="' . $result->user_id . '" data-requestid="' . $result->ID . '" class="itpk-rt-actions-select">';
			$actions_select .= 			'<option value="">change status...</option>';
			$actions_select .= 			'<option value="approved">Approve Request</option>';
			$actions_select .= 			'<option value="denied">Deny Request</option>';
			$actions_select .= 			'<option value="review">Review With Team</option>';
			$actions_select .= 		'</select>';
			$actions_select .= '</form>';
			

			echo '<tr>';
			echo 	'<td style="padding-left:5px;">' . $result->user_ip . '</td>';
			echo 	'<td>' . date( 'd/m/Y  H:i:s', $result->timestamp ) . '</td>';
			echo 	'<td>' . ucwords( $result->first_name ) . ' ' . ucwords( $result->last_name ) . '</td>';
			echo 	'<td><a class="itpk-rt-link" href="mailto:' . $result->email_address . '">' . $result->email_address . '</a></td>';
			echo 	'<td>' . ucwords( $result->company ) . '</td>';
			
			echo 	'<td class="request_message">';
			echo 		'<a href="#" class="itpk-open-modal itpk-rt-link">';
			echo 			'Request Information';
			echo 		'</a>';
			echo 		'<div class="itpk-modal">';
			echo 			'<div class="itpk-modal-content">';
			echo 				'<span class="itpk-modal-close">&times;</span>';
			echo 				'<h2><strong>Request Status:</strong> ' . ucfirst( $result->kit_request ) . '</h2>';
			echo 				'<p><strong>Request Made:</strong> ' . date( 'd/m/Y  H:i:s', $result->timestamp ) . '</p>';
			echo 				'<hr>';
			echo 				'<div class="itpk-modal-info-container">';
			echo 					$formatted_request_message;
			echo 					'<p>';
			echo 						'<strong>Change Request Status:</strong><br>';
			echo 						$actions_select;
			echo 					'</p>';
			echo 				'</div>';
			echo 			'</div>';
			echo 		'</div>';
			echo 	'</td>';
			echo 	'<td>' . $actions_select . '</td>';
			echo '</tr>';
		endforeach;
		?>
	</tbody>
</table>