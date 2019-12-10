const { __, _x, _n, _nx } = wp.i18n;
const { ToggleControl } = wp.components;

const PluginTweaksTab = ( props ) => {
	return (
		<>
			<h2>{__( 'Plugin Tweaks', 'greenerwp' )}</h2>
			<h3>{__( 'Contact Form 7', 'greenerwp' )}</h3>
			<ToggleControl
			label={__( 'Experimental: Disable Contact Form 7\'s embedding of jQuery and Styles on every page.', 'greenerwp' )}
			onChange={ ( ) => props.updateSetting( 'wpcf7_jquery_fix_enabled', ! props.settings[ 'wpcf7_jquery_fix_enabled' ] ) }
			checked={ props.settings[ 'wpcf7_jquery_fix_enabled' ] }/>
			<p>
				{
					__( 'jQuery and styles will only be embedded on sites where a Contact Form 7 shortcode is used. Turn off again if your forms stop working.', 'greenerwp' )
				}
			</p>
		</>
	);
};

export default PluginTweaksTab;