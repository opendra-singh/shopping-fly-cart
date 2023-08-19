<?php

/**
 * Working with HTML Elements
 * Php version 8.2
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @package    wdfcfw
 * @subpackage wdfcfw/admin
 * 
 * @version CVS:  <1.0.0>
 * @link    https://woodevz.com/
 * @since   1.0.0
 */

defined('ABSPATH') || die('Sorry!, No script kiddies allowed!');

if (!class_exists('wdfcfw_Admin_Core_Elements')) :

	/**
	 * Admin core element class
	 * All the elements which are present on front coming from here only.
	 * 
	 * @package    wdfcfw
	 * @subpackage wdfcfw/admin
	 * 
	 * @version Release:  <1.0.0>
	 * @link    https://woodevz.com/
	 * @since   1.0.0
	 */
	class Wdfcfw_Admin_Core_Elements {

		public $setting;
		public $saved_value;
		public $allowed_tags;

		/**
		 * Initialize the class and set its properties.
		 *
		 * @param string $setting Setting of each element.
		 */
		public function __construct( $setting) {
			$this->setting = $setting;

			if (isset($this->setting['default'])) {
				$this->saved_value = get_option($this->setting['field'], $this->setting['default']);
			} else {
				$this->saved_value = get_option($this->setting['field']);
			}

			$allowed_atts = array( 
				'align'      => array( ),
				'class'      => array( ),
				'selected'   => array( ),
				'multiple'   => array( ),
				'checked'    => array( ),
				'type'       => array( ),
				'id'         => array( ),
				'dir'        => array( ),
				'lang'       => array( ),
				'style'      => array( ),
				'xml:lang'   => array( ),
				'src'        => array( ),
				'alt'        => array( ),
				'href'       => array( ),
				'rel'        => array( ),
				'rev'        => array( ),
				'target'     => array( ),
				'novalidate' => array( ),
				'type'       => array( ),
				'value'      => array( ),
				'name'       => array( ),
				'tabindex'   => array( ),
				'action'     => array( ),
				'method'     => array( ),
				'for'        => array( ),
				'width'      => array( ),
				'height'     => array( ),
				'data'       => array( ),
				'title'      => array( ),
				'min'        => array( ),
				'max'        => array( ),
				'step'        => array( ),
				'required'   => array( ),
				'readonly'   => array( ),
				'placeholder'   => array( ),
			);

			$this->allowed_tags['form']     = $allowed_atts;
			$this->allowed_tags['label']    = $allowed_atts;
			$this->allowed_tags['input']    = $allowed_atts;
			$this->allowed_tags['select']    = $allowed_atts;
			$this->allowed_tags['option']    = $allowed_atts;
			$this->allowed_tags['textarea'] = $allowed_atts;
			$this->allowed_tags['iframe']   = $allowed_atts;
			$this->allowed_tags['script']   = $allowed_atts;
			$this->allowed_tags['style']    = $allowed_atts;
			$this->allowed_tags['strong']   = $allowed_atts;
			$this->allowed_tags['small']    = $allowed_atts;
			$this->allowed_tags['table']    = $allowed_atts;
			$this->allowed_tags['span']     = $allowed_atts;
			$this->allowed_tags['abbr']     = $allowed_atts;
			$this->allowed_tags['code']     = $allowed_atts;
			$this->allowed_tags['pre']      = $allowed_atts;
			$this->allowed_tags['div']      = $allowed_atts;
			$this->allowed_tags['img']      = $allowed_atts;
			$this->allowed_tags['h1']       = $allowed_atts;
			$this->allowed_tags['h2']       = $allowed_atts;
			$this->allowed_tags['h3']       = $allowed_atts;
			$this->allowed_tags['h4']       = $allowed_atts;
			$this->allowed_tags['h5']       = $allowed_atts;
			$this->allowed_tags['h6']       = $allowed_atts;
			$this->allowed_tags['ol']       = $allowed_atts;
			$this->allowed_tags['ul']       = $allowed_atts;
			$this->allowed_tags['li']       = $allowed_atts;
			$this->allowed_tags['em']       = $allowed_atts;
			$this->allowed_tags['hr']       = $allowed_atts;
			$this->allowed_tags['br']       = $allowed_atts;
			$this->allowed_tags['tr']       = $allowed_atts;
			$this->allowed_tags['td']       = $allowed_atts;
			$this->allowed_tags['p']        = $allowed_atts;
			$this->allowed_tags['a']        = $allowed_atts;
			$this->allowed_tags['b']        = $allowed_atts;
			$this->allowed_tags['i']        = $allowed_atts;
			$this->wdfcfwAdminCheckFieldType();
		}

		/**
		 * Check wheter feild is of which type.
		 * 
		 * @return function_call
		 */
		public function wdfcfwAdminCheckFieldType() {
			if (isset($this->setting['type'])) :
				switch ( $this->setting['type']) {
					case 'select':
						$this->selectBox();
						break;

					case 'search':
						$this->searchBox();
						break;

					case 'number':
						$this->numberBox();
						break;

					case 'text':
						$this->textBox();
						break;

					case 'textarea':
						$this->textareaBox();
						break;

					case 'multiselect':
						$this->multiselectBox();
						break;

					case 'color':
						$this->colorBox();
						break;

					case 'hidden':
						$this->hiddenBox();
						break;

					case 'switch':
						$this->switchDisplay();
						break;

					case 'checkbox':
						$this->checkBox();
						break;

					case 'image':
						$this->image();
						break;

					case 'accordion':
						$this->accordion();
						break;
				}
			endif;
		}

		/**
		 * Give the outer div with style to each element.
		 * 
		 * @param string $label     Label of the feild
		 * @param string $field     Name of the feild
		 * @param string $desc      Description of the feild
		 * @param string $links     Links of the feild
		 * @param string $title_col Column Number of Title of the feild
		 * 
		 * @return function_call
		 */
		public function bootstrap( $label, $field, $desc = '', $links = '', $title_col = 5) {
			$setting_col = 12 - $title_col;
			if ('accordion' == $this->setting['type']) {
				?>
				<br>
				<div style="margin-left: -35px;" id="<?php echo esc_attr($this->setting['id']); ?>_outer" class="accordion">
					<div class="accordion-item bg-gray-300">
						<a href="#" class="accordion-head collapsed" aria-expanded="false" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_html($this->setting['id']); ?>">
							<h6 class="title"><?php echo esc_html($this->setting['heading']); ?></h6>
							<span class="accordion-icon"></span>
						</a>
						<?php
						if (is_array($this->setting)) {
							foreach ($this->setting['data'] as $key => $value) {
								?>
								<div class="accordion-body bg-gray-100 collapse" id="<?php echo esc_attr($this->setting['id']); ?>" data-bs-parent="#<?php echo esc_html($this->setting['id']); ?>_outer">
									<div class="accordion-inner">
										<div class="row" id="row_<?php echo esc_html($value['field']); ?>">
											<div class="col-12 col-md-6">
												<label class="h6 mb-0" for="<?php echo esc_attr($value['field']); ?>">
													<?php echo esc_html($value['label']); ?>
												</label>
												<br>
												<small><?php echo esc_html($value['desc']); ?></small>
											</div>
											<div class="col-12 col-md-6">
												<?php
												if ('select' == $value['type']) {
													?>
													<select class="form-control accordion-select <?php echo esc_html($value['class']); ?>" name="<?php echo esc_attr($value['field']); ?>" id="<?php echo esc_attr($value['field']); ?>">
														<?php
														foreach ( $value['value'] as $k => $v) {
															?>
															<option value="<?php echo esc_attr($k); ?>">
																<?php echo esc_html($v); ?>
															</option>
															<?php
														}
														?>
													</select>
													<?php
												} else if ('number' == $value['type']) {
													?>
													<input class="accordion-number <?php echo esc_html($value['class']); ?>" type="number" name="<?php echo esc_attr($value['field']); ?>" id="<?php echo esc_attr($value['field']); ?>" value="<?php echo esc_attr($value['default']); ?>">
													<?php
												} else if ('text' == $value['type']) {
													?>
													<input class="form-control accordion-text <?php echo esc_html($value['class']); ?>" type="text" name="<?php echo esc_attr($value['field']); ?>" id="<?php echo esc_attr($value['field']); ?>" value="<?php echo esc_attr($value['default']); ?>">
													<?php
												} else if ('search' == $value['type']) {
													?>
													<input class="accordion-search form-control <?php echo esc_attr($value['class']); ?>" type="search" name="<?php echo esc_attr($value['field']); ?>" id="<?php echo esc_attr($value['field']); ?>" value="<?php echo esc_attr($value['value']); ?>" placeholder="Please enter 4 or more characters.">
													<img class="wdfcfw-search-loader d-none" src="<?php echo esc_url(plugin_dir_url(__DIR__) . 'img/Loading_icon.gif'); ?>" alt=''>
													<?php
												} else if ('textarea' == $value['type']) {
													?>
													<textarea class="accordion-textarea <?php echo esc_html($value['class']); ?>" name="<?php echo esc_attr($value['field']); ?>" id="<?php echo esc_attr($value['field']); ?>" cols="30" rows="10"><?php echo esc_html($value['value']); ?></textarea>
													<?php
												} else if ('multiselect' == $value['type']) {
													?>
													<select class="form-control accordion-multiselect multiselect <?php echo esc_html($value['class']); ?>" name="<?php echo esc_attr($value['field']) . '[]'; ?>" id="<?php echo esc_attr($value['field']); ?>" multiple>
														<?php
														foreach ( $value['value'] as $k => $v) {
															$selected = '';
															if (str_contains($v, 'selected')) {
																$val = explode(', ', $v)[1];
																$selected = 'selected';
															} else {
																$val = $v;
															}
															?>
															<option <?php echo esc_html($selected); ?> value="<?php echo esc_attr($k); ?>"><?php echo esc_html($val); ?></option>
															<?php
														}
														?>
													</select>
													<?php
												} else if ('color' == $value['type']) {
													wp_enqueue_style('wp-color-picker');
													wp_enqueue_script('wp-color-picker');
													wp_add_inline_script( 
														'wp-color-picker',
														'
                                                    jQuery( document).ready( function( $) {
                                                        $( ".color-picker").wpColorPicker( );
                                                    });
                                                    '
													);
													?>
													<input class="<?php echo esc_attr($value['class']); ?>" type="color" name="<?php echo esc_attr($value['field']); ?>" id="<?php echo esc_attr($value['field']); ?>" value="<?php echo esc_attr($value['value']); ?>">
													<?php
												} else if ('switch' == $value['type']) {
													?>
													<div class="custom-control custom-switch">
														<input class="custom-control-input <?php echo esc_html($value['class']); ?>" type="checkbox" name="<?php echo esc_attr($value['field']); ?>" id="<?php echo esc_attr($value['field']); ?>" value="1" <?php echo  1 == esc_html($value['default']) ? 'checked' : ''; ?>>
														<label class="custom-control-label" for="<?php echo esc_attr($value['field']); ?>"></label>
													</div>
													<?php
												} else if ('checkbox' == $value['type']) {
													?>
													<div class="custom-control custom-switch">
														<input class="<?php echo esc_attr($value['class']); ?>" type="checkbox" name="<?php echo esc_attr($value['field']); ?>" id="
														<?php echo esc_html($value['field']); ?>" 
														<?php 
														echo     esc_html($value['default']) == 1 ? 'checked' : '';
														?>
														>
													</div>
													<?php
												} else if ('image' == $value['type']) {
													wp_enqueue_media();
													?>
													<input type="hidden" name="wdfcfw_remove_image_default_value" class="wdfcfw_remove_image_default_value" value="<?php echo esc_attr(plugin_dir_url(__DIR__) . 'img/default-upload-image.jpg'); ?>">
													<img style="border:2px solid #ababab; margin-bottom:10%; width:25%;" height="100" id="<?php echo esc_attr($value['field']); ?>" src="<?php echo esc_url($value['value']); ?>" alt="<?php echo esc_attr(plugin_dir_url(__DIR__) . 'img/default-upload-image.jpg'); ?>">
													<a class="wdfcfw_remove_image" href="#"><small>Remove</small></a>
													<br>
													<input class="form-control btn-lg wdfcfw_admin_accordion_img_btn <?php echo esc_html($value['class']); ?>" id="<?php echo esc_attr($value['field']); ?>" name="<?php echo esc_attr($value['field']); ?>" style="width: 100px;" type="button" value="Upload">
													<?php
												} else if ('audio' == $value['type']) {
													wp_enqueue_media();
													?>
													<div class="wdfcfw_audio_div">
														<audio class="pb-3 wdfcfw_add_audio_file" controls>
															<source id="wdfcfw_add_audio_file_show" src="<?php echo esc_url($value['value']); ?>" type="audio/mpeg">
														</audio>
														<input class="form-control btn-lg wdfcfw_admin_accordion_img_btn <?php echo esc_html($value['class']); ?>" id="<?php echo esc_attr($value['field']); ?>" name="<?php echo esc_attr($value['field']); ?>" style="width: 50%;" type="button" value="Upload">
													</div>
													<?php
												}
												?>
											</div>
										</div>
									</div>
								</div>
								<?php
							}
						}
						?>
					</div>
				</div>
				<br>
				<?php

			} else if ('hidden' != $this->setting['type']) {
				?>
				<div id="row_<?php echo esc_attr($this->setting['field']); ?>" class="row py-4 border-bottom align-items-center 
				<?php
				echo ( !empty($this->setting['class']) ? esc_attr($this->setting['class']) : '' ); 
				?>
				">
					<div class="col-12 col-md-<?php echo esc_attr($title_col); ?>">
						<?php echo wp_kses($label, $this->allowed_tags); ?>
						<?php echo wp_kses('' != $desc ? $desc . '<br>' : '', $this->allowed_tags); ?>
						<?php echo wp_kses('' != $links ? $links : '', $this->allowed_tags); ?>
					</div>
					<div class="col-12 col-md-<?php echo esc_attr($setting_col - 2); ?>">
						<?php echo wp_kses($field, $this->allowed_tags); ?>
					</div>
				</div>
				<?php
			} else {
				?>
				<div id="row_<?php echo esc_attr($this->setting['field']); ?>" class="row align-items-center">
					<div class="col-12 col-md-12">
						<?php echo wp_kses($field, $this->allowed_tags); ?>
					</div>
				</div>
				<?php
			}
		}

		/**
		 * Generate Links from the given setting
		 * 
		 * @param string $setting Get setting
		 * 
		 * @return void
		 */
		public function generateLinks( $setting) {
			if (!isset($setting['links']) || !is_array($setting['links']) || empty($setting['links'])) {
				return;
			}
			$html = '';
			$links = $setting['links'];
			if (is_array($links)) {
				foreach ( $links as $link) {
					$class = 'pi-' . $link['type'];
					$html .= '<a href="' . esc_url($link['url']) . '" class="' . esc_attr($class) . ' pi-info-links" target="_blank">' . esc_html($link['name']) . '</a> ';
				}
			}
			return $html;
		}
		/*
			Field type: select box
		*/

		/**
		 * Create Select Box
		 * 
		 * @return void
		 */
		public function selectBox() {
			$label = "<label class='h5 mb-0 " . esc_attr($this->setting['field']) . "' for='" . esc_attr($this->setting['field']) . "'>" . esc_html($this->setting['label']) . '</label>';
			$desc = isset($this->setting['desc']) ? '<br><small>' . wp_kses($this->setting['desc'], $this->allowed_tags) . '</small>' : '';

			$field = "
            <select class='form-control " . esc_attr($this->setting['class']) . "' name='" . esc_attr($this->setting['field']) . "'
            id='" . esc_attr($this->setting['field']) . "'
            " . ( isset($this->setting['multiple']) ? "multiple='" . esc_attr($this->setting['multiple']) . "'" : '' ) . '>';

			if (is_array($this->setting) ) {
				foreach ( $this->setting['value'] as $key => $value ) {
					$field .= "<option value='" . esc_attr($key) . "' 
                        " . ( ( $this->saved_value == $key ) ? 'selected="selected"' : '' ) . '>
                        ' . esc_html($value) . '</option>';
				}
			}
			$field .= '</select>';
			$links = $this->generateLinks($this->setting);
			$this->bootstrap($label, $field, $desc, $links, 7);
		}

		/*
			Field type: select box
		*/

		/**
		 * Create Multi Select Box
		 * 
		 * @return void
		 */
		public function multiselectBox() {
			$label = '<label class="h5 mb-0" for="' . esc_attr($this->setting['field']) . '">' . esc_html($this->setting['label']) . '</label>';
			$desc = ( ( isset($this->setting['desc']) ) ? '<br><small>' . wp_kses($this->setting['desc'], $this->allowed_tags) . '</small>' : '' );
			$field = '<select class="form-control non-accordion-multiselect multiselect ' . esc_attr($this->setting['class']) . '" name="' . esc_attr($this->setting['field']) . '[]" id="' . esc_attr($this->setting['field']) . '" multiple>';
			if (is_array($this->setting)) {
				foreach ( $this->setting['value'] as $key => $val) {
					if (str_contains($val, 'selected')) {
						$val = explode(', ', $val);
					}
					if (is_array($val)) {
						$field .= '<option value="' . esc_attr($key) . '" ' . $val[0] . '>' . esc_html($val[1]) . '</option>';
					} else {
						$field .= '<option value="' . esc_attr($key) . '">' . esc_html($val) . '</option></select>';
					}
				}
			}
			$links = $this->generateLinks($this->setting);
			$this->bootstrap($label, $field, $desc, $links, 5);
		}

		/*
			Field type: Number box
		*/

		/**
		 * Create Number Box
		 * 
		 * @return void
		 */
		public function numberBox() {
			$label = '<label class="h5 mb-0" for="' . esc_attr($this->setting['field']) . '">' . esc_html($this->setting['label']) . '</label>';
			$desc =  ( isset($this->setting['desc']) ) ? '<br><small>' . wp_kses($this->setting['desc'], $this->allowed_tags) . '</small>' : '';
			$field = '<input type="number" class="form-control ' . esc_attr($this->setting['class']) . '" name="' . esc_attr($this->setting['field']) . '" id="' . esc_attr($this->setting['field']) . '" value="' . esc_attr($this->saved_value) . '"'
				. ( isset($this->setting['min']) ? ' min="' . esc_attr($this->setting['min']) . '"' : '' )
				. ( isset($this->setting['max']) ? ' max="' . esc_attr($this->setting['max']) . '"' : '' )
				. ( isset($this->setting['step']) ? ' step="' . esc_attr($this->setting['step']) . '"' : '' )
				. ( isset($this->setting['required']) ? ' required="' . esc_attr($this->setting['required']) . '"' : '' )
				. ( isset($this->setting['readonly']) ? ' readonly="' . esc_attr($this->setting['readonly']) . '"' : '' )
				. '>';
			$links = $this->generateLinks($this->setting);
			$this->bootstrap($label, $field, $desc, $links, 7);
		}

		/*
			Field type: Text box
		*/

		/**
		 * Create Text Box
		 * 
		 * @return void
		 */
		public function textBox() {
			$label = '<label class="h5 mb-0" for="' . esc_attr($this->setting['field']) . '">' . esc_html($this->setting['label']) . '</label>';
			$desc =  ( isset($this->setting['desc']) ) ? '<br><small>' . wp_kses($this->setting['desc'], $this->allowed_tags) . '</small>' : '';
			$field = '<input type="text" class="non-accordion-text form-control ' . esc_attr($this->setting['class']) . '" name="' . esc_attr($this->setting['field']) . '" id="' . esc_attr($this->setting['field']) . '" value="' . esc_attr($this->saved_value) . '"'
				. ( isset($this->setting['required']) ? ' required="' . esc_attr($this->setting['required']) . '"' : '' )
				. ( isset($this->setting['readonly']) ? ' readonly="' . esc_attr($this->setting['readonly']) . '"' : '' )
				. '>';
			$links = $this->generateLinks($this->setting);
			$this->bootstrap($label, $field, $desc, $links, 5);
		}

		/*
		Textarea field
		*/

		/**
		 * Create Textarea
		 * 
		 * @return void
		 */
		public function textareaBox() {
			$label = '<label class="h5 mb-0" for="' . esc_attr($this->setting['field']) . '">' . esc_html($this->setting['label']) . '</label>';
			$desc =  ( isset($this->setting['desc']) ) ? '<br><small>' . wp_kses($this->setting['desc'], $this->allowed_tags) . '</small>' : '';
			$field = '<textarea class="form-control ' . esc_attr($this->setting['class']) . '" name="' . esc_attr($this->setting['field']) . '" id="' . esc_attr($this->setting['field']) . '"' . ( isset($this->setting['required']) ? ' required="' . esc_attr($this->setting['required']) . '"' : '' ) . ( isset($this->setting['readonly']) ? ' readonly="' . esc_attr($this->setting['readonly']) . '"' : '' ) . ' style="height:auto !important; min-height:200px;" type="text" >';
			$field .= esc_textarea($this->saved_value) . '</textarea>';

			$links = $this->generateLinks($this->setting);
			$this->bootstrap($label, $field, $desc, $links, 12);
		}

		/*
			Field type: color
		*/

		/**
		 * Create ColorBox
		 * 
		 * @return void
		 */
		public function colorBox() {
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_script('wp-color-picker');
			wp_add_inline_script( 
				'wp-color-picker',
				'
            jQuery( document).ready( function( $) {
                $( ".color-picker").wpColorPicker( );
            });
            '
			);

			$label = '<label class="h5 mb-0" for="' . esc_attr($this->setting['field']) . '">' . esc_html($this->setting['label']) . '</label>';
			$desc =  ( isset($this->setting['desc']) ) ? '<br><small>' . wp_kses($this->setting['desc'], $this->allowed_tags) . '</small>' : '';
			$field = '<input type="color" class=" ' . esc_attr($this->setting['class']) . '" name="' . esc_attr($this->setting['field']) . '" id="' . esc_attr($this->setting['field']) . '" value="' . esc_attr($this->saved_value) . '"'
				. ( isset($this->setting['required']) ? ' required="' . esc_attr($this->setting['required']) . '"' : '' )
				. ( isset($this->setting['readonly']) ? ' readonly="' . esc_attr($this->setting['readonly']) . '"' : '' )
				. '>';
			$links = $this->generateLinks($this->setting);
			$this->bootstrap($label, $field, $desc, $links, 6);
		}

		/**
		 * Create ColorBox
		 * 
		 * @return void
		 */
		public function hiddenBox() {
			$label =  '<label class="h5 mb-0" for="' . esc_attr($this->setting['field']) . '">' . esc_html($this->setting['label']) . '</label>';
			$desc =   ( isset($this->setting['desc']) ) ? '<br><small>' . wp_kses($this->setting['desc'], $this->allowed_tags) . '</small>' : '';
			$field = '<input type="hidden" class="pisol_select" name="' . esc_attr($this->setting['field']) . '" id="' . esc_attr($this->setting['field']) . '" value="' . esc_attr($this->saved_value) . '"'
				. ( isset($this->setting['required']) ? ' required="' . esc_attr($this->setting['required']) . '"' : '' )
				. ( isset($this->setting['readonly']) ? ' readonly="' . esc_attr($this->setting['readonly']) . '"' : '' )
				. '>';
			$links = $this->generateLinks($this->setting);
			$this->bootstrap($label, $field, $desc, $links, 0);
		}

		/*
			Field type: switch
		*/

		/**
		 * Create Switch Box
		 * 
		 * @return void
		 */
		public function switchDisplay() {
			$label = '<label class="h5 mb-0" for="' . esc_attr($this->setting['field']) . '">' . esc_html($this->setting['label']) . '</label>';
			$desc = ( isset($this->setting['desc']) ) ? '<br><small>' . wp_kses($this->setting['desc'], $this->allowed_tags) . '</small>' : '';

			$field = '<div class="custom-control custom-switch">
            <input type="checkbox" value="1" class="custom-control-input ' . esc_attr($this->setting['class']) . '" name="' . esc_attr($this->setting['field']) . '" id="' . esc_attr($this->setting['field']) . '" ' . ( ( $this->saved_value ) ? "checked='checked'" : '' ) . ' >
            <label class="custom-control-label" for="' . esc_attr($this->setting['field']) . '"></label>
            </div>';

			$links = $this->generateLinks($this->setting);
			$this->bootstrap($label, $field, $desc, $links, 6);
		}

		/*
			Field type: switch
		*/

		/**
		 * Create Search Box
		 * 
		 * @return void
		 */
		public function searchBox() {
			$label = '<label class="h5 mb-0" for="' . esc_attr($this->setting['field']) . '">' . esc_html($this->setting['label']) . '</label>';
			$desc =  ( isset($this->setting['desc']) ) ? '<br><small>' . wp_kses($this->setting['desc'], $this->allowed_tags) . '</small>' : '';

			$field = '<input type="search"
            class="non-accordion-search form-control ' . esc_attr($this->setting['class']) . '" 
            name="' . esc_attr($this->setting['field']) . '" 
            id="' . esc_attr($this->setting['field']) . '" 
            placeholder="' . esc_attr($this->setting['placeholder']) . '" 
            value="' . esc_attr($this->saved_value) . '"' .
			( isset($this->setting['required']) ? 'required' : '' ) .
			( isset($this->setting['readonly']) ? 'readonly' : '' ) . ' >
            <img width="30" class="wdfcfw-search-switch" src="' . plugin_dir_url(__DIR__) . 'img/switch.webp" alt=""><img class="wdfcfw-search-loader d-none" src="' . plugin_dir_url(__DIR__) . 'img/Loading_icon.gif" alt=""><select class="form-control  non-accordion-multiselect wdfcfw_admin_product_settings" name="' . esc_attr($this->setting['field']) . '_multiselect" id="' . esc_attr($this->setting['field']) . '_multiselect" multiple><option value="select">--Select--</option></select>';

			$links = $this->generateLinks($this->setting);
			$this->bootstrap($label, $field, $desc, $links, 5);
		}

		/**
		 * Create Check Box
		 * 
		 * @return void
		 */
		public function checkBox() {
			$label = '<label class="h5 mb-0" for="' . esc_attr($this->setting['field']) . '">' . esc_html($this->setting['label']) . '</label>';
			$desc = ( isset($this->setting['desc']) ) ? '<br><small>' . wp_kses($this->setting['desc'], $this->allowed_tags) . '</small>' : '';
			$field = '<div class="custom-control custom-checkbox"><input type="checkbox" value="1" class="custom-control-input ' . esc_attr($this->setting['class']) . '" name="' . esc_attr($this->setting['field']) . '" id="' . esc_attr($this->setting['field']) . '"' . ( ( $this->saved_value ) ? "checked='checked'" : '' ) . ' ><label class="custom-control-label" for="' . esc_attr($this->setting['field']) . '"></label></div>';
			$links = $this->generateLinks($this->setting);
			$this->bootstrap($label, $field, $desc, $links);
		}

		/**
		 * Create an Image Element
		 * 
		 * @return void
		 */
		public function image() {
			wp_enqueue_media();
			add_action('admin_footer', array( $this, 'mediaSelectorScripts'));

			$label = '<label class="h5 mb-0" for="' . esc_attr($this->setting['field']) . '">' . esc_html($this->setting['label']) . '</label>';
			$desc = ( isset($this->setting['desc']) ) ? '<br><small>' . wp_kses($this->setting['desc'], $this->allowed_tags) . '</small>' : '';
			$field = '
            <div class="row align-items-center">
            <div class="col-6">
            <input id="' . esc_attr($this->setting['field']) . '_button" type="button" class="button" value="' . esc_attr(__('Upload image', 'add-coupon-by-link-woocommerce')) . '" />
            <input type="hidden" name="' . esc_attr($this->setting['field']) . '" id="' . esc_attr($this->setting['field']) . '" value="' . esc_attr($this->saved_value) . '">
            </div>
            <div class="col-6">
            <div class="image-preview-wrapper">
            <img class="' . esc_attr($this->setting['class']) . '" id="' . esc_attr($this->setting['field']) . '_preview" ' . ( $this->saved_value > 0 ? 'src="' . wp_get_attachment_url(get_option($this->setting['field'])) . '"' : '' ) . ' width="100" height="100" style="max-height: 100px; width: 100px;">
            <a href="javascript:void( 0)" class="clear-image-' . esc_attr($this->setting['field']) . '">Clear</a>
            </div>
            </div>
            </div>
            ';

			$links = $this->generateLinks($this->setting);
			$this->bootstrap($label, $field, $desc, $links, 0);
		}

		/**
		 * Create an Accordion
		 * 
		 * @return void
		 */
		public function accordion() {
			$links = $this->generateLinks($this->setting);
			$this->bootstrap('', '', '', $links, 9);
		}

		/**
		 * Create a custom media uploader
		 * 
		 * @return void
		 */
		public function mediaSelectorScripts() {
			$my_saved_attachment_post_id = get_option($this->setting['field'], 0);
			?>
			<script type='text/javascript'>
				jQuery( document).ready( function( $) {
					// Uploading files
					var file_frame;
					var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
					var set_to_post_id = <?php echo esc_attr(0 == $my_saved_attachment_post_id || '' == $my_saved_attachment_post_id ? "''" : $my_saved_attachment_post_id); ?>; // Set this
					jQuery( '#<?php echo esc_attr($this->setting['field']); ?>_button').on( 'click', function( event) {
						event.preventDefault( );
						// If the media frame already exists, reopen it.
						if ( file_frame) {
							// Set the post ID to what we want
							file_frame.uploader.uploader.param( 'post_id', set_to_post_id);
							// Open frame
							file_frame.open( );
							return;
						} else {
							// Set the wp.media post id so the uploader grabs the ID we want when initialised
							wp.media.model.settings.post.id = set_to_post_id;
						}
						// Create the media frame.
						file_frame = wp.media.frames.file_frame = wp.media( {
							title: 'Select a image to upload',
							button: {
								text: 'Use this image',
							},
							multiple: false // Set to true to allow multiple files to be selected
						});
						// When an image is selected, run a callback.
						file_frame.on( 'select', function( ) {
							// We set multiple to false so only get one image from the uploader
							attachment = file_frame.state( ).get( 'selection').first( ).toJSON( );
							// Do something with attachment.id and/or attachment.url here
							$( '#<?php echo esc_attr($this->setting['field']); ?>_preview').attr( 'src', attachment.url).css( 'width', 'auto');
							$( '#<?php echo esc_attr($this->setting['field']); ?>').val( attachment.id);
							// Restore the main post ID
							wp.media.model.settings.post.id = wp_media_post_id;
						});
						// Finally, open the modal
						file_frame.open( );
					});
					// Restore the main ID when the add media button is pressed
					jQuery( 'a.add_media').on( 'click', function( ) {
						wp.media.model.settings.post.id = wp_media_post_id;
					});
					jQuery( 'a.clear-image-<?php echo esc_attr($this->setting['field']); ?>').on( 'click', function( ) {
						$( '#<?php echo esc_attr($this->setting['field']); ?>_preview').attr( "src", '');
						$( '#<?php echo esc_attr($this->setting['field']); ?>').val( '');
					});
				});
			</script>
			<?php
		}
	}

endif
?>
