const { __, _x, _n, _nx } = wp.i18n;
const { ToggleControl } = wp.components;

const StatisticsTab = ( props ) => {
	return (
		<>
			<h2>{__( 'Page Statistics', 'greenerwp' ) + ' (' + __( 'experimental', 'greenerwp' ) + ')' }</h2>
			<p>
				{
					__( 'This feature collects data about your pages\' sizes, meaning the amount of bytes transferred over the network when a user visits a page.', 'greenerwp' ) + ' ' +
					__( 'It works by counting the transferred bytes in your visitor\'s browser, and sending this information back to your WordPress.', 'greenerwp' ) + ' ' +
					__( 'This information is processed and presented in a table, where you can look for big pages that you could optimize. ', 'greenerwp' ) + ' '
				}
			</p>
			<p>
				<strong>
					{
						__( 'This feature is experimental and currently not optimised for websites with lots of pages. If you notice problems or slow downs, disable the feature and contact greenerWP.', 'greenerwp' )
					}
				</strong>
			</p>
			<ToggleControl
			label={__( 'Enable page statistics', 'greenerwp' )}
			onChange={ ( ) => props.updateSetting( 'statistics_enabled', ! props.settings[ 'statistics_enabled' ] ) }
			checked={ props.settings[ 'statistics_enabled' ] }/>
		</>
	);
};

export default StatisticsTab;