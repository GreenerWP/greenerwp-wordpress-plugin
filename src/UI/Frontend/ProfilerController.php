<?php
namespace GreenerWP\UI\Frontend;

/**
 * REST controller for collecting website profiles.
 */
class ProfilerController {
	public function __construct() {
		$this->namespace = '/greenerwp/v1';
	}

	public function run() {
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	/**
	 * Remove any filters and actions.
	 */
	public function tear_down() {
		remove_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	/**
	 * Registers the REST route.
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace, '/profiler', [
				[
					'methods'   => [ 'POST' ],
					'callback'  => [ $this, 'receive_profile' ],
					'permission_callback' => function ( $request ) {
						return true;
					},
				],
			] );
	}

	/**
	 * Collect website profile.
	 *
	 * @param WP_REST_Request $request Current request.
	 */
	public function receive_profile( $request ) {
    $profile = (array) json_decode( $request->get_body() );
		$saved_profile = get_option( 'greenerwp_profile', [] );
		$profile['views'] = 1;
		if ( array_key_exists( $profile['path'], $saved_profile ) ) {
			$profile['views'] = $saved_profile[$profile['path']]['views'] + 1;
		}
		$saved_profile[$profile['path']] = $profile;
		update_option( 'greenerwp_profile', $saved_profile );
	}
}