( ( $ ) => {
	$( document ).ready( () => {

		// license agreement
		const agreement_form = document.forms[ 'iupdmLAF' ];

		// =======================
		// agree terms elements
		const 	agree_to_license_question = document.createElement( 'div' );
				agree_to_license_question.className = 'iupdm-laf-question';
				agree_to_license_question.textContent = 'Do you accept the terms of this license?';
		// radio group
		const 	agree_to_license_radio_div = document.createElement( 'div' );
				agree_to_license_radio_div.className = 'iupdm-laf-radio-group';
		// yes
		const 	yes_label = document.createElement( 'label' );
				yes_label.className = 'iupdm-laf-radio-label';
				yes_label.setAttribute( 'for', 'iupdm-laf-yes' );
				yes_label.textContent = 'Yes';
		const 	yes_radio = document.createElement( 'input' );
				yes_radio.setAttribute( 'type', 'radio' );
				yes_radio.setAttribute( 'name', 'iupdmRFYesNo' );
				yes_radio.setAttribute( 'value', 'yes' );
				yes_radio.setAttribute( 'id', 'iupdm-laf-yes' );
				yes_radio.setAttribute( 'required', '' );
				yes_radio.className = 'iupdm-laf-radio';
				yes_label.appendChild( yes_radio );
				agree_to_license_radio_div.appendChild( yes_label );
		// no
		const 	no_label = document.createElement( 'label' );
				no_label.className = 'iupdm-laf-radio-label';
				no_label.setAttribute( 'for', 'iupdm-laf-no' );
				no_label.textContent = 'No';
		const 	no_radio = document.createElement( 'input' );
				no_radio.setAttribute( 'type', 'radio' );
				no_radio.setAttribute( 'name', 'iupdmRFYesNo' );
				no_radio.setAttribute( 'value', 'no' );
				no_radio.setAttribute( 'id', 'iupdm-laf-no' );
				no_radio.className = 'iupdm-laf-radio';
				no_label.appendChild( no_radio );
				agree_to_license_radio_div.appendChild( no_label );
		// add to container
				agree_to_license_question.appendChild( agree_to_license_radio_div );
		// add to route container
		agreement_form.appendChild( agree_to_license_question );

		// ================
		// submit button
		const 	submit_btn = document.createElement( 'input' );
				submit_btn.setAttribute( 'type', 'submit' );
				submit_btn.setAttribute( 'value', 'Submit' );
				submit_btn.className = 'iupdm-laf-btn';
		// add to form
		agreement_form.appendChild( submit_btn );



		// event handlers
		function iupdm_agree_license( e ){
			e.preventDefault();
			// alert('test');

			var agree_license = document.getElementById( 'iupdm-laf-yes' );

			if ( agree_license.checked ){
				var form = {
					action 			: 'iupdm_license_agreement',
					license_id 		: licenseAgreement.license_id,
					license_title 	: licenseAgreement.license_title,
					license_url 	: licenseAgreement.license_url,
					terms_agreed 	: agree_license.checked ? 'Yes' : 'No',
					user_id 		: licenseAgreement.user_id
				}
			} else {
				alert( 'you need to agree the license' );
			}
	
			$.post(
				licenseAgreement.ajax_url,
				form,
				( response ) => {					
					var allCookies 		= document.cookie;
					var splitCookies 	= allCookies.split( ';' );
					var lastValue 		= splitCookies[ splitCookies.length - 1 ];
					var returnURL 		= lastValue.split( '=' ).pop();
					
					window.location = returnURL;

					console.log( 'Form Submission Success...\n' + response );
					// console.log( returnURL );
				}
			);
		}

		agreement_form.addEventListener( 'submit', iupdm_agree_license );

	} );
} )( jQuery );