<?php

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
