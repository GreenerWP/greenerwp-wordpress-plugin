<?php
/**
 * GreenerWP\Upgrades\V0_2_3\RemoveLazyLoadingFeature class.
 *
 * @package GreenerWP
 */

namespace GreenerWP\Upgrades\V0_2_3;

/**
 * Removes lazy loading option.
 */
class RemoveLazyLoadingFeature {
	/**
	 * Performs upgrades.
	 */
	public function upgrade() {
		delete_option( 'greenerwp_image_previews_lazy_loading' );
	}
}