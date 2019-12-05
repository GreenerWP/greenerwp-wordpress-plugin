const { __, _x, _n, _nx } = wp.i18n;
const { TextControl } = wp.components;

const ProfilesTab = ( props ) => {
	return (
		<>
			<h2>{__( 'Profiles', 'greenerwp' )}</h2>
			<h3>{__( 'Indicator', 'greenerwp' )}</h3>
			<p>
				{__( 'The indicator uses weather data from OpenWeatherMap. Leave empty to not use the indicator widget.', 'greenerwp' )}
				<ul>
					<li>
						<a target="_blank" href="https://openweathermap.org/users/sign_up">
							{__( 'Sign up to get an API key', 'greenerwp' )}
						</a>
					</li>
					<li>
						<a target="_blank" href="https://openweathermap.org/find">
							{__( 'Find your location', 'greenerwp' )}
						</a>
					</li>
				</ul>
			</p>
			<label htmlFor="">
				<TextControl
				label={__( 'Location for Weather', 'greenerwp' )}
				onChange={ ( value ) => props.updateSetting( 'weather_location', value ) }
				help={ __( 'E.g. "Frankfurt,DE"', 'greenerwp' ) }
				value={props.settings[ 'weather_location' ]}/>
				<TextControl
				label={__( 'OpenWeatherMap API Key', 'greenerwp' )}
				onChange={ ( value ) => props.updateSetting( 'weather_api_key', value ) }
				value={props.settings[ 'weather_api_key' ]}/>
			</label>
		</>
	);
};

export default ProfilesTab;