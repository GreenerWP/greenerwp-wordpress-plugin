<?php
/**
 * Template for the awareness widget form in the widget settings.
 */
?>
<p>
	<label for="<?php echo $widget->get_field_id( 'description' ); ?>">
		<?php _e( 'Custom description (HTML):', 'greenerwp' ); ?>
	</label>
	<br>
	<small><?php _e( 'You should add a disclaimer like the one included in the default description:', 'greenerwp' ) ?>
		<?php _e( '"[bytes transferred] as reported by your browser excluding embedded elements from other websites."', 'greenerwp' ) ?>
	</small>
	<textarea class="widefat code content" rows="10" cols="20"
		id="<?php echo $widget->get_field_id( 'description' ); ?>"
		name="<?php echo $widget->get_field_name( 'description' ); ?>"
	><?php esc_html_e( $description ); ?></textarea>
</p>
<p>
	<input type="checkbox" class="checkbox"
		<?php echo ( $position === 'absolute' ? 'checked' : '' ) ?>
		id="<?php echo $widget->get_field_id( 'position' ); ?>"
		name="<?php echo $widget->get_field_name( 'position' ); ?>"
		value="absolute">
	<label for="<?php echo $widget->get_field_id( 'position' ); ?>">
		<?php _e( 'Position at top of website', 'greenerwp' ); ?>
	</label>
</p>