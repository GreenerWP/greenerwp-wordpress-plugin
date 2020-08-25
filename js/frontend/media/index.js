import ImagePreview from "./image-preview.js";

[...document.querySelectorAll( 'img.greenerwp-image-preview' )].forEach(
	(image) => new ImagePreview( image ) );