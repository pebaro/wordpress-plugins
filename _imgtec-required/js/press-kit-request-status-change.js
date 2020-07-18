( ( $ ) => {
	$( document ).ready( function(){

		// all status change select fields
		let all_actions_selects = document.querySelectorAll( '.itpk-rt-actions-select' );
		var content_panels = $( '.it-section-content' );

		// loading content animation
		function display_loader(){
			content_panels.html(`
				<div id="it-loader-container">
					<div id="it-loader-css-animation"></div>
					<div id="it-loader-text">Changing Request Status</div>
				</div>
			`);
		}

		// add event listener to all status change select fields
		all_actions_selects.forEach( select => {
			select.addEventListener( 'change', function( e ){

				// display loading content animation
				display_loader();

				// grab the target value
				var selectVal = e.target.value;
				console.log( selectVal );

				// update request status then refresh page to update front end
				$.post(
					PKRequestChange.ajax_url,
					{
						action 			: 'itpk_change_request_status',
						new_status 		: selectVal,
						first_name 		: $( this ).data( 'firstname' ),
						email_address 	: $( this ).data( 'emailaddress' ),
						request_id		: $( this ).data( 'requestid' )
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
