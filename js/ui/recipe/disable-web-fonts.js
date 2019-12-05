const { __, _x, _n, _nx } = wp.i18n;

/**
 * Recipe to disable web fonts.
 */
class DisableWebFonts {
  constructor() {
    this.visible = true;
    this.id = 'disable_web_fonts';
    this.name = __( 'Disable web fonts', 'greenerwp' );
    this.description =
      __( 'Web fonts allow web designers to choose custom fonts for the design of the website.', 'greenerwp' )
      + ' ' + __( 'Because they have to be downloaded at least on the first visit of the site, their use increases page load time and the amount of bytes transferred.', 'greenerwp' );
		this.guide = 'web-fonts';
    this.steps = [
      {
        type: 'link',
        id: 'disable_web_fonts_with_greenerwp',
        args: {
          text: __( 'Configure greenerWP to disable web fonts', 'greenerwp' ),
					description: __( 'This will not work for all themes.', 'greenerwp' ),
          href: 'admin.php?page=greenerwp_settings'
        },
      }
    ];
  };
}

export default DisableWebFonts;