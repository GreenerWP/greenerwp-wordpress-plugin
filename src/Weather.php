<?php
namespace LTWP;

/**
 * Implements weather info retrieval.
 */
class Weather {
	private const TRANSIENT_WEATHER_DATA = 'ltwp_weather_data';

	public function fetch_weather_data() {
		$jsonurl = "http://api.openweathermap.org/data/2.5/weather?q=" . OPEN_WEATHER_CITY . "&APPID=" . OPEN_WEATHER_API_KEY;
		$json = file_get_contents( $jsonurl );
		$weather = json_decode( $json );
		$kelvin = $weather->main->temp;
		$celcius = $kelvin - 273.15;
		return $weather;
	}

	public function get() {
		$weather_data = get_site_transient( self::TRANSIENT_WEATHER_DATA );
		if ( ! $weather_data ) {
			$weather_data = $this->fetch_weather_data();
			set_site_transient(
				self::TRANSIENT_WEATHER_DATA, $weather_data, 5 * MINUTE_IN_SECONDS );
		}
		$cloudiness = $weather_data->clouds->all;
		if ( $cloudiness > 75 ) {
			return 'full-cloudy';
		} else if ( $cloudiness > 25 ) {
			return 'cloudy';
		} else {
			return 'sunny';
		}
	}
}
