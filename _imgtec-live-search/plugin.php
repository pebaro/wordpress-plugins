<?php
# include the liveSearch functions
it_livesearch_include_file( 'functions.php' );


#######################
##### STYLESHEETS #####
#######################
function it_styles(){
    # --------------
    # live search
    # -----------
    # development version - NO CACHING
    wp_enqueue_style( 'plugin-stylesheet', plugins_url( '/_css/live-search.css', __FILE__ ), NULL, microtime() );

    # production version - CACHING ENABLED
    // wp_enqueue_style( 'plugin-stylesheet', plugins_url( '/_css/live-search.css', __FILE__ ), NULL, LIVESEARCH_VERSION );
    #------ END live search
    
    # -------------------
    # products filters
    # ----------------
    if ( is_page( 'product-finder-2019' ) ) :
        # development version - NO CACHING
        wp_enqueue_style( 'filtering-stylesheet', plugins_url( '/_css/products-filters.css', __FILE__ ), NULL, microtime() );

        // # production version - CACHING ENABLED
        // wp_enqueue_style( 'plugin-stylesheet', plugins_url( '/_css/products-filters.css', __FILE__ ), NULL, LIVESEARCH_VERSION );
    endif;
    #------ END products filters
    
    # ----------------
    # demos filters
    # -------------
    if ( is_page( 'demos' ) ) :
        # development version - NO CACHING
        wp_enqueue_style( 'demos-filtering-stylesheet', plugins_url( '/_css/demos-filters.css', __FILE__ ), NULL, microtime() );

        // # production version - CACHING ENABLED
        // wp_enqueue_style( 'demos-filtering-stylesheet', plugins_url( '/_css/demos-filters.css', __FILE__ ), NULL, LIVESEARCH_VERSION );
    endif;
    #------ END products filters
}
add_action( 'wp_enqueue_scripts', 'it_styles' );


###################
##### SCRIPTS #####
###################
function it_scripts(){
    # --------------
    # live search
    # -----------
    # development version - NO CACHING
    // wp_enqueue_script( 'live-search', plugins_url( '/_js/live-search.js', __FILE__ ), array( 'jquery' ), microtime(), true );

    # production version - CACHING ENABLED
    wp_enqueue_script( 'live-search', plugins_url( '/_js/live-search.js', __FILE__ ), array( 'jquery' ), LIVESEARCH_VERSION, true );

    # localize for use with main live-search.js
    wp_localize_script( 'live-search', 'liveSearch', array(
        'site_root'         => get_site_url(),
        'plugin_root'       => plugins_url( '/' ),
        '_imgfolder_root'   => plugins_url( '/_img/', __FILE__ )
    ) );

    # -------------------
    # products filters
    # ----------------
    if ( is_page( 'product-finder-2019' ) ) :

        # ===== initialize ===== #
        # development version - CACHING DISABLED
        wp_enqueue_script( 'products-filtering-initialize', plugins_url( '/_js/products-filtering-initialize.js', __FILE__ ), array( 'jquery' ), microtime(), true );
        # production version - CACHING ENABLED
        // wp_enqueue_script( 'products-filtering-initialize', plugins_url( '/_js/products-filtering-initialize.js', __FILE__ ), array( 'jquery' ), LIVESEARCH_VERSION, true ); b 
        # localize
        wp_localize_script( 'products-filtering-initialize', 'productsFilteringInitialize', array(
            'site_root'         => get_site_url(),
            'plugin_root'       => plugins_url( '/' ),
            '_imgfolder_root'   => plugins_url( '/_img/', __FILE__ )
        ) );


        # ===== create html ===== #
        # development version - CACHING DISABLED
        wp_enqueue_script( 'products-filtering-html', plugins_url( '/_js/products-filtering-html.js', __FILE__ ), array( 'jquery' ), microtime(), true );
        # production version - CACHING ENABLED
        // wp_enqueue_script( 'products-filtering-html', plugins_url( '/_js/products-filtering-html.js', __FILE__ ), array( 'jquery' ), LIVESEARCH_VERSION, true );


        # ===== functions ===== #
        # development version - CACHING DISABLED
        wp_enqueue_script( 'products-filtering-functions', plugins_url( '/_js/products-filtering-functions.js', __FILE__ ), array( 'jquery' ), microtime(), true );
        # production version - CACHING ENABLED
        // wp_enqueue_script( 'products-filtering-functions', plugins_url( '/_js/products-filtering-functions.js', __FILE__ ), array( 'jquery' ), LIVESEARCH_VERSION, true );
        # localize
        wp_localize_script( 'products-filtering-functions', 'productsFunctionsFunctions', array(
            'site_root'         => get_site_url(),
            'plugin_root'       => plugins_url( '/' ),
            '_imgfolder_root'   => plugins_url( '/_img/', __FILE__ )
        ) );

        # ===== filtering app ===== #
        # development version - CACHING DISABLED
        // wp_enqueue_script( 'products-filtering-app', plugins_url( '/_js/products-filtering-app.js', __FILE__ ), array( 'jquery' ), microtime(), true );
        # production version - CACHING ENABLED
        // wp_enqueue_script( 'products-filtering-app', plugins_url( '/_js/products-filtering-app.js', __FILE__ ), array( 'jquery' ), LIVESEARCH_VERSION, true );
    endif;

    if ( is_page( 'product-finder' ) ) :

        # ===== products-ids.js ===== #
        # development version - CACHING DISABLED
        wp_enqueue_script( 'products-ids', plugins_url( '/_js/products-ids.js', __FILE__ ), array( 'jquery' ), microtime(), true );

        # production version - CACHING ENABLED
        // wp_enqueue_script( 'products-ids', plugins_url( '/_js/products-ids.js', __FILE__ ), array( 'jquery' ), LIVESEARCH_VERSION, true );

        # localize for use with main products-ids.js
        wp_localize_script( 'products-ids', 'productsIDs', array(
            'site_root'         => get_site_url(),
            'plugin_root'       => plugins_url( '/' ),
            '_imgfolder_root'   => plugins_url( '/_img/', __FILE__ )
        ) );


        # ===== products-filters.js ===== #
        # development version - CACHING DISABLED
        wp_enqueue_script( 'products-filters', plugins_url( '/_js/products-filters.js', __FILE__ ), array( 'jquery' ), microtime(), true );
        # production version - CACHING ENABLED
        // wp_enqueue_script( 'products-filters', plugins_url( '/_js/products-filters.js', __FILE__ ), array( 'jquery' ), LIVESEARCH_VERSION, true );

        # localize for use with main products-filters.js
        wp_localize_script( 'products-filters', 'productsFilters', array(
            'site_root'         => get_site_url(),
            'plugin_root'       => plugins_url( '/' ),
            '_imgfolder_root'   => plugins_url( '/_img/', __FILE__ )
        ) );
    endif;

    # ----------------
    # demos filters
    # -------------
    # load demos filters on the stated pages only
    if ( is_page( 'demos' ) ) :
        # development version - NO CACHING
        // wp_enqueue_script( 'demos-filters-html', plugins_url( '/_js/demos-filters-html.js', __FILE__ ), array( 'jquery' ), microtime(), true );
        # production version - CACHING ENABLED
        // wp_enqueue_script( 'demos-filters-html', plugins_url( '/_js/demos-filters-html.js', __FILE__ ), array( 'jquery' ), LIVESEARCH_VERSION, true );


        # development version - NO CACHING
        // wp_enqueue_script( 'demos-filters-class', plugins_url( '/_js/demos-filters-class.js', __FILE__ ), array( 'jquery' ), microtime(), true );
        # production version - CACHING ENABLED
        // wp_enqueue_script( 'demos-filters-class', plugins_url( '/_js/demos-filters-class.js', __FILE__ ), array( 'jquery' ), LIVESEARCH_VERSION, true );


        # ===== filtering application ===== #
        # development version - NO CACHING
        wp_enqueue_script( 'demos-filters-app', plugins_url( '/_js/demos-filters-app.js', __FILE__ ), array( 'jquery' ), microtime(), true );
        # production version - CACHING ENABLED
        // wp_enqueue_script( 'demos-filters-app', plugins_url( '/_js/demos-filters-app.js', __FILE__ ), array( 'jquery' ), LIVESEARCH_VERSION, true );

        # localize php for use with javascript
        // wp_localize_script( 'demos-filters-class', 'demosFiltersClass', array(
        //     'site_root'         => get_site_url(),
        //     'plugin_root'       => plugins_url( '/' ),
        //     '_imgfolder_root'   => plugins_url( '/_img/', __FILE__ )
        // ) );
        wp_localize_script( 'demos-filters-app', 'demosFiltersApp', array(
            'site_root'         => get_site_url(),
        ) );
        endif;
}
add_action( 'wp_enqueue_scripts', 'it_scripts' );
