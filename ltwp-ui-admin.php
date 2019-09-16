<?php

$plugin['ui_admin_page'] = function ( $plugin ) {
  return new LTWP\UI\Admin\Page(
    $plugin[ 'frontend' ],
    $plugin[ 'template_renderer' ]
  );
};
