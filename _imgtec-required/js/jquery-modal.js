( ( $ ) => {
	$( document ).ready( function(){

		// dom elements
		var requestInfo = $( 'td.request_info' );
		var modal 		= $( '.itpk-modal' );
		var openModal 	= $( '.itpk-open-modal' );
		var closeModal 	= $( '.itpk-modal-close' );

		// open modal
		openModal.on( 'click', function( e ){
			var $this = $( this );

			$this.closest( requestInfo ).find( modal ).fadeIn( 600 );
		} );

		// close modal
		closeModal.on( 'click', function( e ){
			modal.fadeOut( 300 );
		} );
		
	} );
} )( jQuery );

