<?php
namespace LTWP;

/**
 * Implements weather info retrieval.
 */
class Weather {
	const TRANSIENT_WEATHER_DATA = 'ltwp_weather_data';

	public function is_configured() {
		$city = get_option( 'ltwp_weather_location', null ) ;
		$api_key = get_option( 'ltwp_weather_api_key', null ) ;
		return $city && $api_key;
	}

	public function fetch_weather_data() {
		$city = get_option( 'ltwp_weather_location', null ) ;
		$api_key = get_option( 'ltwp_weather_api_key', null ) ;
		if ( ! $city || ! $api_key ) {
			return;
		}
		$jsonurl = "http://api.openweathermap.org/data/2.5/weather?q=$city&APPID=$api_key";
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
