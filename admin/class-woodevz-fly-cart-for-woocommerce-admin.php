<?php

/**
 * The admin-specific functionality of the plugin.
 * Php version 7.4
 *
 * @package    Woodevz_Fly_Cart_For_Woocommerce
 * @subpackage Wdfcfw/admin
 * 
 * @version CVS:  <1.0.0>
 * @link    https://woodevz.com
 * @since   1.0.0
 */


/**
 * The admin-specific functionality of the plugin.
 * Php version 7.4
 *
 * @package    Woodevz_Fly_Cart_For_Woocommerce
 * @subpackage Wdfcfw/admin
 * 
 * @version Release:  <1.0.0>
 * @link    https://woodevz.com
 * @since   1.0.0
 */

class Woodevz_Fly_Cart_For_Woocommerce_Admin {


	/**
	 * The ID of this plugin.
	 *
	 * @since  1.0.0
	 * @var    string    $plugin_name    The ID of this plugin.
	 */
	private $_plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since  1.0.0
	 * @var    string    $version    The current version of this plugin.
	 */
	private $_version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version     The version of this plugin.
	 * 
	 * @since  1.0.0
	 * @return void
	 */
	public function __construct( $plugin_name, $version) {

		$this->_plugin_name = $plugin_name;
		$this->_version = $version;

		include 'class-wdfcfw-menu.php';

		new Wdfcfw_Admin_Menu($this->_plugin_name, $this->_version);

		// Redirecting to plugin page
		add_action('admin_init', array($this, 'pluginRedirect'));
	}

	/**
	 * Plugin_redirect is used to redirect the user on plugin page.
	 * 
	 * @return void
	 */
	public function pluginRedirect() {
		if (get_option('wdfcfw_activate_plugin_redirect', false)) {
			delete_option('wdfcfw_activate_plugin_redirect');
			if (!isset($_GET['activate-multi'])) {
				wp_redirect('admin.php?page=wdfcfw');
			}
		}
	}

	/**
	 * Register the stylesheets for the admin area.
	 * 
	 * @param string $page_id ID of Current page
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function enqueueStyles( $page_id) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woodevz_Fly_Cart_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woodevz_Fly_Cart_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ('toplevel_page_wdfcfw' == $page_id) {
			wp_enqueue_style('dashlab-css', 'https://woodevz.com/assets/woodevz.css', array(), $this->_version, 'all');
			wp_enqueue_style('font-css', plugin_dir_url(__FILE__) . 'css/fonts.css', array(), $this->_version, 'all');
			wp_enqueue_style('fonticonpicker-css', plugin_dir_url(__FILE__) . 'fonticonpicker/css/jquery.fonticonpicker.css', array(), $this->_version, 'all');
			wp_enqueue_style('fonticonpicker-min-css', plugin_dir_url(__FILE__) . 'fonticonpicker/css/jquery.fonticonpicker.min.css', array(), $this->_version, 'all');
			wp_enqueue_style($this->_plugin_name, plugin_dir_url(__FILE__) . 'css/woodevz-fly-cart-for-woocommerce-admin.css', array(), $this->_version, 'all');
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 * 
	 * @param string $page_id ID of Current page
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function enqueueScripts( $page_id) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woodevz_Fly_Cart_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woodevz_Fly_Cart_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ('toplevel_page_wdfcfw' == $page_id) {
			wp_enqueue_script('bundle-js', 'https://woodevz.com/assets/bundle.js', array('jquery'), $this->_version, false);
			wp_enqueue_script('fonticonpicker-js', plugin_dir_url(__FILE__) . 'fonticonpicker/js/jquery.fonticonpicker.js', array('jquery'), $this->_version, false);
			wp_enqueue_script('fonticonpicker-min-js', plugin_dir_url(__FILE__) . 'fonticonpicker/js/jquery.fonticonpicker.min.js', array('jquery'), $this->_version, false);
			wp_enqueue_script($this->_plugin_name, plugin_dir_url(__FILE__) . 'js/woodevz-fly-cart-for-woocommerce-admin.js', array('jquery'), $this->_version, false);
			wp_localize_script(
				$this->_plugin_name,
				'ajax_object',
				array(
					'ajax_url' => admin_url('admin-ajax.php'),
				)
			);
		}
	}

	/**
	 * Debug the input
	 * 
	 * @param string $data data to debug
	 * 
	 * @return void
	 */
	private function debug( $data) {
		echo '<pre>';
		print_r($data);
		die;
	}

	/**
	 * Admin Form Submit Ajax Callback
	 * 
	 * @return void
	 */
	public function wdfcfwAdminFormSubmitAjax() {
		wp_verify_nonce(wp_create_nonce(isset($_POST) ? $_POST : ''));
		$post = $_POST;
		wp_verify_nonce(wp_create_nonce(isset($post['key']) ? $post['key'] : ''));
		wp_verify_nonce(wp_create_nonce(isset($post['data']) ? $post['data'] : ''));
		$key  = isset($post['key']) ? $post['key'] : '';
		$data = isset($post['data']) ? $post['data'] : '';
		update_option($key, $data);
		echo 'Settings Saved Successfully!';
		exit();
	}

}
