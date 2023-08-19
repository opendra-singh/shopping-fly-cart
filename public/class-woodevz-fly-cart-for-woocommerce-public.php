<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Woodevz_Fly_Cart_For_Woocommerce
 * @subpackage Wdfcfw/admin
 * 
 * @version CVS:  <1.0.0>
 * @link    https://woodevz.com
 * @since   1.0.0
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woodevz_Fly_Cart_For_Woocommerce
 * @subpackage Wdfcfw/admin
 * 
 * @version Release:  <1.0.0>
 * @link    https://woodevz.com
 * @since   1.0.0
 */
class Woodevz_Fly_Cart_For_Woocommerce_Public {


	/**
	 * The ID of this plugin.
	 *
	 * @since  1.0.0
	 * @var    string    $_plugin_name    The ID of this plugin.
	 */
	private $_plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since  1.0.0
	 * @var    string    $_version    The current version of this plugin.
	 */
	private $_version;

	/**
	 * Initialize the class and set its properties.
	 * 
	 * @param string $_plugin_name The name of the plugin.
	 * @param string $_version     The version of this plugin.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function __construct( $_plugin_name, $_version) {

		$this->_plugin_name = $_plugin_name;
		$this->_version = $_version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function enqueueStyles() {

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

		wp_enqueue_style($this->_plugin_name, plugin_dir_url(__FILE__) . 'css/woodevz-fly-cart-for-woocommerce-public.css', array(), $this->_version, 'all');
		wp_enqueue_style('font-css', plugin_dir_url(__DIR__) . 'admin/css/fonts.css', array(), $this->_version, 'all');
		wp_enqueue_style('admin-css', plugin_dir_url(__DIR__) . 'admin/css/woodevz-fly-cart-for-woocommerce-admin.css', array(), $this->_version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function enqueueScripts() {

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

		wp_enqueue_script('wdfyfw-notify-js', plugin_dir_url(__FILE__) . 'js/notify.min.js', array('jquery'), $this->_version, false);
		wp_enqueue_script($this->_plugin_name, plugin_dir_url(__FILE__) . 'js/woodevz-fly-cart-for-woocommerce-public.js', array('jquery'), $this->_version, false);
		wp_localize_script(
			$this->_plugin_name,
			'ajax_object',
			array(
				'ajax_url' => admin_url('admin-ajax.php'),
			)
		);
	}

	/**
	 * Frontend code of the plugin
	 *
	 * @param string $data data to debug
	 * 
	 * @since  1.0.0
	 * @return void
	 */
	public function debug( $data) {
		echo '<pre>';
		print_r($data);
		die;
	}

	/**
	 * Product Quantity Ajax Callback
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function increaseProductQtyAjax() {
		global $woocommerce;
		wp_verify_nonce(wp_create_nonce(isset($_POST) ? $_POST : ''));
		$post = $_POST;
		wp_verify_nonce(wp_create_nonce(isset($post['key']) ? $post['key'] : ''));
		wp_verify_nonce(wp_create_nonce(isset($post['qty']) ? $post['qty'] : ''));
		wp_verify_nonce(wp_create_nonce(isset($post['operator']) ? $post['operator'] : ''));
		$key  = isset($post['key']) ? $post['key'] : '';
		$qty = isset($post['qty']) ? $post['qty'] : '';
		$operator = isset($post['operator']) ? $post['operator'] : '';
		if (is_object($woocommerce)) {
			$items = $woocommerce->cart->get_cart();
			$total = $woocommerce->cart->get_cart_total();
		}
		if (is_array($items)) {
			foreach ($items as $item => $values) {
				if ($item == $key) {
					if ('+' == $operator) {
						WC()->cart->set_quantity($item, $qty + 1);
					} else {
						WC()->cart->set_quantity($item, $qty - 1);    
					}
				}                    
			}
		}
		$sub_total = WC()->cart->get_cart_subtotal();
		echo wp_json_encode(
			array(
			'total' => $total,
			'sub_total' => $sub_total,
			'message' => 'Product Quantity Update Successfully!',)
		);
		exit();
	}

	/**
	 * Product Remove Ajax Callback
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function removeProductAjaxCallback() {
		global $woocommerce;
		if (is_object($woocommerce)) {
			$total = $woocommerce->cart->get_cart_total();
		}
		wp_verify_nonce(wp_create_nonce(isset($_POST) ? $_POST : ''));
		$post = $_POST;
		wp_verify_nonce(wp_create_nonce(isset($post['key']) ? $post['key'] : ''));
		$key  = isset($post['key']) ? $post['key'] : '';
		WC()->cart->remove_cart_item($key);
		$sub_total = WC()->cart->get_cart_subtotal();
		echo wp_json_encode(
			array(
			'total' => $total,
			'sub_total' => $sub_total,
			'message' => 'Product Removed Successfully!',)
		);
		exit();
	}

	/**
	 * Frontend code of the plugin
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function wdfcfwFrontend() {
		$wdfcfw_bubble_settings = get_option('wdfcfw_bubble_settings', array());
		$wdfcfw_general_settings = get_option('wdfcfw_general_settings', array());
		global $woocommerce;
		if (is_object($woocommerce)) {
			$items = $woocommerce->cart->get_cart();
		}
		$cart_items = array();
		if (is_array($items)) {
			foreach ($items as $item => $values) {
				$_product =  wc_get_product($values['data']->get_id());
				$price = get_post_meta($values['product_id'], '_price', true);
				$cart_items[] = array(
					'title' => $_product->get_title(),
					'quantity' => $values['quantity'],
					'price' => $price,
					'img_url' => wp_get_attachment_image_src(get_post_thumbnail_id($values['data']->get_id()))[0],
					'url' => get_permalink($values['data']->get_id()),
					'key' => $item,
				);
			}
		}
		switch ($wdfcfw_general_settings['wdfcfw_position']) {
			case 'left':
				$position = 2;
				break;
			case 'right':
				$position = 1;
				break;
			case 'top':
				$position = 3;
				break;
			case 'bottom':
				$position = 4;
				break;
			case 'center':
				$position = 5;
				break;
			default:
				$position = 5;
				break;
		}
		$color = !empty($wdfcfw_general_settings['wdfcfw_color']) ? $wdfcfw_general_settings['wdfcfw_color'] : '#659bf2';
		$background = '';
		switch ($wdfcfw_general_settings['wdfcfw_style']) {
			case 'color-background':
				$background = 'style="background: ' . $color . ';"';
				break;
			case 'white-background':
				$background = 'style="background: white;"';
				break;
			default:
				$background = 'style="background: #659bf2;"';
				break;
		}
		$cart = true;
		$checkout = true;
		switch ($wdfcfw_general_settings['wdfcfw_action_butttons']) {
			case 'cart&checkout':
				$cart = true;
				$checkout = true;
				break;
			case 'cart_only':
				$cart = true;
				$checkout = false;
				break;
			case 'checkout_only':
				$cart = false;
				$checkout = true;
				break;
			default:
				$cart = true;
				$checkout = true;
				break;
		}
		$count = WC()->cart->get_cart_contents_count();
		$sub_total = WC()->cart->get_cart_subtotal();
		$total = $woocommerce->cart->get_cart_total();
		?>
		<script>
			const wdfcfw_open_to_ajax_add_to_cart = <?php echo esc_html($wdfcfw_general_settings['wdfcfw_open_to_ajax_add_to_cart']); ?>;
		</script>
		<div style="display:block;" id="woofc-count" class="woofc-count woofc-count-<?php echo esc_html($wdfcfw_bubble_settings['wdfcfw_bubble_position']); ?> woofc-count-shake">
			<i class="<?php echo esc_attr($wdfcfw_bubble_settings['wdfcfw_bubble_icon']); ?>"></i>
			<span id="woofc-count-number" class="woofc-count-number"><?php echo esc_html($count); ?></span>
		</div>
		<div class="woofc-overlay"></div>
		<div id="woofc-area" class="woofc-area woofc-position-0<?php echo esc_attr($position); ?> woofc-effect-01 woofc-slide-yes woofc-style-01">
			<div <?php echo esc_html($background); ?> class="woofc-inner woofc-cart-area">
				<div style="display:none;" class="wdfyfw_loading">
					&#8230;
				</div>
				<div class="woofc-area-top">
					<span class="woofc-area-heading"> <?php echo esc_html(!empty($wdfcfw_bubble_settings['wdfcfw_cart_heading']) ? $wdfcfw_bubble_settings['wdfcfw_cart_heading'] : 'Shopping cart'); ?><span class="woofc-area-count"><?php echo esc_html($count); ?></span></span>
					<div style="display:<?php echo esc_attr('true' == $wdfcfw_general_settings['wdfcfw_close_button'] ? 'block' : 'none'); ?>;" class="woofc-close hint--left" aria-label="Close">
						<i class="woofc-icon-icon10"></i>
					</div>
				</div>
				<!-- woofc-area-top -->
				<div class="woofc-area-mid woofc-items ps-container ps-theme-wpc">
					<?php
					if (0 != $count) {
						foreach ($cart_items as $item) {
							?>
							<div class="woofc-item woofc-item-has-remove" data-name="<?php echo esc_attr($item['title']); ?>" data-key="<?php echo esc_attr($item['key']); ?>">
								<div class="woofc-item-inner">
									<div class="woofc-item-thumb">
										<a target="<?php echo esc_attr('true' == $wdfcfw_general_settings['wdfcfw_open_product_in_new_tab'] ? '_blank' : ''); ?>" href="<?php echo esc_url($item['url']); ?>"><img width="276" height="320" src="<?php echo esc_url($item['img_url']); ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" decoding="async" loading="lazy"></a></div><!-- /.woofc-item-thumb -->
									<div class="woofc-item-info">
										<span class="woofc-item-title"><a target="<?php echo esc_html('true' == $wdfcfw_general_settings['wdfcfw_open_product_in_new_tab'] ? '_blank' : ''); ?>" href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['title']); ?></a></span><!-- /.woofc-item-title -->
										<span style="display: <?php echo esc_attr('true' == $wdfcfw_general_settings['wdfcfw_item_price'] ? 'block' : 'none'); ?>;" class="woofc-item-price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">₹</span><?php echo esc_html($item['price'] . '.00'); ?></bdi></span></span></div><!-- /.woofc-item-info -->
									<div class="woofc-item-qty woofc-item-qty-plus-minus">
										<div class="woofc-item-qty-inner"><span class="woofc-item-qty-minus">-</span>
											<div class="quantity">
												<label class="screen-reader-text" for="quantity_<?php echo esc_attr($item['key']); ?>"><?php echo esc_html($item['title']); ?> quantity</label>
												<input type="number" id="quantity_<?php echo esc_attr($item['key']); ?>" class="input-text woofc-qty qty text" step="1" min="1" max="" name="woofc_qty_<?php echo esc_attr($item['key']); ?>" value="<?php echo esc_attr($item['quantity']); ?>" title="Qty" size="4" placeholder="" inputmode="numeric" autocomplete="off">
											</div>
											<span class="woofc-item-qty-plus">+</span>
										</div>
									</div>
									<!-- /.woofc-item-qty -->
									<span class="woofc-item-remove">
										<span style="<?php echo esc_attr('style="background: white;"' == $background ? 'color:black;' : ''); ?>" class="hint--left" aria-label="Remove">
											<i class="woofc-icon-icon10"></i>
										</span>
									</span>
								</div>
							</div>
							<?php
						}
					} else {
						?>
						<div class="woofc-no-item"><?php echo 'There are no products in the cart!'; ?></div>
						<div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
							<div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
						</div>
						<div class="ps-scrollbar-y-rail" style="top: 0px; right: 0px;">
							<div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div>
						</div>
						<?php
					}
					?>
				</div>
				<!-- woofc-area-mid -->
				<div class="woofc-area-bot">
					<div style="display: <?php echo 'true' == $wdfcfw_general_settings['wdfcfw_subtotal'] ? 'block' : 'none'; ?>" class="woofc-data">
						<div style="<?php echo 'style="background: white;"' == $background ? 'color:black;' : ''; ?>" class="woofc-data-left">Subtotal</div>
						<div id="woofc-subtotal" class="woofc-data-right">
							<span class="woocommerce-Price-amount amount">
								<bdi style="<?php echo 'style="background: white;"' == $background ? 'color:black;' : ''; ?>">
									<?php echo esc_sql($sub_total); ?>
								</bdi>
							</span>
						</div>
					</div>
					<div class="woofc-data">
						<div style="<?php echo 'style="background: white;"' == $background ? 'color:black;' : ''; ?>" class="woofc-data-left">Total</div>
						<div id="woofc-total" class="woofc-data-right">
							<span class="woocommerce-Price-amount amount">
								<bdi style="<?php echo 'style="background: white;"' == $background ? 'color:black;' : ''; ?>">
									<?php echo esc_sql($total); ?>
								</bdi>
							</span>
						</div>
					</div>
					<div class="woofc-action">
						<div class="woofc-action-inner">
							<div style="display: 
							<?php 
							echo $cart ? 'block' : 'none';
							echo 'style="background: white;"' == $background ? 'color:black;' : ''; 
							?>
							;" class="woofc-action-left"><a class="woofc-action-cart" href="<?php echo esc_url(wc_get_cart_url()); ?>">Cart</a></div>
							<div style="display: 
							<?php 
							echo $checkout ? 'block' : 'none';
							echo 'style="background: white;"' == $background ? 'color:black;' : ''; 
							?>
							;" class="woofc-action-right"><a class="woofc-action-checkout" href="<?php echo esc_url(wc_get_checkout_url()); ?>">Checkout</a></div>
						</div>
					</div>
					<div style="display: <?php echo esc_attr('true' == $wdfcfw_general_settings['wdfcfw_continue_shopping'] ? 'block' : 'none'); ?>" class="woofc-continue">
						<span style="<?php echo esc_attr('style="background: white;"' == $background ? 'color:black;' : ''); ?>" class="woofc-continue-url" data-url="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>">
							Continue shopping
						</span>
					</div>
				</div>
				<!-- woofc-area-bot -->
			</div>
		</div>
		<?php
		if ('false' == $wdfcfw_bubble_settings['wdfcfw_enable_bubble']) {
			?>
			<script>
				document.getElementById("woofc-count").style.display = "none";
			</script>
			<?php
		} else if ('true' == $wdfcfw_general_settings['wdfcfw_hide_on_cart_checkout'] && ( get_the_ID() == get_option('woocommerce_checkout_page_id') || get_the_ID() == get_option('woocommerce_cart_page_id') )) {
			?>
			<script>
				document.getElementById("woofc-count").style.display = "none";
			</script>
			<?php
		} else if ('true' == $wdfcfw_bubble_settings['wdfcfw_hide_if_empty'] && 0 == $count) {
			?>
			<script>
				document.getElementById("woofc-count").style.display = "none";
			</script>
			<?php
		}
	}
}
