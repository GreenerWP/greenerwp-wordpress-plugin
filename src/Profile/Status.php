<?php
namespace LTWP\Profile;

/**
 * Implements profile status.
 */
class Status {
	/**
	 * Returns the currently active profile.
	 *
	 * @return object
	 */
	public function get_active() {
		return new Charging();
	}
}
