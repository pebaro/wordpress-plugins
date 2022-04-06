( ( $ ) => {
	$( document ).ready( function(){

		// settings
		var speedUp 		= '600';
		var speedDown 		= '600';
		// dom elements
		var heading 		= $( 'li.iupdm-section-heading' );
		var image 		= $( 'img' );
		var requestsSection 	= $( '#iupdm-requests-content' );
		var requestsHeading 	= $( '#iupdm-requests-heading' );
		var viewRequestsContent	= $( '#iupdm-view-requests-content' );
		var statisticsContent 	= $( '#iupdm-statistics-content' );
		var statisticsHeading 	= $( '#iupdm-statistics-heading' );
		// css
		var rotate 		= 'iupdm-rotate';

		// open up the section for download requests
		requestsSection.slideToggle();

		// sections handler
		heading.on( 'click', function(){
			// get next element
			$( this ).next()
				.slideToggle( speedDown )
				// select all other sections
				.siblings( 'li.iupdm-section-content' ).slideUp( speedUp );

			// get image for active section
			var img = $( this ).children( image );

			// remove 'iupdm-rotate' from images except active one
			$( image ).not( img ).removeClass( rotate );

			// toggle rotate class
			img.toggleClass( rotate );
		} );

		// view requests section
		viewRequestsContent.on( 'click', function(){
			// close stats panel
			statisticsContent.slideUp( speedUp );

			statisticsHeading.find( 'img' ).removeClass( rotate );

			requestsHeading.find( 'img' ).toggleClass( rotate );

			requestsSection.slideDown( speedDown );
		} );

	} );
} )( jQuery );

