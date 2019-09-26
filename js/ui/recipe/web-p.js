const { __, _x, _n, _nx } = wp.i18n;

/**
 * Recipe to use WebP images.
 */
class WebP {
  constructor() {
    this.visible = true;
    this.id = 'web_p';
    this.name = __( 'Use WebP image format', 'ltwp' );
    this.description =
      __( '[WebP](https://en.wikipedia.org/wiki/WebP) is an image format which often allows smaller file sizes compared to more popular image formats like JPEG and PNG.', 'ltwp' )
      + ' ' + __( 'WebP is not supported by [older browsers](https://caniuse.com/#search=webp), but it is possible to serve older image formats as fallback.', 'ltwp' );
    this.steps = [
      {
        type: 'recipe',
        id: 'install_web_p_express',
        args: {
          recipe: 'web_p_express',
        },
      },
    ];
  };
}

export default WebP;
