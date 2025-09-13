<?php
// Acción AJAX para usuarios logueados y no logueados
add_action( 'wp_ajax_add_product_to_cart', 'add_product_to_cart_callback' );
add_action( 'wp_ajax_nopriv_add_product_to_cart', 'add_product_to_cart_callback' );

add_action( 'wp_ajax_add_product_to_quick_purchase', 'add_product_to_quick_purchase' );
add_action( 'wp_ajax_nopriv_add_product_to_quick_purchase', 'add_product_to_quick_purchase' );

add_action( 'wp_ajax_delete_product_to_cart', 'delete_product_to_cart_callback' );
add_action( 'wp_ajax_nopriv_delete_product_to_cart', 'delete_product_to_cart_callback' );

add_action( 'wp_ajax_set_cart_item_quantity', 'set_cart_item_quantity' );
add_action( 'wp_ajax_nopriv_set_cart_item_quantity', 'set_cart_item_quantity' );

add_action('wp_ajax_apply_coupon_ajax', 'apply_coupon_ajax');
add_action('wp_ajax_nopriv_apply_coupon_ajax', 'apply_coupon_ajax');

add_action('wp_ajax_remove_coupon_ajax', 'remove_coupon_ajax');
add_action('wp_ajax_nopriv_remove_coupon_ajax', 'remove_coupon_ajax');

function add_product_to_cart_callback() {
	// Verifica si el product_id está presente
	if ( isset( $_POST['product_id'] ) ) {
		$product_id = absint( $_POST['product_id'] );
		$variation_id = isset( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : 0;
		$quantity = isset( $_POST['quantity'] ) ? absint( $_POST['quantity'] ) : 1; // Cantidad
		$variation_attributes = isset( $_POST['variation'] ) ? json_decode( stripslashes( $_POST['variation'] ), true ) : []; // Variación (atributos)
		$extra_data = [];

		if ( isset($_POST['color']) ) {
			$extra_data['pa_color'] = sanitize_text_field( $_POST['color'] );
		}

		$product = $variation_id ? wc_get_product( $variation_id ) : wc_get_product( $product_id );
		// Validar stock
		if ( ! $product || ! $product->is_in_stock() ) {
			wp_send_json_error([
				'message' => 'Este producto está agotado.',
			]);
		}

		// Añadir el producto al carrito con los atributos y cantidad
		$added = WC()->cart->add_to_cart(
			$product_id,
			$quantity,
			$variation_id,
			$variation_attributes,
			$extra_data
		);

		// Si se añade correctamente
		if ( $added ) {
			// Captura el contenido del minicart
			ob_start();
			woocommerce_mini_cart();
			$mini_cart = ob_get_clean();

			// Obtiene el objeto del producto
			//$product = wc_get_product( $product_id );

			// Información del producto actual
			/*$product_data = [
				'name' => $product->get_name(),
				'price' => wc_price($product->get_price()),
				'image' => wp_get_attachment_image_src($product->get_image_id(), 'thumbnail')[0], // URL de la imagen
				'quantity' => $quantity,
			];*/

			wp_send_json_success([
				'message' => 'Producto añadido al carrito',
				'cart_count' => WC()->cart->get_cart_contents_count(),
				'mini_cart'  => $mini_cart, // Incluye el contenido del minicart en la respuesta
				//'product'    => $product_data, // Información del producto actual
			]);
		} else {
			wp_send_json_error([
				'message' => 'Error al añadir el producto al carrito',
			]);
		}
	} else {
		wp_send_json_error([
			'message' => 'ID de producto no válido',
		]);
	}

	wp_die(); // Termina la solicitud AJAX
}

function add_product_to_quick_purchase() {
	// Verifica si el product_id está presente
	if ( isset( $_POST['product_id'] ) ) {
		$product_id = absint( $_POST['product_id'] );
		$quantity = isset( $_POST['quantity'] ) ? absint( $_POST['quantity'] ) : 1;
		$variation_id = isset( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : 0;
		$variation_attributes = isset( $_POST['variation'] ) ? json_decode( stripslashes( $_POST['variation'] ), true ) : [];

		$product = $variation_id ? wc_get_product( $variation_id ) : wc_get_product( $product_id );

		// Validar stock
		if ( ! $product || ! $product->is_in_stock() ) {
			wp_send_json_error([
				'message' => 'Este producto está agotado.',
			]);
		}

		// Si el producto está en descuento, eliminar todos los cupones del carrito
		if ( $product->is_on_sale() ) {
			WC()->cart->remove_coupons(); // Elimina todos los cupones aplicados
		}

		// Añadir el producto al carrito
		$added = WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation_attributes );

		if ( $added ) {
			// Captura el contenido del minicart
			ob_start();
			woocommerce_mini_cart();
			$mini_cart = ob_get_clean();

			wp_send_json_success([
				'message' => 'Producto añadido al carrito',
				'cart_count' => WC()->cart->get_cart_contents_count(),
				'mini_cart'  => $mini_cart,
			]);
		} else {
			wp_send_json_error([
				'message' => 'Error al añadir el producto al carrito',
			]);
		}
	} else {
		wp_send_json_error([
			'message' => 'ID de producto no válido',
		]);
	}

	wp_die(); // Finaliza la solicitud AJAX
}

function delete_product_to_cart_callback() {
    $key = sanitize_text_field($_POST['key']);
    $remove_item = WC()->cart->remove_cart_item($key);

    if (!$remove_item) {
        wp_send_json_error('Ocurrió un error al eliminar el producto', 404);
    }

    // Refrescar el carrito mini para el frontend
    ob_start();
    woocommerce_mini_cart();
    $mini_cart = ob_get_clean();

    $discount_total_value = WC()->cart->get_discount_total();
    $has_discount = $discount_total_value > 0;

    wp_send_json_success([
        'message' => 'Producto eliminado del carrito',
        'cart_count' => WC()->cart->get_cart_contents_count(),
        'mini_cart'  => $mini_cart,
        'subtotal' => wc_price(WC()->cart->get_subtotal()),
        'discount_total' => wc_price($discount_total_value),
        'has_discount' => $has_discount, // Aquí indicas si hay descuento activo
        'total' => WC()->cart->get_total(),
        'carrito' => WC()->cart->is_empty()
    ]);

    wp_die();
}


function set_cart_item_quantity() {
	$key = sanitize_text_field($_POST['key']);
	$quantity = sanitize_text_field($_POST['quantity']);
	$set_quantity = wc()->cart->set_quantity($key, $quantity);

	if (!$set_quantity) {
		wp_send_json_error([
			'message' => __('Error occurred while updating product in cart', 'mos'),
		]);

		wp_die();
	}

	ob_start();
	woocommerce_mini_cart();
	$mini_cart = ob_get_clean();

	wp_send_json_success([
		'message' => 'Cantidad de producto agregado',
		'cart_count' => WC()->cart->get_cart_contents_count(),
		'mini_cart'  => $mini_cart,
		'subtotal' => wc_price(WC()->cart->get_subtotal()),
		'total' => wc_price(WC()->cart->get_subtotal()),
	]);

	wp_die();
}

// function apply_coupon_ajax() {
// 	if ( null === WC()->cart ) {
// 		wc_load_cart();
// 	}

// 	if ( ! isset($_POST['coupon_code']) ) {
// 		wp_send_json_error('Cupón no enviado');
// 	}

// 	$coupon_code = sanitize_text_field($_POST['coupon_code']);
// 	$coupons_list = [];

// 	$applied = WC()->cart->get_applied_coupons();
// 	if ( in_array( strtolower($coupon_code), array_map('strtolower', $applied) ) ) {
// 		wp_send_json_error('Este cupón ya ha sido aplicado.');
// 	}

// 	WC()->cart->add_discount($coupon_code);
// 	WC()->cart->calculate_totals(); // importante

// 	if ( WC()->cart->has_discount($coupon_code) ) {
// 		foreach ( WC()->cart->get_applied_coupons() as $code ) {
// 			$coupon = new WC_Coupon( $code );
// 			$coupons_list[] = [
// 				'code'     => $coupon->get_code(),
// 				'amount'   => wc_price( $coupon->get_amount() ),
// 			];
// 		}
// 		wp_send_json_success([
// 			'subtotal' => wc_price(WC()->cart->get_subtotal()),
// 			'discount' => wc_price(WC()->cart->get_discount_total()),
// 			'total' => wc_price(WC()->cart->get_subtotal() - WC()->cart->get_discount_total()),
// 			'coupons'  => $coupons_list
// 		]);
// 	} else {
// 		wp_send_json_error('Cupón inválido o no aplicable');
// 	}
// }

function apply_coupon_ajax() {
	if ( null === WC()->cart ) {
		wc_load_cart();
	}

	if ( ! isset($_POST['coupon_code']) ) {
		wp_send_json_error('Cupón no enviado');
	}

	$coupon_code = sanitize_text_field($_POST['coupon_code']);
	$coupons_list = [];

	// 1. Validar si hay productos en oferta
	foreach ( WC()->cart->get_cart() as $cart_item ) {
		$product = $cart_item['data'];
		if ( $product->is_on_sale() ) {
			wp_send_json_error('No se pueden aplicar cupones cuando hay productos en oferta.');
		}
	}

	// 2. Validar si el cupón ya fue aplicado
	$applied = WC()->cart->get_applied_coupons();
	if ( in_array( strtolower($coupon_code), array_map('strtolower', $applied) ) ) {
		wp_send_json_error('Este cupón ya ha sido aplicado.');
	}

	// 3. Intentar aplicar cupón
	WC()->cart->add_discount($coupon_code);
	WC()->cart->calculate_totals();

	// 4. Verificar si se aplicó correctamente
	if ( WC()->cart->has_discount($coupon_code) ) {
		foreach ( WC()->cart->get_applied_coupons() as $code ) {
			$coupon = new WC_Coupon( $code );


			// Obtener tipo de descuento
			$discount_type = $coupon->get_discount_type();
			switch ( $discount_type ) {
				case 'percent':
					$tipo_descuento = 'Porcentaje';
					break;
				case 'fixed_cart':
					$tipo_descuento = 'Monto fijo en carrito';
					break;
				case 'fixed_product':
					$tipo_descuento = 'Monto fijo por producto';
					break;
				default:
					$tipo_descuento = ucfirst( $discount_type );
					break;
			}

			// Obtener monto del descuento (puede ser un porcentaje o monto fijo)
			$amount = $coupon->get_amount();
			// Si el descuento es porcentaje, mostrar con % 
			if ( $discount_type === 'percent' ) {
				$importe = $amount . '%';
			} else {
				$importe = wc_price( $amount );
			}


			$coupons_list[] = [
				'code'   => $coupon->get_code(),
				'amount' => $importe,
			];
		}
		wp_send_json_success([
			'subtotal' => wc_price(WC()->cart->get_subtotal()),
			'discount' => wc_price(WC()->cart->get_discount_total()),
			'total'    => wc_price(WC()->cart->get_subtotal() - WC()->cart->get_discount_total()),
			'coupons'  => $coupons_list
		]);
	} else {
		wp_send_json_error('Cupón inválido o no aplicable.');
	}
}


function remove_coupon_ajax() {
	if ( ! isset($_POST['coupon_code']) ) {
		wp_send_json_error('Cupón no enviado');
	}

	$coupon_code = sanitize_text_field($_POST['coupon_code']);

	if ( WC()->cart->has_discount($coupon_code) ) {
		WC()->cart->remove_coupon($coupon_code);
		WC()->cart->calculate_totals();

		wp_send_json_success([
			'subtotal' => wc_price(WC()->cart->get_subtotal()),
			'discount' => wc_price(WC()->cart->get_discount_total()),
			'total' => WC()->cart->get_total(), // Aquí sí se incluye el envío
			'has_coupon' => WC()->cart->has_discount(),
			'has_shipping' => WC()->cart->needs_shipping(),
			'shipping_total' => wc_price(WC()->cart->get_shipping_total())
		]);
	} else {
		wp_send_json_error('El cupón no está aplicado');
	}
}
