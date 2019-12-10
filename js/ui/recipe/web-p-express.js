const { __, _x, _n, _nx } = wp.i18n;

/**
 * Recipe to use WebP images.
 */
class WebPExpress {
  constructor() {
    this.id = 'web_p_express';
    this.name = __( 'Install WebP Express', 'greenerwp' );
    this.showOnlyAsDependency = true;
    this.description = __( 'Use the WebP Express plugin to serve WebP images to browsers that support it.', 'greenerwp' );
    this.steps = [
      {
        type: 'install_plugin',
        id: 'install_web_p_express',
				check: (analysis) => { return analysis.web_p_express_active; },
        args: {
          name: 'WebP Express',
          slug: 'webp-express',
        },
      },
      {
        type: 'link',
        id: 'configure_web_p_express',
				check: (analysis) => { return analysis.web_p_express_active; },
        args: {
          text: __( 'Configure WebP Express', 'greenerwp' ),
          description: __( 'Operation mode "CDN friendly" with the "Alter HTML" option might be a good start.', 'greenerwp' ),
          href: 'options-general.php?page=webp_express_settings_page'
        },
      }
    ];
  };
}

export default WebPExpress;
