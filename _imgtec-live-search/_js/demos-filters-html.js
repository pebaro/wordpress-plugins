( ( $ ) => {

	// create form with containers for dropdowns
	$( '#itlf-demos-filters-settings-container' ).prepend( `
		<div class="itlf-demos-filters-settings-wrapper">
			<form id="itlf-demos-filter-settings">
				<div class="itlf-form-column" id="itlf-technologies-select-container"><h5 class="label">Technology</h5></div>
				<div class="itlf-form-column" id="itlf-os-select-container"><h5 class="label">Operating System</h5></div>
				<div class="itlf-form-column" id="itlf-platforms-select-container"><h5 class="label">Platform</h5></div>
				<div class="itlf-form-column" id="itlf-apis-select-container"><h5 class="label">API</h5></div>

				<button class="itlf-filters-btn itlf-filters-apply-btn">Show Me</button>
				<button class="itlf-filters-btn itlf-filters-reset-btn" type="reset">Reset</button>
			</form>
		</div>
	` );
	
	// create technologies select and place in DOM
	// var technologiesSelectArr = [
	// 	{ class : 'itlf-technologies-option', val : '', 	text : 'select one...' },
	// 	{ class : 'itlf-technologies-option', val : 6954, 	text : 'Graphics' },
	// 	{ class : 'itlf-technologies-option', val : 6955, 	text : 'Ray Tracing' },
	// 	{ class : 'itlf-technologies-option', val : 6956, 	text : 'Virtualization' },
	// 	{ class : 'itlf-technologies-option', val : 6957, 	text : 'Vision' }
	// ];
	var technologiesSelectArr = [
		{ class : 'itlf-technologies-option', val : '', 				text : 'select one...' },
		{ class : 'itlf-technologies-option', val : 'graphics', 		text : 'Graphics' },
		{ class : 'itlf-technologies-option', val : 'ray-tracing', 		text : 'Ray Tracing' },
		{ class : 'itlf-technologies-option', val : 'virtualization', 	text : 'Virtualization' },
		{ class : 'itlf-technologies-option', val : 'vison', 			text : 'Vision' }
	]
	var technologiesSelectField = $( '<select/>', { 
		id 		: 'itlf-technologies-select',
		class 	: 'itlf-filters-select' 
	} ).appendTo( 
		'#itlf-technologies-select-container' 
		)
	$( technologiesSelectArr ).each( function() {
		technologiesSelectField.append( $( '<option/>' )
			.attr( 'value', this.val )
				.attr( 'class', this.class )
					.text( this.text ) );
	} )
		
	// create OS select and place in DOM
	// var osSelectArr = [
	// 	{ class : 'itlf-os-option', val : '', 	text : 'select one...' },
	// 	{ class : 'itlf-os-option', val : 6959, text : 'Android' },
	// 	{ class : 'itlf-os-option', val : 6960, text : 'IOS' },
	// 	{ class : 'itlf-os-option', val : 6958, text : 'Linux' }
	// ];
	var osSelectArr = [
		{ class : 'itlf-os-option', val : '',           text : 'select one...' },
		{ class : 'itlf-os-option', val : 'android',    text : 'Android' },
		{ class : 'itlf-os-option', val : 'ios',        text : 'IOS' },
		{ class : 'itlf-os-option', val : 'linux',      text : 'Linux' }
	];
	var osSelectField = $( '<select/>', { 
		id 		: 'itlf-os-select',
		class 	: 'itlf-filters-select' 
	} ).appendTo( 
		'#itlf-os-select-container' 
		);
	$( osSelectArr ).each( function() {
		osSelectField.append( $( '<option/>' )
			.attr( 'value', this.val )
				.attr( 'class', this.class )
					.text( this.text ) );
	} );
	
	// create platforms select and place in DOM
	// var platformsSelectArr = [
	// 	{ class : 'itlf-platforms-option', val : '', 	text : 'select one...' },
	// 	{ class : 'itlf-platforms-option', val : 6965, 	text : 'Digital TV' },
	// 	{ class : 'itlf-platforms-option', val : 6966, 	text : 'Handheld Gaming Console' },
	// 	{ class : 'itlf-platforms-option', val : 6968, 	text : 'Infotainment System' },
	// 	{ class : 'itlf-platforms-option', val : 6963, 	text : 'Laptop' },
	// 	{ class : 'itlf-platforms-option', val : 6964, 	text : 'Set-Top Box' },
	// 	{ class : 'itlf-platforms-option', val : 6961, 	text : 'Smartphone' },
	// 	{ class : 'itlf-platforms-option', val : 6962, 	text : 'Tablet' },
	// 	{ class : 'itlf-platforms-option', val : 6967, 	text : 'Virtual Reality' }
	// ];
	var platformsSelectArr = [
		{ class : 'itlf-platforms-option', val : '',                            text : 'select one...' },
		{ class : 'itlf-platforms-option', val : 'digital-tv',                  text : 'Digital TV' },
		{ class : 'itlf-platforms-option', val : 'handheld-gaming-console',     text : 'Handheld Gaming Console' },
		{ class : 'itlf-platforms-option', val : 'infotainment-system',         text : 'Infotainment System' },
		{ class : 'itlf-platforms-option', val : 'laptop',                      text : 'Laptop' },
		{ class : 'itlf-platforms-option', val : 'set-top-box',                 text : 'Set-Top Box' },
		{ class : 'itlf-platforms-option', val : 'smartphone',                  text : 'Smartphone' },
		{ class : 'itlf-platforms-option', val : 'tablet',                      text : 'Tablet' },
		{ class : 'itlf-platforms-option', val : 'virtual-reality',             text : 'Virtual Reality' }
	];
	var platformsSelectField = $( '<select/>', { 
		id 		: 'itlf-platforms-select',
		class 	: 'itlf-filters-select' 
	} ).appendTo( 
		'#itlf-platforms-select-container' 
		);
	$( platformsSelectArr ).each( function() {
		platformsSelectField.append( $( '<option/>' )
			.attr( 'value', this.val )
				.attr( 'class', this.class )
					.text( this.text ) );
	} );
		
	// create APIs select and place in DOM
	// var apisSelectArr = [
	// 	{ class : 'itlf-apis-option', val : '', 	text : 'select one...' },
	// 	{ class : 'itlf-apis-option', val : 6969, 	text : 'NNA' },
	// 	{ class : 'itlf-apis-option', val : 6972, 	text : 'OGLES 3' },
	// 	{ class : 'itlf-apis-option', val : 6973, 	text : 'OGLES 3.1' },
	// 	{ class : 'itlf-apis-option', val : 6970, 	text : 'OpenCL' },
	// 	{ class : 'itlf-apis-option', val : 6974, 	text : 'OpenCV' },
	// 	{ class : 'itlf-apis-option', val : 6971, 	text : 'OpenGL' },
	// 	{ class : 'itlf-apis-option', val : 6975, 	text : 'OpenVX' },
	// 	{ class : 'itlf-apis-option', val : 6976, 	text : 'PVRCLDNN' },
	// 	{ class : 'itlf-apis-option', val : 6977, 	text : 'PVRDNN' },
	// 	{ class : 'itlf-apis-option', val : 6978, 	text : 'Vulkan' }
	// ];
	var apisSelectArr = [
		{ class : 'itlf-apis-option', val : '', 	    text : 'select one...' },
		{ class : 'itlf-apis-option', val : 'nna',      text : 'NNA' },
		{ class : 'itlf-apis-option', val : 'ogles3',   text : 'OGLES 3' },
		{ class : 'itlf-apis-option', val : 'ogles31',  text : 'OGLES 3.1' },
		{ class : 'itlf-apis-option', val : 'opencl',   text : 'OpenCL' },
		{ class : 'itlf-apis-option', val : 'opencv',   text : 'OpenCV' },
		{ class : 'itlf-apis-option', val : 'opengl',   text : 'OpenGL' },
		{ class : 'itlf-apis-option', val : 'openvx',   text : 'OpenVX' },
		{ class : 'itlf-apis-option', val : 'pvrcldnn', text : 'PVRCLDNN' },
		{ class : 'itlf-apis-option', val : 'pvrdnn',   text : 'PVRDNN' },
		{ class : 'itlf-apis-option', val : 'vulkan',   text : 'Vulkan' }
	];
	var apisSelectField = $( '<select/>', { 
		id 		: 'itlf-apis-select',
		class 	: 'itlf-filters-select' 
	} ).appendTo( 
		'#itlf-apis-select-container' 
	);
	$( apisSelectArr ).each( function() {
		apisSelectField.append( $( '<option/>' )
			.attr( 'value', this.val )
				.attr( 'class', this.class )
					.text( this.text ) );
	} );
	
} )( jQuery );