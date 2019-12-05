<?php
/**
 * Template for the main admin page.
 */
?>
<h1><?php esc_html_e( 'greenerWP', 'greenerwp' ) ?></h1>

<p>
  <?php esc_html_e( 'Welcome to greenerWP. This plugin helps you making your website more environmentally sustainable.', 'greenerwp' ) ?>
</p>
<p>
  🛈 <?php echo str_replace( '<a>', '<a href="'.admin_url( 'admin.php?page=greenerwp_recipes' ).'">',
                            __( 'To get started, have a look at the <a>recipes</a>! ', 'greenerwp' ) ) ?>
</p>
