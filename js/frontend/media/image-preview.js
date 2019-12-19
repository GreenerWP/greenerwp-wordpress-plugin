/**
 * Implements the image previews.
 */
class ImagePreview {
  constructor( image ) {
		this.image = image;
		this.listener = this.handleClick.bind( this );
		image.addEventListener( 'click', this.listener  );
	}

	/**
	 * Handle preview image clicks.
	 *
	 * Loads original image.
	 */
	handleClick( event ) {
		event.preventDefault();
		this.image.removeEventListener( 'click', this.listener  );
		this.image.setAttribute(
			'srcset',
			this.image.getAttribute( 'data-srcset' ) );
		this.image.setAttribute(
			'src',
			this.image.getAttribute( 'data-src' ) );
		this.image.parentNode.classList.add( 'greenerwp-image-preview-wrap--loaded' );
	}
};

export default ImagePreview;