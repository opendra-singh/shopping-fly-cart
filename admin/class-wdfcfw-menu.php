<?php

/**
 * The admin-specific functionality of the plugin.
 * Php version 7.4
 * 
 * @package    Wdfcfw
 * @subpackage Wdfcfw/admin
 * 
 * @version CVS:  <1.0.0>
 * @link    https://woodevz.com/
 * @since   1.0.0
 */

defined('ABSPATH') || die('Sorry!, No script kiddies allowed!');

/**
 * This is a menu class in which all the settings are found
 * 
 * @package    Wdfcfw
 * @subpackage Wdfcfw/admin
 * 
 * @link    https://woodevz.com/
 */
class Wdfcfw_Admin_Menu {

	public $plugin_name;
	public $version;
	public $menu;

	/**
	 * Contructor of class
	 * 
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action('admin_menu', array($this, 'wdfcfwAdminPluginMenu'));
	}

	/**
	 * Admin Plugin Menu
	 * 
	 * @return void
	 */
	public function wdfcfwAdminPluginMenu() {
		$this->menu = add_menu_page(
			__(PLUGIN_NAME),
			__('WooDevz Fly Cart'),
			'manage_options',
			'wdfcfw',
			array($this, 'wdfcfwAdminMenuPage'),
			'//woodevz.com/wp-content/uploads/2023/01/woodevz_icon-20x20-1.png',
			6
		);
	}

	/**
	 * Admin Plugin Menu
	 * 
	 * @return void
	 */
	public function wdfcfwAdminMenuPage() {
		include plugin_dir_path(dirname(__FILE__)) . 'includes/includes.php';
		$general_settings = new Wdfcfw_Admin_General_Settings($this->plugin_name, $this->version);
		$general_settings_data = $general_settings->tabContent();
		$bubble_settings = new Wdfcfw_Admin_Bubble_Settings($this->plugin_name, $this->version);
		$bubble_settings_data = $bubble_settings->tabContent();
		$arr = array(
			array('active', '#wdfcfw_admin_bubble_settings', 'Bubble Settings', $bubble_settings_data),
			array('', '#wdfcfw_admin_general_settings', 'General Settings', $general_settings_data),
		);
		?>
			<div class="nk-header is-light nk-header-wrap p-3">
				<a href="<?php echo esc_url(WOODEVZ_FLY_CART_URL); ?>" target="_blank">
					<img height="50" src="<?php echo esc_url(WOODEVZ_FLY_CART_URL . 'wp-content/uploads/2023/01/cropped-Asset-16.png'); ?>" class="d-inline" alt="Logo">
					<h4 class="d-inline"><?php echo esc_html(PLUGIN_NAME); ?></h4>
				</a>
			</div>
			<div class="card-inner">
				<ul class="nav nav-tabs mt-n3">
					<?php
					foreach ($arr as $key => $value) {
						?>
						<li class="nav-item">
							<a class="nav-link wdfcfw-nav-link <?php echo esc_html($value[0]); ?>" id="<?php echo esc_html(ltrim($value[1], '#')) . '_nav_link'; ?>" data-bs-toggle="tab" href="<?php echo esc_html($value[1]); ?>">
								<?php
								echo esc_html($value[2]);
								?>
							</a>
						</li>
						<?php
					}
					?>
				</ul>
				<div class="tab-content">
					<?php
					foreach ($arr as $k => $v) {
						?>
						<div class="tab-pane wdfcfw-tab-pane <?php echo esc_html($v[0]); ?>" id="<?php echo esc_html(ltrim($v[1], '#')); ?>">
							<?php print_r($v[3]); ?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		<?php
	}
}
?>
