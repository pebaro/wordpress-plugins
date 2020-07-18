<?php

/* =====================
 * customise Rest API
 */
 add_action( 'rest_api_init', 'it_add_author_name_to_json' );
 function it_add_author_name_to_json(){
    register_rest_field( 'post', 'author_name', array(
        'get_callback' => function(){
            return get_the_author();
        }
    ) );
}

// Return acf field for event website
add_action( 'rest_api_init', 'add_customdatanamehere_to_json' );
function add_customdatanamehere_to_json(){
    register_rest_field(
        'post_type', // the post type
        'json_element', // name the json element
        array(
            'get_callback' => 'customdatanamehere_return_type', // function that creates content 
        )
    );
}
function customdatanamehere_return_type(){
    global $post;
    $event_website = get_field( 'event_web_url', $post->ID ); 
    return $event_website;
}



/* ======================
 * register Rest route
 */
function it_live_search_register_route_url(){
    register_rest_route( 'livesearch/v1', 'results', array(
        'methods'       =>  WP_REST_Server::READABLE,
        'callback'      => 'imgtec_live_search_results'
    ) );
}
add_action( 'rest_api_init', 'it_live_search_register_route_url' );


// query for the live search
function imgtec_live_search_results( $data ){

    $excerpt = null;

    // array with arrays that hold the results
    $results = array(
        'mixed'          => [],
        'pages'          => [], 
        'posts'          => [], 
        'our_events'     => [], 
        'webinars'       => [], 
        'presentations'  => [], 
        'press_releases' => [], 
        'the_news'       => [], 
        'ecosystem_news' => [], 
        'powervr_gpus'   => [], 
        'platforms'      => [],
        'partners'       => []
    );

    // ================
    // MIXED RESULTS
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    $query_all = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 100,
        'paged'             => $paged,
        'orderby'           => 'post_date',
        'order'             => 'DESC',
        'post_type'         => array(
            'post', 
            'page', 
            'press_releases', 
            'our_events', 
            'webinars',
            'presentations',
            'the_news',
            'ecosystem_news',
            'powervr_gpus',
            'platforms',
            'partners'
        )
    ) );
    while ( $query_all->have_posts() ) :

        $query_all->the_post();

        $post_type  = get_post_type();
        $type       = null;

        switch ($post_type) {
            case 'page':           $type = 'Page';                   break;
            case 'post':           $type = 'Blog Post';              break;
            case 'powervr_gpus':   $type = 'PowerVR Core';           break;
            case 'platforms':      $type = 'Platform';               break;
            case 'press_releases': $type = 'Press Release';          break;
            case 'the_news':       $type = 'News Article';           break;
            case 'ecosystem_news': $type = 'EcoSystem News Article'; break;
            case 'our_events':     $type = 'Event';                  break;
            case 'webinars':       $type = 'Webinar';                break;
            case 'presentations':  $type = 'Presentation';           break;
            case 'partners':       $type = 'Partner';                break;
                        
            default:               $type = '';                       break;
        }

        if ( 
            get_post_type() == 'post' OR 
            get_post_type() == 'page' OR 
            get_post_type() == 'press_releases' OR 
            get_post_type() == 'our_events' OR 
            get_post_type() == 'webinars' OR 
            get_post_type() == 'presentations' OR 
            get_post_type() == 'the_news' OR 
            get_post_type() == 'ecosystem_news' OR 
            get_post_type() == 'powervr_gpus' OR 
            get_post_type() == 'platforms' OR
            get_post_type() == 'partners'
        ){
            array_push( $results[ 'mixed' ], array(
                'title'     => get_the_title(),
                'excerpt'   => wp_trim_words( get_the_content(), 45 ) . '&hellip;',
                'permalink' => get_the_permalink(),
                'type'      => $type
            ) );
        }
    endwhile; wp_reset_postdata();

    // ========
    // PAGES
    $query_pages = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 100,
        'post_type'         => 'page',
        'paged'             => $paged
    ) );
    while ( $query_pages->have_posts() ) :
        $query_pages->the_post();

        if ( get_post_type() == 'page' ){
            array_push( $results[ 'pages' ], array(
                'title'     => get_the_title(),
                'excerpt'   => wp_trim_words( get_the_content(), 25 ) . '&hellip;',
                'permalink' => get_the_permalink()
            ) );
        }
    endwhile; wp_reset_postdata();


    // =======
    // BLOG
    $query_posts = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 100,
        'post_type'         => 'post',
        'paged'             => $paged
    ) );
    while ( $query_posts->have_posts() ) :
        $query_posts->the_post();

        if ( get_post_type() == 'post' ){
            array_push( $results[ 'posts' ], array(
                'title'     => get_the_title(),
                'excerpt'   => wp_trim_words( get_the_content(), 15 ) . '&hellip;',
                'permalink' => get_the_permalink()
            ) );
        }
    endwhile; wp_reset_postdata();


    // ================
    // POWERVR CORES
    $query_pvrgpus = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 100,
        'post_type'         => 'powervr_gpus',
        'paged'             => $paged
    ) );
    while ( $query_pvrgpus->have_posts() ) :
        $query_pvrgpus->the_post();

        if ( get_post_type() == 'powervr_gpus' ){
            array_push( $results[ 'powervr_gpus' ], array(
                'title'         => 'PowerVR ' . get_the_title(),
                'excerpt'   => wp_trim_words( get_the_content(), 15 ) . '&hellip;',
                'permalink'     => get_the_permalink()
            ) );
        }

    endwhile; wp_reset_postdata();


    // ============
    // PLATFORMS
    $query_platforms = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 100,
        'post_type'         => 'platforms',
        'paged'             => $paged
    ) );
    while ( $query_platforms->have_posts() ) :
        $query_platforms->the_post();

        if ( get_post_type() == 'platforms' ){
            array_push( $results[ 'platforms' ], array(
                'title'     => get_the_title(),
                'excerpt'   => wp_trim_words( get_the_content(), 15 ) . '&hellip;',
                'permalink' => get_the_permalink()
            ) );
        }

    endwhile; wp_reset_postdata();


    // =================
    // PRESS RELEASES
    $query_press = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 100,
        'post_type'         => 'press_releases',
        'paged'             => $paged
    ) );
    while ( $query_press->have_posts() ) :
        $query_press->the_post();

        if ( get_post_type() == 'press_releases' ){
            array_push( $results[ 'press_releases' ], array(
                'title'     => get_the_title(),
                'excerpt'   => wp_trim_words( get_the_content(), 15 ) . '&hellip;',
                'permalink' => get_the_permalink()
            ) );
        }

    endwhile; wp_reset_postdata();


    // =======
    // NEWS
    $query_news = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 100,
        'post_type'         => 'the_news',
        'paged'             => $paged
    ) );
    while ( $query_news->have_posts() ) :
        $query_news->the_post();

        if ( get_post_type() == 'the_news' ){
            array_push( $results[ 'the_news' ], array(
                'title'     => get_the_title(),
                'permalink' => get_the_permalink()
            ) );
        }

    endwhile; wp_reset_postdata();


    // =================
    // ECOSYSTEM NEWS
    $query_econews = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 100,
        'post_type'         => 'ecosystem_news',
        'paged'             => $paged
    ) );
    while ( $query_econews->have_posts() ) :
        $query_econews->the_post();

        if ( get_post_type() == 'ecosystem_news' ){
            array_push( $results[ 'ecosystem_news' ], array(
                'title'     => get_the_title(),
                'excerpt'   => wp_trim_words( get_the_content(), 15 ) . '&hellip;',
                'permalink' => get_the_permalink()
            ) );
        }

    endwhile; wp_reset_postdata();


    // =========
    // EVENTS
    $query_events = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 100,
        'post_type'         => 'our_events',
        'paged'             => $paged
    ) );
    while ( $query_events->have_posts() ) :
        $query_events->the_post();

        if ( get_post_type() == 'our_events' ){
            array_push( $results[ 'our_events' ], array(
                'title'     => get_the_title(),
                'excerpt'   => wp_trim_words( get_the_content(), 15 ) . '&hellip;',
                'permalink' => get_the_permalink()
            ) );
        }

    endwhile; wp_reset_postdata();


    // ===========
    // WEBINARS
    $query_webinars = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 100,
        'post_type'         => 'webinars',
        'paged'             => $paged
    ) );
    while ( $query_webinars->have_posts() ) :
        $query_webinars->the_post();

        if ( get_post_type() == 'webinars' ){
            array_push( $results[ 'webinars' ], array(
                'title'     => get_the_title(),
                'excerpt'   => wp_trim_words( get_the_content(), 15 ) . '&hellip;',
                'permalink' => get_the_permalink()
            ) );
        }

    endwhile; wp_reset_postdata();


    // ================
    // PRESENTATIONS
    $query_presentations = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 100,
        'post_type'         => 'presentations',
        'paged'             => $paged
    ) );
    while ( $query_presentations->have_posts() ) :
        $query_presentations->the_post();

        if ( get_post_type() == 'presentations' ){
            array_push( $results[ 'presentations' ], array(
                'title'     => get_field( 'title_presentation' ),
                'excerpt'   => wp_trim_words( get_the_content(), 15 ) . '&hellip;',
                'event'     => get_the_title(),
                'permalink' => get_the_permalink()
            ) );
        }

    endwhile; wp_reset_postdata();


    // ===========
    // PARTNERS
    $query_partners = new WP_Query( array(
        's'                 => sanitize_text_field( $data[ 'terms' ] ),
        'posts_per_page'    => 100,
        'post_type'         => 'partners',
        'paged'             => $paged
    ) );
    while ( $query_partners->have_posts() ) :
        $query_partners->the_post();

        if ( get_post_type() == 'partners' ){
            array_push( $results[ 'partners' ], array(
                'title'     => get_the_title(),
                'excerpt'   => wp_trim_words( get_the_content(), 15 ) . '&hellip;',
                'permalink' => get_the_permalink()
            ) );
        }

    endwhile; wp_reset_postdata();


    return $results;
}
