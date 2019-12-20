const { __, _x, _n, _nx } = wp.i18n;

/**
 * Recipe to tweak Contact Form 7.
 */
class WPCF7 {
  constructor() {
    this.visible = (analysis) => { return analysis.plugin_wpcf7_active; },
    this.id = 'plugin_wpcf7';
    this.name = __( 'Optimise Contact Form 7', 'greenerwp' );
    // this.description = __( 'Optimise Contact Form 7', 'greenerwp' );
    this.steps = [
      {
        type: 'link',
				id: 'plugin_wpcf7_jquery_fix',
				check: (analysis) => { return analysis.greenerwp_wpcf7_jquery_fix_enabled; },
        args: {
          text: __( 'Configure greenerWP to remove jQuery from posts and pages without a contact form.', 'greenerwp' ),
          href: 'admin.php?page=greenerwp_settings'
        },
      },
    ];
  };
}

export default WPCF7;
