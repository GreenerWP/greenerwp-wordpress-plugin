const { __, _x, _n, _nx } = wp.i18n;

/**
 * Recipe to use lazy loading.
 */
class UseLazyLoading {
  constructor() {
    this.visible = true;
    this.id = 'use_lazy_loading';
    this.name = __( 'Use lazy loading', 'greenerwp' );
    this.description =
      __( 'Decrease the amount of transferred bytes by deferring loading of images until they are in range.', 'greenerwp' )
      + ' ' + __( '', 'greenerwp' );
		this.guide = 'images';
    this.steps = [
      {
        type: 'link',
        id: 'image_lazy_loading_with_greenerwp',
				check: (analysis) => { return analysis.greenerwp_image_lazy_loading; },
        args: {
          text: __( 'Configure greenerWP to use lazy loading of images', 'greenerwp' ),
          href: 'admin.php?page=greenerwp_settings'
        },
      }
    ];
  };
}

export default UseLazyLoading;