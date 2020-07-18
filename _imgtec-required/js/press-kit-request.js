( ( $ ) => { $( document ).ready( () => {

// ==============================
// ===== press kit requests =====
// ==============================
if ( document.getElementById( 'itpk-rf' ) ){
	// form
	const request_form 	= document.forms[ 'presskitrequestform' ];

	// questions
	function itpk_get_request_form_data( e ){

		e.preventDefault();


		// create cookie with download access code
		var part_1 			= Math.floor( Math.random() * Math.floor( 99999 ) );
		var part_2 			= Math.floor( Math.random() * Math.floor( 99999 ) );
		var part_3 			= Math.floor( Math.random() * Math.floor( 99999 ) );
		var part_4 			= Math.floor( Math.random() * Math.floor( 99999 ) );

		var unique_code 	= part_1 + '-' + part_2 + '-' + part_3 + '-' + part_4;

		var current_date 	= new Date();
		var expiry_date 	= new Date( current_date.getTime() + 2*24*60*60*1000 );
		var use_expiry 		= expiry_date.toGMTString();
			
		document.cookie 	= 'itpk_download_access=' + unique_code + '; ' + 'expires=' + use_expiry + ';';		

		const submission_message_container = document.getElementById( 'itpk-submission-feedback' );

		submission_message_container.innerHTML = `
			<div id="it-loader-container" style="margin:-60px 0 0 -100px !important;">
				<div id="it-loader-css-animation"></div>
				<div id="it-loader-text">Processing</div>
			</div>
		`;

		// check request_purpose value to set the form configuration
		const request_form 	= document.forms[ 'presskitrequestform' ];

		var form = {
			action 			: 'it_presskit_request',
			user_ip 		: PKRequest.user_ip,
			access_code 	: unique_code,
			kit_request 	: 'pending',
			first_name 		: request_form[ 'itpkfirstname' ].value,
			last_name 		: request_form[ 'itpklastname' ].value,
			email_address 	: request_form[ 'itpkemail' ].value,
			company 		: request_form[ 'itpkcompany' ].value,
			message 		: request_form[ 'itpkmessage' ].value
		}
		$.post(
			PKRequest.ajax_url,
			form,
			( response ) => {
						submission_message_container.innerHTML = '';

				const 	submission_message_H4 = document.createElement( 'h4' );
						submission_message_H4.setAttribute( 'id', 'itpk-status-msg-h4' );
						submission_message_H4.className = 'itpk-status-msg-h4';
						submission_message_H4.textContent = 'Thank you for requesting our press kit';
						submission_message_container.appendChild( submission_message_H4 );
				const 	submission_message_P = document.createElement( 'p' );
						submission_message_P.setAttribute( 'id', 'itpk-status-msg-p' );
						submission_message_P.className = 'itpk-status-msg';
						submission_message_P.innerHTML = `We will come back to you shortly; however, if you request is urgent <br>please contact Jo Jones on +44(0) 7802 490347 / <a href="mailto:jo.jones@imgtec.com">jo.jones@imgtec.com</a>`;
						submission_message_container.appendChild( submission_message_P );
							
				console.log( 'Succesful Form Submission!!!\n' + response );
			}
		);
	}
	
	// trigger when form submits
	request_form.addEventListener( 'submit', itpk_get_request_form_data );
}


} ); } )( jQuery );