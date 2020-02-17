import Awareness from "./awareness.js";
document.querySelectorAll( '.greenerwp-awareness-widget' ).forEach(
	( widget ) => {
		new Awareness( widget );
	}
);
