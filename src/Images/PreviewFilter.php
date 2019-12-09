<?php
namespace GreenerWP\Images;

/**
 * Implement image previews.
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
		add_image_size( 'greenerwp-preview', 200 );
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
				$this->generate_preview_image( $image, $image_meta, $attachment_id ),
				$content );
		}

		return $content;
	}

	/**
	 * Performs a HEAD request to the given URL and returns the content-length.
	 *
	 * @param $url The URL to request.
	 * @returns int The content-length or -1 if there has been an error.
	 */
	public function get_resource_size( $url ) {
		$response = wp_remote_get( $url, [
			'method' => 'HEAD',
			'timeout' => 10,
		] );
		if ( ! is_wp_error ( $response ) ) {
			return $response['headers']['content-length'];
		}
		return -1;
	}

	/**
	 * Generates the markup for the linked preview image.
	 */
	public function generate_preview_image( $image, $image_meta, $attachment_id ) {
		$preview_src = wp_get_attachment_image_src( $attachment_id, 'greenerwp-preview' );
		$image = preg_replace( '/srcset="([^"]+)"/', '', $image );
		preg_match( '/src="([^"]+)"/', $image, $matches );
		$old_src = $matches[1];
		$image = preg_replace( '/src="([^"]+)"/', 'style="width: 100%;" src="' . $preview_src[0] . '"', $image );
		$controls = $this->template_renderer->get_rendered(
			'frontend/media/image-preview-controls', [
				'size' => $this->get_resource_size( $old_src ),
			] );
		return '<a class="greenerwp-image-preview__link" href="' . $old_src . '">' . $image . $controls . '</a>';
	}
}