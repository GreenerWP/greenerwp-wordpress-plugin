import ProfilesTab from './profiles-tab.jsx';
const { Button } = wp.components;

const { __, _x, _n, _nx } = wp.i18n;

const SettingsTabs = ( props ) => {
	var tabs = [
		<ProfilesTab key="profiles-tab" {...props}/>,
	];
	return (
		<div>
			{ props.isLoading && (
					<p>
						{__( 'Loading settings...', 'greenerwp' )}
					</p>
			) }
			{ props.hasError && (
					<p>
						{__( 'Could not load saved settings.', 'greenerwp' )}
					</p>
			) }
			{ ! props.isLoading && ! props.hasError && tabs }
			<Button isPrimary disabled={props.isSaving} isBusy={props.isSaving} onClick={props.saveSettings}>
				{ __( 'Save', 'greenerwp' ) }
			</Button>
		</div>
	);
};

export default SettingsTabs;
