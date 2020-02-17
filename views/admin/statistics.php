<?php
/**
 * Template for the statistics admin page.
 */
?>
<div class="wrap">
	<h1 class="wp-heading-inline"><?php esc_html_e( 'Statistics', 'greenerwp' ) ?></h1>

	<p>
		<?php esc_html_e( 'For technical reasons, only visits from users with modern browsers are collected. Also, transfer sizes for embedded elements from other domains (e.g. images, scripts or videos) are normally not counted.', 'greenerwp' ) ?>
	</p>

	<p>
		🛈 <?php esc_html_e( 'To lessen the burden on your server, only the last 1000 views are considered (and kept in database) and only the top 50 entries will be shown.', 'greenerwp' ) ?>
	</p>

	<div id="greenerwp-statistics"></div>
</div>