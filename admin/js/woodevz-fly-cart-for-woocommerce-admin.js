(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	document.addEventListener("DOMContentLoaded", function () {
		$(document).find('#wdfcfw_bubble_icon').fontIconPicker();

		// Save btn click event
		$(document).find(".wdfcfw-admin-form-btn").each(function () {
			$(this).on('click', function (e) {
				$(document).find(".wdfyfw_loading").css({ "display": "block" });
				e.preventDefault();
				const form_data = {};
				const form_key = $(this).attr('option-key');
				const data_class = $(this).attr('data-class');
				$("." + data_class).each(function () {
					switch ($(this).attr('type')) {
						case 'number':
							form_data[$(this).attr("id")] = $(this).val();
							break;

						case 'text':
							form_data[$(this).attr("id")] = $(this).val();
							break;

						case 'color':
							form_data[$(this).attr('id')] = $(this).val();
							break;

						case 'checkbox':
							if ($(this).is(":checked")) {
								form_data[$(this).attr('id')] = true;
							}
							else {
								form_data[$(this).attr('id')] = false;
							}
							break;
					}
					if ($(this).is('select')) {
						if ($(this).attr('multiple') == false || $(this).attr('multiple') == undefined) {
							form_data[$(this).attr('id')] = $(this).children('option:selected').val();
						} else {
							const multi_select = [];
							$(this).children('option:selected').each(function () {
								multi_select.push($(this).val());
							});
							form_data[$(this).attr('id')] = multi_select;
						}
					}
					if ($(this).is('textarea')) {
						form_data[$(this).attr("id")] = $(this).val();
					}
				});
				const data = {
					'action': 'wdfcfwAdminFormSubmitAjax',
					'key': form_key,
					'data': form_data,
				}
				jQuery.post(ajax_object.ajax_url, data, function (response) {
					$(document).find(".wdfyfw_loading").css({ "display": "none" });
					alert(response);
					location.reload();
				});
			});
		});

	})

})( jQuery );
