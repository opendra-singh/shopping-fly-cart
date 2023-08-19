<?php

/**
 * Define the internationalization functionality
 * Php version 7.4
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @package    Woodevz_Fly_Cart_For_Woocommerce
 * @subpackage Wdfcfw/admin
 * 
 * @version CVS:  <1.0.0>
 * @link    https://woodevz.com
 * @since   1.0.0
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @package    Woodevz_Fly_Cart_For_Woocommerce
 * @subpackage Wdfcfw/admin
 * 
 * @version Release:  <1.0.0>
 * @link    https://woodevz.com
 * @since   1.0.0
 */
class Woodevz_Fly_Cart_For_Woocommerce_I18n {



	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function loadPluginTextdomain() {

		load_plugin_textdomain(
			'woodevz-fly-cart-for-woocommerce',
			false,
			dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
		);

	}
}
