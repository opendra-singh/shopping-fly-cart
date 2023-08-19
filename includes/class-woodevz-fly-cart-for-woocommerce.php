<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @package    Woodevz_Fly_Cart_For_Woocommerce
 * @subpackage Wdfcfw/admin
 * 
 * @version CVS:  <1.0.0>
 * @link    https://woodevz.com
 * @since   1.0.0
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @package    Woodevz_Fly_Cart_For_Woocommerce
 * @subpackage Wdfcfw/admin
 * 
 * @version Release:  <1.0.0>
 * @link    https://woodevz.com
 * @since   1.0.0
 */
class Woodevz_Fly_Cart_For_Woocommerce {


	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since  1.0.0
	 * @var    Woodevz_Fly_Cart_For_Woocommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since  1.0.0
	 * @var    string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since  1.0.0
	 * @var    string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		if (defined('WOODEVZ_FLY_CART_FOR_WOOCOMMERCE_VERSION') ) {
			$this->version = WOODEVZ_FLY_CART_FOR_WOOCOMMERCE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'woodevz-fly-cart-for-woocommerce';

		$this->_loadDependencies();
		$this->_setLocale();
		$this->_defineAdminHooks();
		$this->_definePublicHooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woodevz_Fly_Cart_For_Woocommerce_Loader. Orchestrates the hooks of the plugin.
	 * - Woodevz_Fly_Cart_For_Woocommerce_i18n. Defines internationalization functionality.
	 * - Woodevz_Fly_Cart_For_Woocommerce_Admin. Defines all hooks for the admin area.
	 * - Woodevz_Fly_Cart_For_Woocommerce_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since  1.0.0
	 * 
	 * @return void
	 */
	private function _loadDependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		include_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-woodevz-fly-cart-for-woocommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		include_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-woodevz-fly-cart-for-woocommerce-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		include_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-woodevz-fly-cart-for-woocommerce-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		include_once plugin_dir_path(dirname(__FILE__)) . 'public/class-woodevz-fly-cart-for-woocommerce-public.php';

		$this->loader = new Woodevz_Fly_Cart_For_Woocommerce_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woodevz_Fly_Cart_For_Woocommerce_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since  1.0.0
	 * 
	 * @return void
	 */
	private function _setLocale() {

		$plugin_i18n = new Woodevz_Fly_Cart_For_Woocommerce_I18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'loadPluginTextdomain');

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since  1.0.0
	 * 
	 * @return void
	 */
	private function _defineAdminHooks() {
		$plugin_admin = new Woodevz_Fly_Cart_For_Woocommerce_Admin($this->getPluginName(), $this->getVersion());
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueueStyles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueueScripts');
		$this->loader->add_action('wp_ajax_wdfcfwAdminFormSubmitAjax', $plugin_admin, 'wdfcfwAdminFormSubmitAjax');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since  1.0.0
	 * 
	 * @return void
	 */
	private function _definePublicHooks() {

		$plugin_public = new Woodevz_Fly_Cart_For_Woocommerce_Public($this->getPluginName(), $this->getVersion());

		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueueStyles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueueScripts');
		$this->loader->add_action('wp_footer', $plugin_public, 'wdfcfwFrontend');
		$this->loader->add_action('wp_ajax_increaseProductQtyAjax', $plugin_public, 'increaseProductQtyAjax');
		$this->loader->add_action('wp_ajax_removeProductAjaxCallback', $plugin_public, 'removeProductAjaxCallback');

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since  1.0.0
	 * @return string    The name of the plugin.
	 */
	public function getPluginName() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since  1.0.0
	 * @return Woodevz_Fly_Cart_For_Woocommerce_Loader    Orchestrates the hooks of the plugin.
	 */
	public function getLoader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since  1.0.0
	 * @return string    The version number of the plugin.
	 */
	public function getVersion() {
		return $this->version;
	}

}
