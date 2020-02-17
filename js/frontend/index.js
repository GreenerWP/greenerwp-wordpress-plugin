"use strict";

import Profiler from "./stats/profiler.js";

var profiler = new Profiler( {
	sendProfile: greenerwpVars.statisticsEnabled,
} );

require( "./media/index.js" );