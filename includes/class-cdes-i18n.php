<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https:/rightbuddy.pt/
 * @since      1.0.0
 *
 * @package    Codigo_Envio_Simples
 * @subpackage Codigo_Envio_Simples/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Codigo_Envio_Simples
 * @subpackage Codigo_Envio_Simples/includes
 * @author     Rafa Pardal <eu@rafapardal.pt>
 */
class Codigo_Envio_Simples_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'codigo-envio-woocommerce',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
