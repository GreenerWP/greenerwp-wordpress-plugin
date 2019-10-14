const { __, _x, _n, _nx } = wp.i18n;

/**
 * Recipe to use the Disable Emojis plugin.
 */
class PluginDisableEmojis {
  constructor() {
    this.id = 'plugin_disable_emojis';
    this.name = __( 'Install Disable Emojis', 'ltwp' );
    this.showOnlyAsDependency = true;
    this.description = __( 'Use the Disable Emojis plugin to disable emoji replacement.', 'ltwp' );
    this.steps = [
      {
        type: 'install_plugin',
        id: 'install_plugin_emoji',
        args: {
          name: 'Disable Emoji',
          slug: 'disable-emoji',
        },
      },
    ];
  };
}

export default PluginDisableEmojis;
