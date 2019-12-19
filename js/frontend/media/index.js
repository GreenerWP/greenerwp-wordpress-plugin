import ImagePreview from "./image-preview.js";

if ( document.querySelector( 'img.lazyload' ) ) {
	import( 'lazysizes' ).then();
}

document.querySelectorAll( 'img.greenerwp-image-preview' ).forEach(
	(image) => new ImagePreview( image ) );