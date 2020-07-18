<?php

// start off with the columns
function press_releases_columns( $columns ){
	$columns = array(
		'cb' => '<input type="checkbox"/>',
		'title' => __( 'Press Releases' ),
		'language' => __( 'Language' ),
		'taxonomies' => __( 'Taxonomies' ),
		'date' => __( 'Published' ),
		'author' => __( 'Admin' )
	);
	return $columns;
}


// manage the columns
function press_releases_manage_columns( $column ){

	global $post;
	global $wp_query;

	switch ( $column ) {
		case 'language':
			$language = get_post_meta( $post->ID, 'language', true );

			if ( $language == 'English' ) {
				echo 'English';
			} elseif ( $language == 'German' ) {
				echo 'German';
			} elseif ( $language == 'Chinese' ) {
				echo 'Chinese';
			} elseif ( $language == 'Japanese' ) {
				echo 'Japanese';
			} else {
				echo 'no language set';
			}
			break;

		case 'taxonomies':
			$global_taxonomies = get_the_terms( $post->ID, 'global_taxonomies' );

			if ( !empty( $global_taxonomies ) ) {
				$taxonomies_out = [];
				foreach ($global_taxonomies as $tax) {
					$taxonomies_out[] = sprintf(
						'<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'global_taxonomies' => $tax->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $tax->name, $tax->term_id, 'global_taxonomies', 'display' ) )
					);
				}
				echo join( ', ', $taxonomies_out );
			}
			break;

		default:
			# code...
			break;
	}
}


// make language column sortable
// add_filter( 'parse_query', 'press_releases_admin_posts_filter' );
// add_action( 'restrict_manage_posts', 'press_releases_admin_posts_filter_manage_posts' );

function press_releases_admin_posts_filter( $query )
{
    global $pagenow;
    if ( is_admin() && $pagenow=='edit.php' && isset($_GET['ADMIN_FILTER_FIELD_NAME']) && $_GET['ADMIN_FILTER_FIELD_NAME'] != '') {
        $query->query_vars['meta_key'] = $_GET['ADMIN_FILTER_FIELD_NAME'];
    if (isset($_GET['ADMIN_FILTER_FIELD_VALUE']) && $_GET['ADMIN_FILTER_FIELD_VALUE'] != '')
        $query->query_vars['meta_value'] = $_GET['ADMIN_FILTER_FIELD_VALUE'];
    }
}

function press_releases_admin_posts_filter_manage_posts()
{
    global $wpdb;
    $sql = 'SELECT DISTINCT meta_key FROM '.$wpdb->postmeta.' ORDER BY 1';
    $fields = $wpdb->get_results($sql, ARRAY_N);
?>
<select name="ADMIN_FILTER_FIELD_NAME">
<option value=""><?php _e('Filter By Custom Fields', 'language'); ?></option>
<?php
    $current = isset($_GET['ADMIN_FILTER_FIELD_NAME'])? $_GET['ADMIN_FILTER_FIELD_NAME']:'';
    $current_v = isset($_GET['ADMIN_FILTER_FIELD_VALUE'])? $_GET['ADMIN_FILTER_FIELD_VALUE']:'';
    foreach ($fields as $field) {
        if (substr($field[0],0,1) != "_"){
        printf
            (
                '<option value="%s"%s>%s</option>',
                $field[0],
                $field[0] == $current? ' selected="selected"':'',
                $field[0]
            );
        }
    }
?>
</select> <?php _e('Value:', 'language'); ?><input type="TEXT" name="ADMIN_FILTER_FIELD_VALUE" value="<?php echo $current_v; ?>" />
<?php
}
