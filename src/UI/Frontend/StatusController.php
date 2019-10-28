<?php
namespace LTWP\UI\Frontend;

/**
 * REST controller for providing webside status.
 */
class StatusController {
	public function __construct( $weather, $profile_status ) {
		$this->weather = $weather;
		$this->profile_status = $profile_status;
		$this->namespace = '/ltwp/v1';

		$this->profile_labels = [
			'charging' => __( "Charging", "ltwp" ),
			'battery' => __( "On battery", "ltwp" ),
			'low' => __( "Low battery", "ltwp" ),
		];

		$this->weather_labels = [
			'sunny' => __( "Sunny", "ltwp" ),
			'cloudy' => __( "Somewhat cloudy", "ltwp" ),
			'full-cloudy' => __( "Cloudy", "ltwp" ),
		];

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
		$weather_id = $this->weather->get();
		$profile_id = $this->profile_status->get_active()::id;
		$response = [
			'weather' => [
				'id' => $weather_id,
				'label' => $this->weather_labels[ $weather_id ],
			],
			'profile' => [
				'id' => $profile_id,
				'label' => $this->profile_labels[ $profile_id ],
			],
		];
		$result = new \WP_REST_Response( $response, 200 );
		$result->set_headers( [
			'Cache-Control' => 'max-age=' . 5 * MINUTE_IN_SECONDS ] );
		return $result;
	}
}