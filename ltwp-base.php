<?php

/* $plugin['frontend_script'] = function( $plugin ) { */
/* return new LTWP\FrontendScripts( [ */
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

$plugin['template_renderer'] = function ( $plugin ) {
  return new LTWP\TemplateRenderer( $plugin['template_settings'] );
};
