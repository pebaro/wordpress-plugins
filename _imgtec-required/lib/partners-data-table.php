<?php
// =========================================
// =====> Adding Columns To The Admin <=====
//
function partners_edit_columns( $columns ) {
   $columns = array(
		'cb'       				=> '<input type="radio" />',
		'title'    				=> __( 'Company Name' ),
		'author'   				=> __( 'Company Admin' ),
		'partner-type'			=> __( 'Partner Type' ),
		'products'				=> __( 'Products' ),
		'markets'   			=> __( 'Markets' ),
		'design-services' 		=> __( 'Design Services' ),
		'geography'   			=> __( 'Geography' ),
		'date'     				=> __( 'Date' ),
		'updated'  				=> __( 'Updated' )
   );
   return $columns;
}

// ============================
// =====> Manage Columns <=====
//
function partners_manage_columns( $column, $post_id ) {

   global $post;

   switch( $column ) {

		# The author and admin of the company #
		case 'author':
			$author = get_the_author();
			echo $author;
		break;

		# The date the post was updated #
		case 'updated':
			the_modified_date();
		break;

		# The Partner Types #
		case 'partner-type':
			$terms = get_the_terms( $post_id, 'partner-type' );
			 	if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
			     echo "<ul>";
			     	foreach ( $terms as $term ) {
			       	echo "<li>" . $term->name . "</li>";
			     }
			   echo "</ul>";
			}
		break;

		# The Products #
		case 'products':
			$terms = get_the_terms( $post_id, 'products' );
			 	if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
			     echo "<ul>";
			     	foreach ( $terms as $term ) {
			       	echo "<li>" . $term->name . "</li>";
			     }
			   echo "</ul>";
			}
		break;

		# The Design Services #
		case 'design-services':
			$terms = get_the_terms( $post_id, 'design-services' );
			 	if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
			     echo "<ul>";
			     	foreach ( $terms as $term ) {
			       	echo "<li>" . $term->name . "</li>";
			     }
			   echo "</ul>";
			}
		break;

		# The Geography #
		case 'geography':
			$terms = get_the_terms( $post_id, 'geography' );
			 	if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
			     echo "<ul>";
			     	foreach ( $terms as $term ) {
			       	echo "<li>" . $term->name . "</li>";
			     }
			   echo "</ul>";
			}
		break;

		# The Markets #
		case 'markets':
			$terms = get_the_terms( $post_id, 'markets' );
			 	if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
			     echo "<ul>";
			     	foreach ( $terms as $term ) {
			       	echo "<li>" . $term->name . "</li>";
			     }
			   echo "</ul>";
			}
		break;
	}
}
