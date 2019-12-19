<?php
/**
 * Template for the image preview controls.
 */
?>
<span class="greenerwp-image-preview__controls">
	🔍 <?php esc_html_e( 'Load image', 'greenerwp' ) ?><?php if ( $alt ): ?>:
		<?php esc_html_e( $alt ) ?>
	<?php endif ?>
</span>