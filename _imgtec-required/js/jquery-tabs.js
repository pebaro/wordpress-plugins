( ( $ ) => {
	$( document ).ready( function(){

		$( '.request-status-tabs .request-status-tab-links a' ).on( 'click', function( tabClick ) {

			var currentAttrValue = $( this ).attr( 'href' );

			// show or hide
			$( '.request-status-tabs ' + currentAttrValue ).show().siblings().hide();

			// change or remove active
			$( this ).parent( 'li' ).addClass( 'request-status-active' ).siblings().removeClass( 'request-status-active' );

			tabClick.preventDefault();
		} );

	} );
} )( jQuery );
