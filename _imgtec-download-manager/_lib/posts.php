<?php
/*
 * Custom Post Types for imgtec.com
 */

function iupdm_download_manager_cpts_init(){

	// downloads
	register_post_type( 'iup_downloads', [
		'labels' 		=> [
			'name'			=> 'Downloads',
			'singular_name'		=> 'Download',
			'add_new'		=> 'Add New Download',
			'add_new_item'		=> 'Add New Download',
			'edit_item'		=> 'Edit Download',
			'new_item'		=> 'New Download',
			'all_items'		=> 'All Downloads',
			'view_item'		=> 'View Download',
			'search_items'		=> 'Search Downloads',
			'not_found'		=> 'No Downloads found',
			'not_found_in_trash'	=> 'No Downloads found in Trash',
			'menu_name'		=> 'Downloads',
		],
		'publicly_queryable'	=> true,
		'query_var' 		=> true,
		'show_in_rest' 		=> true,
		'rest_base' 		=> 'iup_downloads',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'public' 		=> true,
		'capability_type' 	=> 'post',
		'has_archive' 		=> 'resources/downloads',
		'rewrite' 		=> [ 'slug' => 'resources/download' ],
		'supports'		=> [ 'title' ],
		// 'taxonomies' 	=> [ 'post_tag' ]
	] );


	// licenses
	register_post_type( 'iup_licenses', [
		'labels' 		=> [
			'name'			=> 'Licenses',
			'singular_name'		=> 'License',
			'add_new'		=> 'Add New License',
			'add_new_item'		=> 'Add New License',
			'edit_item'		=> 'Edit License',
			'new_item'		=> 'New License',
			'all_items'		=> 'All Licenses',
			'view_item'		=> 'View License',
			'search_items'		=> 'Search Licenses',
			'not_found'		=> 'No Licenses found',
			'not_found_in_trash'	=> 'No Licenses found in Trash',
			'menu_name'		=> 'Licenses',
		],
		'publicly_queryable'	=> true,
		'query_var' 		=> true,
		'show_in_rest' 		=> true,
		'rest_base' 		=> 'iup_licenses',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'public' 		=> true,
		'capability_type' 	=> 'post',
		'has_archive' 		=> false,
		'rewrite' 		=> [ 'slug' => 'license-agreement' ],
		'supports'		=> [ 'title' ]
	] );
}
