<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https:/rightbuddy.pt/
 * @since             1.0.0
 * @package           Codigo_Envio_Simples
 *
 * @wordpress-plugin
 * Plugin Name:       Código de Envio Simples
 * Description:       Easily add the tracking code for your orders so your customers always know where their purchases are. Compatible with CTT, DPD, Nacex, GLS, DHL, UPS and Paack.
 * Version:           1.0.0
 * Author:            Rafa Pardal
 * Author URI:        https:/rightbuddy.pt/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       codigo-envio-woo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CODIGO_ENVIO_Simples_VERSION', '1.0.0' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cdes.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_codigo_envio_Simples() {

	$plugin = new CDES_Codigo_Envio_Simples();
	$plugin->run();

}
run_codigo_envio_Simples();
