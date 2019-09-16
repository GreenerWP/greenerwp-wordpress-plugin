<?php
namespace LTWP;

class TemplateRenderer {
  protected $settings_page_properties;

  public function __construct( $template_settings ){
    $this->template_settings = $template_settings;
  }

  /**
   * Render the given template and echo the result.
   */
  public function render( $template, $context=[] ) {
		if ( empty( $context['renderer'] ) ) {
			$context['renderer'] = $this;
		}
		extract( $context );
    include $this->template_settings['templates_path'] . DIRECTORY_SEPARATOR . $template . '.php';
  }

  /**
   * Render the given template and return the result.
   */
  public function get_rendered( $template, $context=[] ) {
    ob_start();
    $this->render( $template, $context );
    return ob_get_clean();
  }
}
