( ( $ ) => { $( document ).ready( () => {

	// get div with id of 'main'
	const main = document.getElementById( 'main' )
	// create a container for additional html content
	const messageContainer = document.createElement( 'div' )
	messageContainer.setAttribute( 'id', 'itpk-download-feedback' )
	
	// main.append( messageContainer )


	function checkForCookie( cookieName ){

		const name = cookieName + '='
		const cookiesDecoded = decodeURIComponent( document.cookie )
		const cookieArray = cookiesDecoded.split( ';' )

		for ( let i = 0; i < cookieArray.length; i++ ){
			let cookie = cookieArray[ i ]

			while ( cookie.charAt( 0 ) == ' ' ){
				cookie = cookie.substring( 1 )
			}

			if ( cookie.indexOf( name ) == 0 ){
				return cookie.substring( name.length, cookie.length );
			}
		}
		return ''
	}

	let accessCode = checkForCookie( 'itpk_download_access' )

	accessCode ? console.log( accessCode ) : console.log( 'no access code exists' );


} ); } )( jQuery );