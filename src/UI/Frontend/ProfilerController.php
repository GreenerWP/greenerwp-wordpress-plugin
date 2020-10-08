<?php
namespace GreenerWP\UI\Frontend;

/**
 * REST controller for collecting website profiles.
 */
class ProfilerController {
	public function __construct( $page_views ) {
		$this->page_views = $page_views;
		$this->namespace = 'greenerwp/v1';
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
		if ( ! is_numeric( $profile['transferredSize'] ?? null )
			|| ! is_numeric( $profile['encodedBodySize'] ?? null )
			|| ! is_string( $profile['path'] ?? null ) ) {
			return new \WP_Error( 'missing_arguments', 'Missing/wrong arguments' );
		}
		$this->page_views->save( [
			'path' => $profile['path'],
			'transferred' => $profile['transferredSize'],
		] );
		$this->page_views->prune();
	}
}