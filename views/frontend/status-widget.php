<?php
/**
 * Template for the status widget.
 */
$profile_labels = [
	'charging' => __( "Charging", "ltwp" ),
	'battery' => __( "On battery", "ltwp" ),
	'low' => __( "Low battery", "ltwp" ),
];

$weather_labels = [
	'sunny' => __( "Sunny", "ltwp" ),
	'cloudy' => __( "Somewhat cloudy", "ltwp" ),
	'full-cloudy' => __( "Cloudy", "ltwp" ),
];

?>
<div class="ltwp-status-widget">
	<div class="ltwp-indicator">
		<div class="ltwp-indicator__profile ltwp-indicator__profile--<?php echo $profile_id ?>"
			title="<?php echo esc_attr( $profile_labels[ $profile_id ] ) ?>">
		</div>
		<div class="ltwp-indicator__weather ltwp-indicator__weather--<?php echo $weather_id ?>"
			title="<?php echo esc_attr( $weather_labels[ $weather_id ] ) ?>">
		</div>
		<div class="ltwp-indicator__transfer"
			title="<?php echo esc_attr( __( 'Transferred bytes (approximation)', 'ltwp' ) ) ?>">
			&gt; <span class="ltwp-indicator__transfer-kb-value">?</span> kB<br>
			<span class="ltwp-indicator__transfer-co2-value">?</span> g CO<sub>2</sub>
		</div>
	</div>
</div>