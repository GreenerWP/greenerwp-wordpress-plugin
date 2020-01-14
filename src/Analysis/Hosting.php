<?php
namespace GreenerWP\Analysis;

/**
 * Checks for green hosting.
 */
class Hosting {
	public function get_results() {
		$is_green_host = false;
		$host = parse_url( get_home_url(), PHP_URL_HOST );
		if ( $host ) {
			$transient_key = 'greenerwp_is_green_host_response';
			$result = get_transient( $transient_key );
			if ( ! $result ) {
				$url = 'http://api.thegreenwebfoundation.org/greencheck/' . $host;
				$response = wp_remote_get( $url );
				$body = wp_remote_retrieve_body( $response );
				$result = json_decode( $body );
				if ( $result ) {
					set_transient( $transient_key, $result, DAY_IN_SECONDS );
				}
			}
			$is_green_host = !! ( $result->green ?? false );
		}
		return [
			'is_green_host' => $is_green_host,
		];
	}
}