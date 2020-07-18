<?php
function iupdm_add_new_downloads_columns( $columns ){
	$new_columns 							= [];
	$new_columns[ 'cb' ] 					= '<input type="checkbox" />';
	// $new_columns[ 'shortcode' ] 			= __( 'Shortcode', IUPDM_TEXTDOMAIN );
	$new_columns[ 'title' ] 				= __( 'Download', IUPDM_TEXTDOMAIN );
	$new_columns[ 'version' ] 				= __( 'Version', IUPDM_TEXTDOMAIN );
	$new_columns[ 'license' ] 				= __( 'License Agreement', IUPDM_TEXTDOMAIN );
	$new_columns[ 'request_process' ] 		= __( 'Request Process', IUPDM_TEXTDOMAIN );
	$new_columns[ 'download_categories' ] 	= __( 'Categories', IUPDM_TEXTDOMAIN );
	$new_columns[ 'administrators' ] 		= __( 'Administrators', IUPDM_TEXTDOMAIN );
	$new_columns[ 'date' ] 					= __( 'Date', IUPDM_TEXTDOMAIN );

	return $new_columns;
}

function iupdm_manage_new_downloads_columns( $column, $post_id ){
	global $post;
	global $wpdb;

	switch ( $column ) {
		// case 'shortcode' :
		// break;

		case 'version' :
			$download_version = get_post_meta( $post_id, 'iup_download_version', true );
			echo isset( $download_version ) ? $download_version : '' ;
		break;

		case 'license' :
			$license_url = get_post_meta( $post_id, 'iup_license_agreement_needed', true );
			echo $license_url ? 'yes' : 'no'; 
		break;

		case 'request_process' :
			$request_process = get_post_meta( $post_id, 'iup_download_approval_needed', true );
			echo $request_process ? 'yes' : 'no'; 
		break;

		case 'download_categories' :
			$download_categories   = get_the_terms( $post->ID, 'download_categories' );

			if ( ! empty( $download_categories ) ){
				$download_categories_out = array();

				foreach ( $download_categories as $category ){
					$download_categories_out[] = sprintf(
						'<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'download_categories' => $category->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $category->name, $category->term_id, 'download_categories', 'display' ) )
					);
				}
				echo join( ', ', $download_categories_out );
			}
		break;

		case 'administrators' :
		break;


		default :
		break;
	}
}