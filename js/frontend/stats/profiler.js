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

		this.initProfile();
		var perfObserver = new PerformanceObserver( this.update.bind( this ) );
		perfObserver.observe( {
			entryTypes: [ "navigation", "resource" ],
		} );
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

	initProfile() {
		this.profile = {};
		this.profile.transferredSize = performance.getEntriesByType( "navigation" )[0].transferSize;
		this.profile.encodedBodySize = performance.getEntriesByType( "navigation" )[0].encodedBodySize;
		this.update( performance, null );
	}

	// Updates the profile.
	update( list, obj ) {
		var entries = list.getEntriesByType( "resource" );
		if ( entries === undefined ) {
			return;
		}
		for ( var i=0; i < entries.length; i++ ) {
			if ( "transferSize" in entries[i] ) {
				this.profile.transferredSize += entries[i].transferSize;
				this.profile.encodedBodySize += entries[i].encodedBodySize;
			}
		}
		var event = new CustomEvent( 'greenerwp:profiler-update', { detail: { profiler: this } });
		document.dispatchEvent( event );
	};

	// Returns the profile.
	get() {
		return this.profile;
	};
};

export default Profiler;