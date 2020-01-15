/**
 * Statistics for bytes transferred.
 */
class Profiler {
	constructor( args ) {
		// Feature detection
		if ( ! 'sendBeacon' in navigator
				 || ! 'keepalive' in new Request('')
			 ) {
			return;
		}
		// window.addEventListener( "unload", this.sendBeacon.bind( this ) );
		setTimeout( this.sendBeacon.bind( this ), 500 );
	}

	sendBeacon() {
		var profile = {
			transferred: this.get(),
			path: document.location.pathname,
		};

		const opts = {
			// headers: {
			// 	'X-WP-Nonce': wpApiSettings.nonce,
			// },
			method: 'POST',
			keepalive: true,
			body: JSON.stringify( profile ),
		};
		fetch( greenerwpVars.root + 'greenerwp/v1/profiler', opts );
	}

	get() {
		if ( performance === undefined ) {
			return;
		}
		var list = performance.getEntriesByType( "resource" );
		if ( list === undefined ) {
			return;
		}

		// var pageNav = performance.getEntriesByType("navigation")[0];
		// var headerSize = pageNav.transferSize - pageNav.encodedBodySize;


		// Use observer?
		// https://developers.google.com/web/fundamentals/performance/navigation-and-resource-timing#listen_for_performance_entries_using_performanceobserver

		var transferred = performance.getEntriesByType("navigation")[0].encodedBodySize;
		console.log(transferred);
		for ( var i=0; i < list.length; i++ ) {
			console.log("== Resource[" + i + "] - " + list[i].name);
			if ( "transferSize" in list[i] ) {
				// console.log("... transferSize[" + i + "] = " + list[i].transferSize);
				// transferred += list[i].transferSize;
				transferred += list[i].encodedBodySize;
			}
		}

		return transferred;
	}
};

export default Profiler;