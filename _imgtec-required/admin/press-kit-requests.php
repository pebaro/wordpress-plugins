<!-- Press Kit Requests - Pending / Approved / Denied / Review -->
<h2 class="it-admin-heading">Press Kit Requests</h2>

<div id="it-requests-content" class="it-section-content">
	<div class="request-status-tabs">
		<ul class="request-status-tab-links"><!-- TABS -->
			<li class="request-status-active"><a href="#request-status-tab-pending">Pending</a></li>
			<li><a href="#request-status-tab-approved">Approved</a></li>
			<li><a href="#request-status-tab-denied">Denied</a></li>
		</ul>

		<div class="request-status-tab-content"><!-- PANELS -->
			<div id="request-status-tab-pending" class="request-status-tab request-status-active">
				<?php require_once( 'press-kit-requests-pending.php' ); ?>
			</div>

			<div id="request-status-tab-approved" class="request-status-tab">
				<?php require_once( 'press-kit-requests-approved.php' ); ?>
			</div>

			<div id="request-status-tab-denied" class="request-status-tab">
				<?php require_once( 'press-kit-requests-denied.php' ); ?>
			</div>
		</div>
	</div>
</div>