import ImagePreviewLink from "./image-preview-link.js";

document.querySelectorAll( '.greenerwp-image-preview__link' ).forEach(
	link => new ImagePreviewLink( link ) );