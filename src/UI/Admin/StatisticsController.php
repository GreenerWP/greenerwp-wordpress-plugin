<?php
namespace GreenerWP\UI\Admin;

/**
 * REST controller for providing statistics.
 */
class StatisticsController {
	public function __construct( $page_views ) {
		$this->page_views = $page_views;
		$this->namespace = 'greenerwp/v1';
	}

	public function run() {
		if ( ! get_option( 'greenerwp_statistics_enabled', false ) ) {
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
					'methods'   => [ 'GET', 'DELETE' ],
					'callback'  => [ $this, 'statistics' ],
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
	public function statistics( $request ) {
		if ( $request->get_method() === 'DELETE' ) {
			$this->page_views->clear();
			return;
		}
		$statistic = $this->page_views->get_statistic();
		$scheme = is_ssl() ? 'https://' : 'http://';
		$base_url = "{$scheme}{$_SERVER['HTTP_HOST']}";
		$results = [];
		foreach( $statistic['pages'] as $entry ) {
			$result = [
				'views' => $entry['views'],
				'path' => $entry['path'],
			];
			$result['url'] = "$base_url{$entry['path']}";
			$post_id = url_to_postid( $result['url'] );
			if ( $post_id ) {
				$result['permalink'] = get_permalink( $post_id );
				$result['title'] = get_the_title( $post_id );
			}
			$result['avgTransferred'] = $entry['avg_transferred'];
			$result['minTransferred'] = $entry['min_transferred'];
			$result['maxTransferred'] = $entry['max_transferred'];
			$result['totalTransferred'] = $entry['total_transferred'];
			$results[] = $result;
		}
		return [
			'pages' => $results,
			'views' => $statistic['views'],
		];
	}
}