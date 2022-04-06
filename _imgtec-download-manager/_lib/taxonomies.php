<?php

function iupdm_download_manager_taxononomies(){

	// download categories
	$labels_dm_categories = [
		'name'              	=> _x( 'Download Categories', 'taxonomy general name' ),
		'singular_name'     	=> _x( 'Download Categories', 'taxonomy singular name' ),
		'search_items'      	=> __( 'Search Download Categories' ),
		'all_items'         	=> __( 'All Download Categories' ),
		'parent_item'       	=> __( 'Parent Download Category' ),
		'parent_item_colon' 	=> __( 'Parent Download Category:' ),
		'edit_item'         	=> __( 'Edit Download Category' ),
		'update_item'       	=> __( 'Update Download Category' ),
		'add_new_item'      	=> __( 'Add New Download Category' ),
		'new_item_name'     	=> __( 'New Download Category Name' ),
		'menu_name'         	=> __( 'Categories (DM)' )
	];
	$args_dm_categories = [
		'hierarchical'      	=> true,
		'labels'            	=> $labels_dm_categories,
		'public'            	=> false,
		'show_ui'           	=> true,
		'show_admin_column' 	=> true,
		'query_var'         	=> true,
		'show_in_rest' 		=> true,
		'rest_base' 		=> 'download_categories',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'rewrite'           	=> [ 'slug' => 'download-categories' ]
	];
	register_taxonomy(
		'download_categories', [ 'iup_downloads' ], $args_dm_categories
	);

}
