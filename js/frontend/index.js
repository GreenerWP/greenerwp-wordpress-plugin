"use strict";

import ProfileIndicator from "./profile/indicator.js";

var init = function( status ) {
	console.log( status );
	new ProfileIndicator( {
		weather: status.weather,
		profile: status.profile,
	} );
};

fetch( '/wp-json/ltwp/v1/status', {} )
	.then( response => response.json() )
	.then( response => init( response ) )
	.catch( error => console.log( error ) );
