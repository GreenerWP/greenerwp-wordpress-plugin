"use strict";

import Profiler from "./stats/profiler.js";

if ( greenerwpVars.statisticsEnabled ) {
	var profiler = new Profiler();
}

require( "./media/index.js" );