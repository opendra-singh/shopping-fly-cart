<?php

/**
 * General Settings
 * Php version 7.4
 * 
 * @package  Wdfcfw
 * @link     https://woodevz.com/
 */

/**
 * General Settings
 * Php version 7.4
 * 
 * @package  Wdfcfw
 * @link     https://woodevz.com/
 */


class Wdfcfw_Admin_General_Settings {

	public $plugin_name;
	public $settings = array();
	public $active_tab;
	public $this_tab = 'general';
	public $tab_name = 'General Settings';
	public $setting_key = 'wdfcfw_general_settings';
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
		$this->get_data = get_option('wdfcfw_general_settings', array());
		$this->settings = array(
			array(
				'field'=> 'wdfcfw_open_to_ajax_add_to_cart',
				'class' => 'wdfcfw_admin_general_settings',
				'label'=> esc_html__('Open on AJAX add to cart', 'wdfcfw-open-to-ajax-add-to-cart'),
				'type'=>'switch',
				'default'=> 'true' == $this->get_data['wdfcfw_open_to_ajax_add_to_cart'] ? true : false,
				'desc'=> esc_html('The fly cart will be opened immediately after whenever click to AJAX Add to cart buttons?')
			),
			array(
				'field' => 'wdfcfw_position',
				'class' => 'wdfcfw_admin_general_settings',
				'label' => esc_html__('Position', 'wdfcfw-position'),
				'type' => 'select',
				'value' => array(
					'center' => 'Center',
					'right' => 'Right',
					'left' => 'Left',
					'top' => 'Top',
					'bottom' => 'Bottom',
				),
				'desc' => esc_html('wdfcfw-position')
			),
			array(
				'field' => 'wdfcfw_style',
				'class' => 'wdfcfw_admin_general_settings',
				'label' => esc_html__('Style', 'wdfcfw-style'),
				'type' => 'select',
				'value' => array(),
				'desc' => esc_html('wdfcfw-style')
			),
			array(
				'field' => 'wdfcfw_color',
				'class' => 'wdfcfw_admin_general_settings',
				'label' => esc_html__('Color', 'wdfcfw-color'),
				'type' => 'color',
				'default' => $this->get_data['wdfcfw_color'],
				'desc' => esc_html('wdfcfw-color')
			),
			array(
				'field' => 'wdfcfw_close_button',
				'class' => 'wdfcfw_admin_general_settings',
				'label' => esc_html__('Close Button', 'wdfcfw-close-button'),
				'type' => 'switch',
				'default' => 'true' == $this->get_data['wdfcfw_close_button'] ? true : false,
				'desc' => esc_html('Show/hide the close button.')
			),
			array(
				'field' => 'wdfcfw_open_product_in_new_tab',
				'class' => 'wdfcfw_admin_general_settings',
				'label' => esc_html__('Open Product in New Tab', 'wdfcfw-open-product-in-new-tab'),
				'type' => 'switch',
				'default' => 'true' == $this->get_data['wdfcfw_open_product_in_new_tab'] ? true : false,
				'desc' => esc_html('')
			),
			array(
				'field' => 'wdfcfw_item_price',
				'class' => 'wdfcfw_admin_general_settings',
				'label' => esc_html__('Item price', 'wdfcfw-item-price'),
				'type' => 'switch',
				'default' => 'true' == $this->get_data['wdfcfw_item_price'] ? true : false,
				'desc' => esc_html('Show/hide the item price under title.')
			),
			array(
				'field' => 'wdfcfw_subtotal',
				'class' => 'wdfcfw_admin_general_settings',
				'label' => esc_html__('Subtotal', 'wdfcfw-subtotal'),
				'type' => 'switch',
				'default' => 'true' == $this->get_data['wdfcfw_subtotal'] ? true : false,
				'desc' => esc_html('')
			),
			array(
				'field' => 'wdfcfw_action_butttons',
				'class' => 'wdfcfw_admin_general_settings',
				'label' => esc_html__('Action buttons', 'wdfcfw-action-butttons'),
				'type' => 'select',
				'value' => array(),
				'desc' => esc_html('')
			),
			array(
				'field' => 'wdfcfw_continue_shopping',
				'class' => 'wdfcfw_admin_general_settings',
				'label' => esc_html__('Continue shopping', 'wdfcfw-continue-shopping'),
				'type' => 'switch',
				'default' => 'true' == $this->get_data['wdfcfw_continue_shopping'] ? true : false,
				'desc' => esc_html('Show/hide the continue shopping button at the end of fly cart.')
			),
			array(
				'field' => 'wdfcfw_hide_on_cart_checkout',
				'class' => 'wdfcfw_admin_general_settings',
				'label' => esc_html__('Hide on Cart & Checkout', 'wdfcfw-hide-on-cart-checkout'),
				'type' => 'switch',
				'default' => 'true' == $this->get_data['wdfcfw_hide_on_cart_checkout'] ? true : false,
				'desc' => esc_html('Hide the fly cart on the Cart and Checkout page.')
			),
		);
		switch ($this->get_data['wdfcfw_position']) {
			case 'center':
				$this->settings[1]['value'] = array(
					'center' => 'Center',
					'right' => 'Right',
					'left' => 'Left',
					'top' => 'Top',
					'bottom' => 'Bottom',
				);            
				break;
			case 'right':
				$this->settings[1]['value'] = array(
					'right' => 'Right',
					'center' => 'Center',
					'left' => 'Left',
					'top' => 'Top',
					'bottom' => 'Bottom',
				);            
				break;
			case 'left':
				$this->settings[1]['value'] = array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right',
					'top' => 'Top',
					'bottom' => 'Bottom',
				);            
				break;
			case 'top':
				$this->settings[1]['value'] = array(
					'top' => 'Top',
					'center' => 'Center',
					'right' => 'Right',
					'left' => 'Left',
					'bottom' => 'Bottom',
				);            
				break;
			case 'bottom':
				$this->settings[1]['value'] = array(
					'bottom' => 'Bottom',
					'center' => 'Center',
					'right' => 'Right',
					'left' => 'Left',
					'top' => 'Top',
				);            
				break;
			default:
				$this->settings[1]['value'] = array(
				'center' => 'Center',
				'right' => 'Right',
				'left' => 'Left',
				'top' => 'Top',
				'bottom' => 'Bottom',
				);
				break;
		}
		switch ($this->get_data['wdfcfw_style']) {
			case 'color-background':
				$this->settings[2]['value'] = array(
				'color-background' => 'Color Background',
				'white-background' => 'White Background',
				);
				break;
			case 'white-background':
				$this->settings[2]['value'] = array(
				'white-background' => 'White Background',
				'color-background' => 'Color Background',
				);
				break;
			default:
				$this->settings[2]['value'] = array(
				'color-background' => 'Color Background',
				'white-background' => 'White Background',
				);
				break;
		}
		switch ($this->get_data['wdfcfw_action_butttons']) {
			case 'cart&checkout':
				$this->settings[8]['value'] = array(
				'cart&checkout' => 'Cart & Checkout',
				'cart_only' => 'Cart Only',
				'checkout_only' => 'Checkout Only',
				);
				break;
			case 'cart_only':
				$this->settings[8]['value'] = array(
				'cart_only' => 'Cart Only',
				'cart&checkout' => 'Cart & Checkout',
				'checkout_only' => 'Checkout Only',
				);
				break;
			case 'checkout_only':
				$this->settings[8]['value'] = array(
				'checkout_only' => 'Checkout Only',
				'cart&checkout' => 'Cart & Checkout',
				'cart_only' => 'Cart Only',
				);
				break;
			default:
				$this->settings[8]['value'] = array(
				'cart&checkout' => 'Cart & Checkout',
				'cart_only' => 'Cart Only',
				'checkout_only' => 'Checkout Only',
				);
				break;
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
			<form method="POST" class="wdfcfw-general-setting-form" enctype= multipart/form-data>
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
				<button type="button" id="general_settings_btn" class="btn btn-round btn-primary wdfcfw-admin-form-btn" option-key="<?php echo esc_html($this->setting_key); ?>" data-class="wdfcfw_admin_general_settings">
					Save
					&nbsp;
					<em class="icon ni ni-arrow-right"></em>
				</button>
					<div style="display:none;" class="wdfyfw_loading">
						&#8230;
					</div>
			</form>
		<?php
		$general_settings = ob_get_contents();
		ob_clean();
		return $general_settings;
	}
}
?>
