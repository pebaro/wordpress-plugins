function requestStatus( event, status ){

	let tabcontent = document.getElementsByClassName( 'status-tabcontent' );
	for ( let i = 0; i < tablinks.length; i++ ){
		tabcontent[ i ].style.display = 'none';
	}

	let tablinks = document.getElementsByClassName( 'status-tablinks' )
	for ( let i = 0; i < tablinks.length; i++ ){
		tablinks[ i ].className = tablinks[ i ].className.replace( ' active', '' );
	}

	document.getElementById( status ).style.display = 'block';
	event.currentTarget.className += ' active';
	
}
