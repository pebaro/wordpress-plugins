// make filters compatible with WordPress
( ( $ ) => {

    'use strict'

    // class for demos filtering
    class DemosClass {

        // first check for saved demos
        getSavedDemos() {
            const demosJSON = localStorage.getItem( 'demos' )

            try {
                // convert to an object if valid data is found
                // if no data is found store an empty object
                return demosJSON ? JSON.parse( demosJSON ) : []
            } catch ( e ) {
                // in event of corrupt data store an empty array
                console.log( 'restarting demos storage due to a problem' )
                return []
            }
        }

        // save demos to localstorage
        saveDemos( demos ) {
            localStorage.setItem( 'demos', JSON.stringify( demos ) )
        }

        // create DOM structure for each demo
        generateDemoDOM( demo ) {
            // create DOM elements
            const demoWrapperDIV        = document.createElement( 'div' )
            const demoWrapperA          = document.createElement( 'a' )
            const demoIMGContainerDIV   = document.createElement( 'div' )
            const demoIMG               = document.createElement( 'img' )
            const demoInfoDIV           = document.createElement( 'div' )
            const demoMetaDIV           = document.createElement( 'div' )
            const demoTechnologiesSPAN  = document.createElement( 'span' )
            const demoOperatingSysSPAN  = document.createElement( 'span' )
            const demoMetaSpacerDIV     = document.createElement( 'div' )
            const demoTitleH3           = document.createElement( 'h3' )
            const demoDescriptionP      = document.createElement( 'p' )
            const demoLearnWrapperDIV   = document.createElement( 'div' )
            const demoLearnSPAN         = document.createElement( 'span' )

            // setup DOM elements class names
            demoWrapperDIV.className        = 'itls-demo-wrapper'
            demoWrapperA.className          = 'itls-demo-link-wrapper'
            demoIMGContainerDIV.className   = 'itls-demo-img-container'
            demoIMG.className               = 'itls-demo-img'
            demoInfoDIV.className           = 'itls-demo-info'
            demoMetaDIV.className           = 'itls-demo-meta'
            demoTechnologiesSPAN.className  = 'itls-demo-meta-term'
            demoOperatingSysSPAN.className  = 'itls-demo-meta-term'
            demoMetaSpacerDIV.className     = 'itls-demo-meta-spacer'
            demoTitleH3.className           = 'itls-demo-title'
            demoDescriptionP.className      = 'itls-demo-description'
            demoLearnWrapperDIV.className   = 'itls-demo-learnmore-wrapper'
            demoLearnSPAN.className         = 'itls-demo-learnmore'

            // set attributes
            demoWrapperA.setAttribute( 'href', demo.permalink )
            demoIMG.setAttribute( 'src', demo.imageurl )

            // set elements content
            demoTitleH3.textContent         = demo.title
            demoDescriptionP.textContent    = demo.excerpt
            demoLearnSPAN.textContentn      = 'Learn More'
            demoMetaSpacerDIV.textContent   = ' | '

            // demo.technologies.foreach( technology => {
            //     demoTechnologiesSPAN.appendChild( document.createElement( 'span' ).textContent = technology.value )
            // } )
            // demo.os.foreach( os => {
            //     demoOperatingSysSPAN.appendChild( document.createElement( 'span' ).textContent = os.value )
            // } )

            // build demo
            demoIMGContainerDIV.appendChild( demoIMG )

            demoMetaDIV.appendChild( demoOperatingSysSPAN )
            demoMetaDIV.appendChild( demoMetaSpacerDIV )
            demoMetaDIV.appendChild( demoTechnologiesSPAN )

            demoInfoDIV.appendChild( demoDescriptionP )
            demoInfoDIV.appendChild( demoTitleH3 )
            demoInfoDIV.appendChild( demoMetaDIV )

            demoLearnWrapperDIV.appendChild( demoLearnSPAN )

            demoWrapperA.appendChild( demoLearnWrapperDIV )
            demoWrapperA.appendChild( demoInfoDIV )
            demoWrapperA.appendChild( demoIMGContainerDIV )

            demoWrapperDIV.appendChild( demoWrapperA )

            // return finished demo
            return demoWrapperDIV
        }

        // render demos
        renderDemos( demos, filters ) {

            const filteredDemos = demos.filter( demo => {
                const technologyMatch = demo.technology
            } )
            // ########################################################
            // add conditions against searchTaxTerm in filters object
            // ########################################################

            // filter out technologies not in the list
            const filteredTechnologies = demos.filter( demo => demo.technology.includes( filters.searchTechnology ) )

            // // filter out operating systems not in the list
            // const filteredOS = demos.filter( demo => demo.operatingsys.includes( filters.searchOS ) )

            // // filter out platforms not in the list
            // const filteredPlatforms = demos.filter( demo => demo.platform.includes( filters.searchPlatform ) )

            // // filter out apis not in the list
            // const filteredAPIs = demos.filter( demo => demo.api.includes( filters.searchAPI ) )

            // clear out div containing demos to prepare for filtered results
            document.getElementById( 'itls-demos-filter-results' ).innerHTML = ''

            // generate demos based on filtered list
            filteredTechnologies.forEach( demo => {
                document.getElementById( 'itls-demos-filter-results' ).appendChild( this.generateDemoDOM( demo ) )
            } )
            // filteredOS.forEach( demo => {
            //     document.getElementById( 'itls-demos-filter-results' ).appendChild( this.generateDemoDOM( demo ) )
            // } )
            // filteredPlatforms.forEach( demo => {
            //     document.getElementById( 'itls-demos-filter-results' ).appendChild( this.generateDemoDOM( demo ) )
            // } )
            // filteredAPIs.forEach( demo => {
            //     document.getElementById( 'itls-demos-filter-results' ).appendChild( this.generateDemoDOM( demo ) )
            // } )
        }
    }

    const DemosFiltering = new DemosClass()

} )( jQuery );