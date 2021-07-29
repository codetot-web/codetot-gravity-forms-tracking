<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Codetot_Gravity_Forms_Tracking_Init {
  public function __construct()
  {
    $this->load_dependencies();

    add_action('gform_loaded', array($this, 'load_gf_dependencies'), 10);
  }

  public function load_dependencies() {
    require_once CODETOT_GF_TRACKING_DIR . 'includes/class-cookies.php';
  }

  public function load_gf_dependencies() {
    require_once CODETOT_GF_TRACKING_DIR . 'includes/class-ct-gf-tracking.php';
  }
}
