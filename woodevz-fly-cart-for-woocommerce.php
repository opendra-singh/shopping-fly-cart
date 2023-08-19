<?php

/**
 * The plugin bootstrap file
 * Php version 8.2
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @package    Woodevz_Fly_Cart_For_Woocommerce
 * @subpackage Wdfcfw/admin
 * 
 * @version CVS:  <1.0.0>
 * @link    https://woodevz.com
 * @since   1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       WooDevz Shopping & Fly Cart For Woocommerce
 * Plugin URI:        https://woodevz.com
 * Description:       This is a WordPress plugin for showing a popup of shopping cart when a user clicks on a notification. It allow customers to quickly review their purchases and easily add or remove items from their cart. It features a customizable design, allowing you to choose the size, colors, and position of the popup. It also provides a convenient way to keep track of customers' shopping cart contents.
 * Version:           1.0.0
 * Author:            Shashwat Srivastava
 * Author URI:        https://woodevz.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woodevz-fly-cart-for-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC') ) {
	die;
}

// Making sure woocommerce is there 
require_once ABSPATH . 'wp-admin/includes/plugin.php';

if (!is_plugin_active('woocommerce/woocommerce.php')) {
	/**
	 * Check whether woocommerce is installed or not.
	 * 
	 * @return void
	 */
	function wdfcfwAdminCheckWoocommerce() {
		?>
		<div class="error notice">
			<p><?php echo esc_sql( ' Installation Error:- Please Install and Activate WooCommerce plugin. To get WooCommerce <a href="https://wordpress.org/plugins/woocommerce/" target="_blank">click here</a>.', 'woodevz-fly-cart-for-woocommerce' ); ?></p>
		</div>
		<?php
		unset($_GET['activate']);
	}
	add_action('admin_notices', 'wdfcfwAdminCheckWoocommerce');
	deactivate_plugins(plugin_basename(__FILE__));
	return;
}



/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('WOODEVZ_FLY_CART_FOR_WOOCOMMERCE_VERSION', '1.0.0');
define('PLUGIN_NAME', 'WooDevz Shopping & Fly Cart For Woocommerce');
define('WOODEVZ_FLY_CART_URL', 'https://woodevz.com/');
define('WOODEVZ_FLY_CART_FOR_WOOCOMMERCE_DELETE_SETTING', false);

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woodevz-fly-cart-for-woocommerce-activator.php
 * 
 * @return void
 */
function Activate_Woodevz_Fly_Cart_For_woocommerce() {
	include_once plugin_dir_path(__FILE__) . 'includes/class-woodevz-fly-cart-for-woocommerce-activator.php';
	Woodevz_Fly_Cart_For_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woodevz-fly-cart-for-woocommerce-deactivator.php
 * 
 * @return void
 */
function Deactivate_Woodevz_Fly_Cart_For_woocommerce() {
	include_once plugin_dir_path(__FILE__) . 'includes/class-woodevz-fly-cart-for-woocommerce-deactivator.php';
	Woodevz_Fly_Cart_For_Woocommerce_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'Activate_Woodevz_Fly_Cart_For_woocommerce');
register_deactivation_hook(__FILE__, 'Deactivate_Woodevz_Fly_Cart_For_woocommerce');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-woodevz-fly-cart-for-woocommerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since  1.0.0
 * @return void
 */
function Run_Woodevz_Fly_Cart_For_woocommerce() {

	$plugin = new Woodevz_Fly_Cart_For_Woocommerce();
	$plugin->run();

}
Run_Woodevz_Fly_Cart_For_woocommerce();
