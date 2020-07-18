<?php
// ============================================
// =====> Adding Columns to Events Admin <=====
//
function webinars_columns( $columns ) {
    $columns = array(
        'cb'       	        => '<input type="checkbox" />',
        'title'    	        => __( 'Event' ),
        'dates'             => __( 'Start / Finish' ),
        'speaker'           => __( 'Event Speaker' ),
        'featured'          => __( 'Featured' ),
        'events_taxonomies' => __( 'Taxonomies' ),
        'date'     	        => __( 'Date' ),
        'administrator'     => __( 'Event Admin' )
    );
    return $columns;
}


// =====================================================
// =====> Manage Columns Content for Events Admin <=====
//
function webinars_manage_columns( $column ) {

    global $post;
    global $wp_query;

    # get meta data for the events
    $event_start        = get_post_meta( $post->ID, 'event_start', true );
    $event_end          = get_post_meta( $post->ID, 'event_end', true );
    $event_year         = get_post_meta( $post->ID, 'event_end', true );
    $webinar_start      = get_post_meta( $post->ID, 'webinar_start', true );
    $webinar_end        = get_post_meta( $post->ID, 'webinar_end', true );
    $webinar_year       = get_post_meta( $post->ID, 'webinar_end', true );
    $timezone           = get_post_meta( $post->ID, 'timezone', true );
    // $event_type         = get_post_meta( $post->ID, 'event_type', true );
    $speaker            = get_post_meta( $post->ID, 'speaker', true );
    $speaker_day        = get_post_meta( $post->ID, 'speaker_time', true );
    $speaker_year       = get_post_meta( $post->ID, 'speaker_time', true );
    $duration           = get_post_meta( $post->ID, 'speaker_duration', true );
    $featured           = get_post_meta( $post->ID, 'featured_event', true );

    // $ex_or_conf         = get_post_meta( $post->ID, 'ex_or_conf', true );

    # for condition checks
    $today              = date( 'Ymd' );
    $check_event_start  = date( 'Ymd', strtotime( $event_start ) );
    $check_event_end    = date( 'Ymd', strtotime( $event_end ) );
    // $check_speak_start  = date( 'Ymd', strtotime( $speaker_day ) );
    // $check_web_start    = date( 'Ymd', strtotime( $webinar_start ) );
    // $check_web_end      = date( 'Ymd', strtotime( $webinar_end ) );

    # for echo
    $start_date         = date( 'd F', strtotime( $event_start ) );
    $start_date         = substr( $start_date, 0, 6 );
    $end_date 	        = date( 'd F', strtotime( $event_end ) );
    $end_date 	        = substr( $end_date, 0, 6 );
    $event_year         = date( 'Y', strtotime( $event_year ) );
    $event_year         = substr( $event_year, 0, 6 );
    $event_date         = $start_date . ' ' . $event_year;
    // $event_dates        = $start_date . ' - ' . $end_date . ' ' . $event_year;
    // $event_dates        = '<small>starts:</small> ' $start_date . '<br><small>ends:</small> ' . $end_date . ' ' . $event_year;

    $speaker_time       = date( 'H:i', strtotime( $speaker_day ) );
    $speaker_date       = date( 'd-m-Y', strtotime( $speaker_day ) );
    $speaker_date       = date( 'd F', strtotime( $speaker_day ) );
    $speaker_date       = substr( $speaker_date, 0, 6 );
    $speaker_year       = date( 'Y', strtotime( $speaker_year ) );
    $speaker_year       = substr( $speaker_year, 0, 6 );
    $speaker_appears    = $speaker_date . ' ' . $speaker_year;

    $webinar_date       = date( 'd F', strtotime( $webinar_start ) );
    $webinar_date       = substr( $webinar_date, 0, 6 );
    $webinar_year       = date( 'Y', strtotime( $webinar_year ) );
    $webinar_year       = substr( $webinar_year, 0, 6 );
    $webinar_streamed   = $webinar_date . ' ' . $webinar_year;


    switch( $column ) {

        # Start / Finish
        case 'dates':
            echo '<strong><small>Webinar:</small></strong><br>';
            echo '<strong style="color:#256B86;">' . $webinar_streamed . '</strong>';
            echo '<div style="border-top:1px dotted #CCC;"><strong><small>Duration:</small></strong> ' . $duration . ' minutes</div>';
        break;

        # Event Speaker
        case 'speaker':
            echo '<strong style="color:#256B86;">Webinar <small>by:</small></strong><br>' . ucwords($speaker);
        break;

        # Featured
        case 'featured':
            if( $featured != '' ){
                echo '<strong style="color:#862585;">Yes</strong>';
            } else {
                echo '<span style="color: #999;">No</span>';
            }
        break;

        # Taxonomies
        case 'events_taxonomies':

            $technologies   = get_the_terms( $post->ID, 'webinar_technologies' );
            $markets        = get_the_terms( $post->ID, 'webinar_markets' );
            $categories     = get_the_terms( $post->ID, 'webinar_categories' );


            if ( !empty( $technologies ) || !empty( $markets ) || !empty( $categories ) ) { ?>
                <span class="view-events-taxonomies" style="cursor: pointer; color: #b71a8b; text-decoration: underline;"><small><strong>View Taxonomies</strong></small></span>
                <script>
                    jQuery('.view-events-taxonomies').on('click', function(e){
                        jQuery(this).closest('td.events_taxonomies').find('div.events-taxonomies').slideToggle(500);
                        e.stoppropogation();
                    });
                </script><?php
            } ?>
            <div class="events-taxonomies" style="display:none;"><?php
                if ( !empty( $technologies ) ){
                    echo '<strong><small>Technologies</small></strong><br>';
                    $technologies_out = array();

                    foreach ( $technologies as $technology ){
                        $technologies_out[] = sprintf(
                            '<a href="%s">%s</a>',
                            esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'webinar_technologies' => $technology->slug ), 'edit.php' ) ),
                            esc_html( sanitize_term_field( 'name', $technology->name, $technology->term_id, 'webinar_technologies', 'display' ) )
                        );
                    }
                    echo join( ',<br>', $technologies_out ).'<br><br>';
                }
                if ( !empty( $markets ) ){
                    echo '<strong><small>Markets</small></strong><br>';

                    $markets_out = array();

                    foreach ( $markets as $market ){
                        $markets_out[] = sprintf(
                            '<a href="%s">%s</a>',
                            esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'webinar_markets' => $market->slug ), 'edit.php' ) ),
                            esc_html( sanitize_term_field( 'name', $market->name, $market->term_id, 'webinar_markets', 'display' ) )
                        );
                    }
                    echo join( ',<br>', $markets_out ).'<br><br>';
                }
                if ( !empty( $categories ) ){
                    echo '<strong><small>Categories</small></strong><br>';

                    $categories_out = array();

                    foreach ( $categories as $category ){
                        $categories_out[] = sprintf(
                            '<a href="%s">%s</a>',
                            esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'webinar_categories' => $category->slug ), 'edit.php' ) ),
                            esc_html( sanitize_term_field( 'name', $category->name, $category->term_id, 'webinar_categories', 'display' ) )
                        );
                    }
                    echo join( ',<br>', $categories_out ).'<br><br>';
                } ?>
            </div><?php
        break;

		# Event Administrator / Manager
		case 'administrator':
            echo the_author_meta('first_name');
            echo '&nbsp;';
            echo the_author_meta('last_name');
		break;

	}
}

