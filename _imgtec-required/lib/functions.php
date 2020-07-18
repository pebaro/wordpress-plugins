<?php
// replace names or parts of names
function imgtec_admin_string_formatting( $heading ){
	$heading = str_replace( '_', ' ', $heading );
	$heading = str_replace( '-', ' ', $heading );

	return $heading;
}
// name of the post type post editing via function imgtec_admin_string_formatting()
function imgtec_cpt_listing_name( $heading ){
	if ( strpos( $heading, 'our_' ) !== false )
		$heading = str_replace( 'our_', '', $heading );
	if ( strpos( $heading, 'gpu') !== false )
		$heading = str_replace( 'gpu', ' GPU', $heading );
	if ( strpos( $heading, 'tiers' ) !== false )
		$heading = str_replace( 'tiers', 'tier', $heading );
	if ( strpos( $heading, 'the_news' ) !== false )
		$heading = str_replace( 'the', 'in the', $heading );
	if ( strpos( $heading, 'rvr_gpu_series') !== false )
		$heading = str_replace( 'rvr_gpu_series', 'rVR Series', $heading );
	if ( strpos( $heading, 'ip-series') !== false )
		$heading = str_replace( 'ip-series', 'Product Series', $heading );
	if ( strpos( $heading, 'ip-architectures') !== false )
		$heading = str_replace( 'ip-architectures', 'Product Architectures', $heading );
	if ( strpos( $heading, 'powervr') !== false )
		$heading = str_replace( 'powervr', 'PowerVR', $heading );
	if ( strpos( $heading, 'it_') !== false )
		$heading = str_replace( 'it_', '', $heading );
	if ( strpos( $heading, 'ip-') !== false )
		$heading = str_replace( 'ip-', '', $heading );
	if ( strpos( $heading, 'product-ip') !== false )
		$heading = str_replace( 'product-ip', 'Product IPs', $heading );
	if ( strpos( $heading, 'demo-os') !== false )
		$heading = str_replace( 'demo-os', 'Operating Systems', $heading );
	if ( strpos( $heading, 'demo-apis') !== false )
		$heading = str_replace( 'demo-apis', 'Demo APIs', $heading );
	if ( strpos( $heading, 'dlm_download') !== false )
		$heading = str_replace( 'dlm_download', 'Downloads', $heading );

	return ucwords( imgtec_admin_string_formatting( $heading ) );

}
// generate the admin/edit buttons for the post type
function imgtec_cpt_listing_buttons( $post_type ){
	$buttons  =
		'<a href="edit.php?post_type='.$post_type.'">View All</a>' .
		'<a href="edit.php?post_status=publish&amp;post_type='.$post_type.'">View Published</a>' .
		'<a href="edit.php?post_status=draft&amp;post_type='.$post_type.'">View Drafts</a>' .
		'<a href="post-new.php?post_type='.$post_type.'">Add New</a>';

	return $buttons;
}
// get the taxonomies for the post type and output them as buttons
function imgtec_cpt_listing_taxonomies( $type ){
	$taxonomies = get_object_taxonomies( $type );

	if( $taxonomies ){
		echo '<h4 style="margin: 25px 0 8px !important;"><strong>Taxonomies:</strong></h4>';
		foreach ( $taxonomies as $taxonomy ) {
			echo '<a href="edit-tags.php?taxonomy='.$taxonomy
				.'&amp;post_type='.$type.'">Edit '
				.imgtec_cpt_listing_name( $taxonomy ).'</a>';
		}
	} else {
		echo '<h4 style="margin: 25px 0 8px !important;"><strong class="red">No Taxonomies Applied To This Post Type</strong></h4>';
	}
}


// generate the listings for each of the post types
function imgtec_cpt_listings( $types ){
	foreach ( $types as $type ) {
		echo '<div class="imgtec-cpt-listing"><span class="imgtec-options">';
		echo '<h3>'.imgtec_cpt_listing_name( $type ).'</h3>';
		echo imgtec_cpt_listing_buttons( $type );
		echo '</span><span class="imgtec-taxonomies">';
		// echo '<h4 style="margin: 25px 0 8px !important;"><strong>Taxonomies:</strong></h4>';
		echo imgtec_cpt_listing_taxonomies( $type );
		echo '</span></div>';
	}
}
// link to pages attached to a post type
function imgtec_post_type_page_listing( $class, $imgtec_post_type, $page ){
	$link = '<a href="' . admin_url( '/edit.php?post_type='.$imgtec_post_type.'&page='.$page ).'"
			 class="' . $class . '" >' .
			 imgtec_cpt_listing_name( $page ) . '</a>';

	echo $link;
}


# -----------------------------------
# Functions for the Admin Menu Bar
# ................................
# Create the sub-menu items in the menu from the taxonomies applied to that post type
function imgtec_menu_bar_taxonomies( $imgtec_post_type ){
	global $wp_admin_bar;

	$sub_menu_items = get_object_taxonomies( $imgtec_post_type );

	if ( $sub_menu_items ) {
		foreach ( $sub_menu_items as $sub_menu_item ) {

			$wp_admin_bar_item = $wp_admin_bar->add_menu(
				array(
					'id' 		=> $sub_menu_item,
					'parent' 	=> $imgtec_post_type,
					'title' 	=> __( imgtec_cpt_listing_name( $sub_menu_item ) ),
					'href' 		=> admin_url( '/edit-tags.php?taxonomy=' . $sub_menu_item )
				)
			);
		}
	}
}

# manually add taxonomy to admin menu bar
function imgtec_menu_bar_single_taxonomy( $section, $imgtec_taxonomy ){
	global $wp_admin_bar;

	$wp_admin_bar->add_menu(
		array(
			'id' 		=> $imgtec_taxonomy,
			'parent' 	=> $section,
			'title' 	=> __( imgtec_cpt_listing_name( $imgtec_taxonomy ) ),
			'href' 		=> admin_url( '/edit-tags.php?taxonomy=' . $imgtec_taxonomy )
		)
	);
}

# create multiple taxonomies
function imgtec_menu_bar_section_multiple_taxonomies( $parent, $section, $imgtec_taxonomies ){
	global $wp_admin_bar;

	foreach ( $imgtec_taxonomies as $taxonomy ) {
		$wp_admin_bar->add_menu(
			array(
				'id' 		=> $taxonomy,
				'parent' 	=> $section,
				'title' 	=> __( imgtec_cpt_listing_name( $taxonomy ) ),
				'href' 		=> admin_url( '/edit-tags.php?taxonomy=' . $taxonomy )
			)
		);
	}
}

# Create the post type menu links
function imgtec_menu_bar_post_types( $section, $imgtec_post_types ){
	global $wp_admin_bar;

	foreach ( $imgtec_post_types as $imgtec_post_type ) {

		$wp_admin_bar->add_menu(
			array(
				'id' 		=> $imgtec_post_type,
				'parent' 	=> $section,
				'title' 	=> __( imgtec_cpt_listing_name( $imgtec_post_type ) ),
				'href' 		=> admin_url( '/edit.php?post_type=' . $imgtec_post_type )
			)
		);
		imgtec_menu_bar_taxonomies( $imgtec_post_type );
	}
}

# Create the post type menu links minus the taxonomies as sub-menu items
function imgtec_menu_bar_post_types_minus_taxonomies( $section, $imgtec_post_types ){
	global $wp_admin_bar;

	foreach ( $imgtec_post_types as $imgtec_post_type ) {

		$wp_admin_bar->add_menu(
			array(
				'id' 		=> $imgtec_post_type,
				'parent' 	=> $section,
				'title' 	=> __( imgtec_cpt_listing_name( $imgtec_post_type ) ),
				'href' 		=> admin_url( '/edit.php?post_type=' . $imgtec_post_type )
			)
		);
	}
}

# Create the section titles, linking to the main admin page
function imgtec_menu_bar_sections( $parent, $section, $imgtec_post_types ){
	global $wp_admin_bar;

	$wp_admin_bar->add_menu(
		array(
			'id' 		=> $section,
			'parent' 	=> $parent,
			'title' 	=> __( imgtec_cpt_listing_name( $section ) ),
			'href' 		=> admin_url( '/admin.php?page=_imgtec-required/admin.php' )
		)
	);
	imgtec_menu_bar_post_types( $section, $imgtec_post_types );
}

# Create the section titles, linking to the main admin page - minus taxonomies
function imgtec_menu_bar_sections_minus_taxonomies( $parent, $section, $imgtec_post_types ){
	global $wp_admin_bar;

	$wp_admin_bar->add_menu(
		array(
			'id' 		=> $section,
			'parent' 	=> $parent,
			'title' 	=> __( imgtec_cpt_listing_name( $section ) ),
			'href' 		=> admin_url( '/admin.php?page=_imgtec-required/admin.php' )
		)
	);
	imgtec_menu_bar_post_types_minus_taxonomies( $section, $imgtec_post_types );
}

# single admin page listing
function imgtec_menu_bar_page_listing( $section, $imgtec_post_type, $page ){
	global $wp_admin_bar;

	$wp_admin_bar->add_menu(
		array(
			'id' 		=> $page,
			'parent' 	=> $section,
			'title' 	=> __( imgtec_cpt_listing_name( $page ) ),
			'href' 		=> admin_url( '/edit.php?post_type=' . $imgtec_post_type . '&page=' . $page )
		)
	);
}

# additional admin page
function imgtec_menu_bar_additional_admin_page( $section, $page ){
	global $wp_admin_bar;

	add_submenu_page(
		'_imgtec-required/admin.php',
		'Press Kit Requests',
		'Press Kit Requests',
		'manage_options',
		'/_imgtec-required/admin/press-kit-requests.php'
	);
}

# create a heading
function imgtec_menu_bar_heading( $section, $heading ){
	global $wp_admin_bar;

	$wp_admin_bar->add_menu(
		array(
			'id' 		=> $heading,
			'parent' 	=> $section,
			'title' 	=> __( '<span style="color: #b1ff6d; border-top: 1px solid #555; border-bottom: 1px solid #555; padding-top: 5px !important; padding-bottom: 5px !important; font-size: .7rem !important;">' . $heading . '</span>' )
		)
	);
}
