<?php
add_action('wp_ajax_toggle_wishlist', 'toggle_wishlist');
add_action('wp_ajax_nopriv_toggle_wishlist', 'toggle_wishlist');

function toggle_wishlist() {
	// Verificar si el usuario está autenticado
	if ( !is_user_logged_in() ) {
		wp_send_json_error(['message' => 'Debes iniciar sesión para usar la wishlist.']);
	}

	$user_id = get_current_user_id();
	$product_id = intval($_POST['product_id']);

	// Obtener la wishlist del usuario (guardada como un meta dato del usuario)
	$wishlist = get_user_meta($user_id, '_wishlist', true);

	if (empty($wishlist)) {
		$wishlist = [];
	}

	// Verificar si el producto ya está en la wishlist
	if (in_array($product_id, $wishlist)) {
		// Eliminar de la wishlist
		$wishlist = array_diff($wishlist, [$product_id]);
		update_user_meta($user_id, '_wishlist', $wishlist);
		wp_send_json_success(['message' => 'Producto eliminado de la wishlist.']);
	} else {
		// Añadir a la wishlist
		$wishlist[] = $product_id;
		update_user_meta($user_id, '_wishlist', $wishlist);
		wp_send_json_success(['message' => 'Producto añadido a la wishlist.']);
	}
}

function show_wishlist() {
	if ( !is_user_logged_in() ) {
		return 'Debes iniciar sesión para ver tu wishlist.';
	}

	$user_id = get_current_user_id();
	$wishlist = get_user_meta($user_id, '_wishlist', true);

	if (empty($wishlist)) {
		return 'Tu wishlist está vacía.';
	}

	// Mostrar los productos
	$output = '<ul>';
	foreach ($wishlist as $product_id) {
		$product = wc_get_product($product_id);
		$output .= '<li>
			<a href="' . get_permalink($product_id) . '">' . '<img src="'. wp_get_attachment_image_src($product->get_image_id(), 'thumbnail')[0].'"/>' . $product->get_name() . '</a>
		</li>';
	}
	$output .= '</ul>';

	return $output;
}
