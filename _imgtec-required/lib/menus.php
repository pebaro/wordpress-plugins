<?php // menus and admin menu bar for the imgtec plugin


// =====> Remove Standard Admin Menu Items for Custom Post Types <=====
function remove_custom_menu_items( $menu_order ){

	global $menu;

	foreach ( $menu as $mkey => $m ) {
		$press_releases 	= array_search( 'edit.php?post_type=press_releases', $m );
		$our_events 		= array_search( 'edit.php?post_type=our_events', $m );
		$webinars 			= array_search( 'edit.php?post_type=webinars', $m );
		$presentations 		= array_search( 'edit.php?post_type=presentations', $m );
		$the_news 			= array_search( 'edit.php?post_type=the_news', $m );
		$esys_news 			= array_search( 'edit.php?post_type=ecosystem_news', $m );
		$powervr 			= array_search( 'edit.php?post_type=powervr_gpus', $m );
		$powervr_demos 		= array_search( 'edit.php?post_type=powervr_demos', $m );
		$products 			= array_search( 'edit.php?post_type=it_products', $m );
		$product_demos 		= array_search( 'edit.php?post_type=it_product_demos', $m );
		$staff_profiles 	= array_search( 'edit.php?post_type=staff_profiles', $m );
		$partners 			= array_search( 'edit.php?post_type=partners', $m );
		$platforms 			= array_search( 'edit.php?post_type=platforms', $m );

		if(
			$press_releases ||
			$our_events ||
			$webinars ||
			$presentations ||
			$the_news ||
			$esys_news ||
			$powervr ||
			$powervr_demos ||
			$products ||
			$product_demos ||
			$staff_profiles ||
			$partners ||
			$platforms
		){
			unset( $menu[$mkey] );
		}
	}
	return $menu_order;
}

function toggle_imgtec_menu_order(){
	return true;
}


// =====> Register Menu Page <=====( only user roles: admin, editor, contributor )
function register_imgtec_custom_menu_page() {

	if ( ! current_user_can( 'administrator', 'editor', 'contributor' ) ) return;

    add_menu_page(
        __( 'Custom Post Types', IT_TEXTDOMAIN ),
        'ImgTec Admin', 'manage_options',
        '_imgtec-required/admin.php', '',
        plugins_url( '_imgtec-required/images/imgtec-icon.svg' ), 3
	);
	
	add_submenu_page(
		'_imgtec-required/admin.php',
		'Press Kit Requests',
		'Press Kit Requests',
		'manage_options',
		'/_imgtec-required/admin/press-kit-requests.php'
	);
}

function custom_menu_page(){
    esc_html_e( 'Custom Admin Page', IT_TEXTDOMAIN );
}


// =====> Add Sub-Menu in WordPress Admin <=====
function add_sub_menu_custom_posts(){
	$imgtec_cpts = [
        'press_releases', 'the_news', 'ecosystem_news', 
        'our_events', 'webinars', 'presentations', 
        'it_products', 'it_product_demos', 'powervr_gpus', 'powervr_demos', 'platforms',
        'staff_profiles', 'partners', 
		'dlm_download'
	];
	// $imgtec_cpts = [
    //     'press_releases', 'the_news', 'ecosystem_news', 
    //     'our_events', 'webinars', 'presentations', 
    //     'it_products', 'it_product_demos', 'platforms',
    //     'staff_profiles', 'partners', 
	// 	'dlm_download'
	// ];
	foreach ($imgtec_cpts as $cpt) {
		add_submenu_page( '_imgtec-required/admin.php',
			imgtec_cpt_listing_name( $cpt ), imgtec_cpt_listing_name( $cpt ),
			'edit_pages', 'edit.php?post_type='.$cpt
		);
	}
}


// =====> Admin Bar Menu <=====
function admin_menu_bar_cpt_menu(){

	global $wp_admin_bar;
	if( ! current_user_can( 'administrator', 'editor', 'contributor' ) ||
		! is_admin_bar_showing() ||
		! is_object( $wp_admin_bar ) ||
		! function_exists( 'is_admin_bar_showing' ) ||
		! is_admin_bar_showing() )
		: return;
	endif;

	$top_level 			=   'imgtec_admin_menu_bar';
	$press 				= [ 'press_releases', 'the_news', 'ecosystem_news' ];
	$events 			= [ 'our_events', 'webinars', 'presentations' ];
	$company 			= [ 'staff_profiles', 'partners' ];
	$technology 		= [ 'it_products', 'it_product_demos', 'powervr_gpus', 'powervr_demos', 'platforms' ];
	// $technology			= [ 'it_products', 'it_product_demos', 'platforms' ];
	$downloads 			= [ 'dlm_download' ];
	$downloads_pages 	= [ 'download-monitor-settings', 'download-monitor-reports', 'download-monitor-logs' ];
	$technology_taxs 	= [ 'product-ip', 'ip-technology', 'ip-series', 'ip-architectures', 'ip-performance-options', 'ip-product-markets', 'product-tags', 'product-categories' ];


	// MENU STARTS HERE!!!!!
	$wp_admin_bar->add_menu( // Top Level Menu Item
		array(
			'id' 		=> $top_level,
			'title' 	=> __( '<span id="imgtec-top-level-admin-bar" style="color: #b1ff6d !important;">' . 'Imgtec Admin' . '</span>' ),
			'href' 		=> admin_url( '/admin.php?page=_imgtec-required/admin.php' )
		)
	);

	# PRESS Section
	imgtec_menu_bar_sections_minus_taxonomies( $top_level, 'press_section', $press );
		# PRESS Section Taxonomies
		imgtec_menu_bar_heading( 'press_section', 'Press Section Taxonomies' );
		$wp_admin_bar->add_menu( # Global Taxonomies
			array(
				'id' 		=> 'global-taxonomies',
				'parent' 	=> 'press_section',
				'title' 	=> __( 'Global Taxonomies' ),
				'href' 		=> admin_url( '/edit-tags.php?taxonomy=global_taxonomies' )
			)
		);
		# PRESS Section Press Kit Requests
		imgtec_menu_bar_heading( 'press_section', 'Press Kit' );
		$wp_admin_bar->add_menu( # Press Kit Requests
			array(
				'id' 		=> 'press-kit-requests',
				'parent' 	=> 'press_section',
				'title' 	=> __( 'Press Kit Requests' ),
				'href' 		=> admin_url( '/admin.php?page=_imgtec-required/admin/press-kit-requests.php' )
			)
		);

	# EVENTS Section
	imgtec_menu_bar_sections( $top_level, 'events_section', $events );

	# TECHNOLOGY Section
	imgtec_menu_bar_sections_minus_taxonomies( $top_level, 'technology_section', $technology );
		# TECHNOLOGY Section Taxonomies
		imgtec_menu_bar_heading( 'technology_section', 'Technology Section Taxonomies' );
		imgtec_menu_bar_section_multiple_taxonomies( $top_level, 'technology_section', $technology_taxs );

	# COMPANY Section
	imgtec_menu_bar_sections( $top_level, 'company_section', $company );

	# DOWNLOADS Section
	imgtec_menu_bar_sections( $top_level, 'downloads_section', $downloads );
		# DOWNLOADS Section Pages
		imgtec_menu_bar_heading( 'downloads_section', 'Download Manager Pages' );
		imgtec_menu_bar_page_listing( 'downloads_section', 'dlm_download', $downloads_pages[ 0 ] );
		imgtec_menu_bar_page_listing( 'downloads_section', 'dlm_download', $downloads_pages[ 1 ] );
		imgtec_menu_bar_page_listing( 'downloads_section', 'dlm_download', $downloads_pages[ 2 ] );

}