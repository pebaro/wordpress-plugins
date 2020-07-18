(function($){

    // MAIN CLASS FOR LIVE SEARCH
    class LiveSearch {

        // ========================================================
        // ===== 1. constructor: describe / create / initiate =====
        // --------------------------------------------------------
        constructor(){
            // HTML content
            this.addSearchHTML();
            this.addMenuSearchIcon();

            // DOM elements
            this.pageBody                       = $( 'body' );
            this.closeButton                    = $( '.it-search-overlay-close' );
            this.searchOverlay                  = $( '.it-search-overlay' );
            this.searchField                    = $( '#it-search-term' );
            this.saveCurrentSearchBtn           = $( '#it-save-current-search' );
            this.clearSavedSearchesBtn          = $( '#it-clear-saved-searches' );
            this.searchForm                     = $( '#it-save-search-form' );
            this.clearSearches                  = $( '#it-clear-all-searches' );
            // this.navSearchListItem              = $( 'li.search-item' );
            // this.navSearchIcon                  = $( '.it-live-search-trigger' );
            this.navSearchTrigger               = $( '.it-search-trigger' );
            this.resultsContainer               = $( '#it-search-overlay-results' );
            this.resultsList                    = $( '#it-results-list' );
            this.filtersContainer               = $( '#it-search-overlay-filters' );
            this.mobileTriggers                 = $( '#it-mobile-triggers' );
            this.mobileSavedSearchesTrigger     = $( '#it-mobile-saved-searches-trigger' );
            this.mobileSavedSearchesClose       = $( '#it-close-mobile-saved-searches' );
            this.savedSearchesContainer         = $( '#it-search-overlay-saved-searches' );
            this.mobileFiltersTrigger           = $( '#it-mobile-filters-trigger' );
            this.mobileFiltersClose             = $( '#it-close-mobile-filters' );
            this.radioFilters                   = $( '#it-livesearch-filters' );
            this.loadMoreButton                 = $( '#it-load-more' );

            // saved searches
            this.savedSearches          = this.getSearches();

            // avoid multiple and/or false DOM queries
            this.isOverlayOpen          = false;
            this.isLoaderVisible        = false;
            this.previousValue;

            // control timing of live search
            this.typingTimer;

            // call events handlers
            this.events();
        }
        // =====|| END constructor


        // =============================
        // ===== 2. event handlers =====
        // -----------------------------
        events(){
            // open/close search overlay
            this.navSearchTrigger.on( 'click', this.openOverlay.bind( this ) );
            this.closeButton.on( 'click', this.closeOverlay.bind(this) );

            // trigger keyboard events
            $( document ).on( 'keydown', this.keypressDispatcher.bind( this ) );
            this.searchField.on( 'keyup', this.typingLogic.bind( this ) );

            // save searches
            this.searchForm.on( 'submit', this.saveSearch.bind( this ) );
            this.mobileSavedSearchesTrigger.on( 'click', this.displayMobileSavedSearches.bind( this ) );
            this.mobileSavedSearchesClose.on( 'click', this.hideMobileSavedSearches.bind( this ) );

            // filters
            this.radioFilters.on( 'change', this.radioSelection.bind( this ) );
            this.mobileFiltersTrigger.on( 'click', this.displayMobileFilters.bind( this ) );
            this.mobileFiltersClose.on( 'click', this.hideMobileFilters.bind( this ) );
        }
        // =====|| END event handlers


        // ======================
        // ===== 3. methods =====
        // ----------------------
        // Animated content loaders - animated .gif and pure css versions
        loaderCSSVersion(){
            // CSS version
            return this.resultsList.html( `
                <div id="it-loader-container">
                    <div id="it-loader-css-animation"></div>
                    <div id="it-loader-text">Loading Results</div>
                </div>
            ` );
        }
        loaderBrandedVersion(){
            // Imagination Technologies logo animation
            return this.resultsList.html(`
                <div id="it-loader-container">
                    <div id="it-loader-gif-animation">
                        <img id="it-loader-gif" src="${liveSearch._imgfolder_root}imgtec-loading-animation.gif">
                    </div>
                </div>
            `);
        }

        // custom notices with duration
        displayNotice( arrayOfTextEntries, displayDuration ){
            const container             = document.querySelector( '.it-search-container' );
            let createNoticeDIV         = document.createElement( 'div' );
            createNoticeDIV.classList   = 'it-saved-search-notice';

            // create a paragraph for each item in the text array
            arrayOfTextEntries.forEach( item => {
                let createTextP         = document.createElement( 'p' );
                createTextP.textContent = item;

                createNoticeDIV.appendChild( createTextP );
            } );

            container.insertBefore( createNoticeDIV, container.childNodes[ 0 ] );

            createNoticeDIV.classList = 'it-active';

            // display duration
            setTimeout( () => {
                createNoticeDIV.parentNode.removeChild( createNoticeDIV );
            }, displayDuration );
        }

        // shorten strings to specified length
        truncateString( string, number ){
            return string.length > number ? string.substr( 0, number - 1 ).trim() + '...' : string;
        }

        // check for an entry
        checkSearchField(){
            return ( ( this.searchField.val() !== '' ) && ( this.searchField.val().trim() !== '' ) ) ? true : false;
        }

        // fire results set based on radio selection
        radioSelection(){
            let radioValue;
            const radios = document.querySelectorAll( '.it-filter-radio' );

            radios.forEach( radio => {
                if ( radio.checked ){
                    radioValue = radio.value;

                    this.checkSearchField() ? this.loaderCSSVersion() : '';

                    switch ( radioValue ) {
                        case 'mixed':          this.checkSearchField() ? this.getResults() : '';              break;
                        case 'pages':          this.checkSearchField() ? this.getPagesResults() : '';         break;
                        case 'posts':          this.checkSearchField() ? this.getPostsResults() : '';         break;
                        case 'press_releases': this.checkSearchField() ? this.getPressReleasesResults() : ''; break;
                        case 'our_events':     this.checkSearchField() ? this.getEventsResults() : '';        break;
                        case 'webinars':       this.checkSearchField() ? this.getWebinarsResults() : '';      break;
                        case 'presentations':  this.checkSearchField() ? this.getPresentationsResults() : ''; break;
                        case 'the_news':       this.checkSearchField() ? this.getNewsResults() : '';          break;
                        case 'ecosystem_news': this.checkSearchField() ? this.getEcoNewsResults() : '';       break;
                        case 'powervr_gpus':   this.checkSearchField() ? this.getPowervrCoresResults() : '';  break;
                        case 'platforms':      this.checkSearchField() ? this.getPlatformsResults() : '';     break;
                        case 'partners':       this.checkSearchField() ? this.getPartnersResults() : '';      break;
                        case 'downloads':      this.checkSearchField() ? this.getDownloadsResults() : '';     break;

                        default:               this.checkSearchField() ? this.getResults() : '';              break;
                    }
                }
            } );
        }

        // check localStorage for saved searches - retreive any that exist
        getSearches(){
            const searchesJSON = localStorage.getItem( 'savedSearches' );

            return searchesJSON !== null ? JSON.parse( searchesJSON ) : [];
        }

        // generate unique ID for search
        generateID( searches ){
            let searchID = 0;

            searches.length > 0
                ? searchID = searches[ searches.length - 1 ].id + 1
                : searchID = 0;

            return searchID;
        }

        // remove search by ID
        removeSearch( searchID ){
            let searches        = this.savedSearches;
            const searchIndex   = searches.findIndex( search => search.id === searchID );

            if ( searchIndex > -1 ) searches.splice( searchIndex, 1 );
        }

        // save search
        saveSearch( e ){
            e.preventDefault();

            let searches            = this.savedSearches;
            let thisSearch          = e.target.elements.itSearchTerm.value.toLowerCase();
            let removePunctuation   = '';

            thisSearch.endsWith( '.' )
                ? removePunctuation = thisSearch.substring( 0, thisSearch.length - 1 )
                : removePunctuation = thisSearch;

            let filteredSearches = searches.filter( search => {
                    return search.term.toLowerCase().trim() == removePunctuation.trim() ? true : false;
                } );

            if ( ! filteredSearches.length ){
                if ( removePunctuation !== '' && removePunctuation.trim() !== '' ){
                    if ( searches.length == 5 ){
                        searches.push( {
                            id: this.generateID( searches ),
                            term: removePunctuation.trim(),
                            trunc: this.truncateString( removePunctuation, 16 )
                        } );
                        setTimeout( this.displayNotice( [
                            'Your next save will replace the first in your list unless you delete one first.'
                        ], 2250 ), 250 );
                    }
                    else if ( searches.length >= 6 ){
                        searches.shift();
                        searches.push( {
                            id: this.generateID( searches ),
                            term: removePunctuation.trim(),
                            trunc: this.truncateString( removePunctuation, 16 )
                        } );
                    }
                    else {
                        searches.push( {
                            id: this.generateID( searches ),
                            term: removePunctuation.trim(),
                            trunc: this.truncateString( removePunctuation, 16 )
                        } );
                    }
                }
                else {
                    setTimeout( this.displayNotice( [
                        'You must enter some text first before the save button will work.'
                    ], 2250 ), 250 );
                }
            }
            else {
                setTimeout( this.displayNotice( [
                    'You have already saved this search term, please try enter something else.'
                ], 2250 ), 250 );
            }

            this.saveSearches( searches );
            this.renderSearches( searches );

            // // clear the search input field
            // e.target.elements.itSearchTerm.value = '';
        }

        // save searches to localStorage
        saveSearches( searches ){
            localStorage.setItem( 'savedSearches', JSON.stringify( searches ) );
        }

        // render saved searches
        renderSearches( searches ){
            const searchesList = document.getElementById( 'it-saved-searches' );
            const closeSearches = document.getElementById( 'it-close-mobile-saved-searches' );
            searchesList.innerHTML = '';

            // if ( searches.length > 0 ){
            //     searchesList.appendChild( this.generateSearchesSummaryDOM( searches ) );
            // }

            searches.forEach( search => {
                const createSearch = this.generateSearchDOM( search );
                searchesList.appendChild( createSearch );
            });

            // const clearAllSearches = document.createElement( 'a' );
            // clearAllSearches.setAttribute( 'id', 'it-clear-all-searches' );
            // clearAllSearches.textContent = 'Clear Searches';

            const clearAllSearches = document.getElementById( 'it-clear-all-searches' );

            if ( searches.length > 1 ){
                // searchesList.appendChild( clearAllSearches );
                document.getElementById( 'it-clear-all-searches' ).style.display = 'inline-block';
            }
            clearAllSearches.addEventListener( 'click', () => {
                searches = this.savedSearches;

                localStorage.removeItem( 'savedSearches', this.savedSearches );
                searchesList.innerHTML = '';

                document.getElementById( 'it-clear-all-searches' ).style.display = 'none';

                searches.splice( 0 );
            } )

            if ( searches.length === 0 ){
                searchesList.innerHTML = '';
            }
        }

        // generate search in DOM
        generateSearchDOM( search ){
            let searches                = this.savedSearches;

            const savedSearchDIV        = document.createElement( 'div' );
            const savedSearchTEXT       = document.createElement( 'a' );
            const savedSearchDELETE     = document.createElement( 'span' );

            savedSearchDIV.className    = 'it-saved-search';

            savedSearchTEXT.className   = 'it-saved-search-term';
            savedSearchTEXT.textContent = search.trunc;
            savedSearchTEXT.setAttribute( 'title', search.term );

            savedSearchDELETE.className = 'it-remove-saved-search';
            savedSearchDELETE.innerHTML = '&times;';

            savedSearchDELETE.addEventListener( 'click', () => {
                this.removeSearch( search.id );
                this.saveSearches( searches );
                this.renderSearches( searches );
            } );

            savedSearchTEXT.addEventListener( 'click', () => {
                this.searchField.val( search.term );
                this.radioSelection();
            } );

            savedSearchDIV.appendChild( savedSearchTEXT );
            savedSearchDIV.appendChild( savedSearchDELETE );

            return savedSearchDIV;
        }

        // create summary heading for saved searches
        generateSearchesSummaryDOM( searches ){
            const searchesSummary   = document.createElement( 'h4' );
            let singularPlural      = '';

            searches.length == 1 ? singularPlural = 'Search' : singularPlural = 'Searches';

            return searchesSummary.textContent = `${ searches.length } ${ singularPlural } Saved`;
        }

        // display search overlay
        openOverlay(){
            // render saved searches
            this.renderSearches( this.savedSearches );

            // open overlay
            this.searchOverlay.removeClass( 'it-search-overlay--inactive' );
            this.searchOverlay.addClass( 'it-search-overlay--active' );
            this.isOverlayOpen = true;

            // empty search input
            this.searchField.val( '' );

            // select search input once overlay opens
            setTimeout( () => this.searchField.focus(), 501 );

            // stop body from scrolling in background
            this.pageBody.addClass( 'body-no-scroll' );
        }

        // hide search overlay
        closeOverlay(){
            // close overlay
            this.searchOverlay.removeClass( 'it-search-overlay--active' );
            this.searchOverlay.addClass( 'it-search-overlay--inactive' );
            this.isOverlayOpen = false;

            // return scrolling to body
            this.pageBody.removeClass( 'body-no-scroll' );
        }

        // overlay key control
        keypressDispatcher( e ){
            // 'S' key opens overlay
            if ( e.keyCode == 83 && ! this.isOverlayOpen && ! $( 'input, textarea' ).is( ':focus' ) && ! $( '.elementor-inline-editing' ).is( ':focus' ) ){
                this.openOverlay();
            }

            // 'Esc' key close overlay
            if ( e.keyCode == 27 && this.isOverlayOpen ){
                this.closeOverlay();
            }
        }

        // search input field timers & loader
        typingLogic(){
            // only run if there's change to input value
            // if ( this.searchField.val().trim () != this.previousValue ){
            if ( this.checkSearchField() != this.previousValue ){
                // reset timer to start
                clearTimeout( this.typingTimer );

                if ( this.checkSearchField() ){
                    // loading animation
                    if ( ! this.isLoaderVisible ){
                        this.loaderCSSVersion();
                        this.isLoaderVisible = true;
                    }
                    // start timer for results
                    this.typingTimer = setTimeout( this.radioSelection.bind( this ), 600 );
                } else {
                    // clear results and hide loader
                    this.resultsList.html('');
                    this.isLoaderVisible = false;
                }
            }
            // set previous value
            this.previousValue = this.searchField.val().trim();
        }

        // load more
        loadMore(){
            let loadMoreButton = $( '#it-load-more' );

            if ( loadMoreButton ){
                let loadContent = ( page ) => {

                    var theData, loadMoreContainer;

                    // ajax request
                    $.ajax( {
                        url: liveSearch.site_root + '/wp-json/livesearch/v1/results?terms=' + this.searchField.val(),
                        dataType: 'json',

                        data: {
                            'per_page': 20,
                            'page': page
                        },

                        success: ( data ) => {
                            console.log('running');
                            if ( data.length < 1 ){
                                loadMoreButton.remove();
                            }

                            theData = [];

                            for ( let i = 0; i < data.length; i++ ){
                                theData[ i ]            = data.mixed[ i ];
                                theData[ i ].excerpt    = data.mixed[ i ].excerpt;
                                theData[ i ].permalink  = data.mixed[ i ].permalink;
                                theData[ i ].title      = data.mixed[ i ].title;
                                theData[ i ].type       = data.mixed[ i ].type;
                            }

                            console.log( theData );
                            console.log( data );

                            loadMoreContainer = this.resultsList;

                            $.each( theData.mixed, ( i ) => {
                                loadMoreContainer.append( i );
                            } );
                        },

                        error: ( jqXHR, errorStatus, errorMessage ) => {
                            errorStatus = jqXHR.status + ' ' + jqXHR.statusText + '\n';
                            errorMessage = jqXHR.responseJSON.responseText;

                            console.log(errorStatus + errorMessage);
                        }
                    } );
                };

                let getPage = 2;

                loadMoreButton.on( 'click', () => {
                    loadContent( getPage );
                    getPage++;
                } );
            }
        }



        // ---------------------------------------
        // RESULTS FOR EACH RADIO BUTTON FILTER
        // ====================================

        // search: mixed set of all custom post types, blog posts and pages
        getResults(){
            // select the mixed radio button option
            document.getElementById('it-mixed-radio').setAttribute( 'checked', true );

            // $.getJSON( liveSearch.site_root + '/wp-json/livesearch/v1/results?terms=' + this.searchField.val() + '&per_page=20&page=1', results => {
            $.getJSON( liveSearch.site_root + '/wp-json/livesearch/v1/results?terms=' + this.searchField.val(), results => {
                this.resultsList.html(`
                    ${ results.mixed.length
                        ? `<li><h3 id="it-results-heading">Everything found for &nbsp;<strong>"${ this.searchField.val() }"</strong></h3></li>`
                        : `<li><p>Nothing matches that search entry &nbsp;&mdash;&nbsp; please try something else</p></li>`
                    }
                    ${ results.mixed.map( item => `
                        <li>
                            <span class="it-result-meta">${ item.type }${ item.type == 'Blog Post' ? `&nbsp;&nbsp;|&nbsp;&nbsp;<span class="it-result-meta-small">published</span> ${ item.published }${ item.author ? `&nbsp;&nbsp;|&nbsp;&nbsp;<span class="it-result-meta-small">author</span> &nbsp;${ item.author }` : '' }` : '' }${ item.type == 'Press Release' || item.type == 'News Article' || item.type == 'EcoSystem News' ? `&nbsp;&nbsp;|&nbsp;&nbsp;<span class="it-result-meta-small">published</span> ${ item.published }` : '' }</span>
                            <h3 class="it-result-heading"><a href="${ item.type == 'Download' ? `${ liveSearch.site_root }/downloads/download-info/${ item.slug }` : `${ item.permalink }` }">${ item.title }</a></h3>
                            <a href="${ item.type == 'Download' ? `${ liveSearch.site_root }/downloads/download-info/${ item.slug }` : `${ item.permalink }` }" class="it-result-permalink" ${ item.type == 'News Article' || item.type == 'EcoSystem News Article' ? `target="_blank"` : '' }>${ item.type == 'Download' ? `${ liveSearch.site_root }/downloads/download-info/${ item.slug }` : `${ item.permalink }` }</a>${ item.type == 'News Article' || item.type == 'EcoSystem News Article' ? `&nbsp;&nbsp;<i class="fa fa-external-link"></i>` : '' }<br>
                            ${ item.excerpt ? `<span class="it-result-excerpt">${ item.excerpt }</span><br>` : '' }
                            ${ item.type == 'Download' ? `<a href="${ liveSearch.site_root }/downloading/?dlm-dp-dl=${ item.id }" class="it-result-permalink">Download Now</a>&nbsp;&nbsp;<i class="fa fa-download" aria-hidden="true"></i>` : '' }
                        </li>
                    ` ).join( '' ) }
                `);
                // this.loadMore();
                this.isLoaderVisible = false;
            } );
        }
        // search: pages
        getPagesResults(){
            $.getJSON( liveSearch.site_root + '/wp-json/livesearch/v1/results?terms=' + this.searchField.val(), results => {
                this.resultsList.html(`
                    ${ results.pages.length
                        ? `<li><h3 id="it-results-heading">Pages found for &nbsp;<strong>"${ this.searchField.val() }"</strong></h3></li>`
                        : `<li><p>None of our Pages match that search &nbsp;&mdash;&nbsp; please try something else or look in our &nbsp<a href="${ liveSearch.site_root }/sitemap_index.xml">site map</a></p></li>`
                    }
                    ${ results.pages.map( item => `
                        <li>
                            <h3 class="it-result-heading"><a href="${ item.permalink }">${ item.title }</a></h3>
                            <a href="${ item.permalink }" class="it-result-permalink">${ item.permalink }</a>
                            ${ item.excerpt ? `<span class="it-result-excerpt">${ item.excerpt }</span>` : '' }
                        </li>
                    ` ).join( '' ) }
                `);
                this.isLoaderVisible = false;
            } );
        }
        // search: blog posts
        getPostsResults(){
            $.getJSON( liveSearch.site_root + '/wp-json/livesearch/v1/results?terms=' + this.searchField.val(), results => {
                this.resultsList.html(`
                    ${ results.posts.length
                        ? `<li><h3 id="it-results-heading">Blog Posts found for &nbsp;<strong>"${ this.searchField.val() }"</strong></h3></li>`
                        : `<li><p>None of our Blog Posts match that search &nbsp;&mdash;&nbsp; visit &nbsp<a href="${ liveSearch.site_root }/blog">our Blog</a></p></li>`
                    }
                    ${ results.posts.map( item => `
                        <li>
                        <span class="it-result-meta"><span class="it-result-meta-small">published</span> ${ item.published }${ item.author ? `&nbsp;&nbsp;|&nbsp;&nbsp;<span class="it-result-meta-small">author</span> ${ item.author }` : '' }</span>
                            <h3 class="it-result-heading"><a href="${ item.permalink }">${ item.title }</a></h3>
                            <a href="${ item.permalink }" class="it-result-permalink">${ item.permalink }</a>
                            ${ item.excerpt ? `<span class="it-result-excerpt">${ item.excerpt }</span><br>` : '' }
                        </li>
                    ` ).join( '' ) }
                `);
                this.isLoaderVisible = false;
            } );
        }
        // search: events
        getEventsResults(){
            $.getJSON( liveSearch.site_root + '/wp-json/livesearch/v1/results?terms=' + this.searchField.val(), results => {
                this.resultsList.html(`
                    ${ results.our_events.length
                        ? `<li><h3 id="it-results-heading">Events found for &nbsp;<strong>"${ this.searchField.val() }"</strong></h3></li>`
                        : `<li><p>None of our Events match that search &nbsp;&mdash;&nbsp; view all &nbsp<a href="${ liveSearch.site_root }/events">Events</a></p></li>`
                    }
                    ${ results.our_events.map( item => `
                        <li>
                            <h3 class="it-result-heading"><a href="${ item.permalink }">${ item.title }</a></h3>
                            <a href="${ item.permalink }" class="it-result-permalink">${ item.permalink }</a>
                            ${ item.excerpt ? `<span class="it-result-excerpt">${ item.excerpt }</span>` : '' }
                        </li>
                    ` ).join( '' ) }
                `);
                this.isLoaderVisible = false;
            } );
        }
        // search: webinars
        getWebinarsResults(){
            $.getJSON( liveSearch.site_root + '/wp-json/livesearch/v1/results?terms=' + this.searchField.val(), results => {
                this.resultsList.html(`
                    ${ results.webinars.length
                        ? `<li><h3 id="it-results-heading">Webinars found for &nbsp;<strong>"${ this.searchField.val() }"</strong></h3></li>`
                        : `<li><p>None of our Webinars match that search &nbsp;&mdash;&nbsp; view all &nbsp<a href="${ liveSearch.site_root }/events/webinars">Webinars</a></p></li>`
                    }
                    ${ results.webinars.map( item => `
                        <li>
                            <h3 class="it-result-heading"><a href="${ item.permalink }">${ item.title }</a></h3>
                            <a href="${ item.permalink }" class="it-result-permalink">${ item.permalink }</a>
                            ${ item.excerpt ? `<span class="it-result-excerpt">${ item.excerpt }</span>` : '' }
                        </li>
                    ` ).join( '' ) }
                `);
                this.isLoaderVisible = false;
            } );
        }
        // search: presentations
        getPresentationsResults(){
            $.getJSON( liveSearch.site_root + '/wp-json/livesearch/v1/results?terms=' + this.searchField.val(), results => {
                this.resultsList.html(`
                    ${ results.presentations.length
                        ? `<li><h3 id="it-results-heading">Presentations found for &nbsp;<strong>"${ this.searchField.val() }"</strong></h3></li>`
                        : `<li><p>None of our Presentations match that search &nbsp;&mdash;&nbsp; view all &nbsp<a href="${ liveSearch.site_root }/events/presentations">Presentations</a></p></li>`
                    }
                    ${ results.presentations.map( item => `
                        <li>
                            <h3 class="it-result-heading"><a href="${ item.permalink }">${ item.title }</a></h3>
                            <a href="${ item.permalink }" class="it-result-permalink">${ item.permalink }</a>
                            ${ item.excerpt ? `<span class="it-result-excerpt">${ item.excerpt }</span>` : '' }
                            <br><span class="it-result-acf">Hosted at: ${ item.event }</span>
                        </li>
                    ` ).join( '' ) }
                `);
                this.isLoaderVisible = false;
            } );
        }
        // search: press releases
        getPressReleasesResults(){
            $.getJSON( liveSearch.site_root + '/wp-json/livesearch/v1/results?terms=' + this.searchField.val(), results => {
                this.resultsList.html(`
                    ${ results.press_releases.length
                        ? `<li><h3 id="it-results-heading">Press  Releases found for &nbsp;<strong>"${ this.searchField.val() }"</strong></h3></li>`
                        : `<li><p>None of our Press Releases match that search &nbsp;&mdash;&nbsp; view all &nbsp<a href="${ liveSearch.site_root } /press-releases">Press Releases</a></p></li>`
                    }
                    ${ results.press_releases.map( item => `
                        <li>
                            <span class="it-result-meta"><span class="it-result-meta-small">published</span> ${ item.published }</span>
                            <h3 class="it-result-heading"><a href="${ item.permalink }">${ item.title }</a></h3>
                            <a href="${ item.permalink }" class="it-result-permalink">${ item.permalink }</a>
                            ${ item.excerpt ? `<span class="it-result-excerpt">${ item.excerpt }</span><br>` : '' }
                        </li>
                    ` ).join( '' ) }
                `);
                this.isLoaderVisible = false;
            } );
        }
        // search: in the news
        getNewsResults(){
            $.getJSON( liveSearch.site_root + '/wp-json/livesearch/v1/results?terms=' + this.searchField.val(), results => {
                this.resultsList.html(`
                    ${ results.the_news.length
                        ? `<li><h3 id="it-results-heading">News found for &nbsp;<strong>"${ this.searchField.val() }"</strong></h3></li>`
                        : `<li><p>None of our News Articles match that search &nbsp;&mdash;&nbsp; view all &nbsp<a href="${ liveSearch.site_root }/in-the-news">News Articles</a></p></li>`
                    }
                    ${ results.the_news.map( item => `
                        <li>
                            <span class="it-result-meta"><span class="it-result-meta-small">published</span> ${ item.published }</span>
                            <h3 class="it-result-heading"><a href="${ item.permalink }">${ item.title }</a></h3>
                            <a href="${ item.permalink }" class="it-result-permalink" target="_blank">${ item.permalink }</a>&nbsp;&nbsp;<i class="fa fa-external-link"></i><br>
                            ${ item.excerpt ? `<span class="it-result-excerpt">${ item.excerpt }</span>` : '' }
                        </li>
                    ` ).join( '' ) }
                `);
                this.isLoaderVisible = false;
            } );
        }
        // search: ecosystem news
        getEcoNewsResults(){
            $.getJSON( liveSearch.site_root + '/wp-json/livesearch/v1/results?terms=' + this.searchField.val(), results => {
                this.resultsList.html(`
                    ${ results.ecosystem_news.length
                        ? `<li><h3 id="it-results-heading">Ecosystem News found for &nbsp;<strong>"${ this.searchField.val() }"</strong></h3></li>`
                        : `<li><p>None of our EcoSystem News Articles match that search &nbsp;&mdash;&nbsp; view all &nbsp<a href="${ liveSearch.site_root }/news/ecosystem">EcoSystem News</a></p></li>`
                    }
                    ${ results.ecosystem_news.map( item => `
                        <li>
                            <span class="it-result-meta"><span class="it-result-meta-small">published</span> ${ item.published }</span>
                            <h3 class="it-result-heading"><a href="${ item.permalink }">${ item.title }</a></h3>
                            <a href="${ item.permalink }" class="it-result-permalink" target="_blank">${ item.permalink }</a>&nbsp;&nbsp;<i class="fa fa-external-link"></i><br>
                            ${ item.excerpt ? `<span class="it-result-excerpt">${ item.excerpt }</span><br>` : '' }
                        </li>
                    ` ).join( '' ) }
                `);
                this.isLoaderVisible = false;
            } );
        }
        // search: powervr gpus
        getPowervrCoresResults(){
            $.getJSON( liveSearch.site_root + '/wp-json/livesearch/v1/results?terms=' + this.searchField.val(), results => {
                this.resultsList.html(`
                    ${ results.powervr_gpus.length
                        ? `<li><h3 id="it-results-heading">PowerVR Cores found for &nbsp;<strong>"${ this.searchField.val() }"</strong></h3></li>`
                        : `<li><p>None of our PowerVR Cores match that search &nbsp;&mdash;&nbsp; view all &nbsp<a href="${ liveSearch.site_root }/graphics-processors/powervr-gpus">PowerVR Cores</a></p></li>`
                    }
                    ${ results.powervr_gpus.map( item => `
                        <li>
                            <h1 class="it-result-heading"><a href="${ item.permalink }">${ item.title }</a></h1>
                            <a href="${ item.permalink }" class="it-result-permalink">${ item.permalink }</a>
                            ${ item.excerpt ? `<span class="it-result-excerpt">${ item.excerpt }</span>` : '' }
                        </li>
                    `).join( '' ) }
                `);
                this.isLoaderVisible = false;
            } );
        }
        // search: platforms
        getPlatformsResults(){
            $.getJSON( liveSearch.site_root + '/wp-json/livesearch/v1/results?terms=' + this.searchField.val(), results => {
                this.resultsList.html(`
                    ${ results.platforms.length
                        ? `<li><h3 id="it-results-heading">Platforms found for &nbsp;<strong>"${ this.searchField.val() }"</strong></h3></li>`
                        : `<li><p>None of our Platforms match that search &nbsp;&mdash;&nbsp; view all &nbsp<a href="${ liveSearch.site_root }/developers/platforms">Platforms</a></p></li>`
                    }
                    ${ results.platforms.map( item => `
                        <li>
                            <h1 class="it-result-heading"><a href="${ item.permalink }">${ item.title }</a></h1>
                            <a href="${ item.permalink }" class="it-result-permalink">${ item.permalink }</a>
                            ${ item.excerpt ? `<span class="it-result-excerpt">${ item.excerpt }</span>` : '' }
                        </li>
                    ` ).join( '' ) }
                `);
                this.isLoaderVisible = false;
            } );
        }
        // search: partners
        getPartnersResults(){
            $.getJSON( liveSearch.site_root + '/wp-json/livesearch/v1/results?terms=' + this.searchField.val(), results => {
                this.resultsList.html(`
                    ${ results.partners.length
                        ? `<li><h3 id="it-results-heading">Partners found for &nbsp;<strong>"${ this.searchField.val() }"</strong></h3></li>`
                        : `<li><p>None of our Partners match that search &nbsp;&mdash;&nbsp; view all &nbsp<a href="${ liveSearch.site_root }/partners">Partners</a></p></li>`
                    }
                    ${ results.partners.map( item => `
                        <li>
                            <h1 class="it-result-heading"><a href="${ item.permalink }">${ item.title }</a></h1>
                            <a href="${ item.permalink }" class="it-result-permalink">${ item.permalink }</a>
                            ${ item.excerpt ? `<span class="it-result-excerpt">${ item.excerpt }</span>` : '' }
                        </li>
                    ` ).join( '' ) }
                `);
                this.isLoaderVisible = false;
            } );
        }
        // search: downloads
        getDownloadsResults(){
            $.getJSON( liveSearch.site_root + '/wp-json/livesearch/v1/results?terms=' + this.searchField.val(), results => {
                this.resultsList.html(`
                    ${ results.downloads.length
                        ? `<li><h3 id="it-results-heading">Downloads found for &nbsp;<strong>"${ this.searchField.val() }"</strong></h3></li>`
                        : `<li><p>None of our Downloads match that search &nbsp;&mdash;&nbsp; view all &nbsp;<a href="${ liveSearch.site_root }/downloads">Downloads</a></li></li>`
                    }
                    ${ results.downloads.map( item => `
                        <li>
                            <h1 class="it-result-heading"><a href="${ liveSearch.site_root }/downloads/download-info/${ item.slug }">${ item.title }</a></h1>
                            <a href="${ liveSearch.site_root }/downloads/download-info/${ item.slug }" class="it-result-permalink">${ liveSearch.site_root }/downloads/download-info/${ item.slug }</a>
                            ${ item.excerpt ? `<span class="it-result-excerpt">${ item.excerpt }</span><br>` : '' }
                            <a href="${ liveSearch.site_root }/downloading/?dlm-dp-dl=${ item.id }" class="it-result-permalink">Download Now</a>&nbsp;&nbsp;<i class="fa fa-download" aria-hidden="true"></i>
                        </li>
                    ` ).join( '' ) }
                `);
                this.isLoaderVisible = false;
            } );
        }

        // add search icon to main navigation
        addMenuSearchIcon(){
            const desktopNav = $( '#menu-primary-navigation' );
            const mobileNavs = $( '#menu-primary-navigation-1' );
            const menuToggle = $( '.menu-toggle' );

            // fontawsome search icon
            $( '<li class="menu-item it-search-trigger"><a class="it-site-search-btn"><i class="fa fa-search"></i></a></li>' ).appendTo( desktopNav );
            $( '<li class="menu-item it-search-trigger"><a class="it-site-search-btn">SEARCH <i class="fa fa-search"></i></a></li>' ).appendTo( mobileNavs );
            $( '<span class="it-mobile-search-icon  it-search-trigger it-site-search-btn"><i class="fa fa-search"></i></span>' ).insertBefore( menuToggle );


            // // .png search icon
            // const sfMenu     = $( '.sf-menu' );
            // $( '<li class="search-item"><img src="' + liveSearch._imgfolder_root + 'nav-search-icon-white-22x22.png" class="it-live-search-trigger"></li>' ).appendTo( sfMenu );
        }

        // mobile trigger for results filters
        displayMobileFilters(){
            const savedSearches = this.savedSearchesContainer;
            savedSearches.removeClass( 'it-search-saved-searches-active' );

            const filters = this.filtersContainer;
            filters.addClass( 'it-search-filters-active');
        }
        hideMobileFilters(){
            const filters = this.filtersContainer;
            filters.removeClass( 'it-search-filters-active' );
        }

        // mobile trigger for results filters
        displayMobileSavedSearches(){
            const filters = this.filtersContainer;
            filters.removeClass( 'it-search-filters-active' );

            const savedSearches = this.savedSearchesContainer;
            savedSearches.addClass( 'it-search-saved-searches-active');
        }
        hideMobileSavedSearches(){
            const savedSearches = this.savedSearchesContainer;
            savedSearches.removeClass( 'it-search-saved-searches-active' );
        }

        // add the search overlay HTML
        addSearchHTML(){
            $('body').append(`
                <div class="it-search-overlay it-search-overlay--inactive">
                    <div class="it-search-overlay-top">
                        <span class="it-search-overlay-close" aria-hidden="true">&times;</span>

                        <div class="it-search-container">
                            <form id="it-save-search-form">
                                <div class="it-input-div">
                                    <div id="it-search-overlay-search-icon"  class="it-search-overlay-search-icon"></div>
                                    <input name="itSearchTerm" id="it-search-term" class="it-search-term" type="text" placeholder="what are you looking for?" aria-label="Search">
                                    <button title="Save Current Search" id="it-save-current-search" tabindex="0" class="it-search-overlay-save-icon"></button>
                                </div>
                            </form>

                            <div id="it-mobile-triggers">
                                <span id="it-mobile-filters-trigger">
                                    <i class="fa fa-bars" aria-hidden="true"></i> Filters
                                </span>
                                <span id="it-mobile-saved-searches-trigger">
                                    <i class="fa fa-folder" aria-hidden="true"></i> Saved Searches
                                </span>
                            </div>

                            <div id="it-search-overlay-saved-searches">
                                <div id="it-saved-searches"></div>
                                <span id="it-clear-all-searches">Clear Searches</span>
                                <span id="it-close-mobile-saved-searches">Close Searches</span>
                            </div>
                        </div>
                    </div>

                    <div class="it-results-container">
                        <div class="it-results-wrapper">
                            <div id="it-search-overlay-filters" class="">
                                <h3 id="it-filters-heading">Filter Results by:</h3>
                                <ul id="it-livesearch-filters">
                                    <div class="it-left-filter-list">
                                        <li><label><input class="it-filter-radio" type="radio" id="it-mixed-radio" name="itradiosfilter" value="mixed" checked>Mixed Results</label></li>
                                        <li><label><input class="it-filter-radio" type="radio" id="it-pages-radio" name="itradiosfilter" value="pages">Pages</label></li>
                                        <li><label><input class="it-filter-radio" type="radio" id="it-posts-radio" name="itradiosfilter" value="posts">Blog Posts</label></li>
                                        <li><label><input class="it-filter-radio" type="radio" id="it-press-releases-radio" name="itradiosfilter" value="press_releases">Press Releases</label></li>
                                        <li><label><input class="it-filter-radio" type="radio" id="it-events-radio" name="itradiosfilter" value="our_events">Events</label></li>
                                        <li><label><input class="it-filter-radio" type="radio" id="it-webinars-radio" name="itradiosfilter" value="webinars">Webinars</label></li>
                                        <li><label><input class="it-filter-radio" type="radio" id="it-presentations-radio" name="itradiosfilter" value="presentations">Presentations</label></li>
                                    </div>

                                    <div class="it-right-filter-list">
                                        <li><label><input class="it-filter-radio" type="radio" id="it-news-radio" name="itradiosfilter" value="the_news">News Articles</label></li>
                                        <li><label><input class="it-filter-radio" type="radio" id="it-eco-news-radio" name="itradiosfilter" value="ecosystem_news">EcoSystem News</label></li>
                                        <li><label><input class="it-filter-radio" type="radio" id="it-powervr-cores-radio" name="itradiosfilter" value="powervr_gpus">PowerVR Cores</label></li>
                                        <li><label><input class="it-filter-radio" type="radio" id="it-platforms-radio" name="itradiosfilter" value="platforms">Platforms</label></li>
                                        <li><label><input class="it-filter-radio" type="radio" id="it-partners-radio" name="itradiosfilter" value="partners">Partners</label></li>
                                        <li><label><input class="it-filter-radio" type="radio" id="it-downloads-radio" name="itradiosfilter" value="downloads">Downloads</label></li>
                                    </div>
                                </ul>
                                <span id="it-close-mobile-filters">Close Filters</span>
                            </div>

                            <div id="it-search-overlay-results">
                                <ul id="it-results-list"></ul>
                            </div>
                        </div>
                    </div>
                </div><!-- .it-search-overlay -->
            `);
        }
        // =====|| END methods

    }

    var search = new LiveSearch();

})(jQuery);
