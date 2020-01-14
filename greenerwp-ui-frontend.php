<?php

namespace GreenerWP\UI\Frontend;

$plugin['ui_frontend_profiler_controller'] = function ( $plugin ) {
  return new ProfilerController();
};

$plugin['ui_frontend_status_controller'] = function ( $plugin ) {
  return new StatusController(
		$plugin['weather'],
		$plugin['profile_status'],
		$plugin['template_renderer'],
		$plugin['tools_resource_impact_calculator']
  );
};

$plugin['ui_frontend_tweaks_disable_web_fonts'] = function ( $plugin ) {
  return new Tweaks\DisableWebFonts();
};

$plugin['ui_frontend_tweaks_jpeg_quality'] = function ( $plugin ) {
  return new Tweaks\JPEGQuality();
};

$plugin['ui_frontend_tweaks_plugins_wpcf7'] = function ( $plugin ) {
  return new Tweaks\Plugins\WPCF7();
};