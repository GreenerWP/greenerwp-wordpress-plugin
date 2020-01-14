"use strict";

import Profiler from "./stats/profiler.js";

if ( greenerwpVars.statisticsEnabled ) {
	var profiler = new Profiler();
}

import ProfileIndicator from "./profile/indicator.js";

var init = function( status ) {
	new ProfileIndicator( status );
};

fetch( '/wp-json/greenerwp/v1/status', {} )
	.then( response => response.json() )
	.then( response => response.widgetHTML && init( response ) )
	.catch( error => console.log( error ) );

require( "./media/index.js" );