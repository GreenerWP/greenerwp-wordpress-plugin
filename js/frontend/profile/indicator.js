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
			"ltwp-indicator__profile ltwp-indicator__profile--" + this.args.profile.id );
		profileDiv.setAttribute( "title", this.args.profile.label );
		indicatorDiv.appendChild( profileDiv );

		var weatherDiv = document.createElement( "div" );
		weatherDiv.setAttribute(
			"class",
			"ltwp-indicator__weather ltwp-indicator__weather--" + this.args.weather.id );
		weatherDiv.setAttribute( "title", this.args.weather.label );
		indicatorDiv.appendChild( weatherDiv );
		document.body.appendChild( indicatorDiv );
	};
};

export default Indicator;