<?php
// ====================================================
// =====> Adding Columns to Staff Profiles Admin <=====
//
function staff_profiles_columns( $columns ) {
    $columns = array(
        'cb'       	        => '<input type="checkbox" />',
        'title'    	        => __( 'Staff Member' ),
        'job_title'  		=> __( 'Position' ),
        'job_role' 			=> __( 'Job Role' ),
        'group_team' 		=> __( 'Group / Team' )
    );
    return $columns;
}


// =============================================================
// =====> Manage Columns Content for Staff Profiles Admin <=====
//
function staff_profiles_manage_columns( $column ) {

    global $post;
    global $wp_query;

    # get meta data for staff profiles
    $job_title 	= get_post_meta( $post->ID, 'it_job_title', true );
    $job_role 	= get_post_meta( $post->ID, 'it_job_role', true );

    switch( $column ) {

        # Job Title
        case 'job_title':
            echo '<strong>' . ucwords( $job_title ) . '</strong>';

        break;

        # Job Role
        case 'job_role':
            if( $job_role ){
                echo '<strong>' . ucwords( $job_role ) . '</strong>';
            } else {
                echo '-';
            }
        break;

        # Team / Group
        case 'group_team':

            $teams_groups = get_the_terms( $post->ID, 'staff-team-group' );

			if ( !empty( $teams_groups ) ){
				$teams_groups_out = array();

				foreach ( $teams_groups as $group ){
					$teams_groups_out[] = sprintf(
						'<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'staff-team-group' => $group->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $group->name, $group->term_id, 'staff-team-group', 'display' ) )
					);
				}
				echo join( ', ', $teams_groups_out ).'<br>';
			}
        break;

	}
}
