<?php

# include the liveSearch functions
it_livesearch_include_file( 'functions.php' );


# ==============
# STYLESHEETS
# --------------
function it_styles(){

    # --------------
    # live search
    # -----------
    # load plugin styles
    # development version - NO CACHING
    wp_enqueue_style( 'plugin-stylesheet', plugins_url( '/_css/live-search.css', __FILE__ ), NULL, microtime() );

    # production version - CACHING ENABLED
    # wp_enqueue_style( 'plugin-stylesheet', plugins_url( '/_css/live-search.css', __FILE__ ), NULL, 4.0 );
    #------ END plugin styles development and production
    
}
add_action( 'wp_enqueue_scripts', 'it_styles' );


# ==========
# SCRIPTS
# ----------
function it_scripts(){

    # --------------
    # live search
    # -----------
    # development version - NO CACHING
    wp_enqueue_script( 'live-search', plugins_url( '/_js/live-search.js', __FILE__ ), array( 'jquery' ), microtime(), true );

    # production version - CACHING ENABLED
    // wp_enqueue_script( 'live-search', plugins_url( '/_js/live-search.js', __FILE__ ), array( 'jquery' ), '4.0', true );

    # localize for use with main live-search.js
    wp_localize_script( 'live-search', 'liveSearch', array(
        'site_root'         => get_site_url(),
        'plugin_root'       => plugins_url( '/' ),
        '_imgfolder_root'   => plugins_url( '/_img/', __FILE__ )
    ) );

    
    # ------------
    # load more
    # ---------
    # development version - NO CACHING
    // wp_enqueue_script( 'load-more', plugins_url( '/_js/load-more.js', __FILE__ ), array( 'jquery' ), microtime(), true );

    # production version - CACHING ENABLED
    // wp_enqueue_script( 'load-more', plugins_url( '/_js/load-more.js', __FILE__ ), array( 'jquery' ), '4.0', true );

}
add_action( 'wp_enqueue_scripts', 'it_scripts' );