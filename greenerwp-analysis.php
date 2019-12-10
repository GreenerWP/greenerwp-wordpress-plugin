<?php

namespace GreenerWP\Analysis;

$plugin['analysis_caching'] = function ( $plugin ) {
  return new Caching();
};

$plugin['analysis_emojis'] = function ( $plugin ) {
  return new Emojis();
};

$plugin['analysis_hosting'] = function ( $plugin ) {
  return new Hosting();
};

$plugin['analysis_images'] = function ( $plugin ) {
  return new Images();
};

$plugin['analysis_web_fonts'] = function ( $plugin ) {
  return new WebFonts();
};

$plugin['analysis_checks'] = function ( $plugin ) {
	return [
		$plugin['analysis_caching'],
		$plugin['analysis_emojis'],
		$plugin['analysis_hosting'],
		$plugin['analysis_images'],
		$plugin['analysis_web_fonts'],
	];
};