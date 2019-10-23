import ProfilesTab from './profiles-tab.jsx';

const { __, _x, _n, _nx } = wp.i18n;

const SettingsTabs = ( props ) => {
	var tabs = [
		<ProfilesTab/>,
	];
	return (
		<div>
			{ props.isLoading && (
					<p>
						{__( 'Loading settings...', 'ltwp' )}
					</p>
			) }
			{ props.hasError && (
					<p>
						{__( 'Could not load saved settings.', 'ltwp' )}
					</p>
			) }
			{ ! props.isLoading && ! props.hasError && tabs }
		</div>
	);
};

export default SettingsTabs;
