<?php
/**
 * GreenerWP\Upgrades\Upgrader class.
 *
 * @package GreenerWP
 */

namespace GreenerWP\Upgrades;

/**
 * Implements upgrading to new GreenerWP versions.
 */
class Upgrader {
	/**
	 * Checks the current GreenerWP version and applies any available upgrades if
	 * needed.
	 */
	public function upgrade_if_needed() {
		$version = get_option( 'greenerwp_version', false );

		if ( GREENERWP_VERSION === $version ) {
			return;
		}

		$upgrades = [];

		if ( version_compare( $version, '0.2.3' ) === -1 ) {
			$upgrades[] = new V0_2_3\RemoveLazyLoadingFeature();
		}

		foreach ( $upgrades as $upgrade ) {
			$upgrade->upgrade();
		}
		greenerwp_update_version();
	}
}