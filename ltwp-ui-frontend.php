<?php

$plugin['ui_frontend_status_controller'] = function ( $plugin ) {
  return new LTWP\UI\Frontend\StatusController(
		$plugin['weather']
  );
};