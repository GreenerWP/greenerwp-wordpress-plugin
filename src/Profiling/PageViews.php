<?php
namespace GreenerWP\Profiling;

/**
 * Storage for page view profiles.
 */
class PageViews {
	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct( $wpdb ) {
		$this->wpdb = $wpdb;
		$this->table_name = $wpdb->base_prefix . 'greenerwp_page_views';
	}

	public function run() {
		add_action( 'admin_init', [ $this, 'maybe_upgrade_database' ] );
	}

	/**
	 * Clear profile database.
	 *
	 * @return void
	 */
	public function clear() {
		$query = "DELETE FROM `{$this->table_name}`";
		return $this->wpdb->query( $query );
	}

	/**
	 * Upgrade the database if needed.
	 *
	 * @return void
	 */
	public function maybe_upgrade_database() {
		if( $this->wpdb->get_var( "SHOW TABLES LIKE '{$this->table_name}'") === $this->table_name ) {
			return;
		}

		$charset_collate = $this->wpdb->get_charset_collate();

		$sql = "CREATE TABLE `{$this->table_name}` (
	path varchar(1024) NOT NULL,
	transferred bigint UNSIGNED NOT NULL,
	visited TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		$success = empty( $this->wpdb->last_error );
		return $success;
	}


	/**
	 * Saves the given profile.
	 *
	 * @return boolean|WP_Error
	 */
	public function save( $profile ) {
		$sql = <<<EOT
			INSERT INTO `{$this->table_name}`
			(path, transferred)
			VALUES( %s, %d )
EOT;
		$this->wpdb->query( $this->wpdb->prepare(
			$sql,
			$profile['path'],
			$profile['transferred'] ) );
		return true;
	}

	/**
	 * Free some space by removing old entries.
	 */
	public function prune() {
		$limit = apply_filters( 'greenerwp_page_views_records_limit', 1000 );
		$count = $this->wpdb->get_var( "SELECT COUNT(*) FROM `{$this->table_name}`" );
		if ( $count > $limit ) {
			$sql = <<<EOT
			DELETE FROM `{$this->table_name}`
			ORDER BY visited
			LIMIT %d
EOT;
			$this->wpdb->query( $this->wpdb->prepare(
				$sql, $count - $limit ) );
			return true;
		}
	}

	/**
	 * Returns the subscriptions for the given page and flags.
	 *
	 * @param array $flags Subscriptions must have these flags set to true.
	 *
	 * @return array
	 */
	public function get_statistic() {
		$sql = <<<EOT
		SELECT
			SUM(`transferred`) AS transferred,
      COUNT(*) AS `views`
		FROM `{$this->table_name}`
EOT;
		$total = $this->wpdb->get_results( $sql, ARRAY_A )[0];

		$sql = <<<EOT
		SELECT `path`,
			AVG(`transferred`) AS avg_transferred,
			MIN(`transferred`) AS min_transferred,
			MAX(`transferred`) AS max_transferred,
			COUNT(*) AS `views`,
			AVG(`transferred`) * COUNT(*) AS avg_total
		FROM `{$this->table_name}`
		GROUP BY `path`
		ORDER BY `avg_total` DESC LIMIT %d;
EOT;
		$rows = $this->wpdb->get_results(
			$this->wpdb->prepare(
				$sql, apply_filters( 'greenerwp_page_views_statistics_limit', 50 ) ),
			ARRAY_A );
		if ( ! $total['transferred'] || ! $total['views'] ) {
			return [];
		}
		foreach ( $rows as &$row ) {
			$row['total_transferred'] = ( $row['avg_total'] ) / $total['transferred'];
			$row['views'] = $row['views'] / $total['views'];
		}
		return [
			'pages' => $rows,
			'views' => $total['views'],
		];
	}
}