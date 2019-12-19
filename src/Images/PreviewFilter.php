<?php
namespace GreenerWP\Images;

/**
 * Implement image previews and lazyloading.
 */
class PreviewFilter {
	private $template_renderer = null;

	public function __construct( $template_renderer ) {
		$this->template_renderer = $template_renderer;
	}

	public function run() {
		if ( ! get_option( 'greenerwp_image_previews_enabled', false ) ) {
			return;
		}
		add_image_size( 'greenerwp-preview', 10 );
		add_filter( 'the_content', [ $this, 'add_preview_image' ] );
		add_filter( 'post_thumbnail_html', [ $this, 'filter_thumbnail_html' ], 10, 5 );
  }

	public function filter_thumbnail_html( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
		return $this->generate_preview_image( $html, [], $post_thumbnail_id );
	}

	/**
	 * Replaces images in content with preview images.
	 */
	public function add_preview_image( $content ) {
		// Code based on WordPress' wp_make_content_images_responsive function in media.php
		// Copyright 2011-2019 by the contributors
		// https://wordpress.org/about/license/

		if ( ! preg_match_all( '/<img [^>]+>/', $content, $matches ) ) {
			return $content;
		}

		$selected_images = array();
		$attachment_ids  = array();

		foreach ( $matches[0] as $image ) {
			if ( preg_match( '/wp-image-([0-9]+)/i', $image, $class_id ) ) {
				$attachment_id = absint( $class_id[1] );

				if ( $attachment_id ) {
					/*
					 * If exactly the same image tag is used more than once, overwrite it.
					 * All identical tags will be replaced later with 'str_replace()'.
					 */
					$selected_images[ $image ] = $attachment_id;
					// Overwrite the ID when the same image is included more than once.
					$attachment_ids[ $attachment_id ] = true;
				}
			}
		}

		if ( count( $attachment_ids ) > 1 ) {
			/*
			 * Warm the object cache with post and meta information for all found
			 * images to avoid making individual database calls.
			 */
			_prime_post_caches( array_keys( $attachment_ids ), false, true );
		}

		foreach ( $selected_images as $image => $attachment_id ) {
			$image_meta = wp_get_attachment_metadata( $attachment_id );
			$content = str_replace(
				$image,
				$this->generate_preview_image( $image, $image_meta, $attachment_id, [
					'set_width' => true,
				] ),
				$content );
		}

		return $content;
	}

	/**
	 * Generates the markup for the linked preview image.
	 */
	public function generate_preview_image( $image, $image_meta, $attachment_id, $settings=[] ) {
		$settings = wp_parse_args( $settings, [
			'set_width' => false,
		] );
		$preview_src = wp_get_attachment_image_src( $attachment_id, 'greenerwp-preview' );
		$noscript_image = "<noscript>$image</noscript>";
		$image = preg_replace( '/srcset="([^"]+)"/', 'data-srcset="\1"', $image );
		preg_match( '/src="([^"]+)"/', $image, $matches );
		$old_src = $matches[1];
		$width = '';
		if ( $settings['set_width'] ) {
			$full_width_src = wp_get_attachment_image_src( $attachment_id, 'full' );
			$width = 'width="' . $full_width_src[1] . '"';
		}
		if ( preg_match( '/width="\d+"/', $image ) ) {
			$width = '';
		}
		$lazy_load = get_option( 'greenerwp_image_previews_lazy_loading', false );

		if ( $lazy_load ) {
			$image = preg_replace( '/class="([^"]+)"/', 'class="\1 lazyload"', $image );
		} else {
			$image = preg_replace( '/class="([^"]+)"/', 'class="\1 greenerwp-image-preview"', $image );
		}
		$image = preg_replace( '/src="([^"]+)"/', $width . ' data-src="\1" src="' . $preview_src[0] . '"', $image );
		preg_match( '/alt="([^"]+)"/', $image, $matches );
		$alt = $matches[1];
		$controls = $this->template_renderer->get_rendered(
			'frontend/media/image-preview-controls', [
				'alt' => $alt,
			] );
		$ret = $image . $noscript_image . $controls;
		if ( $lazy_load ) {
			return $ret;
		} else {
			return '<div class="greenerwp-image-preview-wrap">' . $ret . '</div>';
		}
	}
}