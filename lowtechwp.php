<?php
/**
 * Plugin Name: LowTechWP
 * Plugin URI: https://lowtechwp.org
 * Description: Assists you in creating sustainable WordPress websites.
 * Version: 0.0.3
 * Requires at least: 5.2.3
 * Requires PHP: 7.0
 * Author: Christian Neumann
 * Author URI: https://utopicode.de
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ltwp
 * Domain Path: /languages
 *
 *
 * LowTechWP is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * LowTechWP is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with LowTechWP. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */

/* require __DIR__ . '/vendor/autoload.php'; */

spl_autoload_register( 'ltwp_autoloader' );
function ltwp_autoloader( $class_name ) {
  if ( false !== strpos( $class_name, 'LTWP\\' ) ) {
    $class_name = preg_replace( '/^LTWP\\\\/', '', $class_name );
		$classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
    $class_file = str_replace( '\\', DIRECTORY_SEPARATOR, $class_name ) . '.php';
    require_once $classes_dir . $class_file;
  }
}

function ltwp( $module=null ) {
	global $ltwp;
	if ( $module ) {
		return $ltwp[ $module ];
	}
	return $ltwp;
}

function ltwp_init() {
  $plugin = new LTWP\Plugin();
  $plugin['path'] = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR;
  $plugin['url'] = plugin_dir_url( __FILE__ );
  $plugin['basename'] = plugin_basename( __FILE__ );

  require __DIR__ . '/ltwp-base.php';
  require __DIR__ . '/ltwp-profile.php';
  require __DIR__ . '/ltwp-tools.php';
  require __DIR__ . '/ltwp-ui-admin.php';
  require __DIR__ . '/ltwp-ui-frontend.php';

  $plugin->run();

  global $ltwp;
  $ltwp = $plugin;
}
add_action( 'plugins_loaded', 'ltwp_init' );

/* register_activation_hook( __FILE__, 'ltwp_activate' ); */
/* register_deactivation_hook( __FILE__, 'ltwp_deactivate' ); */
/* register_uninstall_hook( __FILE__, 'ltwp_uninstall' ); */
