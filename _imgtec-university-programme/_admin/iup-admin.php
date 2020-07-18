<?php
	// custom post types
	$iup_cpts = [ 'iup_books', 'iup_partners', 'iup_events', 'iup_platforms' ];
?>
<div id="iup-custom-admin">
	<h2 class="iupdm-admin-heading">University Programme Custom Data 
		<span class="iupdm-version-number">Version 3.1</span>
	</h2>
	<?php 

		iupdm_cpt_listings( $iup_cpts ); 
	?>
</div>