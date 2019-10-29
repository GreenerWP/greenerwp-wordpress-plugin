"use strict";

import ProfileIndicator from "./profile/indicator.js";

var init = function( status ) {
	new ProfileIndicator( {
		widgetHTML: status.widgetHTML,
	} );
};

fetch( '/wp-json/ltwp/v1/status', {} )
	.then( response => response.json() )
	.then( response => init( response ) )
	.catch( error => console.log( error ) );
