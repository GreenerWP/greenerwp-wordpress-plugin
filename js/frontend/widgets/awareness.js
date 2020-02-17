/**
 * Implements awareness widgets.
 */
class Awareness {
	constructor( element ) {
		this.widget = element;

		this.state = {
			percentLess: 0,
			transferKBValue: 0,
			transferMBValue: 0,
		};

		var label = this.widget.querySelector( '.greenerwp-awareness-widget__transfer-graph-label' );
		var description = this.widget.querySelector( '.greenerwp-awareness-widget__description' );
		label.addEventListener( 'click', ( event ) => {
			event.preventDefault();
			description.style.display = 'block';
		} );

		description.querySelector( '.greenerwp-awareness-widget__description-close' )
			.addEventListener( 'click', ( event ) => {
				event.preventDefault();
				description.style.display = 'none';
			} );

		document.addEventListener(
			'greenerwp:profiler-update',
			( event ) => {
				this.widget.style.display = 'block';
				var profile = event.detail.profiler.get();

				this.state = {
					percentLess: 10,
					transferKBValue: Math.round( profile.encodedBodySize / 1024 ),
					transferMBValue: ( profile.encodedBodySize / 1024 / 1024 ).toFixed(2),
				};

				// 	transferredSize,
				// 	encodedBodySize,

				this.refresh();
			}
		);

		this.refresh();
	};

	refresh() {
		Object.keys( this.state ).forEach( ( key ) => {
			var elements = this.widget.querySelectorAll(
				'.greenerwp-awareness-widget__' + key );
			[...elements].forEach( ( element ) => {
				if ( element instanceof HTMLProgressElement ) {
					element.value = this.state[key];
				}
				element.innerHTML = this.state[key];
			} );
		} );
		var graph = this.widget.querySelector( '.greenerwp-awareness-widget__transfer-graph-actual' );
		var label = this.widget.querySelector( '.greenerwp-awareness-widget__transfer-graph-label' );
		if ( graph && label ) {
			var percent = 75 * this.state.transferKBValue / ( 4 * 1024 );
			graph.style.width = percent + '%';
			label.style.left = percent + '%';
		}
	};
};

export default Awareness;