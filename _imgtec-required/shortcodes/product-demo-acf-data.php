<?php
// product demo custom fields data
function it_product_demo_acf_data_func( $atts ){

	global $post;

	// ===== bring in the ACFs =====

	// platforms
	$platforms = get_field( 'product_demo_product_platform' );

	if ( $platforms != '' ) : $platforms_list = [];
		if ( count( $platforms ) > 1 ) :
			$demo_acfs .= '<p class="imgtec-tax-terms-list"><strong>Platforms:</strong> ';

			if ( $platforms ) :
				foreach ( $platforms as $platform ) :
					$platforms_list[] = $platform[ 'label' ];
				endforeach;
			endif; 

			$output_platforms = join( ', ', $platforms_list );

			$demo_acfs .= '<span class="imgtec-tax-term">';
			$demo_acfs .= $output_platforms;
			$demo_acfs .= '</span></p>';

		elseif ( count( $platforms ) == 1 ) :
			$demo_acfs .= '<p class="imgtec-tax-terms-list"><strong>Platforms:</strong> ';

			foreach ( $platforms as $platform ) :
				$demo_acfs .= '<span class="imgtec-tax-term">';
				$demo_acfs .= $platform[ 'label' ];
				$demo_acfs .= '</span>';
			endforeach;
			
			$demo_acfs .= '</p>';
		endif;
	endif;

	// technologies
	$technologies = get_field( 'product_demo_product_technology' );

	if ( $technologies != '' ) : $technologies_list = [];
		if ( count( $technologies ) > 1 ) :
			$demo_acfs .= '<p class="imgtec-tax-terms-list"><strong>Technologies:</strong> ';

			if ( $technologies ) :
				foreach ( $technologies as $technology ) :
					$technologies_list[] = $technology[ 'label' ];
				endforeach;
			endif; 

			$output_technologies = join( ', ', $technologies_list );

			$demo_acfs .= '<span class="imgtec-tax-term">';
			$demo_acfs .= $output_technologies;
			$demo_acfs .= '</span></p>';

		elseif ( count( $technologies ) == 1 ) :
			$demo_acfs .= '<p class="imgtec-tax-terms-list"><strong>Technology:</strong> ';

			foreach ( $technologies as $technology ) :
				$demo_acfs .= '<span class="imgtec-tax-term">';
				$demo_acfs .= $technology[ 'label' ];
				$demo_acfs .= '</span>';
			endforeach;

			$demo_acfs .= '</p>';
		endif;
	endif;

	// SoC
	$soc = get_field( 'product_demo_product_soc' );
	if ( $soc ) :
		$demo_acfs .= '<p class="imgtec-tax-terms-list"><strong>SoC: </strong>';
		$demo_acfs .= '<span class="imgtec-tax-term">';
		$demo_acfs .= $soc;
		$demo_acfs .= '</span></p>';
	endif;

	// opearting system
	$operating_systems = get_field( 'product_demo_product_operating_system' );

	if ( $operating_systems != '' ) : $os_list = [];
		if ( count( $operating_systems ) > 1 ) :
			$demo_acfs .= '<p class="imgtec-tax-terms-list"><strong>Operating Systems:</strong> ';

			if ( $operating_systems ) :
				foreach ( $operating_systems as $os ) :
					$os_list[] = $os[ 'label' ];
				endforeach;
			endif; 

			$output_os = join( ', ', $os_list );

			$demo_acfs .= '<span class="imgtec-tax-term">';
			$demo_acfs .= $output_os;
			$demo_acfs .= '</span></p>';

		elseif ( count( $operating_systems ) == 1 ) :
			$demo_acfs .= '<p class="imgtec-tax-terms-list"><strong>Operating System:</strong> ';

			foreach ( $operating_systems as $os ) :
				$demo_acfs .= '<span class="imgtec-tax-term">';
				$demo_acfs .= $os[ 'label' ];
				$demo_acfs .= '</span>';
			endforeach;

			$demo_acfs .= '</p>';
		endif;
	endif;

	// framework
	$frameworks = get_field( 'product_demo_demo_framework' );

	if ( $frameworks != '' ) : $frameworks_list = [];
		if ( count( $frameworks ) > 1 ) :
			$demo_acfs .= '<p class="imgtec-tax-terms-list"><strong>Frameworks:</strong> ';

			if ( $frameworks ) :
				foreach ( $frameworks as $framework ) :
					$frameworks_list[] = $framework[ 'label' ];
				endforeach;
			endif; 

			$output_frameworks = join( ', ', $frameworks_list );

			$demo_acfs .= '<span class="imgtec-tax-term">';
			$demo_acfs .= $output_frameworks;
			$demo_acfs .= '</span></p>';

		elseif ( count( $frameworks ) == 1 ) :
			$demo_acfs .= '<p class="imgtec-tax-terms-list"><strong>Framework:</strong> ';

			foreach ( $frameworks as $framework ) :
				$demo_acfs .= '<span class="imgtec-tax-term">';
				$demo_acfs .= $framework[ 'label' ];
				$demo_acfs .= '</span>';
			endforeach;

			$demo_acfs .= '</p>';
		endif;
	endif;

	// API
	$apis = get_field( 'product_demo_api' );

	if ( $apis != '' ) : $apis_list = [];
		if ( count( $apis ) > 1 ) :
			$demo_acfs .= '<p class="imgtec-tax-terms-list"><strong>APIs:</strong> ';

			if ( $apis ) :
				foreach ( $apis as $api ) :
					$apis_list[] = $api[ 'label' ];
				endforeach;
			endif; 

			$output_apis = join( ', ', $apis_list );

			$demo_acfs .= '<span class="imgtec-tax-term">';
			$demo_acfs .= $output_apis;
			$demo_acfs .= '</span></p>';

		elseif ( count( $apis ) == 1 ) :
			$demo_acfs .= '<p class="imgtec-tax-terms-list"><strong>API:</strong> ';

			foreach ( $apis as $api ) :
				$demo_acfs .= '<span class="imgtec-tax-term">';
				$demo_acfs .= $api[ 'label' ];
				$demo_acfs .= '</span>';
			endforeach;

			$demo_acfs .= '</p>';
		endif;
	endif;


	// ===== return the data =====
	return $demo_acfs;
}
