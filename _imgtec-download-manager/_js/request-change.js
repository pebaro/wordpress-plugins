( ( $ ) => {
	$( document ).ready( function(){

		// all status change select fields
		let all_actions_selects = document.querySelectorAll( '.iupdm-rt-actions-select' );

		// add event listener to all status change select fields
		all_actions_selects.forEach( select => {
			select.addEventListener( 'change', function( e ){

				// grab the target value
				var selectVal = e.target.value;
				console.log( selectVal );

				// update request status then refresh page to update front end
				$.post(
					requestChange.ajax_url,
					{
						action 			: 'iupdm_change_request_status',
						new_status 		: selectVal,
						user_id 		: $( this ).data( 'userid' ),
						download_id 	: $( this ).data( 'downloadid' )
					},
					( data ) => {
						console.log( data );
						location.reload();
					}
				);

			} );
		} );

	} );
} )( jQuery );
