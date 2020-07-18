<?php

function create_imgtec_taxonomies(){

	// Global Taxonomies: press_releases, the_news, ecosystem_news
	$labels_global_taxonomies = array(
		'name'              => _x( 'Global Taxonomies', 'taxonomy general name' ),
		'singular_name'     => _x( 'Global Taxonomies', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Taxonomies' ),
		'all_items'         => __( 'All Taxonomies' ),
		'parent_item'       => __( 'Parent Taxonomy' ),
		'parent_item_colon' => __( 'Parent Taxonomy:' ),
		'edit_item'         => __( 'Edit Taxonomy' ),
		'update_item'       => __( 'Update Taxonomy' ),
		'add_new_item'      => __( 'Add New Taxonomy' ),
		'new_item_name'     => __( 'New Taxonomy Name' ),
		'menu_name'         => __( 'Global Taxonomies' )
	);
	$args_global_taxonomies = array(
		'hierarchical'      => true,
		'labels'            => $labels_global_taxonomies,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest' 		=> true,
		'rewrite'           => array(
			'slug' => 'global-taxonomies'
		)
	);
	register_taxonomy(
		'global_taxonomies', array(
			'press_releases', 'the_news', 'ecosystem_news'
		), $args_global_taxonomies
	);

	// Events Technologies: out_events
	$labels_event_technologies = array(
		'name'              => _x( 'Event Technologies', 'taxonomy general name' ),
		'singular_name'     => _x( 'Event Technologies', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Event Technologies' ),
		'all_items'         => __( 'All Event Technologies' ),
		'parent_item'       => __( 'Parent Event Technology' ),
		'parent_item_colon' => __( 'Parent Event Technology:' ),
		'edit_item'         => __( 'Edit Event Technology' ),
		'update_item'       => __( 'Update Event Technology' ),
		'add_new_item'      => __( 'Add New Event Technology' ),
		'new_item_name'     => __( 'New Event Technology Name' ),
		'menu_name'         => __( 'Event Technologies' )
	);
	$args_event_technologies = array(
		'hierarchical'      => true,
		'labels'            => $labels_event_technologies,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest' 		=> true,
		'rewrite'           => array(
			'slug' => 'events/technology'
		)
	);
	register_taxonomy(
		'event_technologies', array(
			'our_events'
		), $args_event_technologies
	);

	// Events Markets: out_events
	$labels_event_markets = array(
		'name'              => _x( 'Event Markets', 'taxonomy general name' ),
		'singular_name'     => _x( 'Event Markets', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Event Markets' ),
		'all_items'         => __( 'All Event Markets' ),
		'parent_item'       => __( 'Parent Event Market' ),
		'parent_item_colon' => __( 'Parent Event Market:' ),
		'edit_item'         => __( 'Edit Event Market' ),
		'update_item'       => __( 'Update Event Market' ),
		'add_new_item'      => __( 'Add New Event Market' ),
		'new_item_name'     => __( 'New Event Market Name' ),
		'menu_name'         => __( 'Event Markets' )
	);
	$args_event_markets = array(
		'hierarchical'      => true,
		'labels'            => $labels_event_markets,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest' 		=> true,
		'rewrite'           => array(
			'slug' => 'events/market'
		)
	);
	register_taxonomy(
		'event_markets', array(
			'our_events'
		), $args_event_markets
	);

	// Events Categories: out_events
	$labels_event_categories = array(
		'name'              => _x( 'Event Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Event Categories', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Event Categories' ),
		'all_items'         => __( 'All Event Categories' ),
		'parent_item'       => __( 'Parent Event Category' ),
		'parent_item_colon' => __( 'Parent Event Category:' ),
		'edit_item'         => __( 'Edit Event Category' ),
		'update_item'       => __( 'Update Event Category' ),
		'add_new_item'      => __( 'Add New Event Category' ),
		'new_item_name'     => __( 'New Event Category Name' ),
		'menu_name'         => __( 'Event Categories' )
	);
	$args_event_categories = array(
		'hierarchical'      => true,
		'labels'            => $labels_event_categories,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest' 		=> true,
		'rewrite'           => array(
			'slug' => 'events/category'
		)
	);
	register_taxonomy(
		'event_categories', array(
			'our_events'
		), $args_event_categories
	);

	// Webinar Technologies: Webinars
	$labels_webinar_technologies = array(
		'name'              => _x( 'Webinar Technologies', 'taxonomy general name' ),
		'singular_name'     => _x( 'Webinar Technologies', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Webinar Technologies' ),
		'all_items'         => __( 'All Webinar Technologies' ),
		'parent_item'       => __( 'Parent Webinar Technology' ),
		'parent_item_colon' => __( 'Parent Webinar Technology:' ),
		'edit_item'         => __( 'Edit Webinar Technology' ),
		'update_item'       => __( 'Update Webinar Technology' ),
		'add_new_item'      => __( 'Add New Webinar Technology' ),
		'new_item_name'     => __( 'New Webinar Technology Name' ),
		'menu_name'         => __( 'Webinar Technologies' )
	);
	$args_webinar_technologies = array(
		'hierarchical'      => true,
		'labels'            => $labels_webinar_technologies,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest' 		=> true,
		'rewrite'           => array(
			'slug' => 'events/webinar/technology'
		)
	);
	register_taxonomy(
		'webinar_technologies', array(
			'webinars'
		), $args_webinar_technologies
	);

	// Webinar Markets: Webinars
	$labels_webinar_markets = array(
		'name'              => _x( 'Webinar Markets', 'taxonomy general name' ),
		'singular_name'     => _x( 'Webinar Markets', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Webinar Markets' ),
		'all_items'         => __( 'All Webinar Markets' ),
		'parent_item'       => __( 'Parent Webinar Market' ),
		'parent_item_colon' => __( 'Parent Webinar Market:' ),
		'edit_item'         => __( 'Edit Webinar Market' ),
		'update_item'       => __( 'Update Webinar Market' ),
		'add_new_item'      => __( 'Add New Webinar Market' ),
		'new_item_name'     => __( 'New Webinar Market Name' ),
		'menu_name'         => __( 'Webinar Markets' )
	);
	$args_webinar_markets = array(
		'hierarchical'      => true,
		'labels'            => $labels_webinar_markets,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest' 		=> true,
		'rewrite'           => array(
			'slug' => 'events/webinar/market'
		)
	);
	register_taxonomy(
		'webinar_markets', array(
			'webinars'
		), $args_webinar_markets
	);

	// Webinar Categories: Webinars
	$labels_webinar_categories = array(
		'name'              => _x( 'Webinar Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Webinar Categories', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Webinar Categories' ),
		'all_items'         => __( 'All Webinar Categories' ),
		'parent_item'       => __( 'Parent Webinar Category' ),
		'parent_item_colon' => __( 'Parent Webinar Category:' ),
		'edit_item'         => __( 'Edit Webinar Category' ),
		'update_item'       => __( 'Update Webinar Category' ),
		'add_new_item'      => __( 'Add New Webinar Category' ),
		'new_item_name'     => __( 'New Webinar Category Name' ),
		'menu_name'         => __( 'Webinar Categories' )
	);
	$args_webinar_categories = array(
		'hierarchical'      => true,
		'labels'            => $labels_webinar_categories,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest' 		=> true,
		'rewrite'           => array(
			'slug' => 'events/webinar/category'
		)
	);
	register_taxonomy(
		'webinar_categories', array(
			'webinars'
		), $args_webinar_categories
	);

	// Presentation Technologies: presentations
	$labels_presentation_technologies = array(
		'name'              => _x( 'Presentation Technologies', 'taxonomy general name' ),
		'singular_name'     => _x( 'Presentation Technologies', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Presentation Technologies' ),
		'all_items'         => __( 'All Presentation Technologies' ),
		'parent_item'       => __( 'Parent Presentation Technology' ),
		'parent_item_colon' => __( 'Parent Presentation Technology:' ),
		'edit_item'         => __( 'Edit Presentation Technology' ),
		'update_item'       => __( 'Update Presentation Technology' ),
		'add_new_item'      => __( 'Add New Presentation Technology' ),
		'new_item_name'     => __( 'New Presentation Technology Name' ),
		'menu_name'         => __( 'Presentation Technologies' )
	);
	$args_presentation_technologies = array(
		'hierarchical'      => true,
		'labels'            => $labels_presentation_technologies,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest' 		=> true,
		'rewrite'           => array(
			'slug' => 'events/presentation/technology'
		)
	);
	register_taxonomy(
		'presentation_technologies', array(
			'presentations'
		), $args_presentation_technologies
	);

	// Presentation Markets: presentations
	$labels_presentation_markets = array(
		'name'              => _x( 'Presentation Markets', 'taxonomy general name' ),
		'singular_name'     => _x( 'Presentation Markets', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Presentation Markets' ),
		'all_items'         => __( 'All Presentation Markets' ),
		'parent_item'       => __( 'Parent Presentation Market' ),
		'parent_item_colon' => __( 'Parent Presentation Market:' ),
		'edit_item'         => __( 'Edit Presentation Market' ),
		'update_item'       => __( 'Update Presentation Market' ),
		'add_new_item'      => __( 'Add New Presentation Market' ),
		'new_item_name'     => __( 'New Presentation Market Name' ),
		'menu_name'         => __( 'Presentation Markets' )
	);
	$args_presentation_markets = array(
		'hierarchical'      => true,
		'labels'            => $labels_presentation_markets,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest' 		=> true,
		'rewrite'           => array(
			'slug' => 'events/presentation/market'
		)
	);
	register_taxonomy(
		'presentation_markets', array(
			'presentations'
		), $args_presentation_markets
	);

	// Presentation Categories: presentations
	$labels_presentation_categories = array(
		'name'              => _x( 'Presentation Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Presentation Categories', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Presentation Categories' ),
		'all_items'         => __( 'All Presentation Categories' ),
		'parent_item'       => __( 'Parent Presentation Category' ),
		'parent_item_colon' => __( 'Parent Presentation Category:' ),
		'edit_item'         => __( 'Edit Presentation Category' ),
		'update_item'       => __( 'Update Presentation Category' ),
		'add_new_item'      => __( 'Add New Presentation Category' ),
		'new_item_name'     => __( 'New Presentation Category Name' ),
		'menu_name'         => __( 'Presentation Categories' )
	);
	$args_presentation_categories = array(
		'hierarchical'      => true,
		'labels'            => $labels_presentation_categories,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest' 		=> true,
		'rewrite'           => array(
			'slug' => 'events/presentation/category'
		)
	);
	register_taxonomy(
		'presentation_categories', array(
			'presentations'
		), $args_presentation_categories
	);

//===============================================================
	// ================== 'it_products', 'it_product_demos'
	// IP Architecture
	$labels_ip_architecture = array(
		'name'              	=> _x( 'IP Architecture', 'taxonomy general name' ),
		'singular_name'     	=> _x( 'IP Architecture', 'taxonomy singular name' ),
		'search_items'      	=> __( 'Search IP Architectures' ),
		'all_items'         	=> __( 'All IP Architectures' ),
		'parent_item'       	=> __( 'Parent Architecture' ),
		'parent_item_colon' 	=> __( 'Parent Architecture:' ),
		'edit_item'         	=> __( 'Edit Architecture' ),
		'update_item'       	=> __( 'Update Architecture' ),
		'add_new_item'      	=> __( 'Add New IP Architecture' ),
		'new_item_name'     	=> __( 'New IP Architecture Name' ),
		'menu_name'         	=> __( 'Architecture (*Demos)' )
	);
	$args_ip_architecture = array(
		'hierarchical'      	=> true,
		'labels'            	=> $labels_ip_architecture,
		'show_ui'           	=> true,
		'show_admin_column' 	=> true,
		'query_var'         	=> true,
		'show_in_rest' 			=> true,
		'rest_base' 			=> 'architecture',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'rewrite'           	=> array(
			'slug' => 'ip-architecture'
		)
	);
	register_taxonomy(
		'ip-architectures', array(
			'it_products', 'it_product_demos'
		), $args_ip_architecture
	);

	// ============= 'it_product_demos'
	// Product IP
	$labels_product_ip = array(
		'name'              	=> _x( 'Product IP', 'taxonomy general name' ),
		'singular_name'     	=> _x( 'Product IP', 'taxonomy singular name' ),
		'search_items'      	=> __( 'Search Product IP' ),
		'all_items'         	=> __( 'All Product IP' ),
		'parent_item'       	=> __( 'Parent Product IP' ),
		'parent_item_colon' 	=> __( 'Parent Product IP:' ),
		'edit_item'         	=> __( 'Edit Product IP' ),
		'update_item'       	=> __( 'Update Product IP' ),
		'add_new_item'      	=> __( 'Add New Product IP' ),
		'new_item_name'     	=> __( 'New Product IP Name' ),
		'menu_name'         	=> __( 'Product IP (*Demos)' )
	);
	$args_product_ip = array(
		'hierarchical'      	=> true,
		'labels'            	=> $labels_product_ip,
		'show_ui'           	=> true,
		'show_admin_column' 	=> true,
		'query_var'         	=> true,
		'show_in_rest' 			=> true,
		'rest_base' 			=> 'product_ip',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	);
	register_taxonomy( 'product-ip', array( 'it_product_demos' ), $args_product_ip );

	// =================== 'it_products', 'it_product_demos'
	// IP Series/Family
	$labels_ip_series = array(
		'name'              	=> _x( 'IP Series', 'taxonomy general name' ),
		'singular_name'     	=> _x( 'IP Series', 'taxonomy singular name' ),
		'search_items'      	=> __( 'Search IP Series' ),
		'all_items'         	=> __( 'All IP Series' ),
		'parent_item'       	=> __( 'Parent Series' ),
		'parent_item_colon' 	=> __( 'Parent Series:' ),
		'edit_item'         	=> __( 'Edit IP Series' ),
		'update_item'       	=> __( 'Update IP Series' ),
		'add_new_item'      	=> __( 'Add New IP Series' ),
		'new_item_name'     	=> __( 'New IP Series Name' ),
		'menu_name'         	=> __( 'IP Series (*Demos)' )
	);
	$args_ip_series = array(
		'hierarchical'      	=> true,
		'labels'            	=> $labels_ip_series,
		'show_ui'           	=> true,
		'show_admin_column' 	=> true,
		'query_var'         	=> true,
		'show_in_rest' 			=> true,
		'rest_base' 			=> 'series',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'rewrite'           	=> array(
			'slug' => 'ip-series'
		)
	);
	register_taxonomy(
		'ip-series', array(
			'it_products', 'it_product_demos'
		), $args_ip_series
	);

	// ================== 'it_product_demos'
	// Demo Technology
	$labels_demo_technology = array(
		'name'              	=> _x( 'Demo Technologies', 'taxonomy general name' ),
		'singular_name'     	=> _x( 'Demo Technology', 'taxonomy singular name' ),
		'search_items'      	=> __( 'Search Demo Technologies' ),
		'all_items'         	=> __( 'All Demo Technologies' ),
		'parent_item'       	=> __( 'Parent Demo Technology' ),
		'parent_item_colon' 	=> __( 'Parent Demo Technology:' ),
		'edit_item'         	=> __( 'Edit Demo Technology' ),
		'update_item'       	=> __( 'Update Demo Technology' ),
		'add_new_item'      	=> __( 'Add New Demo Technology' ),
		'new_item_name'     	=> __( 'New Demo Technology Name' ),
		'menu_name'         	=> __( 'Demo Technologies' )
	);
	$args_demo_technology = array(
		'hierarchical'      	=> true,
		'labels'            	=> $labels_demo_technology,
		'show_ui'           	=> true,
		'show_admin_column' 	=> true,
		'query_var'         	=> true,
		'show_in_rest' 			=> true,
		'rest_base' 			=> 'demo_technologies',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	);
	// register_taxonomy( 'demo-technologies', array( 'it_product_demos' ), $args_demo_technology );

	// ======================== 'it_product_demos'
	// Demo Operating System
	$labels_demo_os = array(
		'name'              	=> _x( 'Demo Operating System', 'taxonomy general name' ),
		'singular_name'     	=> _x( 'Demo Operating System', 'taxonomy singular name' ),
		'search_items'      	=> __( 'Search Demo Operating Systems' ),
		'all_items'         	=> __( 'All Demo Operating Systems' ),
		'parent_item'       	=> __( 'Parent Demo Operating System' ),
		'parent_item_colon' 	=> __( 'Parent Demo Operating System:' ),
		'edit_item'         	=> __( 'Edit Demo Operating System' ),
		'update_item'       	=> __( 'Update Demo Operating System' ),
		'add_new_item'      	=> __( 'Add New Demo Operating System' ),
		'new_item_name'     	=> __( 'New Demo Operating System Name' ),
		'menu_name'         	=> __( 'Demo Operating Systems' )
	);
	$args_demo_os = array(
		'hierarchical'      	=> true,
		'labels'            	=> $labels_demo_os,
		'show_ui'           	=> true,
		'show_admin_column' 	=> true,
		'query_var'         	=> true,
		'show_in_rest' 			=> true,
		'rest_base' 			=> 'demo_operating_systems',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	);
	// register_taxonomy( 'demo-os', array( 'it_product_demos' ), $args_demo_os );

	// ================ 'it_product_demos'
	// Demo Platform
	$labels_demo_platform = array(
		'name'              	=> _x( 'Demo Platform', 'taxonomy general name' ),
		'singular_name'     	=> _x( 'Demo Platform', 'taxonomy singular name' ),
		'search_items'      	=> __( 'Search Demo Platforms' ),
		'all_items'         	=> __( 'All Demo Platforms' ),
		'parent_item'       	=> __( 'Parent Demo Platform' ),
		'parent_item_colon' 	=> __( 'Parent Demo Platform:' ),
		'edit_item'         	=> __( 'Edit Demo Platform' ),
		'update_item'       	=> __( 'Update Demo Platform' ),
		'add_new_item'      	=> __( 'Add New Demo Platform' ),
		'new_item_name'     	=> __( 'New Demo Platform Name' ),
		'menu_name'         	=> __( 'Demo Platforms' )
	);
	$args_demo_platform = array(
		'hierarchical'      	=> true,
		'labels'            	=> $labels_demo_platform,
		'show_ui'           	=> true,
		'show_admin_column' 	=> true,
		'query_var'         	=> true,
		'show_in_rest' 			=> true,
		'rest_base' 			=> 'demo_platforms',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	);
	// register_taxonomy( 'demo-platforms', array( 'it_product_demos' ), $args_demo_platform );

	// =========== 'it_product_demos'
	// Demo API
	$labels_demo_api = array(
		'name'              	=> _x( 'Demo API', 'taxonomy general name' ),
		'singular_name'     	=> _x( 'Demo API', 'taxonomy singular name' ),
		'search_items'      	=> __( 'Search Demo APIs' ),
		'all_items'         	=> __( 'All Demo APIs' ),
		'parent_item'       	=> __( 'Parent Demo API' ),
		'parent_item_colon' 	=> __( 'Parent Demo API:' ),
		'edit_item'         	=> __( 'Edit Demo API' ),
		'update_item'       	=> __( 'Update Demo API' ),
		'add_new_item'      	=> __( 'Add New Demo API' ),
		'new_item_name'     	=> __( 'New Demo API Name' ),
		'menu_name'         	=> __( 'Demo APIs' )
	);
	$args_demo_api = array(
		'hierarchical'      	=> true,
		'labels'            	=> $labels_demo_api,
		'show_ui'           	=> true,
		'show_admin_column' 	=> true,
		'query_var'         	=> true,
		'show_in_rest' 			=> true,
		'rest_base' 			=> 'demo_apis',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	);
	// register_taxonomy( 'demo-apis', array( 'it_product_demos' ), $args_demo_api );


	// ============= 'it_products'
	// IP Technology
	$labels_ip_technology = array(
		'name'              	=> _x( 'IP Technology', 'taxonomy general name' ),
		'singular_name'     	=> _x( 'IP Technology', 'taxonomy singular name' ),
		'search_items'      	=> __( 'Search IP Technology' ),
		'all_items'         	=> __( 'All IP Technology' ),
		'parent_item'       	=> __( 'Parent Technology' ),
		'parent_item_colon' 	=> __( 'Parent Technology:' ),
		'edit_item'         	=> __( 'Edit IP Technology' ),
		'update_item'       	=> __( 'Update IP Technology' ),
		'add_new_item'      	=> __( 'Add New IP Technology' ),
		'new_item_name'     	=> __( 'New IP Technology Name' ),
		'menu_name'         	=> __( 'Technology' )
	);
	$args_ip_technology = array(
		'hierarchical'      	=> true,
		'labels'            	=> $labels_ip_technology,
		'show_ui'           	=> true,
		'show_admin_column' 	=> true,
		'query_var'         	=> true,
		'show_in_rest' 			=> true,
		'rest_base' 			=> 'technology',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'rewrite'           	=> array(
			'slug' => 'ip-technology'
		)
	);
	register_taxonomy( 'ip-technology', array( 'it_products' ), $args_ip_technology );

	// ========================= 'it_products'
	// IP Performance Options
	$labels_ip_performance_options = array(
		'name'              	=> _x( 'IP Performance Options', 'taxonomy general name' ),
		'singular_name'     	=> _x( 'IP Performance Options', 'taxonomy singular name' ),
		'search_items'      	=> __( 'Search IP Performance Options' ),
		'all_items'         	=> __( 'All IP Performance Options' ),
		'parent_item'       	=> __( 'Parent Option' ),
		'parent_item_colon' 	=> __( 'Parent Option:' ),
		'edit_item'         	=> __( 'Edit IP Performance Option' ),
		'update_item'       	=> __( 'Update IP Performance Option' ),
		'add_new_item'      	=> __( 'Add New IP Performance Option' ),
		'new_item_name'     	=> __( 'New IP Performance Option Name' ),
		'menu_name'         	=> __( 'Performance Options' )
	);
	$args_ip_performance_options = array(
		'hierarchical'      	=> true,
		'labels'            	=> $labels_ip_performance_options,
		'show_ui'           	=> true,
		'show_admin_column' 	=> true,
		'query_var'         	=> true,
		'show_in_rest' 			=> true,
		'rest_base' 			=> 'performance',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'rewrite'           	=> array(
			'slug' => 'ip-performance-option'
		)
	);
	register_taxonomy(
		'ip-performance-options', array(
			'it_products'
		), $args_ip_performance_options
	);

	// ===================== 'it_products'
	// IP Product Markets
	$labels_ip_markets = array(
		'name'              	=> _x( 'IP Product Markets', 'taxonomy general name' ),
		'singular_name'     	=> _x( 'IP Product Markets', 'taxonomy singular name' ),
		'search_items'      	=> __( 'Search IP Product Markets' ),
		'all_items'         	=> __( 'All IP Product Markets' ),
		'parent_item'       	=> __( 'Parent Item' ),
		'parent_item_colon' 	=> __( 'Parent Item:' ),
		'edit_item'         	=> __( 'Edit IP Product Market' ),
		'update_item'       	=> __( 'Update IP Product Market' ),
		'add_new_item'      	=> __( 'Add New IP Product Market' ),
		'new_item_name'     	=> __( 'New IP Product Market Name' ),
		'menu_name'         	=> __( 'Product Markets (*Demos)' )
	);
	$args_ip_markets = array(
		'hierarchical'      	=> true,
		'labels'            	=> $labels_ip_markets,
		'show_ui'           	=> true,
		'show_admin_column' 	=> true,
		'query_var'         	=> true,
		'show_in_rest' 			=> true,
		'rest_base' 			=> 'markets',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'rewrite'           	=> array(
			'slug' => 'product-market'
		)
	);
	register_taxonomy( 'ip-product-markets', array( 'it_products' ), $args_ip_markets );


	// Product Category - multiple cpts
	$labels_product_category = array(
		'name'              	=> _x( 'Product Category', 'taxonomy general name' ),
		'singular_name'     	=> _x( 'Product Category', 'taxonomy singular name' ),
		'search_items'      	=> __( 'Search Product Category' ),
		'all_items'         	=> __( 'All Product Category' ),
		'parent_item'       	=> __( 'Parent Product Category' ),
		'parent_item_colon' 	=> __( 'Parent Product Category:' ),
		'edit_item'         	=> __( 'Edit Product Category' ),
		'update_item'       	=> __( 'Update Product Category' ),
		'add_new_item'      	=> __( 'Add New Product Category' ),
		'new_item_name'     	=> __( 'New Product Category Name' ),
		'menu_name'         	=> __( 'Product Category' )
	);
	$args_product_category = array(
		'hierarchical'      	=> true,
		'labels'            	=> $labels_product_category,
		'show_ui'           	=> true,
		'show_admin_column' 	=> true,
		'query_var'         	=> true,
		'show_in_rest' 			=> true,
		'rest_base' 			=> 'product_category',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'rewrite'           	=> array(  'slug'=> 'product-category', 'with_front' => false )
	);
	register_taxonomy( 'product-category', array(
		'platforms', 'powervr_gpus', 'powervr_demos'
	), $args_product_category );


	// Product Tags - multiple cpts
	$labels_product_tags = array(
		'name'              	=> _x( 'Product Tags', 'taxonomy general name' ),
		'singular_name'     	=> _x( 'Product Tags', 'taxonomy singular name' ),
		'search_items'      	=> __( 'Search Product Tags' ),
		'all_items'         	=> __( 'All Product Tags' ),
		'parent_item'       	=> __( 'Parent Product Tags' ),
		'parent_item_colon' 	=> __( 'Parent Product Tags:' ),
		'edit_item'         	=> __( 'Edit Product Tags' ),
		'update_item'       	=> __( 'Update Product Tags' ),
		'add_new_item'      	=> __( 'Add New Product Tags' ),
		'new_item_name'     	=> __( 'New Product Tags Name' ),
		'menu_name'         	=> __( 'Product Tags' )
	);
	$args_product_tags = array(
		'hierarchical'      	=> true,
		'labels'            	=> $labels_product_tags,
		'show_ui'           	=> true,
		'show_admin_column' 	=> true,
		'query_var'         	=> true,
		'show_in_rest' 			=> true,
		'rest_base' 			=> 'product_tag',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'rewrite'           	=> array(  'slug'=> 'product-tag', 'with_front' => false )
	);
	register_taxonomy( 'product-tags', array( 'platforms', 'powervr_gpus', 'powervr_demos' ), $args_product_tags );

//===============================================================


	// PARTNERS (Partner Type)
	$labels_partner_type = array(
		'name'              => _x( 'Partner Type', 'taxonomy general name' ),
		'singular_name'     => _x( 'Partner Type', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Partner Type' ),
		'all_items'         => __( 'All Partner Type' ),
		'parent_item'       => __( 'Parent Partner Type' ),
		'parent_item_colon' => __( 'Parent Partner Type:' ),
		'edit_item'         => __( 'Edit Partner Type' ),
		'update_item'       => __( 'Update Partner Type' ),
		'add_new_item'      => __( 'Add New Partner Type' ),
		'new_item_name'     => __( 'New Partner Type Name' ),
		'menu_name'         => __( 'Partner Type' )
	);
	$args_partner_type = array(
		'hierarchical'      => true,
		'labels'            => $labels_partner_type,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest' 		=> true
		//'rewrite'           => array(  'slug'=> 'partners' )
	);
	register_taxonomy( 'partner-type', array( 'partners' ), $args_partner_type );

	// PARTNERS (Products)
	$labels_products = array(
		'name'              => _x( 'Products', 'taxonomy general name' ),
		'singular_name'     => _x( 'Products', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Products' ),
		'all_items'         => __( 'All Products' ),
		'parent_item'       => __( 'Parent Products' ),
		'parent_item_colon' => __( 'Parent Products:' ),
		'edit_item'         => __( 'Edit Products' ),
		'update_item'       => __( 'Update Products' ),
		'add_new_item'      => __( 'Add New Products' ),
		'new_item_name'     => __( 'New Products Name' ),
		'menu_name'         => __( 'Products' )
	);
	$args_products = array(
		'hierarchical'      => true,
		'labels'            => $labels_products,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest' 		=> true
	);
	register_taxonomy( 'partner-products', array( 'partners'), $args_products );

	// PARTNERS (Markets)
	$labels_markets = array(
		'name'              => _x( 'Markets', 'taxonomy general name' ),
		'singular_name'     => _x( 'Markets', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Markets' ),
		'all_items'         => __( 'All Markets' ),
		'parent_item'       => __( 'Parent Markets' ),
		'parent_item_colon' => __( 'Parent Markets:' ),
		'edit_item'         => __( 'Edit Markets' ),
		'update_item'       => __( 'Update Markets' ),
		'add_new_item'      => __( 'Add New Markets' ),
		'new_item_name'     => __( 'New Markets Name' ),
		'menu_name'         => __( 'Markets' )
	);
	$args_markets = array(
		'hierarchical'      => true,
		'labels'            => $labels_markets,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest' 		=> true
	);
	register_taxonomy( 'partner-markets', array( 'partners' ), $args_markets );

	// PARTNERS (Design Services)
	$labels_design_services = array(
		'name'              => _x( 'Design Services', 'taxonomy general name' ),
		'singular_name'     => _x( 'Design Services', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Design Services' ),
		'all_items'         => __( 'All Design Services' ),
		'parent_item'       => __( 'Parent Design Services' ),
		'parent_item_colon' => __( 'Parent Design Services:' ),
		'edit_item'         => __( 'Edit Design Services' ),
		'update_item'       => __( 'Update Design Services' ),
		'add_new_item'      => __( 'Add New Design Services' ),
		'new_item_name'     => __( 'New Design Services Name' ),
		'menu_name'         => __( 'Design Services' )
	);
	$args_design_services = array(
		'hierarchical'      => true,
		'labels'            => $labels_design_services,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest' 		=> true
	);
	register_taxonomy( 'design-services', array( 'partners' ), $args_design_services );

	// PARTNERS (Geography)
	$labels_geography = array(
		'name'              => _x( 'Geography', 'taxonomy general name' ),
		'singular_name'     => _x( 'Geography', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Geography' ),
		'all_items'         => __( 'All Geography' ),
		'parent_item'       => __( 'Parent Geography' ),
		'parent_item_colon' => __( 'Parent Geography:' ),
		'edit_item'         => __( 'Edit Geography' ),
		'update_item'       => __( 'Update Geography' ),
		'add_new_item'      => __( 'Add New Geography' ),
		'new_item_name'     => __( 'New Geography Name' ),
		'menu_name'         => __( 'Geography' )
	);
	$args_geography = array(
		'hierarchical'      => true,
		'labels'            => $labels_geography,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest' 		=> true
	);
	register_taxonomy( 'geography', array( 'partners' ), $args_geography );

//===============================================================

	// PowerVR GPU Series
	$labels_gpu_series = array(
		'name'              => _x( 'GPU Series', 'taxonomy general name' ),
		'singular_name'     => _x( 'GPU Series', 'taxonomy singular name' ),
		'search_items'      => __( 'Search GPU Series' ),
		'all_items'         => __( 'All GPU Series' ),
		'parent_item'       => __( 'Parent Series' ),
		'parent_item_colon' => __( 'Parent Series:' ),
		'edit_item'         => __( 'Edit GPU Series' ),
		'update_item'       => __( 'Update GPU Series' ),
		'add_new_item'      => __( 'Add New GPU Series' ),
		'new_item_name'     => __( 'New GPU Series Name' ),
		'menu_name'         => __( 'GPU Series' )
	);
	$args_gpu_series = array(
		'hierarchical'      => true,
		'labels'            => $labels_gpu_series,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug' => 'powervr-series'
		)
	);
	register_taxonomy(
		'gpu-series', array(
			'powervr_gpus'
		), $args_gpu_series
	);

	// PERFORMANCE OPTIONS
	$labels_performance_options = array(
		'name'              => _x( 'GPU Performance', 'taxonomy general name' ),
		'singular_name'     => _x( 'GPU Performance', 'taxonomy singular name' ),
		'search_items'      => __( 'GPU Search Performance' ),
		'all_items'         => __( 'All GPU Performance' ),
		'parent_item'       => __( 'Parent Option' ),
		'parent_item_colon' => __( 'Parent Option:' ),
		'edit_item'         => __( 'Edit Performance Option' ),
		'update_item'       => __( 'Update Performance Option' ),
		'add_new_item'      => __( 'Add New Performance Option' ),
		'new_item_name'     => __( 'New Performance Option Name' ),
		'menu_name'         => __( 'GPU Performance' )
	);
	$args_performance_options = array(
		'hierarchical'      => true,
		'labels'            => $labels_performance_options,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug' => 'performance-option'
		)
	);
	register_taxonomy(
		'gpu-performance', array(
			'powervr_gpus'
		), $args_performance_options
	);

	// POWERVR ARCHITECTURE
	$labels_architecture = array(
		'name'              => _x( 'GPU Architecture', 'taxonomy general name' ),
		'singular_name'     => _x( 'GPU Architecture', 'taxonomy singular name' ),
		'search_items'      => __( 'Search GPU Architectures' ),
		'all_items'         => __( 'All GPU Architectures' ),
		'parent_item'       => __( 'Parent Architecture' ),
		'parent_item_colon' => __( 'Parent Architecture:' ),
		'edit_item'         => __( 'Edit Architecture' ),
		'update_item'       => __( 'Update Architecture' ),
		'add_new_item'      => __( 'Add New GPU Architecture' ),
		'new_item_name'     => __( 'New GPU Architecture Name' ),
		'menu_name'         => __( 'GPU Architectures' )
	);
	$args_architecture = array(
		'hierarchical'      => true,
		'labels'            => $labels_architecture,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug' => 'powervr-architecture'
		)
	);
	register_taxonomy(
		'gpu-architectures', array(
			'powervr_gpus'
		), $args_architecture
	);

	// PRODUCT MARKETS
	$labels_markets = array(
		'name'              => _x( 'GPU Markets', 'taxonomy general name' ),
		'singular_name'     => _x( 'GPU Markets', 'taxonomy singular name' ),
		'search_items'      => __( 'Search GPU Markets' ),
		'all_items'         => __( 'All GPU Markets' ),
		'parent_item'       => __( 'Parent Market' ),
		'parent_item_colon' => __( 'Parent Market:' ),
		'edit_item'         => __( 'Edit Market' ),
		'update_item'       => __( 'Update Market' ),
		'add_new_item'      => __( 'Add New GPU Market' ),
		'new_item_name'     => __( 'New GPU Market Name' ),
		'menu_name'         => __( 'GPU Markets' )
	);
	$args_markets = array(
		'hierarchical'      => true,
		'labels'            => $labels_markets,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug' => 'powervr-market'
		)
	);
	register_taxonomy(
		'gpu-markets', array(
			'powervr_gpus'
		), $args_markets
	);


}
add_action( 'init', 'create_imgtec_taxonomies', 0 );