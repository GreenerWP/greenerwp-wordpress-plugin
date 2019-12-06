<?php

namespace GreenerWP\UI\Frontend;

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