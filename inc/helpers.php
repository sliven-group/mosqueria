<?php
function get_primary_product_category( $product_id ) {
	$terms = get_the_terms( $product_id, 'product_cat' );

	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		// Ordenar por jerarquía (la categoría con menor 'parent' es la principal)
		usort( $terms, function ( $a, $b ) {
			return $a->parent - $b->parent;
		});

		return $terms[0]; // Devuelve el objeto de la categoría principal
	}

	return null; // Si no hay categorías
}

if ( ! function_exists( 'custom_woocommerce_checkout_payment' ) ) {
	/**
	 * custom Output the Payment Methods on the checkout.
	 */
	function custom_woocommerce_checkout_payment() {
		if ( WC()->cart->needs_payment() ) {
			$available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
			WC()->payment_gateways()->set_current_gateway( $available_gateways );
		} else {
			$available_gateways = array();
		}
		wc_get_template(
			'checkout/custom-payment.php',
			array(
				'checkout'           => WC()->checkout(),
				'available_gateways' => $available_gateways,
				'order_button_text'  => apply_filters( 'woocommerce_order_button_text', __( 'Place order', 'woocommerce' ) ),
			)
		);
	}
}

if ( ! function_exists( 'validate_email_newsletter' ) ) {
	function validate_email_newsletter() {
		global $wpdb;
		$current_user = wp_get_current_user();
		$user_email = $current_user->user_email;
		$table = $wpdb->prefix . 'newsletter';
		$existing_email = $wpdb->get_var($wpdb->prepare("SELECT email FROM $table WHERE email = %s", $user_email));
		return $existing_email;
	}
}
