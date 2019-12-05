<?php
/**
 * Template for the status widget.
 */
$profile_labels = [
	'charging' => __( "Charging", "greenerwp" ),
	'battery' => __( "On battery", "greenerwp" ),
	'low' => __( "Low battery", "greenerwp" ),
];

$weather_labels = [
	'sunny' => __( "Sunny", "greenerwp" ),
	'cloudy' => __( "Somewhat cloudy", "greenerwp" ),
	'full-cloudy' => __( "Cloudy", "greenerwp" ),
];

?>
<div class="greenerwp-status-widget">
	<div class="greenerwp-indicator">
		<div class="greenerwp-indicator__profile greenerwp-indicator__profile--<?php echo $profile_id ?>"
			title="<?php echo esc_attr( $profile_labels[ $profile_id ] ) ?>">
		</div>
		<div class="greenerwp-indicator__weather greenerwp-indicator__weather--<?php echo $weather_id ?>"
			title="<?php echo esc_attr( $weather_labels[ $weather_id ] ) ?>">
		</div>
		<div class="greenerwp-indicator__transfer"
			title="<?php echo esc_attr( __( 'Transferred bytes (approximation)', 'greenerwp' ) ) ?>">
			&gt; <span class="greenerwp-indicator__transfer-kb-value">?</span> kB<br>
			<span class="greenerwp-indicator__transfer-co2-value">?</span> g CO<sub>2</sub>
		</div>
	</div>
</div>