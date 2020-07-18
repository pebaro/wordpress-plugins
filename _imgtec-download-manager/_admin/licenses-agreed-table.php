<table id="iupdm-rt-agreements-data" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th style="width:10%;padding-left:5px;">User</th>
			<th style="width:15%;">Email</th>
			<th style="width:20%;">License Agreement</th>
			<th style="width:30%;">License URL</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$agreementsQuery 		= $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "dm_agreements");

		// $agreementsQuery 		= "SELECT * FROM " . $wpdb->prefix . "dm_agreements";
		// $totalAgreementsQuery 	= "SELECT COUNT(1) FROM (${agreementsQuery}) AS combined_table";
		// $totalAgreements 		= $wpdb->get_var( $totalAgreementsQuery );
		// $agreementsPerPage 		= 2;
		// $agreementsPage 		= isset( $_GET[ 'cpage' ] ) ? abs( ( int ) $_GET[ 'cpage' ] ) : 1;
		// $agreementsOffset 		= ( $agreementsPage * $agreementsPerPage ) - $agreementsPerPage;
		// $agreementsResult 		= $wpdb->get_results( $agreementsQuery . " ORDER BY timestamp DESC LIMIT ${agreementsOffset}, ${agreementsPerPage}" );
		// $totalAgreementsPages 	= ceil( $totalAgreements / $agreementsPerPage );

		// $agreementsPageHTML 	= '';

		// if ( $totalAgreementsPages > 1 ){
		// 	$agreementsPageHTML = '<div id="iupdm-review-requests-pagination"><span>Agreements Page ' . $agreementsPage . ' of ' . $totalAgreementsPages . '</span> &nbsp;&nbsp; ' . paginate_links( 
		// 		array(
		// 			'base' 			=> add_query_arg( 'cpage', '%#%' ),
		// 			'format' 		=> '',
		// 			'prev_text' 	=> __('&laquo;'),
		// 			'next_text' 	=> __('&raquo;'),
		// 			'total' 		=> $totalAgreementsPages,
		// 			'current' 		=> $agreementsPage
		// 		)
		// 	) . '</div>';
		// }
		// echo $agreementsPageHTML;

		foreach ( $agreementsQuery as $result ) :
			echo '<tr>';
				echo '<td style="padding-left:5px;">' . $result->username . '</td>';
				echo '<td><a class="iupdm-rt-link" href="mailto:' . $result->preferred_email . '">' . $result->preferred_email . '</a></td>';
				echo '<td>' . $result->license_title . '</td>';
				echo '<td><a class="iupdm-rt-link" href="' . $result->license_url . '" target="_blank">' . $result->license_url . '</a></td>';
			echo '</tr>';
		endforeach;
		?>
	</tbody>
</table>
