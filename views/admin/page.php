<?php
/**
 * Template for the main admin page.
 */
?>
<div class="wrap">
	<h1 class="wp-heading-inline"><?php esc_html_e( 'greenerWP', 'greenerwp' ) ?></h1>

	<p>
		<?php esc_html_e( 'Welcome to greenerWP. This plugin helps you making your website more environmentally sustainable.', 'greenerwp' ) ?>
	</p>
	<p>
		🛈 <?php echo str_replace( '<a>', '<a href="'.admin_url( 'admin.php?page=greenerwp_recipes' ).'">',
															__( 'To get started, have a look at the <a>recipes</a>! ', 'greenerwp' ) ) ?>
		<?php echo str_replace( '<a>', '<a target="_blank" href="https://greenerwp.net/guides">',
														__( 'Also have a look at <a>our guides</a> to get an overview of the possible optimizations. ', 'greenerwp' ) ) ?>
	</p>
</div>
