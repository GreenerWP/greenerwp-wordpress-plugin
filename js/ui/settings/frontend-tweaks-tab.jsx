const { __, _x, _n, _nx } = wp.i18n;
const { TextControl, ToggleControl } = wp.components;

const FrontendTweaksTab = ( props ) => {
	return (
		<>
			<h2>{__( 'Frontend Tweaks', 'greenerwp' )}</h2>
			<h3>{__( 'Web fonts', 'greenerwp' )}</h3>
			<p>
				{
					__( 'This option will force a sans-serif font on all elements of your theme.', 'greenerwp' )
				}
			</p>
			<p><strong>{ __( 'Caution', 'greenerwp' ) }:</strong>{ ' ' }
				{
					__( 'It\'s a last resort and might radically change the way your site looks and even cause problems with some elements on your site.', 'greenerwp' ) + ' ' +
					__( 'You might try it and disable it at any time if the results do not fit.', 'greenerwp' ) + ' ' +
					__( 'For a better solution, contact your theme author or choose a theme that does not use web fonts or allows you to disable them.', 'greenerwp' )
				}
			</p>
			<p>
				<a href="http://greenerwp.net/guides/web-fonts/" target="_blank">
				{__( 'See our web fonts guide for a more detailed explanation about why you might want to do this.', 'greenerwp' ) }
				</a>
			</p>
			<ToggleControl
			label={__( 'Try to disable web fonts', 'greenerwp' )}
			onChange={ ( ) => props.updateSetting( 'web_fonts_disable', ! props.settings[ 'web_fonts_disable' ] ) }
			checked={ props.settings[ 'web_fonts_disable' ] }/>
			<h3>{__( 'Images', 'greenerwp' )}</h3>
			<h4>{__( 'JPEG quality', 'greenerwp' )}</h4>
			<TextControl
			label={__( 'JPEG image quality (%)', 'greenerwp' )}
			onChange={ ( value ) => props.updateSetting( 'jpeg_quality', value ) }
			help={ __( 'Overwrite WordPress\' default quality for JPEG images. Leave empty to use WordPress\' default, which is 82. Does not apply to already uploaded images. Use the "Regenerate Thumbnails" plugin to recreate thumbnails with the new quality.', 'greenerwp' ) }
			value={props.settings[ 'jpeg_quality' ]}/>
			<h4>{__( 'Image previews', 'greenerwp' )}</h4>
			<ToggleControl
			label={__( 'Experimental: Enable image previews', 'greenerwp' )}
			onChange={ ( ) => props.updateSetting( 'image_previews_enabled', ! props.settings[ 'image_previews_enabled' ] ) }
			checked={ props.settings[ 'image_previews_enabled' ] }/>
			<p>
				{
					__( 'This option will replace images in posts and pages with low quality image previews.', 'greenerwp' )
				}
			</p>
		</>
	);
};

export default FrontendTweaksTab;