<?php

$plugin['ui_admin_dashboard_link'] = function ( $plugin ) {
  return new LTWP\UI\Admin\DashboardLink(
		$plugin['basename']
	);
};

$plugin['ui_admin_page'] = function ( $plugin ) {
  return new LTWP\UI\Admin\Page(
    $plugin[ 'frontend' ],
    $plugin[ 'template_renderer' ]
  );
};

$plugin['ui_admin_recipes'] = function ( $plugin ) {
  return new LTWP\UI\Admin\Recipes(
    $plugin[ 'frontend' ],
    $plugin[ 'template_renderer' ]
  );
};

$plugin['ui_admin_recipes_controller'] = function ( $plugin ) {
  return new LTWP\UI\Admin\RecipesController(
  );
};

$plugin['ui_admin_settings'] = function ( $plugin ) {
  return new LTWP\UI\Admin\Settings(
    $plugin[ 'frontend' ],
    $plugin[ 'template_renderer' ]
  );
};

$plugin['ui_admin_settings_controller'] = function ( $plugin ) {
  return new LTWP\UI\Admin\SettingsController(
  );
};
