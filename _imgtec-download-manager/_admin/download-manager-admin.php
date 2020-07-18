<?php
global $wpdb;

// array for custom post types
$iupdm_cpts = [ 'iup_downloads', 'iup_licenses' ];
?>
<div id="iupdm-info-accordian-container">
	<h2 class="iupdm-admin-heading">Download Manager <em style="font-size:50%"><small style="font-size:70%;margin:0 2px 0 15px;">by</small> Imagination Technologies ( Digital Services )</em> <span class="iupdm-version-number">Version 2.1</span></h2>


	<ul class="iupdm-info-accordian">
		<!----------------------->
		<!-- Custom Post Types -->
		<li class="iupdm-section-heading">
			<img class="iupdm-section-arrows" src="/wp-content/plugins/_imgtec-download-manager/_img/arrow.svg"> Downloads & Licenses
		</li>
		<li class="iupdm-section-content">
			<?php iupdm_cpt_listings( $iupdm_cpts ); ?>
		</li>
		
		<!------------------------------------------------------------------------->
		<!-- Requests Database Table Data - Pending / Approved / Denied / Review -->
		<li id="iupdm-requests-heading" class="iupdm-section-heading">
			<img class="iupdm-section-arrows iupdm-rotate" src="/wp-content/plugins/_imgtec-download-manager/_img/arrow.svg"> Download Requests
		</li>
		<li id="iupdm-requests-content" class="iupdm-section-content">
			<div class="request-status-tabs">
				<ul class="request-status-tab-links">
					<li class="request-status-active"><a href="#request-status-tab-pending">Pending</a></li>
					<li><a href="#request-status-tab-review">Review</a></li>
					<li><a href="#request-status-tab-approved">Approved</a></li>
					<li><a href="#request-status-tab-denied">Denied</a></li>
					<li><a href="#request-status-tab-archive">Archive</a></li>
				</ul>

				<div class="request-status-tab-content">
					<div id="request-status-tab-pending" class="request-status-tab request-status-active">
						<?php require_once( 'download-requests-pending-table.php' ); ?>
					</div>

					<div id="request-status-tab-review" class="request-status-tab">
						<?php require_once( 'download-request-reviews-table.php' ); ?>
					</div>

					<div id="request-status-tab-approved" class="request-status-tab">
						<?php require_once( 'download-request-approvals-table.php' ); ?>
					</div>

					<div id="request-status-tab-denied" class="request-status-tab">
						<?php require_once( 'download-request-denials-table.php' ); ?>
					</div>

					<div id="request-status-tab-archive" class="request-status-tab">
						<?php require_once( 'download-request-archive-table.php' ); ?>
					</div>
				</div>
			</div>
		</li>
		
		<!------------------------------------>
		<!-- Agreements Database Table Data -->
		<li class="iupdm-section-heading">
			<img class="iupdm-section-arrows" src="/wp-content/plugins/_imgtec-download-manager/_img/arrow.svg"> Licenses Accepted
		</li>
		<li class="iupdm-section-content">
			<?php require_once( 'licenses-agreed-table.php' ); ?>
		</li>
	
		<!---------------------------->
		<!-- Statistics / Reporting -->		
		<li id="iupdm-statistics-heading" class="iupdm-section-heading">
			<img class="iupdm-section-arrows" src="/wp-content/plugins/_imgtec-download-manager/_img/arrow.svg"> Statistics & Reporting
		</li>
		<li id="iupdm-statistics-content" class="iupdm-section-content">
			<?php require_once( 'reporting-queries.php' ); ?>

			<div class="iupdm-stats-item">
				<h4>Download Requests: <?php echo $download_requests; ?> <span><a id="iupdm-view-requests-content">view</a></span></h4>
				<hr>
				<ul>
					<li>
						<div class="col2 iupdm-orange">Requests Pending: <strong><?php echo $requests_pending; ?></strong></div>
						<div class="col2 iupdm-grey">Requests Archived: <strong><?php echo $requests_archived; ?></strong></div>
					</li>
					<li><hr></li>
					<li>Requests for Course & Labs: <strong><?php echo $course_labs; ?></strong></li>
					<li>Requests for Student Projects: <strong><?php echo $student_projects; ?></strong></li>
					<li>Requests for Other Reasons: <strong><?php echo $others; ?></strong></li>
					<li><hr></li>
					<li>
						<div class="col3 iupdm-green">Approved: <strong><?php echo $request_approvals; ?></strong></div>
						<div class="col3 iupdm-red">Denied: <strong><?php echo $request_denials; ?></strong></div>
						<div class="col3 iupdm-blue">In Review: <strong><?php echo $request_reviews; ?></strong></div>
					</li>
				</ul>
			</div>
			<div class="iupdm-stats-item">
				<h4>License Agreements</h4>
				<hr>
				<ul>
					<li><strong><?php echo $licenses_agreed; ?></strong> Licenses Agreed</li>
					<li><hr></li>
					<?php
					foreach ( $license_agreements as $agreement ) :
						$license_count = $wpdb->get_var( 
							"SELECT COUNT(*) FROM {$wpdb->prefix}dm_agreements WHERE license_id='" . $agreement->license_id . "'"
						);
						$license_counts[] 	= $license_count;
						$license_ids[] 		= $agreement->license_id;						
					endforeach;

					if ( $license_count > 1 ) :
						echo '<li><strong>' . $license_count . '</strong> Users Have Agreed To: ' . ucwords( $agreement->license_title ) . '</li>';
					else :
						echo '<li><strong>' . $license_count . '</strong> User Has Agreed To: ' . ucwords( $agreement->license_title ) . '</li>';
					endif;
					?>
				</ul>
				<h4></h4>
			</div>
		</li>
	</ul>
</div>
<script>
( ( $ ) => {
	$( document ).ready( function(){
		// ========================
		// ===== REFRESH PAGE =====
		// ------------------------
		// const refresh = document.getElementById( 'iupdm-admin-refresh' );

		// refresh.addEventListener( 'click', (e) => {
		// 	location.reload();
		// } );				
	} );
} )( jQuery );
</script>