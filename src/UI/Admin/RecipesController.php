<?php
namespace LTWP\UI\Admin;

/**
 * REST controller for handling recipe states.
 */
class RecipesController {
	public function __construct() {
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
			$this->namespace, '/recipes', [
				[
					'methods'   => [ 'GET', 'POST' ],
					'callback'  => [ $this, 'handle_recipes' ],
					'permission_callback' => function ( $request ) {
						return current_user_can( 'manage_options' );
					},
				],
			] );
	}

	/**
	 * Handles recipes request.
	 *
	 * @param WP_REST_Request $request Current request.
	 */
	public function handle_recipes( $request ) {
		if ( $request->get_method() === 'POST' ) {
      update_option( 'ltwp_recipes', json_decode( $request->get_body() ) );
			return;
    }
    return get_option( 'ltwp_recipes', [ 'foo' => '' ] );
	}
}
