const { __, _x, _n, _nx } = wp.i18n;

/**
 * Recipe to reduce the default JPEG quality.
 */
class ReduceJPEGQuality {
  constructor() {
    this.visible = true;
    this.id = 'reduce_jpeg_quality';
    this.name = __( 'Reduce JPEG quality', 'greenerwp' );
    this.description =
      __( 'Decrease the amount of transferred bytes for JPEG images by reducing it\'s default quality settings.', 'greenerwp' )
      + ' ' + __( '', 'greenerwp' );
		this.guide = 'images';
    this.steps = [
      {
        type: 'link',
        id: 'reduce_jpeg_quality_with_greenerwp',
				check: (analysis) => { return analysis.greenerwp_jpeg_quality_reduced; },
        args: {
          text: __( 'Configure greenerWP to reduce the default JPEG quality', 'greenerwp' ),
          href: 'admin.php?page=greenerwp_settings'
        },
      }
    ];
  };
}

export default ReduceJPEGQuality;