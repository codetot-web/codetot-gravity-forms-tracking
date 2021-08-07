<?php

/**
 * @link              https://codetot.com
 * @since             1.0.0
 * @package           Codetot_Base
 *
 * @wordpress-plugin
 * Plugin Name:       Code Tot - Gravity Forms Tracking
 * Plugin URI:        https://github.com/codetot-web/codetot-gravity-forms-tracking
 * Description:       Integrate tracking source, size and campaign for your forms.
 * Version:           1.0.10
 * Author:            CODE TOT JSC
 * Author URI:        https://codetot.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ct-gf-tracking
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'CODETOT_GF_TRACKING_VERSION', '1.0.10' );
define( 'CODETOT_GF_TRACKING_PLUGIN_SLUG', 'ct-gf-tracking' );
define( 'CODETOT_GF_TRACKING_PLUGIN_NAME', esc_html_x('CT GF Tracking', 'plugin name', 'ct-gf-tracking'));
define( 'CODETOT_GF_TRACKING_DIR', plugin_dir_path(__FILE__));
define( 'CODETOT_GF_TRACKING_AUTHOR', 'Code Tot JSC' );
define( 'CODETOT_GF_TRACKING_AUTHOR_URI', 'https://codetot.com');
define( 'CODETOT_GF_TRACKING_PLUGIN_URI', plugins_url('ct-gf-tracking'));

require_once CODETOT_GF_TRACKING_DIR . 'includes/init.php';

new Codetot_Gravity_Forms_Tracking_Init();
