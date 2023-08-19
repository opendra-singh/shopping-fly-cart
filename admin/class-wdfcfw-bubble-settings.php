<?php

/**
 * Bubble Settings
 * Php version 7.4
 * 
 * @package  Wdfcfw
 * @link     https://woodevz.com/
 */

/**
 * Bubble Settings
 * Php version 7.4
 * 
 * @package  Wdfcfw
 * @link     https://woodevz.com/
 */


class Wdfcfw_Admin_Bubble_Settings {

	public $plugin_name;
	public $settings = array();
	public $active_tab;
	public $this_tab = 'bubble';
	public $tab_name = 'Bubble Settings';
	public $setting_key = 'wdfcfw_bubble_settings';
	public $get_data = array();

	/**
	 * Contructor of class
	 * 
	 * @param string $plugin_name The name of this plugin.
	 * 
	 * @return void
	 */
	public function __construct( $plugin_name) {
		$this->plugin_name = $plugin_name;
		$this->get_data = get_option('wdfcfw_bubble_settings', array());
		$this->settings = array(
			array(
				'field' => 'wdfcfw_enable_bubble',
				'class' => 'wdfcfw_admin_bubble_settings',
				'label' => esc_html__('Enable Bubble', 'wdfcfw-enable-bubble'),
				'type' => 'switch',
				'default' => 'true' == $this->get_data['wdfcfw_enable_bubble'] ? true : false,
				'desc' => esc_html('wdfcfw-enable-bubble')
			),
			array(
				'field' => 'wdfcfw_bubble_position',
				'class' => 'wdfcfw_admin_bubble_settings',
				'label' => esc_html__('Bubble Position', 'wdfcfw-bubble-position'),
				'type' => 'select',
				'value' => array(),
				'desc' => esc_html('wdfcfw-bubble-position')
			),
			array(
				'field' => 'wdfcfw_bubble_icon',
				'class' => 'wdfcfw_admin_bubble_settings',
				'label' => esc_html__('Bubble Icon', 'wdfcfw-bubble-icon'),
				'type' => 'select',
				'value' => array(),
				'desc' => esc_html('wdfcfw-bubble-icon')
			),
			array(
				'field' => 'wdfcfw_hide_if_empty',
				'class' => 'wdfcfw_admin_bubble_settings',
				'label' => esc_html__('Hide if empty', 'wdfcfw-hide-if-empty'),
				'type' => 'switch',
				'default' => 'true' == $this->get_data['wdfcfw_hide_if_empty'] ? true : false,
				'desc' => __('Hide the bubble if the cart is empty?', 'wdfcfw-hide-if-empty')
			),
			array(
				'field' => 'wdfcfw_cart_heading',
				'class' => 'wdfcfw_admin_bubble_settings',
				'label' => esc_html__('Cart Heading', 'wdfcfw-cart-heading'),
				'type' => 'text',
				'default' => !empty($this->get_data['wdfcfw_cart_heading']) ? $this->get_data['wdfcfw_cart_heading'] : get_bloginfo(),
				'desc' => __('FLy Cart Heading', 'wdfcfw-cart-heading')
			),
		);
		switch ($this->get_data['wdfcfw_bubble_position']) {
			case 'top-left':
				$this->settings[1]['value'] = array(
				'top-left' => 'Top Left',
				'bottom-left' => 'Bottom Left',
				'top-right' => 'Top Right',
				'bottom-right' => 'Bottom Right',
				);
				break;
			case 'bottom-left':
				$this->settings[1]['value'] = array(
				'bottom-left' => 'Bottom Left',
				'top-left' => 'Top Left',
				'top-right' => 'Top Right',
				'bottom-right' => 'Bottom Right',
				);
				break;
			case 'top-right':
				$this->settings[1]['value'] = array(
				'top-right' => 'Top Right',
				'top-left' => 'Top Left',
				'bottom-left' => 'Bottom Left',
				'bottom-right' => 'Bottom Right',
				);
				break;
			case 'bottom-right':
				$this->settings[1]['value'] = array(
				'bottom-right' => 'Bottom Right',
				'top-left' => 'Top Left',
				'bottom-left' => 'Bottom Left',
				'top-right' => 'Top Right',
				);
				break;
			default:
				$this->settings[1]['value'] = array(
				'top-left' => 'Top Left',
				'bottom-left' => 'Bottom Left',
				'top-right' => 'Top Right',
				'bottom-right' => 'Bottom Right',
				);              
				break;
		}
		for ($i = 1; $i <= 15; $i++) {
			$this->settings[2]['value'][$this->get_data['wdfcfw_bubble_icon']] = $this->get_data['wdfcfw_bubble_icon'];
			if ('woofc-icon-cart' == $this->get_data['wdfcfw_bubble_icon'] . $i) {
				continue;
			} else {
				$this->settings[2]['value']['woofc-icon-cart' . $i] = 'woofc-icon-cart' . $i;
			}
		}
		add_action($this->plugin_name . '_tab', array($this, 'tab'), 5);
		$this->registerSettings();
		if (WOODEVZ_FLY_CART_FOR_WOOCOMMERCE_DELETE_SETTING) {
			$this->deleteSettings();
		}
	}

	/**
	 * Delete Settings is used to delete the setting feild
	 * 
	 * @return void
	 */
	public function deleteSettings() {
		foreach ($this->settings as $setting) {
			delete_option($setting['field']);
		}
	}

	/**
	 * Register Settings is used to register each setting feild
	 * 
	 * @return void
	 */
	public function registerSettings() {
		foreach ($this->settings as $setting) {
			register_setting($this->setting_key, $setting['field']);
		}
	}

	/**
	 * It is showing the side menu
	 * 
	 * @return void
	 */
	public function tab() {
		?>
		<a class="  wdfcfw-side-menu  <?php echo esc_html( $this->active_tab == $this->this_tab ? 'bg-primary' : 'bg-secondary' ); ?>" href="<?php echo esc_url(admin_url('admin.php?page=' . sanitize_text_field(isset($_GET['page']) ? $_GET['page'] : '') . '&tab=' . $this->this_tab)); ?>">
			<span class="dashicons dashicons-dashboard"></span> <?php esc_html($this->tab_name); ?>
		</a>
		<?php
	}

	/**
	 * It is showing the tab content
	 * 
	 * @return void
	 */
	public function tabContent() {
		ob_start();
		?>
		<form method="POST" class="wdfcfw-bubble-setting-form" enctype=multipart/form-data>
			<?php settings_fields($this->setting_key); ?>
			<div class="row">
				<div class="col-12 card-inner">
					<div class="preview-block">
						<div id="<?php echo esc_html($this->setting_key); ?>">
							<?php
							foreach ($this->settings as $setting) {
								new Wdfcfw_Admin_Core_Elements($setting, $this->setting_key);
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<button type="button" id="bubble_settings_btn" class="btn btn-round btn-primary wdfcfw-admin-form-btn" option-key="<?php echo esc_html($this->setting_key); ?>" data-class="wdfcfw_admin_bubble_settings">
				Save
				&nbsp;
				<em class="icon ni ni-arrow-right"></em>
			</button>
			<div style="display:none;" class="wdfyfw_loading">
				&#8230;
			</div>
		</form>
		<?php
		$bubble_settings = ob_get_contents();
		ob_clean();
		return $bubble_settings;
	}
}
?>
