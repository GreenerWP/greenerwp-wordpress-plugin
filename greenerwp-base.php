<?php

/* $plugin['frontend_script'] = function( $plugin ) { */
/* return new GreenerWP\FrontendScripts( [ */
/* [ */
/* 'script_path' => $plugin['url'] . '/js/core.js', */
/* 'script_version' => filemtime( $plugin['path'] . '/js/core.js' ), */
/* 'script_deps' => [ 'wp-i18n', 'wp-api', 'wp-element' ], */
/* ], */
/* ] ); */
/* }; */

$plugin['template_settings'] = [
  'templates_path' => $plugin['path'] . DIRECTORY_SEPARATOR . 'views',
];

$plugin['frontend'] = function ( $plugin ) {
  return new GreenerWP\UI\Frontend(
    [
      'js_base_url' => $plugin['url'] . '/dist/js',
      'js_base_path' => $plugin['path'] . '/dist/js',
      'css_base_url' => $plugin['url'] . '/dist/css',
      'css_base_path' => $plugin['path'] . '/dist/css',
    ]
  );
};

$plugin['template_renderer'] = function ( $plugin ) {
  return new GreenerWP\TemplateRenderer( $plugin['template_settings'] );
};

$plugin['preview_filter'] = function ( $plugin ) {
  return new GreenerWP\Images\PreviewFilter(
		$plugin['template_renderer']
	);
};