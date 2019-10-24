<?php
namespace LTWP\UI\Frontend;

/**
 * REST controller for providing webside status.
 */
class StatusController {
	public function __construct( $weather ) {
		$this->weather = $weather;
		$this->namespace = '/ltwp/v1';
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
			$this->namespace, '/status', [
				[
					'methods'   => [ 'GET' ],
					'callback'  => [ $this, 'get_status' ],
					'permission_callback' => function ( $request ) {
						return true;
						/* return current_user_can( 'manage_options' ); */
					},
				],
			] );
	}

	/**
	 * Returns website status.
	 *
	 * @param WP_REST_Request $request Current request.
	 */
	public function get_status( $request ) {
		$response = [
			'weather' => $this->weather->get(),
			'profile' => 'charging',
		];
		$result = new \WP_REST_Response( $response, 200 );
		$result->set_headers( [
			'Cache-Control' => 'max-age=' . 5 * MINUTE_IN_SECONDS ] );
		return $result;
	}
}