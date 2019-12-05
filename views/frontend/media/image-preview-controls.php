<?php
/**
 * Template for the image preview controls.
 */
$CO2 = greenerwp( 'tools_resource_impact_calculator' )->get_transfer_impact( $size )['CO2'];
?>
<span class="greenerwp-image-preview__controls">
	🔍 <?php esc_html_e( 'Zoom', 'greenerwp' ) ?>
	( <?php echo round( $size / 1000 ) ?> kB, <?php echo round( $CO2, 2 ) ?>g CO<sub>2</sub> )
</span>