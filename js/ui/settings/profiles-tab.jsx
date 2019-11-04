const { __, _x, _n, _nx } = wp.i18n;
const { TextControl } = wp.components;

const ProfilesTab = ( props ) => {
	return (
		<>
			<h2>{__( 'Profiles', 'ltwp' )}</h2>
			<h3>{__( 'Indicator', 'ltwp' )}</h3>
			<p>
				{__( 'The indicator uses weather data from OpenWeatherMap. Leave empty to not use the indicator widget.', 'ltwp' )}
				<ul>
					<li>
						<a target="_blank" href="https://openweathermap.org/users/sign_up">
							{__( 'Sign up to get an API key', 'ltwp' )}
						</a>
					</li>
					<li>
						<a target="_blank" href="https://openweathermap.org/find">
							{__( 'Find your location', 'ltwp' )}
						</a>
					</li>
				</ul>
			</p>
			<label htmlFor="">
				<TextControl
				label={__( 'Location for Weather', 'ltwp' )}
				onChange={ ( value ) => props.updateSetting( 'weather_location', value ) }
				help={ __( 'E.g. "Frankfurt,DE"', 'ltwp' ) }
				value={props.settings[ 'weather_location' ]}/>
				<TextControl
				label={__( 'OpenWeatherMap API Key', 'ltwp' )}
				onChange={ ( value ) => props.updateSetting( 'weather_api_key', value ) }
				value={props.settings[ 'weather_api_key' ]}/>
			</label>
		</>
	);
};

export default ProfilesTab;