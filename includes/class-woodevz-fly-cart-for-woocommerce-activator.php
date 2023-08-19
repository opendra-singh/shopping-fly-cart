<?php

/**
 * Fired during plugin activation
 *
 * @package    Woodevz_Fly_Cart_For_Woocommerce
 * @subpackage Wdfcfw/admin
 * 
 * @version CVS:  <1.0.0>
 * @link    https://woodevz.com
 * @since   1.0.0
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @package    Woodevz_Fly_Cart_For_Woocommerce
 * @subpackage Wdfcfw/admin
 * 
 * @version Release:  <1.0.0>
 * @link    https://woodevz.com
 * @since   1.0.0
 */
class Woodevz_Fly_Cart_For_Woocommerce_Activator {


	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public static function activate() {
		add_option('wdfcfw_activate_plugin_redirect', true);
		update_option('wdfcfw_bubble_settings', array(
			'wdfcfw_enable_bubble' => 'true',
			'wdfcfw_bubble_position' => 'bottom-left',
			'wdfcfw_bubble_icon' => 'woofc-icon-cart10',
			'wdfcfw_hide_if_empty' => 'false',
			'wdfcfw_cart_heading' => get_bloginfo(),
		));
		update_option('wdfcfw_general_settings', array(
			'wdfcfw_open_to_ajax_add_to_cart' => 'false',
			'wdfcfw_position' => 'right',
			'wdfcfw_style' => 'color-background',
			'wdfcfw_color' => '#0096e0',
			'wdfcfw_close_button' => 'true',
			'wdfcfw_open_product_in_new_tab' => 'true',
			'wdfcfw_item_price' => 'true',
			'wdfcfw_subtotal' => 'true',
			'wdfcfw_action_butttons' => 'cart&checkout',
			'wdfcfw_continue_shopping' => 'true',
			'wdfcfw_hide_on_cart_checkout' => 'false',
		));
	}

}
