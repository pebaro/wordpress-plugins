<?php
// demo introduction as a sub-heading straight underneath the main heading
function it_demo_sub_heading( $atts ){

	global $post;

	// get the product used for this demo
	$product_used = get_field( 'product_demo_product_used' );
	// get the family this product belongs to
	$product_family = get_field( 'product_demo_product_family' );

	if ( $product_used && $product_family ) :
		setup_postdata( $product_used );
		$demo_intro .= '<p class="it-demo-info-intro">Demo created with the <a href="' . get_the_permalink( $product_used ) . '">PowerVR ' . get_the_title( $product_used ) . '</a>';
		wp_reset_postdata();

		setup_postdata( $product_family );
		$demo_intro .= ' from the <a href="' . get_the_permalink( $product_family ) . '">' . get_the_title( $product_family ) . '</a> family</p>';
		wp_reset_postdata();
	elseif ( $product_used ) :
		setup_postdata( $product_used );
		$demo_intro .= '<p class="it-demo-info-intro">Demo created with the <a href="' . get_the_permalink( $product_used ) . '">PowerVR ' . get_the_title( $product_used ) . '</a>';
		wp_reset_postdata();
	elseif ( $product_family ) :
		setup_postdata( $product_family );
		$demo_intro .= '<p class="it-demo-info-intro">Demo showcases the <a href="' . get_the_permalink( $product_family ) . '">' . get_the_title( $product_family ) . ' Family</a>';
		wp_reset_postdata();
	endif;	

	// ==================
	// return the data
	return $demo_intro;

}

