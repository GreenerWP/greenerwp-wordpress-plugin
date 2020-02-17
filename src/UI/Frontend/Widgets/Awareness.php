<?php

namespace GreenerWP\UI\Frontend\Widgets;

/**
 * Implements the Awareness Widget.
 */
class Awareness extends \WP_Widget {
	function __construct( $template_renderer ) {
		parent::__construct(
			'greenerwp_awareness_widget',
			__( 'greenerWP Awareness', 'greenerwp' ),
			[
				'description' => __( 'Talk about climate-friendlyness', 'greenerwp' ),
			] );
		$this->template_renderer = $template_renderer;
	}

	public function run() {
		add_action( 'widgets_init', [ $this, 'register' ] );
	}

	public function register() {
		register_widget( $this );
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		$this->template_renderer->render(
			'frontend/widgets/awareness', [
			] );
		echo $args['after_widget'];
	}
}