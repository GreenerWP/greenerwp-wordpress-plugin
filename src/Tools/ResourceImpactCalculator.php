<?php
namespace LTWP\Tools;

/**
 * Implements resource impact calculations.
 */
class ResourceImpactCalculator {
	/**
	 * Returns the factors used for calculating transfer impacts.
	 *
	 * @return array {
	 *   @var float $CO2 Factor for CO2 (grams per byte)
	 * }
	 */
	public function get_transfer_impact_factors() {
		return [
			'CO2' => 20 / ( 1024 * 1024 ),
		];
	}
	/**
	 * Calculates the transfer impact for the given size.
	 *
	 * @param int $size Size in byte
	 * @return array {
	 *   @var float $CO2 Amount of CO2 in grams.
	 * }
	 */
	public function get_transfer_impact( $size ) {
		$factors = $this->get_transfer_impact_factors();
		return [
			'CO2' => $size * $factors['CO2'],
		];
	}
}
