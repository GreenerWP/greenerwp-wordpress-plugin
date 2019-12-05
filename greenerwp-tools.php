<?php

namespace GreenerWP\Tools;

$plugin['tools_resource_impact_calculator'] = function ( $plugin ) {
  return new ResourceImpactCalculator();
};