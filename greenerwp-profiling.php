<?php

namespace GreenerWP\Profiling;

$plugin['profiling_page_views'] = function ( $plugin ) {
	global $wpdb;
  return new PageViews( $wpdb );
};