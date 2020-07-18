<?php
/*
 * Custom Post Types for imgtec.com
 */

function create_imgtec_post_types(){

	// Staff Profiles
	register_post_type( 'staff_profiles',
		array(
			'labels' 				=> array(
				'name'					=> 'Staff Profiles',
				'singular_name' 		=> 'Staff Profile',
				'add_new'				=> 'Add Staff Profile',
				'add_new_item'			=> 'Add New Staff Profile',
				'edit_item'				=> 'Edit Staff Profile',
				'new_item'				=> 'New Staff Profile',
				'all_items'				=> 'All Staff Profiles',
				'view_item'				=> 'View Staff Profile',
				'search_items'			=> 'Search Staff Profiles',
				'not_found'				=> 'No Staff Profiles found',
				'not_found_in_trash'	=> 'No Staff Profiles found in Trash',
				'parent_item_colon'		=> '',
				'menu_name'				=> 'Staff Profiles',
				'publicly_queryable'	=> true,
			),
			'public' 				=> true,
			'has_archive' 			=> true,
			'rewrite' 				=> array(
				'slug' => 'company/staff-profiles', 'with_front' => false
			),
			'supports'				=> array(
				'title', 'editor', 'author', 'excerpt', 'thumbnail'
			)
		)
	);

	// // Location
	// register_post_type( 'locations',
	// 	array(
	// 		'labels' 				=> array(
	// 			'name'					=> 'Locations',
	// 			'singular_name' 		=> 'Location',
	// 			'add_new'				=> 'Add Location',
	// 			'add_new_item'			=> 'Add New Location',
	// 			'edit_item'				=> 'Edit Location',
	// 			'new_item'				=> 'New Location',
	// 			'all_items'				=> 'All Locations',
	// 			'view_item'				=> 'View Location',
	// 			'search_items'			=> 'Search Locations',
	// 			'not_found'				=> 'No Locations found',
	// 			'not_found_in_trash'	=> 'No Locations found in Trash',
	// 			'parent_item_colon'		=> '',
	// 			'menu_name'				=> 'Locations',
	// 			'publicly_queryable'	=> true,
	// 		),
	// 		'public' 				=> true,
	// 		'has_archive' 			=> true,
	// 		'rewrite' 				=> array(
	// 			'slug' => 'company/locations', 'with_front' => false
	// 		),
	// 		'supports'				=> array(
	// 			'title', 'editor', 'author', 'excerpt'
	// 		)
	// 	)
	// );

	// Press Releases
	register_post_type( 'press_releases',
		array(
			'labels' 				=> array(
				'name'					=> 'Press Releases',
				'singular_name' 		=> 'Press Release',
				'add_new'				=> 'Add Release',
				'add_new_item'			=> 'Add New Release',
				'edit_item'				=> 'Edit Release',
				'new_item'				=> 'New Release',
				'all_items'				=> 'All Press Releases',
				'view_item'				=> 'View Release',
				'search_items'			=> 'Search Press Releases',
				'not_found'				=> 'No Press Releases found',
				'not_found_in_trash'	=> 'No Press Releases found in Trash',
				'parent_item_colon'		=> '',
				'menu_name'				=> 'Press Releases',
				'publicly_queryable'	=> true,
			),
			'public' 				=> true,
			'has_archive' 			=> false,
			'rewrite' 				=> array(
				'slug' => 'news/press-release', 'with_front' => false
			),
			'supports'				=> array(
				'title', 'editor', 'author', 'excerpt', 'thumbnail'
			)
		)
	);

	// Events
	register_post_type( 'our_events',
		array(
			'labels' 				=> array(
				'name'					=> 'Events',
				'singular_name' 		=> 'Event',
				'add_new'				=> 'Add Event',
				'add_new_item'			=> 'Add New Event',
				'edit_item'				=> 'Edit Event',
				'new_item'				=> 'New Event',
				'all_items'				=> 'All Events',
				'view_item'				=> 'View Event',
				'search_items'			=> 'Search Events',
				'not_found'				=> 'No Events found',
				'not_found_in_trash'	=> 'No Events found in Trash',
				'parent_item_colon'		=> '',
				'menu_name'				=> 'Events',
				'publicly_queryable'	=> true,
			),
			'public' 				=> true,
			'has_archive' 			=> false,
			'rewrite' 				=> array(
				'slug' => 'event', 'with_front' => false
			),
			'supports'				=> array(
				'revisions', 'title', 'editor', 'thumbnail', 'author'
			)
		)
	);

	// Webinars
	register_post_type( 'webinars',
		array(
			'labels' 				=> array(
				'name'					=> 'Webinars',
				'singular_name' 		=> 'Webinar',
				'add_new'				=> 'Add Webinar',
				'add_new_item'			=> 'Add New Webinar',
				'edit_item'				=> 'Edit Webinar',
				'new_item'				=> 'New Webinar',
				'all_items'				=> 'All Webinars',
				'view_item'				=> 'View Webinar',
				'search_items'			=> 'Search Webinars',
				'not_found'				=> 'No Webinars found',
				'not_found_in_trash'	=> 'No Webinars found in Trash',
				'parent_item_colon'		=> '',
				'menu_name'				=> 'Webinars',
				'publicly_queryable'	=> true,
			),
			'public' 				=> true,
			'has_archive' 			=> false,
			'rewrite' 				=> array(
				'slug' => 'webinar', 'with_front' => false
			),
			'supports'				=> array(
				'revisions', 'title', 'editor', 'thumbnail', 'author'
			)
		)
	);

	// Presentations
	register_post_type( 'presentations',
		array(
			'labels' 				=> array(
				'name'					=> 'Presentations',
				'singular_name' 		=> 'Presentation',
				'add_new'				=> 'Add Presentation',
				'add_new_item'			=> 'Add New Presentation',
				'edit_item'				=> 'Edit Presentation',
				'new_item'				=> 'New Presentation',
				'all_items'				=> 'All Presentations',
				'view_item'				=> 'View Presentation',
				'search_items'			=> 'Search Presentations',
				'not_found'				=> 'No Presentations found',
				'not_found_in_trash'	=> 'No Presentations found in Trash',
				'parent_item_colon'		=> '',
				'menu_name'				=> 'Presentations',
				'publicly_queryable'	=> true,
			),
			'public' 				=> true,
			'has_archive' 			=> false,
			'rewrite' 				=> array(
				'slug' => 'presentation', 'with_front' => false
			),
			'supports'				=> array(
				'revisions', 'title', 'editor', 'thumbnail', 'author'
			)
		)
	);

	// In The News
	register_post_type( 'the_news',
		array(
			'labels' 				=> array(
				'name'					=> 'In The News',
				'singular_name' 		=> 'News Item',
				'add_new'				=> 'Add In News Item',
				'add_new_item'			=> 'Add In New News Item',
				'edit_item'				=> 'Edit In News Item',
				'new_item'				=> 'New In News Item',
				'all_items'				=> 'All In News Items',
				'view_item'				=> 'View In News Item',
				'search_items'			=> 'Search In News Items',
				'not_found'				=> 'No In News Items found',
				'not_found_in_trash'	=> 'No In News Items found in Trash',
				'parent_item_colon'		=> '',
				'menu_name'				=> 'In The News',
				'publicly_queryable'	=> false,
			),
			// 'exclude_from_search' 	=> true,
			'public' 				=> true,
			'has_archive' 			=> false,
			'rewrite' 				=> array(
				'slug' => 'in-the-news', 'with_front' => false
			),
			'supports'				=> array(
				'title', 'author'
			)
		)
	);

	// EcoSystem News
	register_post_type( 'ecosystem_news',
		array(
			'labels' 				=> array(
				'name'					=> 'Ecosystem News',
				'singular_name' 		=> 'Ecosystem News',
				'add_new'				=> 'Add Ecosystem News',
				'add_new_item'			=> 'Add Ecosystem News',
				'edit_item'				=> 'Edit Ecosystem News Item',
				'new_item'				=> 'New Ecosystem News Item',
				'all_items'				=> 'All Ecosystem News Items',
				'view_item'				=> 'View Ecosystem News Item',
				'search_items'			=> 'Search Ecosystem News',
				'not_found'				=> 'No Ecosystem News Items found',
				'not_found_in_trash'	=> 'No Ecosystem News Items found in Trash',
				'parent_item_colon'		=> '',
				'menu_name'				=> 'Ecosystem News',
				'publicly_queryable'	=> false,
			),
			// 'exclude_from_search' 	=> true,
			'public' 				=> true,
			'has_archive' 			=> false,
			'rewrite' 				=> array(
				'slug' => 'ecosystem-news', 'with_front' => false
			),
			'supports'				=> array(
				'title', 'author', 'thumbnail', 'editor'
			)
		)
	);


	##### DELETE WHEN READY ################################################################################
	// PowerVR GPUs
	register_post_type( 'powervr_gpus',
		array(
			'labels' 				=> array(
				'name'					=> 'PowerVR GPUs',
				'singular_name' 		=> 'PowerVR GPU',
				'add_new'				=> 'Add PowerVR GPU',
				'add_new_item'			=> 'Add PowerVR GPU Product',
				'edit_item'				=> 'Edit PowerVR GPU Item',
				'new_item'				=> 'New PowerVR GPU Item',
				'all_items'				=> 'All PowerVR GPUs',
				'view_item'				=> 'View PowerVR GPU',
				'search_items'			=> 'Search PowerVR GPUs',
				'not_found'				=> 'No PowerVR GPUs found',
				'not_found_in_trash'	=> 'No PowerVR GPUs found in Trash',
				'parent_item_colon'		=> '',
				'menu_name'				=> 'PowerVR GPUs',
				'publicly_queryable'	=> true,
			),
			'public' 				=> true,
			'has_archive' 			=> false,
			'rewrite' 				=> array(
				'slug' => 'powervr-gpu', 'with_front' => false
			),
			'supports'				=> array(
				'title', 'editor', 'author', 'thumbnail'
			)
		)
	);
	// PowerVR Demo
	register_post_type( 'powervr_demos',
		array(
			'labels' 				=> array(
				'name'					=> 'PowerVR Demos',
				'singular_name'			=> 'PowerVR Demo',
				'add_new'				=> 'Add New',
				'add_new_item'			=> 'Add New PowerVR Demo',
				'edit_item'				=> 'Edit PowerVR Demo',
				'new_item'				=> 'New PowerVR Demo',
				'all_items'				=> 'All PowerVR Demos',
				'view_item'				=> 'View Page',
				'search_items'			=> 'Search PowerVR Demos',
				'not_found'				=> 'No PowerVR Demos found',
				'not_found_in_trash'	=> 'No PowerVR Demos found in Trash',
				'parent_item_colon'		=> '',
				'menu_name'				=> 'PowerVR Demos',
				'publicly_queryable'	=> true,
			),
			'public' 				=> true,
			'has_archive' 			=> false,
			'rewrite' 				=> array(
				'slug' => '', 'with_front' => false
			),
			'supports'				=> array(
				'title', 'editor', 'thumbnail', 'author'
			)
		)
	);
	##### DELETE WHEN READY ################################################################################

	// PRODUCTS
	register_post_type( 'it_products',
		array(
			'labels' 				=> array(
				'name'					=> 'Products',
				'singular_name' 		=> 'Product',
				'add_new'				=> 'Add New Product',
				'add_new_item'			=> 'Add New Product Product',
				'edit_item'				=> 'Edit Product Item',
				'new_item'				=> 'New Product Item',
				'all_items'				=> 'All Products',
				'view_item'				=> 'View Product',
				'search_items'			=> 'Search Products',
				'not_found'				=> 'No Products found',
				'not_found_in_trash'	=> 'No Products found in Trash',
				'parent_item_colon'		=> '',
				'menu_name'				=> 'Products',
			),
			'publicly_queryable'	=> true,
			'show_in_rest' 			=> true,
			'rest_base' 			=> 'products',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'public' 				=> true,
			'has_archive' 			=> false,
			'rewrite' 				=> array(
				'slug' => 'product', 'with_front' => false
			),
			'supports'				=> array(
				'title', 'editor', 'author', 'thumbnail'
			)
		)
	);
	// PRODUCT DEMOS
	register_post_type( 'it_product_demos',
		array(
			'labels' 				=> array(
				'name'					=> 'Product Demos',
				'singular_name'			=> 'Product Demos',
				'add_new'				=> 'Add New Product Demo',
				'add_new_item'			=> 'Add New Product Demo',
				'edit_item'				=> 'Edit Product Demo',
				'new_item'				=> 'New Product Demo',
				'all_items'				=> 'All Product Demos',
				'view_item'				=> 'View Product Demo',
				'search_items'			=> 'Search Product Demos',
				'not_found'				=> 'No Product Demos found',
				'not_found_in_trash'	=> 'No Product Demos found in Trash',
				'parent_item_colon'		=> '',
				'menu_name'				=> 'Product Demos',
			),
			'publicly_queryable'	=> true,
			'show_in_rest' 			=> true,
			'rest_base' 			=> 'demos',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'public' 				=> true,
			'has_archive' 			=> false,
			'rewrite' 				=> array(
				'slug' => 'demo', 'with_front' => false
			),
			'supports'				=> array(
				'title', 'editor', 'thumbnail', 'author'
			)
		)
	);


	//PARTNERS
	register_post_type( 'partners',
		array(
			'labels' 				=> array(
				'name'					=> 'Partners',
				'singular_name'			=> 'Partner',
				'add_new'				=> 'Add New',
				'add_new_item'			=> 'Add New partner',
				'edit_item'				=> 'Edit partner',
				'new_item'				=> 'New partner',
				'all_items'				=> 'All partners',
				'view_item'				=> 'View Page',
				'search_items'			=> 'Search partners',
				'not_found'				=> 'No partners found',
				'not_found_in_trash'	=> 'No partners found in Trash',
				'parent_item_colon'		=> '',
				'menu_name'				=> 'Partners'
			),
			'public' 				=> true,
			'menu_icon'				=> 'dashicons-groups',
			'has_archive' 			=> false,
			'rewrite' 				=> array(
				'slug' => 'imagination-partner', 'with_front' => false
			),
			'supports'				=> array(
				'title', 'editor', 'thumbnail', 'excerpt', 'author'
			)
		)
	);

	// PLATFORMS
	register_post_type( 'platforms',
		array(
			'labels' 				=> array(
				'name'					=> 'Platforms',
				'singular_name'			=> 'Platform',
				'add_new'				=> 'Add New',
				'add_new_item'			=> 'Add New Platform',
				'edit_item'				=> 'Edit Platform',
				'new_item'				=> 'New Platform',
				'all_items'				=> 'All Platforms',
				'view_item'				=> 'View Page',
				'search_items'			=> 'Search Platforms',
				'not_found'				=> 'No Platforms found',
				'not_found_in_trash'	=> 'No Platforms found in Trash',
				'parent_item_colon'		=> '',
				'menu_name'				=> 'Platforms',
				'publicly_queryable'	=> true,
			),
			'public' 				=> true,
			'has_archive' 			=> false,
			'rewrite' 				=> array(
				'slug' => 'developers/platform', 'with_front' => false
			),
			'supports'				=> array(
				'title', 'editor', 'thumbnail', 'author'
			)
		)
	);
}


