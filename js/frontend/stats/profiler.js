/**
 * Statistics for bytes transferred.
 */
class Profiler {
	constructor( opts ) {
		// Feature detection
		if ( performance === undefined ) {
			return;
		}
		if ( opts.sendProfile && 'sendBeacon' in navigator ) {
			window.addEventListener( "unload", this.sendBeacon.bind( this ) );
		}

		this.refresh();
	}

	refresh() {
		setTimeout( () => {
			var event = new CustomEvent( 'greenerwp:profiler-update', { detail: { profiler: this } });
			document.dispatchEvent( event );
			this.refresh();
		}, 500 );
	}

	// Sends the profile data to greenerWP.
	sendBeacon() {
		var profile = this.get();
		if ( ! profile ) {
			return;
		}
		var url = greenerwpVars.root + 'greenerwp/v1/profiler';
		profile['path'] = document.location.pathname;
		navigator.sendBeacon( url, JSON.stringify( profile ) );
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

		var transferredSize = performance.getEntriesByType("navigation")[0].transferSize;
		var encodedBodySize = performance.getEntriesByType("navigation")[0].encodedBodySize;
		for ( var i=0; i < list.length; i++ ) {
			if ( "transferSize" in list[i] ) {
				transferredSize += list[i].transferSize;
				encodedBodySize += list[i].encodedBodySize;
			}
		}
		return {
			transferredSize: transferredSize,
			encodedBodySize: encodedBodySize,
		};
	};
};

export default Profiler;