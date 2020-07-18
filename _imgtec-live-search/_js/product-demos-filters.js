// make filters compatible with WordPress
( ( $ ) => {

    // ===============================================================
    // ====== 1. setup: set variables / initiate functions ======
    // ----------------------------------------------------

    // HTML
    addFiltersHTML();

    // load products
    getInitialResults();

    // DOM elements
    const demosPage           	 = $( '#imgtec-fbox-page' );
    const filterSettings         = $( '#it-products-filter-settings' );
    const inputField             = $( '#it-text-input' );
    const technologyCheckboxes   = $( '#it-technology-checkboxes' );
    const marketsCheckboxes      = $( '#it-markets-checkboxes' );
    const performanceCheckboxes  = $( '#it-performance-checkboxes' );
    const technologyRadios       = $( '#it-technology-radios' );
    const marketsRadios          = $( '#it-markets-radios' );
    const performanceRadios      = $( '#it-performance-radios' );
    const filterFeedback         = $( '#it-filters-feedback' );
    const filterResults          = $( '#it-filter-results' );
    const filtersWrapper         = $( '#it-products-filters-wrapper' );
    const filtersOpen            = $( '#it-products-filters-open' );

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
            filtersWrapper.removeClass( 'it-products-filters--inactive' );
            filtersWrapper.addClass( 'it-products-filters--active' );
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
    returnCheckboxValue( 'it-performance-checkbox', getPerformanceResults );
    returnCheckboxValue( 'it-markets-checkbox', getMarketsResults );

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
    returnRadioValue( 'it-technologies-radio', getTechnologyResults );
    // returnRadioValue( 'it-performance-radio', getPerformanceResults );
    // returnRadioValue( 'it-markets-radio', getMarketsResults );

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
        const filters = document.getElementById( 'it-products-filters-wrapper' );
        filtersWrapper.removeClass( 'it-products-filters--inactive' );
        filtersWrapper.addClass( 'it-products-filters--active' );
        areFiltersOpen = true;
    }


    
    // get the filter results from input field
    function getInitialResults(){
        $.getJSON( productsFilters.site_root + '/wp-json/wp/v2/products?per_page=72', results => {
            filterResults.html( `
                ${ results.map( item => 
                    `<a href="" class="it-fbox-filters-product it-filters-product-link">
                        <article class="">
                            <section class="it-filters-product-header">
                                ${ convertIDsToNames( technologyIDs, technologyNames, item.technology ) }
                            </section>
                            <section class="it-filters-product-info">
                                <h2 class="it-filters-product-title">${ item.title.rendered }</h2>
                                <span class="it-filters-product-series">${ convertIDsToNames( seriesIDs, seriesNames, item.series ) }</span>
                            </section>
                            <section class="it-filters-product-taxonomies">
                                <p><strong>Architecture: </strong>${ convertIDsToNames( architectureIDs, architectureNames, item.architecture ) }</p>
                                <p><strong>Performance: </strong>${ convertIDsToNames( performanceIDs, performanceNames, item.performance ) }</p>
                                <p><strong>Markets: &nbsp;</strong>${ convertIDsToNames( marketsIDs, marketsNames, item.markets ) }</p>
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


    // get the filter results from input field
    function getTechnologyResults( technologiesValue ){
        $.getJSON( productsFilters.site_root + '/wp-json/wp/v2/products?per_page=72&technology=' + technologiesValue, results => {
            filterFeedback.html( `
                ${ results.length
                    ? `<p>Products that match <strong>"${ technologiesValue }"</strong></p><br>`
                    : `<p>None of our products match that input</p>`
                }
            ` );
            filterResults.html( `
                ${ results.map( item => 
                    `<a href="" class="it-fbox-filters-product it-filters-product-link">
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
                                <p><strong>Performance: </strong>${ returnNamesFromIDs( performanceIDs, performanceNames, item.performance ) }</p>
                                <p><strong>Markets: &nbsp;</strong>${ returnNamesFromIDs( marketsIDs, marketsNames, item.markets ) }</p>
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


    // get the filter results from input field
    function getMarketsResults( marketsValue ){
        $.getJSON( productsFilters.site_root + '/wp-json/wp/v2/products?per_page=72&markets=' + marketsValue, results => {
            filterFeedback.html( `
                ${ results.length
                    ? `<p>Products that match <strong>"${ marketsValue }"</strong></p><br>`
                    : `<p>None of our products match that input</p>`
                }
            ` );
            filterResults.html( `
                ${ results.map( item => 
                    `<a href="" class="it-fbox-filters-product it-filters-product-link">
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
                                <p><strong>Performance: </strong>${ returnNamesFromIDs( performanceIDs, performanceNames, item.performance ) }</p>
                                <p><strong>Markets: &nbsp;</strong>${ returnNamesFromIDs( marketsIDs, marketsNames, item.markets ) }</p>
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
    

    // get the filter results from input field
    function getPerformanceResults( performanceValue ){
        $.getJSON( productsFilters.site_root + '/wp-json/wp/v2/products?per_page=72&performance=' + performanceValue, results => {
            filterFeedback.html( `
                ${ results.length
                    ? `<p>Products that match <strong>"${ performanceValue }"</strong></p><br>`
                    : `<p>None of our products match that input</p>`
                }
            ` );
            filterResults.html( `
                ${ results.map( item => 
                    `<a href="" class="it-fbox-filters-product it-filters-product-link">
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
        $.getJSON( productsFilters.site_root + '/wp-json/wp/v2/products?per_page=72&terms=' + inputField.value, results => {
            filterFeedback.html( `
                ${ results.length
                    ? `<p>Products that match <strong>"${ inputField.val() }"</strong></p><br>`
                    : `<p>None of our products match that input</p>`
                }
            ` );
            filterResults.html( `
                ${ results.map( item => 
                    `<a href="" class="it-fbox-filters-product it-filters-product-link">
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
        $( '#imgtec-fbox-page' ).prepend( `
            <div id="it-products-filters-wrapper" class="it-products-filters--inactive">
                <div class="it-products-filters-options-wrapper">
                    <div class="it-products-filters-heading-wrapper">
                        <div class="it-products-filters-heading">Product Filter</div>
                        <img class="it-products-filters-close" src="${ productsFilters._imgfolder_root }/right-arrow.png">
                    </div>
                    <form id="it-products-filter-settings">
                        <div id="it-technology-radios" class="it-filters-radios">
                            <h5>Technology</h5>
                            <label><input type="radio" name="itTechnologyRadios" value="5891" class="it-technologies-radio"> Graphics Processors</label>
                            <label><input type="radio" name="itTechnologyRadios" value="5892" class="it-technologies-radio"> Vision & Artificial Intelligence</label>
                            <label><input type="radio" name="itTechnologyRadios" value="5893" class="it-technologies-radio"> Wi-Fi Connectivity</label>
                            <label><input type="radio" name="itTechnologyRadios" value="5894" class="it-technologies-radio"> Bluetooth Connectivity</label>
                            <label><input type="radio" name="itTechnologyRadios" value="5895" class="it-technologies-radio"> Networking</label>
                            <label><input type="radio" name="itTechnologyRadios" value="5896" class="it-technologies-radio"> Broadcast</label>
                        </div>

                        <div id="it-markets-checkboxes" class="it-filters-checkboxes">
                            <h5>Applications</h5>
                            <input type="checkbox" name="itMarketsCheckboxes" value="5852" class="it-markets-checkbox"> Automotive
                            <input type="checkbox" name="itMarketsCheckboxes" value="5853" class="it-markets-checkbox"> Communications
                            <input type="checkbox" name="itMarketsCheckboxes" value="5854" class="it-markets-checkbox"> Consumer Electronics
                            <input type="checkbox" name="itMarketsCheckboxes" value="5855" class="it-markets-checkbox"> Data Processing
                            <input type="checkbox" name="itMarketsCheckboxes" value="5886" class="it-markets-checkbox"> Enterprise
                            <input type="checkbox" name="itMarketsCheckboxes" value="5859" class="it-markets-checkbox"> Gaming
                            <input type="checkbox" name="itMarketsCheckboxes" value="5879" class="it-markets-checkbox"> Hand Held Console
                            <input type="checkbox" name="itMarketsCheckboxes" value="5866" class="it-markets-checkbox"> Industrial
                            <input type="checkbox" name="itMarketsCheckboxes" value="5856" class="it-markets-checkbox"> Industrial and Medical
                            <input type="checkbox" name="itMarketsCheckboxes" value="5867" class="it-markets-checkbox"> Infotainment
                            <input type="checkbox" name="itMarketsCheckboxes" value="5877" class="it-markets-checkbox"> Internet of Things
                            <input type="checkbox" name="itMarketsCheckboxes" value="5857" class="it-markets-checkbox"> Military/Civil Aerospace
                            <input type="checkbox" name="itMarketsCheckboxes" value="5860" class="it-markets-checkbox"> Mobile
                            <input type="checkbox" name="itMarketsCheckboxes" value="5868" class="it-markets-checkbox"> Mobile Internet Devices
                            <input type="checkbox" name="itMarketsCheckboxes" value="5858" class="it-markets-checkbox"> Others
                            <input type="checkbox" name="itMarketsCheckboxes" value="5870" class="it-markets-checkbox"> Set-Top Boxes
                            <input type="checkbox" name="itMarketsCheckboxes" value="5871" class="it-markets-checkbox"> Smart TV
                            <input type="checkbox" name="itMarketsCheckboxes" value="5880" class="it-markets-checkbox"> Smartphones
                            <input type="checkbox" name="itMarketsCheckboxes" value="5881" class="it-markets-checkbox"> Surveillance
                            <input type="checkbox" name="itMarketsCheckboxes" value="5872" class="it-markets-checkbox"> Tablets
                            <input type="checkbox" name="itMarketsCheckboxes" value="5873" class="it-markets-checkbox"> UHDTVs
                        </div>

                        <div id="it-performance-checkboxes" class="it-filters-checkboxes">
                            <h5>Performance</h5>
                            <input type="checkbox" name="itPerformanceCheckboxes" value="5878" class="it-performance-checkbox"> Ultra-Low to Entry-Level
                            <input type="checkbox" name="itPerformanceCheckboxes" value="5861" class="it-performance-checkbox"> Entry-Level
                            <input type="checkbox" name="itPerformanceCheckboxes" value="5863" class="it-performance-checkbox"> Entry to Mid-Level
                            <input type="checkbox" name="itPerformanceCheckboxes" value="5864" class="it-performance-checkbox"> Mid-Level
                            <input type="checkbox" name="itPerformanceCheckboxes" value="5885" class="it-performance-checkbox"> Mid to High-Level
                            <input type="checkbox" name="itPerformanceCheckboxes" value="5882" class="it-performance-checkbox"> High-Level
                            <input type="checkbox" name="itPerformanceCheckboxes" value="5875" class="it-performance-checkbox"> High to Premium-Level
                            <input type="checkbox" name="itPerformanceCheckboxes" value="5888" class="it-performance-checkbox"> Premium-Level
                            <input type="checkbox" name="itPerformanceCheckboxes" value="5874" class="it-performance-checkbox"> High-End Gaming
                            <input type="checkbox" name="itPerformanceCheckboxes" value="5876" class="it-performance-checkbox"> Neural Networks
                        </div>

                        <button class="it-filters-apply-btn it-filters-close-btn">Close</button>
                        <button class="it-filters-apply-btn it-filters-reset-btn" type="reset">Reset</button>
                    </form>
                </div>
            </div>
        ` );
    }

    // =====|| END functions
    // ..........................


} )( jQuery );