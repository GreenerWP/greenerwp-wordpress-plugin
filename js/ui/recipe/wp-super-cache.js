const { __, _x, _n, _nx } = wp.i18n;

/**
 * Receipe for installing WP Super Cache
 */
class WPSuperCache {
  constructor() {
    this.id = 'wp_super_cache';
    this.showOnlyAsDependency = true;
    this.name = __( 'Install WP Super Cache', 'greenerwp' );
    this.description =  __( 'Use the WP Super Cache plugin to cache your sites.', 'greenerwp' );
    this.steps = [
      {
        type: 'install_plugin',
				check: (analysis) => { return analysis.wp_super_cache_active; },
        id: 'install_wp_super_cache',
        args: {
          name: 'WP Super Cache',
          slug: 'wp-super-cache',
        },
      },
      {
        type: 'link',
				check: (analysis) => { return analysis.wp_super_cache_configured; },
        id: 'configure_wp_super_cache',
        args: {
          text: __( 'Configure WP Super Cache and enable caching', 'greenerwp' ),
          href: 'options-general.php?page=wpsupercache'
        },
      }
    ];
  };
}

export default WPSuperCache;
