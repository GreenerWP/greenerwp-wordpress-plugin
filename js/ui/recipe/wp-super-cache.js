const { __, _x, _n, _nx } = wp.i18n;

/**
 * Receipe for installing WP Super Cache
 */
class WPSuperCache {
  constructor() {
    this.id = 'wp_super_cache';
    this.showOnlyAsDependency = true;
    this.name = __( 'Install WP Super Cache', 'lowtechwp' );
    this.description =  __( 'Use the WP Super Cache plugin to cache your sites.', 'ltwp' );
    this.steps = [
      {
        type: 'install_plugin',
        id: 'install_wp_super_cache',
        args: {
          name: 'WP Super Cache',
          slug: 'wp-super-cache',
        },
      },
      {
        type: 'link',
        id: 'configure_wp_super_cache',
        args: {
          text: __( 'Configure WP Super Cache and enable caching', 'ltwp' ),
          href: 'options-general.php?page=wpsupercache'
        },
      }
    ];
  };
}

export default WPSuperCache;
