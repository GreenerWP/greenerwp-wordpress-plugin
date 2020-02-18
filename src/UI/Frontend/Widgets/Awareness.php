<?php

namespace GreenerWP\UI\Frontend\Widgets;

/**
 * Implements the Awareness Widget.
 */
class Awareness extends \WP_Widget {
	function __construct( $template_renderer ) {
		parent::__construct(
			'greenerwp_awareness_widget',
			__( 'greenerWP Bytes Graph', 'greenerwp' ),
			[
				'description' => __( 'A graph which shows transferred bytes.', 'greenerwp' ),
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
				'description' => $instance['description'],
				'position' => $instance['position'],
			] );
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$this->template_renderer->render(
			'frontend/widgets/awareness-form', [
				'widget' => $this,
				'description' => $instance['description'] ?? '',
				'position' => $instance['position'] ?? '',
			] );
	}

	public function update( $new_instance, $old_instance ) {
		return [
			'description' => trim( $new_instance['description'] ?? '' ),
			'position' => $new_instance['position'] === 'absolute' ? 'absolute' : '',
		];
	}
}