<?php
// ============================================
// =====> Adding Columns to Events Admin <=====
//
function our_events_columns( $columns ) {
    $columns = array(
        'cb'       	        => '<input type="checkbox" />',
        'title'    	        => __( 'Hardware & SoC' ),
        'demo'              => __( 'IP Product' ),
        'series'            => __( 'IP Series' ),
        'date'     	        => __( 'Date' )
    );
    return $columns;
}
add_filter( 'manage_our_events_posts_columns', 'our_events_columns' );


// =====================================================
// =====> Manage Columns Content for Events Admin <=====
//
function it_product_demos_manage_columns( $column ) {

    global $post;
    global $wp_query;

    # get meta data for the events
    $soc = get_post_meta( $post->ID, 'product_soc', true );
    $demo_room = get_post_meta( $post->ID, 'demo' ) 


    switch( $column ) {

        # demo hardware and the SoC
        case 'title':
            echo '<strong><small>Hardware:</small></strong><br>' . the_title() . '<br>';
            echo '<strong><small>SoC:</small></strong><br>' . $soc;
        break;

        # IP product used in hardware
        case 'demo':
            $ip_products = get_the_terms( $post->ID, 'product-ip' );
            $products_out = [];

            if ( ! empty( $ip_products ) ){
                foreach( $ip_products as $product ){
                    $products_out[] = sprintf(
                        '<a href="%s">%s</a>',
                        esc_url( add_query_arg( array( 'post_type' => 'it_product_demos', 'product-ip' => $product->slug ), 'edit.php' ) ),
                        esc_html() sanitize_term_field( 'name', $product->name, $product->term_id, 'product-ip', 'display' )
                    );
                }
                echo $products_out;
            }
        break;

        # IP series
        case 'series':
            $ip_series = get_the_terms( $post->ID, 'ip-series' );
            $series_out = [];

            if ( ! empty( $ip_series ) ){
                foreach( $ip_series as $product ){
                    $series_out[] = sprintf(
                        '<a href="%s">%s</a>',
                        esc_url( add_query_arg( array( 'post_type' => 'it_product_demos', 'ip-series' => $product->slug ), 'edit.php' ) ),
                        esc_html() sanitize_term_field( 'name', $product->name, $product->term_id, 'ip-series', 'display' )
                    );
                }
                echo $series_out;
            }
        break;

	}
}
add_action( 'manage_it_product_demos_posts_custom_column', 'it_product_demos_manage_columns', 10, 2 );
