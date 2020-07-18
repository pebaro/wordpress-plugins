/**
 * ------------------------------------------------------------------------------------
 * Product Demos Filters
 * -----
 * Post Type: it_product_demos
 * CPT Rest Base: product_demos
 * -----
 * IDs for Taxonomy Terms
 * Names for Taxonomy Terms
 * 2 Choices of Functions That Swap Term IDs Applied to Product Demo for the Term Names
 * ------------------------------------------------------------------------------------
 */


// ==============================================================
// ====== Convert Term IDs to the Names for Those Term IDs ======
// --------------------------------------------------------------

const returnNamesFromIDs = ( arrayIDs, arrayNames, arrayItems ) => {
    const zip = (a, b) => a.map( ( x, i ) => [ x, b[ i ] ] );
    const namesByID = new Map( zip( arrayIDs, arrayNames ) );

	return arrayItems
		.map( id => namesByID.get( id ) )
			.filter( name => name !== undefined );
}

const convertIDsToNames = ( arrayIDs, arrayNames, arrayItems ) => {
    return arrayNames.filter( ( _, i ) => arrayItems.includes( arrayIDs[ i ] ) );
}

// ---------------------------------------------------------------
// test output...
console.log( selectIDs( seriesIDs, seriesNames, thirdArray ) )
// ---------------------------------------------------------------



// ================================================================
// ====== Arrays for Product Demos Taxonomy Terms & Term IDs ======
// ----------------------------------------------------------------

// taxonomy: ip-architecture
// rest_base: architecture
const architectureIDs = [ 
    6921, // Furian
    6926, // NNA
    6907  // Rogue
];
const architectureNames = [ 
    'Furian', 'NNA', 'Rogue' 
];


// taxonomy: ip-series
// rest_base: series
const seriesIDs = [ 
    6927, // PowerVR Series 2NX
    6910, // PowerVR Series 9XM
    6916, // PowerVR Series 9XE
    6906, // PowerVR Series 8XE
    6923, // PowerVR Series 8XT
    6924  // PowerVR Series 8XEP
];
const seriesNames = [
    'PowerVR Series 2NX', 'PowerVR Series 9XM', 'PowerVR Series 9XE', 'PowerVR Series 8XE', 'PowerVR Series 8XT', 'PowerVR Series 8XEP'
];


// taxonomy: demo-technologies
// rest_base: demo_technologies
const technologyIDs = [ 
    6954, // Graphics
    6955, // Ray Tracing
    6956, // Virtualization
    6957  // Vision
];
const technologyNames = [
    ' Graphics', 
    ' Ray Tracing', 
    ' Virtualization', 
    ' Vision'
];


// taxonomy: demo-os
// rest_base: demo_operating_systems
const osIDs = [ 
    6959, // Android
    6960, // IOS
    6958  // Linux
];
const osNames = [ 
    ' Android', ' IOS', ' Linux'
];


// taxonomy: demo-platforms
// rest_base: demo_platforms
const platformsIDs = [ 
    6965, // Digital TV
    6966, // Handheld Gaming Console
    6968, // Infotainment System
    6963, // Laptop
    6964, // Set-Top Box
    6961, // Smartphone
    6962, // Tablet
    6967  // Virtual Reality
];
const platformsNames = [ 
    ' Digital TV', ' Handheld Gaming Console', ' Infotainment System', ' Laptop', ' Set-Top Box', ' Smartphone', ' Tablet', ' Virtual Reality'
];


// taxonomy: demo-apis
// rest_base: demo_apis
const apisIDs = [ 
    6969, // NNA
    6972, // OGLES 3
    6973, // OGLES 3.1
    6970, // OpenCL
    6974, // OpenCV
    6971, // OpenGL
    6975, // OpenVX
    6976, // PVRCLDNN
    6977, // PVRDNN
    6978  // Vulkan
];
const apisNames = [ 
    ' NNA', ' OGLES 3', ' OGLES 3.1', ' OpenCL', ' OpenCV', ' OpenGL', ' OpenVX', ' PVRCLDNN', ' PVRDNN', ' Vulkan'
];


// taxonomy: product-ip
// rest_base: product_ip
const productIPIDs = [ 
    6905, // PowerVR GE8300
    6909, // PowerVR GM9446
    6912  // PowerVR GT7450
];
const productIPNames = [ 
    ' PowerVR GE8300', ' PowerVR GM9446', ' PowerVR GT7450'
];