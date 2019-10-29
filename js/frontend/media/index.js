import ImagePreviewLink from "./image-preview-link.js";

document.querySelectorAll( '.ltwp-image-preview__link' ).forEach(
	link => new ImagePreviewLink( link ) );