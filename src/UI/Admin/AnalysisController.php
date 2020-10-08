<?php
namespace GreenerWP\UI\Admin;

/**
 * REST controller for providing analysis results.
 */
class AnalysisController {
	public function __construct( $checks ) {
		$this->namespace = 'greenerwp/v1';
		$this->checks = $checks;
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
			$this->namespace, '/analysis', [
				[
					'methods'   => [ 'GET' ],
					'callback'  => [ $this, 'retrive_analysis' ],
					'permission_callback' => function ( $request ) {
						return current_user_can( 'manage_options' );
					},
				],
			] );
	}

	/**
	 * Handles analysis request.
	 *
	 * @param WP_REST_Request $request Current request.
	 */
	public function retrive_analysis( $request ) {
		$results = [];
		foreach ( $this->checks as $check ) {
			$results = array_merge( $results, $check->get_results() );
		}
		return $results;
	}
}
