( ( $ ) => {

    // ===============================================================
    // ====== 1. setup: set variables / initiate functions ======
    // ----------------------------------------------------

    // HTML
    addFiltersHTML();

    // load demos
    getInitialResults();

    // DOM elements
    const filtersTemplate        = $( '.it-demos-filters' );
    const filterSettings         = $( '#it-demos-filters-settings-container' );
    const inputField             = $( '#it-text-input' );
    const technologyCheckboxes   = $( '#it-technology-checkboxes' );
    const marketsCheckboxes      = $( '#it-markets-checkboxes' );
    const performanceCheckboxes  = $( '#it-performance-checkboxes' );
    const technologyRadios       = $( '#it-technology-radios' );
    const marketsRadios          = $( '#it-markets-radios' );
    const performanceRadios      = $( '#it-performance-radios' );
    const filterFeedback         = $( '#it-filters-feedback' );
    const filterResults          = $( '#it-filter-results' );
    const filtersWrapper         = $( '#it-demos-filters-wrapper' );
    const filtersOpen            = $( '#it-demos-filters-open' );

    // avoid multiple queries
    let areFiltersOpen = false;
    let isLoaderVisible = false;
    let previousInputValue;

    // timing for live input
    let inputTimer = undefined;

    // event handlers
    events();

    // =====|| END constructor
    // ............................





    // ====================================
    // ====== 2. event handlers ======
    // -------------------------

    function events(){
        filterSettings.on( 'submit', e => e.preventDefault() );
        inputField.on( 'keyup', typingLogic );
        filtersOpen.on( 'click', () => {
            filtersWrapper.removeClass( 'it-demos-filters--inactive' );
            filtersWrapper.addClass( 'it-demos-filters--active' );
            areFiltersOpen = true;
        } );
    }

    function returnCheckboxValue( classname_for_checkboxes, function_name ){
        let checkboxes = document.getElementsByClassName( classname_for_checkboxes );

        for ( let i = 0; i < checkboxes.length; i++ ){
            checkboxes[ i ].addEventListener(
                'click', ( e ) => {
                    e.target.checked ? function_name( e.target.value ) : '';
                }
            );
        }
    }
    // returnCheckboxValue( 'it-technologies-checkbox', getTechnologyResults );
    // returnCheckboxValue( 'it-performance-checkbox', getPerformanceResults );
    // returnCheckboxValue( 'it-markets-checkbox', getMarketsResults );

    function returnRadioValue( classname_for_radios, function_name ){
        let radios = document.getElementsByClassName( classname_for_radios );

        for ( let i = 0; i < radios.length; i++ ){
            radios[ i ].addEventListener(
                'click', ( e ) => {
                    e.target.checked ? function_name( e.target.value ) : '';
                }
            );
        }
    }
    // returnRadioValue( 'it-technologies-radio', getTechnologyResults );



    function returnSelectValue( classname_for_select, function_name ){
        let radios = document.getElementsByClassName( classname_for_select );

        for ( let i = 0; i < radios.length; i++ ){
            radios[ i ].addEventListener(
                'click', ( e ) => {
                    e.target.checked ? function_name( e.target.value ) : '';
                }
            );
        }
    }
    // returnSelectValue( 'it-technologies-radio', getTechnologyResults );

    // =====|| END event handlers
    // ...............................
    
    
    
    
    
    // ===============================
    // ====== 3. functions ======
    // ---------------------

    // animated results loader
    function displayLoader(){
        // CSS version
        return filterResults.html( `
            <div id="it-loading-filters-container">
                <div id="it-loading-filters-animation"></div>
                <div id="it-loading-filters-text">Loading Results</div>
            </div>
        ` );
    }

    // open up filters
    function openFilters(){
        const filters = document.getElementById( 'it-demos-filters-wrapper' );
        filtersWrapper.removeClass( 'it-demos-filters--inactive' );
        filtersWrapper.addClass( 'it-demos-filters--active' );
        areFiltersOpen = true;
    }


    
    // get the filter results from input field
    function getInitialResults(){
        $.getJSON( demosFilters.site_root + '/wp-json/filtering/v1/demos?per_page=72', results => {
            filterResults.html( `
                ${ results.map( demo => 
                    `<a href="" class="it-filters-demo it-filters-demo-link">
                        <article class="">
							<section class="it-filters-demo-header"></section>
							
							<section class="it-filters-demo-info">
								${ returnNamesFromIDs( technologyIDs, technologyNames, demo.technology ) } | 
								${ returnNamesFromIDs( osIDs, osNames, demo.os ) }

                                <h2 class="it-filters-demo-title">${ demo.title }</h2>
                            </section>
                            <section class="it-filters-demo-taxonomies">
                            </section>
                            <section class="it-filters-demo-learn-more">
                                <span class="it-filters-demo-learn-more-link">learn more</span>
                            </section>
                        </article>
                    </a>` 
                ).join( '' ) }
            ` );
        } );
    }


    // get the filter results from input field
    function getTechnologyResults( technologiesValue ){
        $.getJSON( demosFilters.site_root + '/wp-json/wp/v2/demos?per_page=72&technology=' + technologiesValue, results => {
            filterFeedback.html( `
                ${ results.length
                    ? `<p>demos that match <strong>"${ technologiesValue }"</strong></p><br>`
                    : `<p>None of our demos match that input</p>`
                }
            ` );
            filterResults.html( `
                ${ results.map( item => 
                    `<a href="" class="it-filters-demo it-filters-demo-link">
                        <article class="">
                            <section class="it-filters-demo-header">
                                ${ returnNamesFromIDs( technologyIDs, technologyNames, item.technology ) }
                            </section>
                            <section class="it-filters-demo-info">
                                <h2 class="it-filters-demo-title">${ item.title.rendered }</h2>
                                <span class="it-filters-demo-series">${ returnNamesFromIDs( seriesIDs, seriesNames, item.series ) }</span>
                            </section>
                            <section class="it-filters-demo-taxonomies">
                                <p><strong>Architecture: </strong>${ returnNamesFromIDs( architectureIDs, architectureNames, item.architecture ) }</p>
                                <p><strong>Performance: </strong>${ returnNamesFromIDs( performanceIDs, performanceNames, item.performance ) }</p>
                                <p><strong>Markets: &nbsp;</strong>${ returnNamesFromIDs( marketsIDs, marketsNames, item.markets ) }</p>
                            </section>
                            <section class="it-filters-demo-learn-more">
                                <span class="it-filters-demo-learn-more-link">learn more</span>
                            </section>
                        </article>
                    </a>` 
                ).join( '' ) }
            ` );
        } );
    }


    // get the filter results from input field
    function getMarketsResults( marketsValue ){
        $.getJSON( demosFilters.site_root + '/wp-json/wp/v2/demos?per_page=72&markets=' + marketsValue, results => {
            filterFeedback.html( `
                ${ results.length
                    ? `<p>demos that match <strong>"${ marketsValue }"</strong></p><br>`
                    : `<p>None of our demos match that input</p>`
                }
            ` );
            filterResults.html( `
                ${ results.map( item => 
                    `<a href="" class="it-filters-demo it-filters-demo-link">
                        <article class="">
                            <section class="it-filters-demo-header">
                                ${ returnNamesFromIDs( technologyIDs, technologyNames, item.technology ) }
                            </section>
                            <section class="it-filters-demo-info">
                                <h2 class="it-filters-demo-title">${ item.title.rendered }</h2>
                                <span class="it-filters-demo-series">${ returnNamesFromIDs( seriesIDs, seriesNames, item.series ) }</span>
                            </section>
                            <section class="it-filters-demo-taxonomies">
                                <p><strong>Architecture: </strong>${ returnNamesFromIDs( architectureIDs, architectureNames, item.architecture ) }</p>
                                <p><strong>Performance: </strong>${ returnNamesFromIDs( performanceIDs, performanceNames, item.performance ) }</p>
                                <p><strong>Markets: &nbsp;</strong>${ returnNamesFromIDs( marketsIDs, marketsNames, item.markets ) }</p>
                            </section>
                            <section class="it-filters-demo-learn-more">
                                <span class="it-filters-demo-learn-more-link">learn more</span>
                            </section>
                        </article>
                    </a>` 
                ).join( '' ) }
            ` );
        } );
    }
    

    // get the filter results from input field
    function getPerformanceResults( performanceValue ){
        $.getJSON( demosFilters.site_root + '/wp-json/wp/v2/demos?per_page=72&performance=' + performanceValue, results => {
            filterFeedback.html( `
                ${ results.length
                    ? `<p>demos that match <strong>"${ performanceValue }"</strong></p><br>`
                    : `<p>None of our demos match that input</p>`
                }
            ` );
            filterResults.html( `
                ${ results.map( item => 
                    `<a href="" class="it-filters-demo it-filters-demo-link">
                        <article class="">
                            <section class="it-filters-demo-header">
                                ${ returnNamesFromIDs( technologyIDs, technologyNames, item.technology ) }
                            </section>
                            <section class="it-filters-demo-info">
                                <h2 class="it-filters-demo-title">${ item.title.rendered }</h2>
                                <span class="it-filters-demo-series">${ returnNamesFromIDs( seriesIDs, seriesNames, item.series ) }</span>
                            </section>
                            <section class="it-filters-demo-taxonomies">
                                <p><strong>Architecture: </strong>${ returnNamesFromIDs( architectureIDs, architectureNames, item.architecture ) }</p>
                                <p><strong>Performance: </strong>${ returnNamesFromIDs( performanceIDs, performanceNames, item.performance ) }</p>                                <p><strong>Markets: &nbsp;</strong>${ returnNamesFromIDs( marketsIDs, marketsNames, item.markets ) }</p>
                            </section>
                            <section class="it-filters-demo-learn-more">
                                <span class="it-filters-demo-learn-more-link">learn more</span>
                            </section>
                        </article>
                    </a>` 
                ).join( '' ) }
            ` );
        } );
    }



    // check for text input
    function checkInputField(){
        return ( ( inputField.val() !== '' ) && ( inputField.val().trim() !== '' ) ) ? true : false;
    }
    // typing logic
    function typingLogic(){
        if ( checkInputField() != previousInputValue ){
            // reset tinmer
            clearTimeout( inputTimer );

            if ( checkInputField() ){
                if ( ! isLoaderVisible ){
                    displayLoader();
                    isLoaderVisible = true;
                }
                inputTimer = setTimeout( getInputResults.bind( this ), 600 );
            } else {
                filterResults.html( '' );
                isLoaderVisible = false;
            }
        }
        // set previous input
        previousInputValue = inputField.val().trim();
    }
    // get the filter results from input field
    function getInputResults(){
        $.getJSON( demosFilters.site_root + '/wp-json/wp/v2/demos?per_page=72&terms=' + inputField.value, results => {
            filterFeedback.html( `
                ${ results.length
                    ? `<p>demos that match <strong>"${ inputField.val() }"</strong></p><br>`
                    : `<p>None of our demos match that input</p>`
                }
            ` );
            filterResults.html( `
                ${ results.map( item => 
                    `<a href="" class="it-filters-product it-filters-product-link">
                        <article class="">
                            <section class="it-filters-product-header">
                                ${ returnNamesFromIDs( technologyIDs, technologyNames, item.technology ) }
                            </section>
                            <section class="it-filters-product-info">
                                <h2 class="it-filters-product-title">${ item.title.rendered }</h2>
                                <span class="it-filters-product-series">${ returnNamesFromIDs( seriesIDs, seriesNames, item.series ) }</span>
                            </section>
                            <section class="it-filters-product-taxonomies">
                                <p><strong>Architecture: </strong>${ returnNamesFromIDs( architectureIDs, architectureNames, item.architecture ) }</p>
                                <p><strong>Performance: </strong>${ returnNamesFromIDs( performanceIDs, performanceNames, item.performance ) }</p>                                <p><strong>Markets: &nbsp;</strong>${ returnNamesFromIDs( marketsIDs, marketsNames, item.markets ) }</p>
                            </section>
                            <section class="it-filters-product-learn-more">
                                <span class="it-filters-product-learn-more-link">learn more</span>
                            </section>
                        </article>
                    </a>` 
                ).join( '' ) }
            ` );
        } );
    }

    // add the filters
    function addFiltersHTML(){


        $( '#it-demos-filters-settings-container' ).prepend( `
			<div class="it-demos-filters-settings-wrapper">
				<form id="it-demos-filter-settings">
					<div id="it-technologies-select-container"><h5>Technology</h5></div>
					<div id="it-os-select-container"><h5>Operating System</h5></div>
					<div id="it-platforms-select-container"><h5>Platform</h5></div>
					<div id="it-apis-select-container"><h5>API</h5></div>

					<button class="it-filters-btn it-filters-close">Close</button>
					<button class="it-filters-btn it-filters-reset" type="reset">Reset</button>
				</form>
			</div>
		` );
		
		var technologiesSelectArr = [
			{ val : -1, 	text : 'select one...' },
			{ val : 6954, 	text : 'Graphics' },
			{ val : 6955, 	text : 'Ray Tracing' },
			{ val : 6956, 	text : 'Virtualization' },
			{ val : 6957, 	text : 'Vision' }
		];
		var technologiesSelectField = $( '<select/>', { 
			id 		: 'it-technologies-select',
			class 	: 'it-filters-select' 
		} ).appendTo( 
			'#it-technologies-select-container' 
		);
		$( technologiesSelectArr ).each( function() {
			technologiesSelectField.append( $( '<option/>' )
				.attr( 'value', this.val )
					.text( this.text ) );
		} );


		var osSelectArr = [
			{ val : -1, 	text : 'select one...' },
			{ val : 6959, 	text : 'Android' },
			{ val : 6960, 	text : 'IOS' },
			{ val : 6958, 	text : 'Linux' }
		];
		var osSelectField = $( '<select/>', { 
			id 		: 'it-os-select',
			class 	: 'it-filters-select' 
		} ).appendTo( 
			'#it-os-select-container' 
		);
		$( osSelectArr ).each( function() {
			osSelectField.append( $( '<option/>' )
				.attr( 'value', this.val )
					.text( this.text ) );
		} );


		var platformsSelectArr = [
			{ val : -1, 	text : 'select one...' },
			{ val : 6965, 	text : 'Digital TV' },
			{ val : 6966, 	text : 'Handheld Gaming Console' },
			{ val : 6968, 	text : 'Infotainment System' },
			{ val : 6963, 	text : 'Laptop' },
			{ val : 6964, 	text : 'Set-Top Box' },
			{ val : 6961, 	text : 'Smartphone' },
			{ val : 6962, 	text : 'Tablet' },
			{ val : 6967, 	text : 'Virtual Reality' }
		];
		var platformsSelectField = $( '<select/>', { 
			id 		: 'it-platforms-select',
			class 	: 'it-filters-select' 
		} ).appendTo( 
			'#it-platforms-select-container' 
		);
		$( platformsSelectArr ).each( function() {
			platformsSelectField.append( $( '<option/>' )
				.attr( 'value', this.val )
					.text( this.text ) );
		} );


		var apisSelectArr = [
			{ val : -1, 	text : 'select one...' },
			{ val : 6969, 	text : 'NNA' },
			{ val : 6972, 	text : 'OGLES 3' },
			{ val : 6973, 	text : 'OGLES 3.1' },
			{ val : 6970, 	text : 'OpenCL' },
			{ val : 6974, 	text : 'OpenCV' },
			{ val : 6971, 	text : 'OpenGL' },
			{ val : 6975, 	text : 'OpenVX' },
			{ val : 6976, 	text : 'PVRCLDNN' },
			{ val : 6977, 	text : 'PVRDNN' },
			{ val : 6978, 	text : 'Vulkan' }
		];
		var apisSelectField = $( '<select/>', { 
			id 		: 'it-apis-select',
			class 	: 'it-filters-select' 
		} ).appendTo( 
			'#it-apis-select-container' 
		);
		$( apisSelectArr ).each( function() {
			apisSelectField.append( $( '<option/>' )
				.attr( 'value', this.val )
					.text( this.text ) );
		} );
    }

    // =====|| END functions
    // ..........................


} )( jQuery );