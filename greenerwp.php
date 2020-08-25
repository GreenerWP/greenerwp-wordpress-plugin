<?php
/**
 * Plugin Name: GreenerWP
 * Plugin URI: https://greenerwp.net
 * Description: Assists you in creating environmentally sustainable WordPress websites.
 * Version: 0.2.3
 * Requires at least: 5.2.3
 * Requires PHP: 7.0
 * Author: Christian Neumann
 * Author URI: https://utopicode.de
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: greenerwp
 * Domain Path: /languages
 *
 *
 * GreenerWP is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * GreenerWP is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with GreenerWP. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */

/* require __DIR__ . '/vendor/autoload.php'; */


define( 'GREENERWP_VERSION', '0.2.3' );

spl_autoload_register( 'greenerwp_autoloader' );
function greenerwp_autoloader( $class_name ) {
  if ( false !== strpos( $class_name, 'GreenerWP\\' ) ) {
    $class_name = preg_replace( '/^GreenerWP\\\\/', '', $class_name );
		$classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
    $class_file = str_replace( '\\', DIRECTORY_SEPARATOR, $class_name ) . '.php';
    require_once $classes_dir . $class_file;
  }
}

function greenerwp( $module=null ) {
	global $greenerwp;
	if ( $module ) {
		return $greenerwp[ $module ];
	}
	return $greenerwp;
}

function greenerwp_init() {
  $plugin = new GreenerWP\Plugin();
  $plugin['path'] = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR;
  $plugin['url'] = plugin_dir_url( __FILE__ );
  $plugin['basename'] = plugin_basename( __FILE__ );

  require __DIR__ . '/greenerwp-base.php';
  require __DIR__ . '/greenerwp-analysis.php';
  require __DIR__ . '/greenerwp-profiling.php';
  require __DIR__ . '/greenerwp-tools.php';
  require __DIR__ . '/greenerwp-ui-admin.php';
  require __DIR__ . '/greenerwp-ui-frontend.php';

  $plugin->run();

	$upgrader = new GreenerWP\Upgrades\Upgrader();
	$upgrader->upgrade_if_needed();

  global $greenerwp;
  $greenerwp = $plugin;
}
add_action( 'plugins_loaded', 'greenerwp_init' );

function greenerwp_update_version() {
	update_option( 'greenerwp_version', GREENERWP_VERSION );
}

function greenerwp_activate() {
	greenerwp_update_version();
}
register_activation_hook( __FILE__, 'greenerwp_activate' );

/* register_activation_hook( __FILE__, 'greenerwp_activate' ); */
/* register_deactivation_hook( __FILE__, 'greenerwp_deactivate' ); */

function greenerwp_uninstall() {
	global $wpdb;

	// Delete all prefixed options
	$keys = $wpdb->get_col( "SELECT option_name FROM $wpdb->options WHERE option_name LIKE 'greenerwp_%'" );
	foreach ( $keys as $key ) {
		delete_option( $key );
	}

	// Drop all prefixed tables
	$keys = $wpdb->get_col( "SHOW TABLES LIKE '{$wpdb->base_prefix}greenerwp_%'" );
	foreach ( $keys as $key ) {
		$wpdb->query( "DROP TABLE `{$key}`" );
	}
}

register_uninstall_hook( __FILE__, 'greenerwp_uninstall' );