const { __, _x, _n, _nx } = wp.i18n;

/**
 * Recipe to disable Emojis.
 */
class DisableEmojis {
  constructor() {
    this.visible = true;
    this.id = 'disable_emojis';
    this.name = __( 'Disable emoji replacement', 'ltwp' );
    this.description =
      __( 'WordPress by default replaces [emojis](https://en.wikipedia.org/wiki/Emoji) with images if the browser does not support them directly.', 'ltwp' )
      + ' ' + __( "To detect unsupported browsers, a JavaScript is inserted into every page, and possibly more scripts and images if emojis get replaced.", 'ltwp' )
      + ' ' + __( "If you don't use emojis or if it's not important for your site that they are correctly displayed on older browsers, you could remove this feature and make page loads slightly more efficient.", 'ltwp' );
    this.steps = [
      {
        type: 'recipe',
        id: 'install_disable_emojis',
        args: {
          recipe: 'plugin_disable_emojis',
        },
      },
    ];
  };
}

export default DisableEmojis;
