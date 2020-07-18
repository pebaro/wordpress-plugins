<?php
// disables the auto-refresh in FacetWP
function imgtec_disable_facetwp_autorefresh() { ?><script>
	(function($){
	    $(function(){
	        FWP.auto_refresh = false;
	    });
	})(jQuery);
</script><?php }
// add_action( 'wp_head', 'imgtec_disable_facetwp_autorefresh', 100 );


// filter to change date format for display value
$params = array(
    'facet_name'            => 'press_releases_date',
    'facet_source'          => 'post_date',
    'facet_value'           => date('Y-m-d-H:i:s'),
    'facet_display_value'   => date('Y-m-d H:i:s'),
    'term_id'               => 0,
    'parent_id'             => 0,
    'depth'                 => 0,
    'variation_id'          => 0
);
add_filter( 'facetwp_index_row', function( $params, $class ) {
    if ( 'press_releases_date' == $params['facet_name'] ) {
        $raw_value = $params['facet_value'];
        $params['facet_value'] = date( 'Y', strtotime( $raw_value ) );
        $params['facet_display_value'] = date( 'Y', strtotime( $raw_value ) );
    }
    return $params;
}, 10, 2 );

$params = array(
    'facet_name'            => 'in_the_news_date',
    'facet_source'          => 'post_date',
    'facet_value'           => date('Y-m-d-H:i:s'),
    'facet_display_value'   => date('Y-m-d H:i:s'),
    'term_id'               => 0,
    'parent_id'             => 0,
    'depth'                 => 0,
    'variation_id'          => 0
);
add_filter( 'facetwp_index_row', function( $params, $class ) {
    if ( 'in_the_news_date' == $params['facet_name'] ) {
        $raw_value = $params['facet_value'];
        $params['facet_value'] = date( 'Y', strtotime( $raw_value ) );
        $params['facet_display_value'] = date( 'Y', strtotime( $raw_value ) );
    }
    return $params;
}, 10, 2 );

// filter to change sort order
function my_facetwp_sort_options( $options, $params ) {
    $options['in_the_news_date'] = array(
        // 'label' => 'Years',
        'query_args' => array(
            'orderby' => 'post_date', // sort by numerical custom field
            'order' => 'DESC', // descending order
        )
    );
    return $options;
}

add_filter( 'facetwp_sort_options', 'my_facetwp_sort_options', 10, 2 );



// set the number of post views
function imgtec_set_post_views($postID) {
    $count_key = 'imgtec_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
// get rid of prefetching for accuracy
// remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

// track the number of post views
function imgtec_track_post_views ($postID) {
    if ( !is_single() ) return;
    if ( empty ( $postID) ) {
        global $post;
        $postID = $post->ID;
    }
    imgtec_set_post_views($postID);
}
// add_action( 'wp_head', 'imgtec_track_post_views');

// generate_after_header - condition based to change depending on the page/post/post typ/etc
// add_action( 'generate_after_header','generate_after_header_section' );
function generate_after_header_section() {
    if ( is_front_page() && is_home() ) {
        // Default homepage
        // echo 'this is the DEFAULT homepage';

    } elseif ( is_front_page() ) {
        // static homepage
        // echo 'this is the STATIC homepage';

    } elseif ( is_home() ) {
        // blog page
        imgtec_after_blog_header();

    } //elseif (is_singular('post')) {
        // single blog post
        //imgtec_after_post_header();
    //}
		else {
        //everything else
        // echo 'this is everything else';
    }
}

function imgtec_after_blog_header(){ ?>
    <section id="imgtec-after-blog-header">
        <h1>Imagination Blog</h1>
    </section><?php
}


// generate_before_footer - condition based to change depending on the page/post/post typ/etc
// add_action( 'generate_before_footer','generate_before_footer_section' );

function generate_before_footer_section() {
    if ( is_front_page() && is_home() ) {
        // Default homepage
        // echo 'this is the DEFAULT homepage';

    } elseif ( is_front_page() ) {
        // static homepage
        // echo 'this is the STATIC homepage';

    } elseif ( is_home() ) {
        // blog page
        imgtec_popular_posts_section();
        imgtec_subscribe_to_mailing_list();

    } elseif (is_singular('post')) {
        // single blog post
        //imgtec_single_post_section();
        //imgtec_subscribe_to_mailing_list();

    } else {
        //everything else
        // echo 'this is everything else';
    }
}

function imgtec_popular_posts_section(){
    $popularpost = new WP_Query( array( 'posts_per_page' => 8, 'meta_key' => 'imgtec_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC'  ) ); ?>
    <section id="imgtec-popular-posts-section">
        <h1>Popular Blog Posts</h1>
        <div class="imgtec-popular-posts-container">
            <?php while ( $popularpost->have_posts() ) : $popularpost->the_post(); ?>
                <?php
                $date           = get_the_date('d M Y');
                $firstName      = get_the_author_meta('user_firstname');
                $lastName       = get_the_author_meta('user_lastname');
                $categories     = get_the_category();
                ?>
                <div class="imgtec-popular-post">
                    <a class="imgtec-popular-post-linkwrap" href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('small'); ?>
                        <div class="meta-info">
                            <p><span class="imgtec-popular-post-date"><?php echo $date; ?></span> <span class="imgtec-popular-post-author"><?php echo $firstName . ' ' . $lastName; ?></span></p>
                            <p><?php the_title(); ?></p>
                            <p class="imgtec-popular-post-category"><?php foreach ($categories as $category) {
                                echo $category->name;
                            } ?></p>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </section><?php
}


function imgtec_single_post_section(){ ?>
    <section id="imgtec-popular-posts-section">
        <h1>Related blog articles</h1>
        <div class="imgtec-popular-posts-container"><?php
            global $post;
            $tags = wp_get_post_tags($post->ID);

            if ($tags) {
                $tag_ids = array();

                foreach($tags as $individual_tag) {
                    $tag_ids[] = $individual_tag->term_id;
                }

                $args = array(
                    'tag__in'               => $tag_ids,
                    'post__not_in'          => array($post->ID),
                    'posts_per_page'        => 8,
                    'ignore_sticky_posts'   => 1
                );

                $my_query = new wp_query($args);

                while($my_query->have_posts()) : $my_query->the_post();
                    $date           = get_the_date('d M Y');
                    $firstName      = get_the_author_meta('user_firstname');
                    $lastName       = get_the_author_meta('user_lastname');
                    $categories     = get_the_category();
                    ?>

                    <div class="imgtec-popular-post">
                        <a class="imgtec-popular-post-linkwrap" href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('small'); ?>
                            <div class="meta-info">
                                <p><span class="imgtec-popular-post-date"><?php echo $date; ?></span> <span class="imgtec-popular-post-author"><?php echo $firstName . ' ' . $lastName; ?></span></p>
                                <p><?php the_title(); ?></p>
                                <p class="imgtec-popular-post-category"><?php foreach ($categories as $category) {
                                    echo $category->name;
                                } ?></p>
                            </div>
                        </a>
                    </div><?php

                endwhile;
            }
            wp_reset_query(); ?>
        </div>
    </section><?php
}




/***
 * string replace function
 */
function imgtec_string_replace_func($string){
    $string  = str_replace( '-', ' ', $string );
    $string .= str_replace( '_', ' ', $string );
    $string .= str_replace( 'gpu', 'GPU', $string );
	$string = str_replace( 'powervr', 'PowerVR', $string );
    $string .= str_replace( 'tiers', 'tier', $string );

    return $string;
}
function imgtec_string_replace_rename_func($string){
    $string  = str_replace( '-', ' ', $string );
    $string .= str_replace( '_', ' ', $string );
    $string .= str_replace( 'gpu', 'GPU', $string );
	$string = str_replace( 'powervr', 'PowerVR', $string );
    $string .= str_replace( 'tiers', 'tier', $string );

    $outputString = string;
    $outputString = $string;

    return $outputString;
}

/**
 * list all taxonomies for a cpt followed by the terms for each taxonomy
 */
function imgtec_masonry_list_terms_links( $cpt_names ){
	// get all associated taxonomies
	$all_cpt_taxonomies = get_object_taxonomies( $cpt_names, 'objects' );

	// get terms for each taxonomy
	foreach ( $all_cpt_taxonomies as $cpt_taxonomy ) {
		$tax_terms = get_terms( $cpt_taxonomy->name );
		$terms_list = [];

		// put terms into an array and format the output to filtered list
		foreach ( $tax_terms as $tax_term ) {
			$terms_href = '?_' . $cpt_taxonomy->name . '=' . $tax_term->name;
			$terms_list[] = '<a href="' . $terms_href . '" class="imgtec-tax-term" aria-label="'. $term->name .' filter">' . $tax_term->name . '</a>';
		}
		// format terms list
		$terms = join(', ', $terms_list);

        // create list of links to FacetWP terms filter for each taxonomy
		?><p><strong><?php
            echo ucwords( $cpt_taxonomy->name ); ?>:</strong>
            <span class="imgtec-tax-terms-list"><?php echo ucwords( $terms );
        ?></span></p><?php
	}
}


/**
 * does the same as the function above but calculates the post type
 */
function imgtec_list_all_taxonomies_with_selected_terms(){
    // get the post type
    $CPT = get_post_type( get_the_ID() );

    // get the taxonomies
    $all_taxonomies = get_object_taxonomies( $CPT, 'objects' );

    // get the terms for each taxonomy
    foreach ($all_taxonomies as $taxonomy) {
        $all_terms = wp_get_post_terms( get_the_ID(), $taxonomy->name );

        // place terms into an array to format later
        $terms_list = [];
        foreach ( $all_terms as $term ) {
            // build the href
            $href = '?_' . $taxonomy->name . '=' . $term->slug;

            // build a list of links
            $terms_list[] = '<a href="/' . $href . '" class="imgtec-tax-term" aria-label="'. $term->name .' filter">' . $term->name . '</a>';
        }
        // format the list
        $output_terms = join( ', ', $terms_list );

        // render each taxonomy with it's selected terms per paragraph
        $combined_output  = '<p class="imgtec-tax-terms-list"><strong>';
        $combined_output .= imgtec_cpt_listing_name( $taxonomy ) . ':</strong> ';
        $combined_output .= imgtec_cpt_listing_name( $output_terms ) . '</p>';

        // output the result
        echo $combined_output;
    }
}
function imgtec_list_all_taxonomies_with_selected_terms_as_text(){
	// get the post type
	$CPT = get_post_type( get_the_ID() );

	// get the taxonomies
	$all_taxonomies = get_object_taxonomies( $CPT, 'objects' );

	// get the terms for each taxonomy
	foreach ($all_taxonomies as $taxonomy) {
		$all_terms = wp_get_post_terms( get_the_ID(), $taxonomy->name );

		// place terms into an array to format later
		$terms_list = [];
		foreach ( $all_terms as $term ) {
			// build a list of terms
			$terms_list[] = '<span class="imgtec-tax-term">' . $term->name . '</span>';
		}
		// format the list
		$output_terms = join( ', ', $terms_list );

        if ($output_terms){
    		// render each taxonomy with it's selected terms per paragraph
            $combined_output  = '<p class="imgtec-tax-terms-list"><strong>';
            $combined_output .= imgtec_cpt_listing_name( $taxonomy ) . ':</strong> ';
            $combined_output .= imgtec_cpt_listing_name( $output_terms ) . '</p>';

            // output the result
            echo $combined_output;
        }
	}
}


/**
 * Lists all Post Types in a seperate paragraph
 * Each Post Type is followed by a comma seperated list of the selected terms
 * Each Term is converted to a link back to the parent page
 * Each Link also triggers the filtering of this Term using FacetWP
 * -----------------------------------------------------------------
 * Set the following arguments:
 * $link_prefix - part of the url that comes after domain E.G. href="imgtec.com/$link_prefix/..."
 * $facetwp_adds - part of the url added by FacetWP E.G. href="imgtec.com/$link_prefix/?_taxonomy_name_$facetwp_adds=..."
 */
function imgtec_all_taxonomies_with_selected_terms_links( $link_prefix, $facetwp_adds = null ){
    // get the post type
    $CPT = get_post_type( get_the_ID() );

    // get the taxonomies
    $all_taxonomies = get_object_taxonomies( $CPT, 'objects' );

    // get the terms for each taxonomy
    foreach ($all_taxonomies as $taxonomy) {
        $all_terms = wp_get_post_terms( get_the_ID(), $taxonomy->name );

        // place terms into an array to format later
        $terms_list = [];
        foreach ( $all_terms as $term ) {
            if ( ! empty( $term->slug ) ) {
                // build the href
                $href = '/' . $link_prefix . '/?_' . str_replace( '-', '_', $taxonomy->name ) . $facetwp_adds . '=' . $term->slug;

                // build a list of links
                $terms_list[] = '<a href="' . $href . '" class="imgtec-tax-term" aria-label="'. $term->name .' filter">' . $term->name . '</a>';
            }
        }
        // format the list
        $output_terms = join( ', ', $terms_list );

        // if terms have been selected then create the output
        if ( $output_terms ) {
            // render each taxonomy with it's selected terms per paragraph
            $combined_output  = '<p class="imgtec-tax-terms-list"><strong>';
            $combined_output .= imgtec_cpt_listing_name( $taxonomy ) . ':</strong> ';
            $combined_output .= imgtec_cpt_listing_name( $output_terms ) . '</p>';

            // output the result
            echo $combined_output;
        }
    }
}


// as above but moving the $facet_adds part of the GET query to prefix position
function imgtec_all_taxonomies_with_selected_prefixed_terms_links( $link_prefix, $facetwp_adds = null ){

    // get the post type
    $CPT = get_post_type( get_the_ID() );

    // get the taxonomies
    $all_taxonomies = get_object_taxonomies( $CPT, 'objects' );

    // get the terms for each taxonomy
    foreach ($all_taxonomies as $taxonomy) {
        $all_terms = wp_get_post_terms( get_the_ID(), $taxonomy->name );

        // array to store the terms
        $terms_list = [];

        foreach ( $all_terms as $term ) {
            if ( ! empty( $term->slug ) ) {

                // build the href for the links
                $href = '/' . $link_prefix . '/?_' . $facetwp_adds . str_replace( '-', '_', $taxonomy->name ) . '=' . $term->slug;

                // build a list of links
                $terms_list[] = '<a href="' . $href . '" class="imgtec-tax-term" aria-label="'. $term->name .' filter">' . $term->name . '</a>';
            }
        }

        // format the list
        $output_terms = join( ', ', $terms_list );

        // if terms have been selected then create the output
        if ( $output_terms ) {
            // render each taxonomy with it's selected terms per paragraph
            $combined_output  = '<p class="imgtec-tax-terms-list"><strong>';
            $combined_output .= imgtec_cpt_listing_name( $taxonomy ) . ':</strong> ';
            $combined_output .= imgtec_cpt_listing_name( $output_terms ) . '</p>';

            // output the result
            echo $combined_output;
        }
    }
}

/**
 * same as above but without conversion into links
 */
function imgtec_set_taxonomies_with_selected_terms( $tax_array ){
    // get the terms for each taxonomy
    foreach ($tax_array as $taxonomy) {
        $all_terms = wp_get_post_terms( get_the_ID(), $taxonomy );

        // place terms into an array to format later
        $terms_list = [];
        foreach ( $all_terms as $term ) {
            if ( ! empty( $term ) ) {
                // build a list of links
                $terms_list[] = '<span class="imgtec-tax-term">' . $term->name . '</span>';
            }
        }
        // format the list
        $output_terms = join( ', ', $terms_list );

        // if terms have been selected then create the output
        if ( $output_terms ) {
            // render each taxonomy with it's selected terms per paragraph
            $combined_output  = '<p class="imgtec-tax-terms-list"><strong>';
            $combined_output .= imgtec_cpt_listing_name( $taxonomy ) . ':</strong> ';
            $combined_output .= imgtec_cpt_listing_name( $output_terms ) . '</p>';

            // output the result
            echo $combined_output;
        }
    }
}
function imgtec_set_taxonomies_with_selected_terms_testing( $tax_array ){
    // get the terms for each taxonomy
    foreach ($tax_array as $taxonomy) {
        $all_terms = wp_get_post_terms( get_the_ID(), $taxonomy );

        // place terms into an array to format later
        $terms_list = [];
        foreach ( $all_terms as $term ) {
            if ( ! empty( $term ) ) {
                // build a list of links
                $terms_list[] = '<span class="imgtec-tax-term">' . $term->name . '</span>';
            }
        }
        // format the list
        $output_terms = join( ', ', $terms_list );

        // if terms have been selected then create the output
        if ( $output_terms ) {
            // strip out underscores and hyphens
            imgtec_string_replace_func($taxonomy);
            // render each taxonomy with it's selected terms per paragraph
            $combined_output  = '<span class="imgtec-tax-terms-list"><strong>';
            $combined_output .= ucwords( $taxonomy ) . ':</strong> ';
            $combined_output .= ucwords( $output_terms ) . '</span>';

            // output the result
            echo $combined_output;
        }
    }
}


/**
 * Lists all Post Types in a seperate paragraph
 * Each Post Type is followed by a comma seperated list of the selected terms for set taxonomies
 * Each Term is converted to a link back to the set page with filtering of this Term triggered
 * -----------------------------------------------------------------
 * Set the following arguments:
 * $link_prefix - part of the url that comes after domain
 * E.G. href="imgtec.com/$link_prefix/..."
 * $facetwp_adds - part of the url added by FacetWP
 * E.G. href="imgtec.com/$link_prefix/?_taxonomy_name_$facetwp_adds=..."
 */
function imgtec_set_taxonomies_with_selected_terms_links( $tax_array, $link_prefix, $facetwp_adds = null ){
    // get the terms for each taxonomy
    foreach ($tax_array as $taxonomy) {
        $all_terms = wp_get_post_terms( get_the_ID(), $taxonomy );

        // place terms into an array to format later
        $terms_list = [];
        foreach ( $all_terms as $term ) {
            if ( ! empty( $term->slug ) ) {
                // build the href
                $href = '/' . $link_prefix . '/?_' . str_replace( '-', '_', $taxonomy ) . $facetwp_adds . '=' . $term->slug;

                // build a list of links
                $terms_list[] = '<a href="' . $href . '" class="imgtec-tax-term" aria-label="'. $term->name .' filter">' . $term->name . '</a>';
            }
        }
        // format the list
        $output_terms = join( ', ', $terms_list );

        // if terms have been selected then create the output
        if ( $output_terms ) {
            // strip out underscores and hyphens
            $taxonomy_output = str_replace( '-', ' ', $taxonomy );
            $taxonomy_output = str_replace( '_', ' ', $taxonomy_output );
            $taxonomy_output = str_replace( 'gpu', 'GPU', $taxonomy_output );
			$taxonomy_output = str_replace( 'powervr', 'PowerVR', $taxonomy_output );
            $taxonomy_output = str_replace( 'tiers', 'tier', $taxonomy_output );

            // render each taxonomy with it's selected terms per paragraph
            $combined_output  = '<p class="imgtec-tax-terms-list">';
            $combined_output .= ucwords( $taxonomy_output ) . ': ';
            $combined_output .= ucwords( $output_terms ) . '</p>';

            // output the result
            echo $combined_output;
        }
    }
}
function imgtec_set_taxonomies_with_selected_prefixed_terms_links( $tax_array, $link_prefix, $facetwp_adds = null ){
    // get the terms for each taxonomy
    foreach ($tax_array as $taxonomy) {
        $all_terms = wp_get_post_terms( get_the_ID(), $taxonomy );

        // place terms into an array to format later
        $terms_list = [];

        foreach ( $all_terms as $term ) {
            if ( ! empty( $term->slug ) ) {

                // build the href
                $href = '/' . $link_prefix . '/?_' . $facetwp_adds . str_replace( '-', '_', $taxonomy ) . '=' . $term->slug;

                // build a list of links
                $terms_list[] = '<a href="' . $href . '" class="imgtec-tax-term" aria-label="'. $term->name .' filter" >' . $term->name . '</a>';
            }
        }
        // format the list
        $output_terms = join( ', ', $terms_list );

        // if terms have been selected then create the output
        if ( $output_terms ) {
            // strip out underscores and hyphens
            $taxonomy_output = str_replace( '-', ' ', $taxonomy );
            $taxonomy_output = str_replace( '_', ' ', $taxonomy_output );
            $taxonomy_output = str_replace( 'gpu', 'GPU', $taxonomy_output );
			$taxonomy_output = str_replace( 'powervr', 'PowerVR', $taxonomy_output );
            $taxonomy_output = str_replace( 'tiers', 'tier', $taxonomy_output );

            // render each taxonomy with it's selected terms per paragraph
            $combined_output  = '<span class="imgtec-tax-terms-list">';
            $combined_output .= ucwords( $taxonomy_output ) . ': ';
            $combined_output .= ucwords( $output_terms ) . '</span>';

            // output the result
            echo $combined_output;
        }
    }
}


function taxonomy_slug_rewrite( $wp_rewrite ){
    $rules = [];

    // get all custom taxonomies
    $custom_taxonomies = get_taxonomies( array( '_builtin' => false ), 'objects' );

    // get all custom post types
    $custom_post_types = get_post_types( array( 'public' => true, '_builtin' => false ), 'objects' );

    // loop through the post types
    foreach ( $custom_post_types as $cpt ) {

    // loop through the taxonomies
        foreach ( $custom_taxonomies as $ctax ) {

            // go through the post types that each taxonomy is assigned to
            foreach ( $ctax->object_type as $obj_type ) {

                // check if the post type has the taxonomy
                if ( $obj_type == $cpt->rewrite['slug'] ){

                    // get objects
                    $terms = get_categories( array( 'type' => $obj_type, 'taxonomy' => $ctax->name, 'hide_empty' => 0 ) );

                    // make rules
                    foreach ( $terms as $term ) {
                        $rules[ $obj_type . '/' . $term->slug . '/?$' ] = 'index.php?' . $term->taxonomy . '=' . $term->slug;
                    }
                }
            }
        }
    }
    // merge with global rules
    $wp_rewrite->rules = $rules + $wp_rewrite->rules;
}
// add_filter( 'generate_rewrite_rules', 'taxonomy_slug_rewrite' );