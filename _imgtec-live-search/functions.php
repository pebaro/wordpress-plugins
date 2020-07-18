<?php
/* ====================================================
 * function for formatting strings with the new font
 */
function imgtec_font_formatted_strings( $data, $format = null ){
        
    // initialise the string to lower case first
	$data = strtolower( $data );
    
	// character replacements before treating whole string
    $data = str_replace( 'tv', 'TV', $data );
    $data = str_replace( ' ip', ' IP', $data );
    $data = str_replace( 'tv ip', 'TV IP', $data );
	$data = str_replace( ' ai ', ' AI ', $data );
	$data = str_replace( 'ar/vr', 'AR/VR', $data );
    $data = str_replace( 'sdk', 'SDK', $data );
    $data = str_replace( 'soc ', 'SoC ', $data );
    $data = str_replace( 'soc.', 'SoC.', $data );
    $data = str_replace( 'gpu', 'GPU', $data );
    $data = str_replace( 'cpu', 'CPU', $data );
    $data = str_replace( 'gb', 'GB', $data );
    $data = str_replace( 'isp', 'ISP', $data );
    $data = str_replace( 'sgx', 'SGX', $data );
    $data = str_replace( 'gx', 'GX', $data );
    $data = str_replace( '3d', '3D', $data );

    $data = str_replace( 'mediatek mt', 'Mediatek MT', $data );

    $data = str_replace( 'img edge', 'IMG Edge', $data );
    $data = str_replace( 'pvrt', 'PVRT', $data );
    $data = str_replace( 'pvrc', 'PVRC', $data );
    $data = str_replace( 'pvrm', 'PVRM', $data );
    $data = str_replace( 'pvrs', 'PVRS', $data );
    $data = str_replace( 'pvrg', 'PVRG', $data );
    $data = str_replace( 'pvrh', 'PVRH', $data );
    $data = str_replace( 'pvrvf', 'PVRVF', $data );
    $data = str_replace( 'geopod', 'GeoPOD', $data );
    
	$data = str_replace( 'powervr', 'PowerVR', $data );
	$data = str_replace( 'VR series', 'VR Series', $data );
	$data = str_replace( 'PowerVR rogue', 'PowerVR Rogue', $data );
	$data = str_replace( 'PowerVR furian', 'PowerVR Furian', $data );
	$data = str_replace( 'PowerVR ray tracing', 'PowerVR Ray Tracing', $data );
	$data = str_replace( 'powervr neural network', 'PowerVR Neural Network', $data );
	$data = str_replace( 'PowerVR neural network', 'PowerVR Neural Network', $data );

	$data = str_replace( 'nx', 'NX', $data );
	$data = str_replace( 'vr ax', 'VR AX', $data );
	$data = str_replace( 'VR ax', 'VR AX', $data );
	$data = str_replace( ' nna', ' NNA', $data );

	$data = str_replace( '9xtp', '9XTP', $data );
	$data = str_replace( '9xmp', '9XMP', $data );
	$data = str_replace( '9xep', '9XEP', $data );
	$data = str_replace( '9xm', '9XM', $data );
    $data = str_replace( '9xe', '9XE', $data );
    
	$data = str_replace( '8xt', '8XT', $data );
	$data = str_replace( '8xep', '8XEP', $data );
    $data = str_replace( '8xe', '8XE', $data );
    
	$data = str_replace( '7xt', '7XT', $data );
    $data = str_replace( '7xe', '7XE', $data );
    
	$data = str_replace( '6xt', '6XT', $data );
    $data = str_replace( '6xe', '6XE', $data );
    
	$data = str_replace( '5xt', '5XT', $data );
    $data = str_replace( '5xe', '5XE', $data );
    $data = str_replace( 'sgx', 'SGX', $data );
    
	$data = str_replace( 'gf22fdx', 'GF22FDX', $data );
	$data = str_replace( 'iew220', 'iEW220', $data );
	$data = str_replace( 'fdx ble', 'FDX BLE', $data );
	$data = str_replace( 'global foundaries 22fdx', 'GLOBAL FOUNDARIES 22FDX', $data );
    
    $data = str_replace( 'ensigma rf', 'Ensigma RF', $data );
    $data = str_replace( 'crf5', 'CRF5', $data );
    $data = str_replace( 'crf4', 'CRF4', $data );
    $data = str_replace( '0 rf', '0 RF', $data );
    $data = str_replace( '0 rfic', '0 RFIC', $data );

    $data = str_replace( 'android', 'Android', $data );
    $data = str_replace( 'unity', 'Unity', $data );
    $data = str_replace( 'unreal engine', 'Unreal Engine', $data );
    
	// apply complete string formatting
	switch ( $format ){
		case 'title' :
			return $data = ucwords( $data );
			break;
		case 'sentence' :
			return $data = ucfirst( $data );
			break;
		case 'lowercase' :
			return $data = strtolower( $data );
			break;
		case 'uppercase' :
			return $data = strtoupper( $data );
			break;
    }
    
	// return string fully formatted
	return $data;
}

/* =====================
 * customise Rest API
 */
// Return acf field for event website
add_action( 'rest_api_init', 'itls_add_custom_data_to_json' );
function itls_add_custom_data_to_json(){
    register_rest_field( // post author
        'post', 'post_author', array( 'get_callback' => 'itls_custom_author_call' )
    );
    register_rest_field( // press_releases author
        'press_releases', 'post_author', array( 'get_callback' => 'itls_custom_author_call' )
    );
    register_rest_field( // ecosystem_news author
        'ecosystem_news', 'post_author', array( 'get_callback' => 'itls_custom_author_call' )
    );
}

// get post author's name
function itls_custom_author_call(){
    global $post;

    $post_author = get_the_author(); 
    return $post_author;
}




/* ======================
 * register Rest routes
 */
// rest route url for live search
function itls_register_route_url_livesearch(){
    register_rest_route( 'livesearch/v1', 'results', array(
        'methods'   =>  WP_REST_Server::READABLE,
        'callback'  => 'itls_search_results'
    ) );
}
add_action( 'rest_api_init', 'itls_register_route_url_livesearch' );

// rest route url for products filtering
function itls_register_route_url_products_filters(){
    register_rest_route( 'filtering/v1', 'products', array(
        'methods'   =>  WP_REST_Server::READABLE,
        'callback'  => 'itls_products_filter_results'
    ) );
}
add_action( 'rest_api_init', 'itls_register_route_url_products_filters' );

// rest route url for demos filtering
function itls_register_route_url_demos_filters(){
    register_rest_route( 'filtering/v1', 'demos', array(
        'methods'   =>  WP_REST_Server::READABLE,
        'callback'  => 'itls_demos_filter_results'
    ) );
}
add_action( 'rest_api_init', 'itls_register_route_url_demos_filters' );


// query for demos filters
function itls_demos_filter_results( $data ){

    $excerpt = null;
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    // array with arrays that hold the results
    $results = [];

    // ================
    // PRODUCT DEMOS
    $query_pages = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 50,
        'post_type'         => 'it_product_demos',
        'paged'             => $paged
    ) );
    while ( $query_pages->have_posts() ) :
        $query_pages->the_post();

        if ( get_post_type() == 'it_product_demos' ){
            array_push( $results, array(
                'id'            => get_the_ID(),
                'slug'          => get_post_field( 'post_name', get_the_ID() ),
                'permalink'     => get_the_permalink(),
                'title'         => get_the_title(),
                'excerpt'       => wp_trim_words( get_the_content(), 24 ),
                'imageurl'      => get_the_post_thumbnail_url( get_the_ID(), 'full' ),
                'platform'      => get_field( 'product_demo_product_platform' ),
                'technology'    => get_field( 'product_demo_product_technology' ),
                'soc'           => get_field( 'product_demo_product_soc' ),
                'operating_sys' => get_field( 'product_demo_product_operating_system' ),
                'framework'     => get_field( 'product_demo_demo_framework' ),
				'api'           => get_field( 'product_demo_api' ),
                // 'technologies'  => get_the_terms( $post->ID, 'demo-technologies' ),
				// 'os'            => get_the_terms( $post->ID, 'demo-os' ),
				// 'platforms' 	=> get_the_terms( $post->ID, 'demo-platforms' ),
                // 'apis'          => get_the_terms( $post->ID, 'demo-apis' )
            ) );
        } 
    endwhile; wp_reset_postdata();

    // send results
    return $results;
}


// query for product filters
function itls_products_filter_results( $data ){

    $excerpt = null;
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    // array with arrays that hold the results
    $results = [];

    // ===========
    // PRODUCTS
    $query_pages = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 50,
        'post_type'         => 'it_products',
        'paged'             => $paged
    ) );
    while ( $query_pages->have_posts() ) :
        $query_pages->the_post();

        if ( get_post_type() == 'it_products' ){
            array_push( $results, array(
                'id'            => get_the_ID(),
                'title'         => get_the_title(),
                'excerpt'       => wp_trim_words( get_the_content(), 40 ),
                'permalink'     => get_the_permalink(),
                'family'        => get_field( 'ip_series' )->post_title,
                'technology'    => get_the_terms( $post->ID, 'ip-technology' ),
                'architecture'  => get_the_terms( $post->ID, 'ip-architectures' ),
                'series'        => get_the_terms( $post->ID, 'ip-series' ),
                'performance'   => get_the_terms( $post->ID, 'ip-performance-options' ),
                'markets'       => get_the_terms( $post->ID, 'ip-product-markets' )
            ) );
        }
    endwhile; wp_reset_postdata();

    // send results
    return $results;
}


// query for the live search
function itls_search_results( $data ){

    $excerpt = null;

    // array with arrays that hold the results
    $results = array(
        'mixed'             => [],
        'pages'             => [], 
        'posts'             => [], 
        'our_events'        => [], 
        'webinars'          => [], 
        'presentations'     => [], 
        'press_releases'    => [], 
        'the_news'          => [], 
        'ecosystem_news'    => [], 
        'it_products'       => [], 
        'it_product_demos'  => [], 
        'platforms'         => [],
        'partners'          => [],
        'downloads'         => []
    );

    // ================
    // MIXED RESULTS
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    $query_all = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 100,
        'paged'             => $paged,
        'orderby'           => 'type',
        'order'             => 'DESC',
        'post_type'         => array(
            'it_products',
            'it_product_demos',
            'post', 
            'page', 
            'press_releases', 
            'our_events', 
            'webinars',
            'presentations',
            'the_news',
            'ecosystem_news',
            'platforms',
            'partners',
            'dlm_download'
        )
    ) );
    while ( $query_all->have_posts() ) :

        $query_all->the_post();

        $post_type  = get_post_type();
        $type       = null;

        switch ($post_type) {
            case 'page':                $type = 'Page';                     break;
            case 'post':                $type = 'Blog Post';                break;
            case 'it_products':         $type = 'Products';                 break;
            case 'it_product_demos':    $type = 'Product_demos';            break;
            case 'platforms':           $type = 'Platform';                 break;
            case 'press_releases':      $type = 'Press Release';            break;
            case 'the_news':            $type = 'News Article';             break;
            case 'ecosystem_news':      $type = 'EcoSystem News Article';   break;
            case 'our_events':          $type = 'Event';                    break;
            case 'webinars':            $type = 'Webinar';                  break;
            case 'presentations':       $type = 'Presentation';             break;
            case 'partners':            $type = 'Partner';                  break;
            case 'dlm_download':        $type = 'Download';                 break;
                        
            default:                    $type = '';                         break;
        }

        if ( 
            get_post_type() == 'post' OR 
            get_post_type() == 'page' OR 
            get_post_type() == 'press_releases' OR 
            get_post_type() == 'our_events' OR 
            get_post_type() == 'webinars' OR 
            get_post_type() == 'presentations' OR 
            get_post_type() == 'it_products' OR 
            get_post_type() == 'it_product_demos' OR 
            get_post_type() == 'platforms' OR
            get_post_type() == 'partners' OR 
            get_post_type() == 'dlm_download'
        ){
            array_push( $results[ 'mixed' ], array(
                'id'            => get_the_ID(),
                'slug'          => get_post_field( 'post_name', get_the_ID() ),
                'title'         => get_the_title(),
                'excerpt'       => wp_trim_words( get_the_content(), 25 ),
                'permalink'     => get_the_permalink(),
                'type'          => $type,
                'author'        => get_the_author(),
                'published'     => get_the_date( 'Y/m/d' )
            ) );
        }

        if ( 
            get_post_type() == 'the_news'
        ){
            array_push( $results[ 'mixed' ], array(
                'id'            => get_the_ID(),
                'title'         => get_the_title(),
                'permalink'     => get_field( 'url' ),
                'type'          => $type,
                'published'     => get_the_date( 'Y/m/d' )
            ) );
        }

        if ( 
            get_post_type() == 'ecosystem_news'
        ){
            array_push( $results[ 'mixed' ], array(
                'id'            => get_the_ID(),
                'title'         => get_the_title(),
                'excerpt'       => wp_trim_words( get_the_content(), 25 ),
                'permalink'     => get_field( 'third_party_links' ),
                'type'          => $type,
                'published'     => get_the_date( 'Y/m/d' )
            ) );
        }
    endwhile; wp_reset_postdata();

    // ========
    // PAGES
    $query_pages = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 50,
        'post_type'         => 'page',
        'paged'             => $paged
    ) );
    while ( $query_pages->have_posts() ) :
        $query_pages->the_post();

        if ( get_post_type() == 'page' ){
            array_push( $results[ 'pages' ], array(
                'title'     => get_the_title(),
                'excerpt'   => wp_trim_words( get_the_content(), 25 ),
                'permalink' => get_the_permalink()
            ) );
        }
    endwhile; wp_reset_postdata();


    // =======
    // BLOG
    $query_posts = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 50,
        'post_type'         => 'post',
        'paged'             => $paged
    ) );
    while ( $query_posts->have_posts() ) :
        $query_posts->the_post();

        if ( get_post_type() == 'post' ){
            array_push( $results[ 'posts' ], array(
                'title'     => get_the_title(),
                'excerpt'   => wp_trim_words( get_the_content(), 25 ),
                'permalink' => get_the_permalink(),
                'author'    => get_the_author(),
                'published' => get_the_date( 'Y/m/d' )
            ) );
        }
    endwhile; wp_reset_postdata();

    
    // ===========
    // PRODUCTS
    $query_pvrgpus = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 50,
        'post_type'         => 'it_products',
        'paged'             => $paged
    ) );
    while ( $query_pvrgpus->have_posts() ) :
        $query_pvrgpus->the_post();

        if ( get_post_type() == 'it_products' ){
            array_push( $results[ 'it_products' ], array(
                'title'     => get_the_title(),
                'excerpt'   => wp_trim_words( get_the_content(), 25 ),
                'permalink' => get_the_permalink()
            ) );
        }
    endwhile; wp_reset_postdata();


    // ================
    // PRODUCT DEMOS
    $query_pvrgpus = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 50,
        'post_type'         => 'it_product_demos',
        'paged'             => $paged
    ) );
    while ( $query_pvrgpus->have_posts() ) :
        $query_pvrgpus->the_post();

        if ( get_post_type() == 'it_product_demos' ){
            array_push( $results[ 'it_product_demos' ], array(
                'title'     => get_the_title(),
                'excerpt'   => wp_trim_words( get_the_content(), 25 ),
                'permalink' => get_the_permalink()
            ) );
        }
    endwhile; wp_reset_postdata();


    // ============
    // PLATFORMS
    $query_platforms = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 50,
        'post_type'         => 'platforms',
        'paged'             => $paged
    ) );
    while ( $query_platforms->have_posts() ) :
        $query_platforms->the_post();

        if ( get_post_type() == 'platforms' ){
            array_push( $results[ 'platforms' ], array(
                'title'     => get_the_title(),
                'excerpt'   => wp_trim_words( get_the_content(), 25 ),
                'permalink' => get_the_permalink()
            ) );
        }
    endwhile; wp_reset_postdata();


    // =================
    // PRESS RELEASES
    $query_press = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 50,
        'post_type'         => 'press_releases',
        'paged'             => $paged
    ) );
    while ( $query_press->have_posts() ) :
        $query_press->the_post();

        if ( get_post_type() == 'press_releases' ){
            array_push( $results[ 'press_releases' ], array(
                'title'     => get_the_title(),
                'excerpt'   => wp_trim_words( get_the_content(), 25 ),
                'permalink' => get_the_permalink(),
                'author'    => get_the_author(),
                'published' => get_the_date( 'Y/m/d' )
            ) );
        }
    endwhile; wp_reset_postdata();


    // =======
    // NEWS
    $query_news = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 50,
        'post_type'         => 'the_news',
        'paged'             => $paged
    ) );
    while ( $query_news->have_posts() ) :
        $query_news->the_post();

        if ( get_post_type() == 'the_news' ){
            array_push( $results[ 'the_news' ], array(
                'title'     => get_the_title(),
                'permalink' => get_field( 'url' ),
                'published' => get_the_date( 'Y/m/d' )
            ) );
        }
    endwhile; wp_reset_postdata();


    // =================
    // ECOSYSTEM NEWS
    $query_econews = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 50,
        'post_type'         => 'ecosystem_news',
        'paged'             => $paged
    ) );
    while ( $query_econews->have_posts() ) :
        $query_econews->the_post();

        if ( get_post_type() == 'ecosystem_news' ){
            array_push( $results[ 'ecosystem_news' ], array(
                'title'     => get_the_title(),
                'excerpt'   => wp_trim_words( get_the_content(), 25 ),
                'permalink' => get_field( 'third_party_links' ),
                'author'    => get_the_author(),
                'published' => get_the_date( 'Y/m/d' )
            ) );
        }
    endwhile; wp_reset_postdata();


    // =========
    // EVENTS
    $query_events = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 50,
        'post_type'         => 'our_events',
        'paged'             => $paged
    ) );
    while ( $query_events->have_posts() ) :
        $query_events->the_post();

        if ( get_post_type() == 'our_events' ){
            array_push( $results[ 'our_events' ], array(
                'title'     => get_the_title(),
                'excerpt'   => wp_trim_words( get_the_content(), 25 ),
                'permalink' => get_the_permalink()
            ) );
        }
    endwhile; wp_reset_postdata();


    // ===========
    // WEBINARS
    $query_webinars = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 50,
        'post_type'         => 'webinars',
        'paged'             => $paged
    ) );
    while ( $query_webinars->have_posts() ) :
        $query_webinars->the_post();

        if ( get_post_type() == 'webinars' ){
            array_push( $results[ 'webinars' ], array(
                'title'     => get_the_title(),
                'excerpt'   => wp_trim_words( get_the_content(), 25 ),
                'permalink' => get_the_permalink()
            ) );
        }
    endwhile; wp_reset_postdata();


    // ================
    // PRESENTATIONS
    $query_presentations = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 50,
        'post_type'         => 'presentations',
        'paged'             => $paged
    ) );
    while ( $query_presentations->have_posts() ) :
        $query_presentations->the_post();

        if ( get_post_type() == 'presentations' ){
            array_push( $results[ 'presentations' ], array(
                'title'     => get_field( 'title_presentation' ),
                'excerpt'   => wp_trim_words( get_the_content(), 25 ),
                'event'     => get_the_title(),
                'permalink' => get_the_permalink()
            ) );
        }
    endwhile; wp_reset_postdata();


    // ===========
    // PARTNERS
    $query_partners = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 50,
        'post_type'         => 'partners',
        'paged'             => $paged
    ) );
    while ( $query_partners->have_posts() ) :
        $query_partners->the_post();

        if ( get_post_type() == 'partners' ){
            array_push( $results[ 'partners' ], array(
                'title'     => get_the_title(),
                'excerpt'   => wp_trim_words( get_the_content(), 25 ),
                'permalink' => get_the_permalink()
            ) );
        }
    endwhile; wp_reset_postdata();


    // ============
    // DOWNLOADS
    $query_downloads = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 50,
        'post_type'         => 'dlm_download',
        'paged'             => $paged
    ) );
    while ( $query_downloads->have_posts() ) :
        $query_downloads->the_post();

        if ( get_post_type() == 'dlm_download' ){
            array_push( $results[ 'downloads' ], array(
                'id'            => get_the_ID(),
                'slug'          => get_post_field( 'post_name', get_the_ID() ),
                'title'         => get_the_title(),
                'excerpt'       => wp_trim_words( get_the_content(), 25 ),
                'permalink'     => get_the_permalink()
            ) );
        }
    endwhile; wp_reset_postdata();


    return $results;
}
