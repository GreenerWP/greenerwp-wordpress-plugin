<?php
namespace GreenerWP;

/**
 * Implements weather info retrieval.
 */
class Weather {
	const TRANSIENT_WEATHER_DATA = 'greenerwp_weather_data';

	public function is_configured() {
		$city = get_option( 'greenerwp_weather_location', null ) ;
		$api_key = get_option( 'greenerwp_weather_api_key', null ) ;
		return $city && $api_key;
	}

	public function fetch_weather_data() {
		$city = get_option( 'greenerwp_weather_location', null ) ;
		$api_key = get_option( 'greenerwp_weather_api_key', null ) ;
		if ( ! $city || ! $api_key ) {
			return;
		}
		$jsonurl = "http://api.openweathermap.org/data/2.5/weather?q=$city&APPID=$api_key";
		$response = wp_remote_get( $jsonurl );
		$body = wp_remote_retrieve_body( $response );
		$weather = json_decode( $body );
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
