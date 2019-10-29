<?php

$plugin['ui_frontend_status_controller'] = function ( $plugin ) {
  return new LTWP\UI\Frontend\StatusController(
		$plugin['weather'],
		$plugin['profile_status'],
		$plugin['template_renderer'],
		$plugin['tools_resource_impact_calculator']
  );
};