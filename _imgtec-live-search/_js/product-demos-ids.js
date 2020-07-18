/**
 * For Product Demos Filters
 * -----
 * Post Type: it_product_demos
 * CPT Rest Base: product_demos
 * -----
 * IDs for Taxonomy Terms
 * Names for Taxonomy Terms
 * 2 Choices of Functions That Swap Term IDs Applied to Product Demo for the Term Names
 */


// ==============================================================
// ====== Convert Term IDs to the Names for Those Term IDs ======

const returnNamesFromIDs = ( arrayIDs, arrayNames, arrayItems ) => {
    const zip = (a, b) => a.map( ( x, i ) => [ x, b[ i ] ] );
    const namesByID = new Map( zip( arrayIDs, arrayNames ) );

    return arrayItems.map( id => namesByID.get( id ) ).filter( name => name !== undefined );
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

// ==========================
// taxonomy: ip-technology
// rest_base: technology
const technologyIDs = [ 
    6931, // Bluetooth Connectivity
    6932, // Broadcast
    6933, // Graphics Processors
    6934, // Networking
    6935, // Vistion & AI
    6936  // WiFi Connectivity
];
const technologyNames = [
    '<img src="/wp-content/plugins/_imgtec-live-search/_img/products-filters/products-bluetooth.svg" class="it-product-technology-icon" aria-hidden="true"> Bluetooth Connectivity', 
    '<img src="/wp-content/plugins/_imgtec-live-search/_img/products-filters/products-radio-waves.svg" class="it-product-technology-icon" aria-hidden="true"> Broadcast', 
    '<img src="/wp-content/plugins/_imgtec-live-search/_img/products-filters/products-graphics-processor.svg" class="it-product-technology-icon" aria-hidden="true"> Graphics Processors', 
    '<img src="/wp-content/plugins/_imgtec-live-search/_img/products-filters/products-networking.svg" class="it-product-technology-icon" aria-hidden="true"> Networking', 
    '<img src="/wp-content/plugins/_imgtec-live-search/_img/products-filters/products-artificial-intelligence.svg" class="it-product-technology-icon" aria-hidden="true"> Vistion & AI', 
    '<img src="/wp-content/plugins/_imgtec-live-search/_img/products-filters/products-wifi.svg" class="it-product-technology-icon" aria-hidden="true"> WiFi Connectivity'
];


// ======================
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


// ============================
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


// ===========================
// taxonomy: ip-performance
// rest_base: performance
const performanceIDs = [ 
    6920, // Ultra-Low to Entry-Level
    6913, // Entry-Level
    6914, // Entry to Mid-Level
    6915, // Mid-Level
    6925, // Mid to High-Level
    6922, // High-Level
    6918, // High to Premium
    6928, // Premium
    6917, // High-Level Gaming
    6919  // Neural Networks
];
const performanceNames = [ 
    ' Ultra-Low to Entry-Level', ' Entry-Level', ' Entry to Mid-Level', ' Mid-Level', ' Mid to High-Level', ' High-Level', ' High to Premium', ' Premium', ' High-Level Gaming', ' Neural Networks',
];


// ===============================
// taxonomy: ip-product-markets
// rest_base: markets
const marketsIDs = [ 
    6937, // Automotive
    6938, // Communications
    6901, // Consumer Electronics
    6939, // Data Processing
    6940, // Enterprise
    6902, // Gaming
    6941, // Hand Held Console
    6942, // Industrial
    6944, // Infotainment
    6945, // Internet of Things
    6943, // Medical
    6946, // Military/Civil Aerospace
    6903, // Mobile
    5868, // Mobile Internet Devices
    6947, // Others
    6948, // Set-Top Boxes
    6949, // Smart TV
    6911, // Smartphones
    6950, // Surveillance
    6908, // Tablets
    6951  // UHDTVs
];
const marketsNames = [ 
    ' Automotive', ' Communications', ' Consumer Electronics', ' Data Processing', ' Enterprise', ' Gaming', ' Hand Held Console', ' Industrial', ' Infotainment', ' Internet of Things', ' Medical', ' Military/Civil Aerospace', ' Mobile', ' Mobile Internet Devices', ' Others', ' Set-Top Boxes', ' Smart TV', ' Smartphones', ' Surveillance', ' Tablets', ' UHDTVs'
];


// =======================
// taxonomy: product-ip
// rest_base: product_ip
const productIPIDs = [ 
    5852, // PowerVR GE8100
    5853  // PowerVR 2NX
];
const productIPNames = [ 
    ' PowerVR GE8100', ' PowerVR 2NX'
];




