<?php
/**
 * Template for the main admin page.
 */
?>
<h1><?php esc_html_e( 'LowTechWP', 'lowtechwp' ) ?></h1>

<p>
  <?php esc_html_e( 'Welcome to LowTechWP. This plugin helps you making your website more sustainable.', 'ltwp' ) ?>
</p>
<p>
  🛈 <?php echo str_replace( '<a>', '<a href="'.admin_url( 'admin.php?page=lowtechwp_recipes' ).'">',
                            __( 'To get started, have a look at the <a>recipes</a>! ', 'ltwp' ) ) ?>
</p>
