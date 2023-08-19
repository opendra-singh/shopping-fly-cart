(function( $ ) {
	'use strict'

	/**
	 * All of the code for your public-facing JavaScript source
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
	 * })
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * })
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	const woofc_show_cart = () => {
		jQuery('body').addClass('woofc-show')
		jQuery(document.body).trigger('woofc_show_cart')
	}

	const woofc_hide_cart = () => {
		jQuery('body').removeClass('woofc-show woofc-show-checkout')
		jQuery(document.body).trigger('woofc_hide_cart')
	}

	const woofc_toggle_cart = () => {
		if (jQuery('body').hasClass('woofc-show')) {
			woofc_hide_cart()
		} else {
			woofc_show_cart()
		}
		jQuery(document.body).trigger('woofc_toggle_cart')
	}

	document.addEventListener("DOMContentLoaded", function () {

		// Count Button click event
		$(document).on('click touch', '.woofc-count', function (e) {
			e.preventDefault()
			woofc_toggle_cart()
		})
		// Close Button click event
		$(document).on('click touch', '.woofc-close', function () {
			woofc_hide_cart()
		})
		// Continue Shopping Button click event
		$(document).on('click touch', '.woofc-continue-url', function() {
			const url = $(this).attr('data-url')
			woofc_hide_cart()
			if (url !== '') {
			  window.location.href = url
			}
		})
		// Plus and minus button click event 
		$(document).on('click touch', '.woofc-item-qty-plus, .woofc-item-qty-minus', function() {
			$(document).find(".wdfyfw_loading").css({ "display": "block" })
			const element = $(this)
			const qty = element.siblings(".quantity").children(".woofc-qty").val()
			const key = element.parent(".woofc-item-qty-inner").parent(".woofc-item-qty").parent(".woofc-item-inner").parent().attr("data-key")
			const data = {
				action: "increaseProductQtyAjax",
				qty : qty,
				key : key
			}
			if (element.attr("class") == "woofc-item-qty-minus") {
				data['operator'] = '-'
			}else if (element.attr("class") == "woofc-item-qty-plus") {
				data['operator'] = '+'
			}
			jQuery.post(ajax_object.ajax_url, data, function (response) {
				if (data['operator'] == '+') {
					element.siblings(".quantity").children(".woofc-qty").val(parseInt(qty) + 1)
				} else {
					if (qty == 1) {
						element[0].parentElement.parentElement.parentElement.parentElement.remove()
					}else{
						element.siblings(".quantity").children(".woofc-qty").val(parseInt(qty) - 1)
					}
				}
				$(document).find(".wdfyfw_loading").css({ "display": "none" })
				const result = JSON.parse(response);
				const parser = new DOMParser();
				const total = parser.parseFromString(result.total, 'text/html');
				const sub_total = parser.parseFromString(result.sub_total, 'text/html');
				document.getElementById("woofc-total").firstElementChild.firstElementChild.textContent = total.querySelector(".woocommerce-Price-amount").firstElementChild.textContent
				document.getElementById("woofc-subtotal").firstElementChild.firstElementChild.textContent = sub_total.querySelector(".woocommerce-Price-amount").firstElementChild.textContent
				$.notify(result.message, "success")
				$(document).find(".notifyjs-corner").css({"z-index":"99999999999999"})
			})
		})
		// Remove Button click event
		$(document).on("click touch", '.woofc-item-remove i', function () {
			$(document).find(".wdfyfw_loading").css({ "display": "block" })
			const element = this
			const key = element.parentElement.parentElement.parentElement.parentElement.getAttribute("data-key")
			const data = {
				action: "removeProductAjaxCallback",
				key : key
			}
			jQuery.post(ajax_object.ajax_url, data, function (response) {
				element.parentElement.parentElement.parentElement.parentElement.remove()
				$(document).find(".wdfyfw_loading").css({ "display": "none" })
				const result = JSON.parse(response);
				const parser = new DOMParser();
				const total = parser.parseFromString(result.total, 'text/html');
				const sub_total = parser.parseFromString(result.sub_total, 'text/html');
				document.getElementById("woofc-total").firstElementChild.firstElementChild.textContent = total.querySelector(".woocommerce-Price-amount").firstElementChild.textContent
				document.getElementById("woofc-subtotal").firstElementChild.firstElementChild.textContent = sub_total.querySelector(".woocommerce-Price-amount").firstElementChild.textContent
				$.notify(result.message, "success")
				$(document).find(".notifyjs-corner").css({"z-index":"99999999999999"})
			})
		})
		// Add to Cart Button click event
		const add_to_cart = document.getElementsByClassName("add_to_cart_button")
		if (wdfcfw_open_to_ajax_add_to_cart == "true") {
			for (let i = 0; i < add_to_cart.length; i++) {
				add_to_cart[i].addEventListener("click", function (e) {
					e.preventDefault()
					woofc_show_cart();
				})
			}
		}
	})

})( jQuery )
