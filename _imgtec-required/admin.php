<?php
/**
 * Instructions:
 * To include a new custom post type on the admin page for all custom post types/taxonomies
 * simply add the name of the post type to the appropriate array
 * i.e. if it is to go in the Press Section then add the post type name to the $press array #line 26
 *
 * (admin/editing buttons will be automatically generated on the page
 *  along with any buttons for any taxonomies that are applied to that post type)
 *    --  --  --  --  --  --  --  --  --  --  --  --  --  --  --
 * To add a new Tab simply use standard bootstrap as seen below
 * then create an array for that tab and fill the array with the post type names.
 * For the tab content use the function imgtec_cpt_listings( $arra  by_name );
 * pass in the name of the array as the function argument,
 * if there is no array then place the name of the post type inside an annonymous array
 * e.g. imgtec_cpt_listings( array( 'name-of-post-type' ) );
 *    --  --  --  --  --  --  --  --  --  --  --  --  --  --  --
 * To add a link to a custom page that's tied to a custom post type,
 * use the function imgtec_post_type_page_listing( $class, $imgtec_post_type, $page );
 *    --  --  --  --  --  --  --  --  --  --  --  --  --  --  --
 * See functions.php in the lib folder if you need further info on how the functions work.
 *    --  --  --  --  --  --  --  --  --  --  --  --  --  --  --
 */

// array arguments for the listings function:
$top_level 			=   'imgtec_admin_menu_bar';
$press 				= [ 'press_releases', 'the_news', 'ecosystem_news' ];
$events 			= [ 'our_events', 'webinars', 'presentations' ];
$company 			= [ 'staff_profiles', 'partners' ];
$technology 		= [ 'it_products', 'it_product_demos', 'powervr_gpus', 'powervr_demos', 'platforms' ];
// $technology			= [ 'it_products', 'it_product_demos', 'platforms' ];
$downloads 			= [ 'dlm_download' ];
$downloads_pages 	= [ 'download-monitor-settings', 'download-monitor-reports', 'download-monitor-logs' ];
$technology_taxs 	= [ 'product-ip', 'ip-technology', 'ip-series', 'ip-architectures', 'ip-performance-options', 'ip-product-markets', 'product-tags', 'product-categories' ];
?>

<h2 class="iupdm-admin-heading">Custom Data for Imagination Technologies Corporate Website <br><span style="font-size:70%"><small style="font-size:70%;margin:0;">by</small> Imagination Technologies Digital Services Department</span> <span class="imgtec-version-number">Plugin Version  <?php echo IT_VERSION; ?> </span></h2>

<div class="container col-lg-12 imgtec-cpts">
	<ul class="tabs">
		<li class="tab-link current" data-tab="tab-pr"><h4>Press Section</h4></li>
		<li class="tab-link" data-tab="tab-events"><h4>Events Section</h4></li>
		<li class="tab-link" data-tab="tab-technology"><h4>Technology Section</h4></li>
		<li class="tab-link" data-tab="tab-company"><h4>Company Section</h4></li>
		<li class="tab-link" data-tab="tab-downloads"><h4>Downloads Section</h4></li>
	</ul>
	<div id="tab-pr" class="tab-content current admin-tab-content">
		<?php imgtec_cpt_listings( $press ); ?><!-- Press Section -->
		<div style="padding-bottom: 60px;">
			<h3 class="download-pages-heading" style="font-size:125%;color: #960000 !important;">Press Kit:</h3>
			<p>The Press Kit Requests can be found on a dedicated page where you can view all requests and change the status of each request</p>
			<button class="itpk-panel-button" onclick="location.href='/wp-admin/admin.php?page=_imgtec-required/admin/press-kit-requests.php';">Press Kit Requests</button>
		</div>
	</div>
	<div id="tab-events" class="tab-content admin-tab-content">
		<?php imgtec_cpt_listings( $events ); ?><!-- Events Section -->
	</div>
	<div id="tab-technology" class="tab-content admin-tab-content">
		<?php imgtec_cpt_listings( $technology ); ?><!-- Technology Section -->
	</div>
	<div id="tab-company" class="tab-content admin-tab-content">
		<?php imgtec_cpt_listings( $company ); ?><!-- Company Section -->
	</div>
	<div id="tab-downloads" class="tab-content admin-tab-content">
		<?php imgtec_cpt_listings( $downloads ); ?><!-- Downloads Section -->
		<div style="padding-bottom: 20px;">
			<h3 class="download-pages-heading">Download Monitor Pages:</h3>
			<?php
				foreach ($downloads_pages as $page ) {
					imgtec_post_type_page_listing( 'imgtec-cpt-page', 'dlm_download', $page );
				}
			?>
		</div>
	</div>
</div>


