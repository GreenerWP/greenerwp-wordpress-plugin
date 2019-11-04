<?php
namespace LTWP\Tools;

/**
 * Implements resource impact calculations.
 */
class ResourceImpactCalculator {
	// https://alistapart.com/article/sustainable-web-design/
	const WH_PER_BYTE = 13000/1024/1024/1024;

	// CO2 in grams per kWh
	// German power mix 2017
	// https://www.umweltbundesamt.de/sites/default/files/medien/1410/publikationen/2018-05-04_climate-change_11-2018_strommix-2018_0.pdf
	const G_CO2_PER_WH = 0.489;

	/**
	 * Returns the factors used for calculating transfer impacts.
	 *
	 * @return array {
	 *   @var float $CO2 Factor for CO2 (grams per byte)
	 * }
	 */
	public function get_transfer_impact_factors() {
		return [
			'CO2' => self::G_CO2_PER_WH * self::WH_PER_BYTE,
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
