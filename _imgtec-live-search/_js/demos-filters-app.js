( ( $ ) => {

	const filterResults = $( '#itlf-demos-filter-results' );

	$.getJSON( demosFiltersApp.site_root + '/wp-json/filtering/v1/demos', results => {
		filterResults.html( `
			${ results.map( item => `<div class="itlf-demo-wrapper">
					<a href="${ item.permalink }" class="itlf-demo-link-wrapper">
						<div class="itlf-demo-img-container">
							<img src="${ item.imageurl }" class="itlf-demo-img">
						</div>
						<div class="itlf-demo-info">
							<div class="itlf-demo-meta"><span class="itlf-demo-meta-term">${ item.technology[0].label }</span><span class="itlf-demo-meta-spacer"> | </span><span class="itlf-demo-meta-term">${ item.operating_sys[0].label }</span></div>
							<h2 class="itlf-demo-title">${ item.title }</h2>
							<p class="itlf-demo-description">${ item.excerpt }</p>
						</div>
						<div class="itlf-demo-learnmore-wrapper">
							<span class="itlf-demo-learnmore">learn more</span>
						</div>
					</a>
				</div>`
			).join( '' ) }
		` );
	} );
	
} )( jQuery );