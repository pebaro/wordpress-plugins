<table id="itpk-rt-pending-data" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th style="width:8%;padding-left:5px;">IP Address</th>
			<th style="width:8%;">Requested</th>
			<th style="width:10%;">Name</th>
			<th style="width:20%;">Email</th>
			<th style="width:15%;">Company</th>
			<th style="width:10%;">Message</th>
			<th style="width:6%;">Status</th>
			<th style="width:10%;">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$pendingRequestsQuery = $wpdb->get_results(
			"SELECT * FROM " . $wpdb->prefix . "presskit_requests WHERE kit_request='pending'"
		);

		foreach ( $pendingRequestsQuery as $result ) :

			$formatted_request_message  = '';
			$formatted_request_message .= '<p class="itpk-modal-info"><strong>Full Name:</strong> ' . ucwords( $result->first_name ) . ' ' . ucwords( $result->last_name ) . '</p>';
			$formatted_request_message .= '<p class="itpk-modal-info"><strong>Email Address:</strong> <a href="' . $result->email_address . '">' . $result->email_address . '</a></p>';
			$formatted_request_message .= '<p class="itpk-modal-info"><strong>Company:</strong> ' . ucwords( $result->company ) . '</p>';
			$formatted_request_message .= '<br><p class="itpk-modal-info"><strong>Message:</strong> ' . ucfirst( $result->message ) . '</p>';


			// create select field for actions
			$actions_select  = '<form class="itpk-rt-status-change-container">';
			$actions_select .= '<select data-firstname="' . $result->first_name . '" data-emailaddress="' . $result->email_address . '" data-requestid="' . $result->ID . '" class="itpk-rt-actions-select">';
			$actions_select .= '<option value="">change status...</option>';
			$actions_select .= '<option value="approved">Approve Request</option>';
			$actions_select .= '<option value="denied">Deny Request</option>';
			$actions_select .= '</select>';
			$actions_select .= '</form>';
			

			echo '<tr>';
			echo '<td style="padding-left:5px;">' . $result->user_ip . '</td>';
			echo '<td>' . date( 'd/m/Y  H:i:s', $result->timestamp ) . '</td>';
			echo '<td>' . ucwords( $result->first_name ) . ' ' . ucwords( $result->last_name ) . '</td>';
			echo '<td><a class="itpk-rt-link" href="mailto:' . $result->email_address . '">' . $result->email_address . '</a></td>';
			echo '<td>' . ucwords( $result->company ) . '</td>';
			echo '<td class="request_info">';
			echo '<a href="#" class="itpk-open-modal itpk-rt-link">';
			echo 'Request Information';
			echo '</a>';
			echo '<div class="itpk-modal">';
			echo '<div class="itpk-modal-content">';
			echo '<span class="itpk-modal-close">&times;</span>';
			echo '<h2><strong>Request Status:</strong> ' . ucfirst( $result->kit_request ) . '</h2>';
			echo '<p><strong>Request Made:</strong> ' . date( 'd/m/Y  H:i:s', $result->timestamp ) . '</p>';
			echo '<hr>';
			echo '<div class="itpk-modal-info-container">';
			echo $formatted_request_message;
			echo '<p>';
			echo '<strong>Change Request Status:</strong><br>';
			echo $actions_select;
			echo '</p>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</td>';
			echo '<td>' . ucfirst( $result->kit_request ) . '</td>';
			echo '<td>' . $actions_select . '</td>';
			echo '</tr>';
		endforeach;
		?>
	</tbody>
</table>