<?php

namespace LTWP\Tools;

$plugin['tools_resource_impact_calculator'] = function ( $plugin ) {
  return new ResourceImpactCalculator();
};