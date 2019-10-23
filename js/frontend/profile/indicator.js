const { __, _x, _n, _nx } = wp.i18n;

/**
 * Show the profile indicator.
 */
class Indicator {
  constructor( args ) {
		this.args = args;
		this.render();
	}

	render() {
		var indicatorDiv = document.createElement( "div" );
		indicatorDiv.setAttribute( "class", "ltwp-indicator" );

		var profileDiv = document.createElement( "div" );
		profileDiv.setAttribute(
			"class",
			"ltwp-indicator__profile ltwp-indicator__profile--" + this.args.profile );
		var profileLabels = {
			charging: __( "Charging", "ltwp" ),
			battery: __( "On battery", "ltwp" ),
			low: __( "Low battery", "ltwp" ),
		};
		profileDiv.setAttribute( "title", profileLabels[ this.args.profile ] );
		indicatorDiv.appendChild( profileDiv );

		var weatherDiv = document.createElement( "div" );
		weatherDiv.setAttribute(
			"class",
			"ltwp-indicator__weather ltwp-indicator__weather--" + this.args.weather );
		var weatherLabels = {
			sunny: __( "Sunny", "ltwp" ),
			cloudy: __( "Somewhat cloudy", "ltwp" ),
			'full-cloudy': __( "Cloudy", "ltwp" ),
		};
		weatherDiv.setAttribute( "title", weatherLabels[ this.args.weather ] );
		indicatorDiv.appendChild( weatherDiv );
		document.body.appendChild( indicatorDiv );
	};
};

export default Indicator;