<?php
namespace GreenerWP\UI\Admin;

/**
 * REST controller for providing statistics.
 */
class StatisticsController {
	public function __construct() {
		$this->namespace = '/greenerwp/v1';
	}

	public function run() {
		if ( ! get_option( 'statistics_enabled', false ) ) {
			return;
		}
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
			$this->namespace, '/statistics', [
				[
					'methods'   => [ 'GET' ],
					'callback'  => [ $this, 'retrieve_statistics' ],
					'permission_callback' => function ( $request ) {
						return current_user_can( 'manage_options' );
					},
				],
			] );
	}

	/**
	 * Handles statistics request.
	 *
	 * @param WP_REST_Request $request Current request.
	 */
	public function retrieve_statistics( $request ) {
		$profile = get_option( 'greenerwp_profile', [] );
		$scheme = is_ssl() ? 'https://' : 'http://';
		$base_url = "{$scheme}{$_SERVER['HTTP_HOST']}";
		$results = [];
		foreach( $profile as $path => $entry ) {
			$entry['url'] = "$base_url{$entry['path']}";
			if ( $entry['postID'] ) {
				$entry['permalink'] = get_permalink( $entry['postID'] );
				$entry['title'] = get_the_title( $entry['postID'] );
			}
			$entry['totalTransferred'] = $entry['transferred'] * $entry['views'];
			$results[] = $entry;
		}
		return $results;
	}
}