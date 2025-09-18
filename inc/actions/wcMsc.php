<?php
//agregar evento al historial
function mosqueira_agregar_evento_historial($user_id, $titulo, $descripcion = '',$puntos_o_categoria = '', $tipo = 'puntos') {
	$historial = get_user_meta($user_id, 'mosqueira_historial', true);
	$date = new DateTime("now", new DateTimeZone('America/Lima'));
	if (!is_array($historial)) $historial = [];

	$evento = [
		'title' => $titulo,
		'descripcion' => $descripcion,
		'fecha' => $date->format('d/m/Y'),
		'puntos_categoria' => $puntos_o_categoria,
		'tipo' => $tipo,
	];

	$historial[] = $evento;

	update_user_meta($user_id, 'mosqueira_historial', $historial);
}
//Se escucha el hook de WooCommerce después de que un pedido cambie a estado completed.
add_action('woocommerce_order_status_completed', 'mosqueira_asignar_puntos_por_compra');
function mosqueira_asignar_puntos_por_compra($order_id) {
	$order = wc_get_order($order_id);
	$user_id = $order->get_user_id();
	if (!$user_id) return;

	$total = $order->get_total();
	$puntos_base = $total * 10;

	$categoria = get_user_meta($user_id, 'mosqueira_categoria', true);

	// Bonificación por categoría
	$bonificaciones = [
		'Silver'   => 0.10, // 10%
		'Gold'     => 0.15, // 15%
		'Platinum' => 0.15, // 15%
	];

	$porcentaje_extra = $bonificaciones[$categoria] ?? 0;
	$puntos_extra = $puntos_base * $porcentaje_extra;

	$puntos_totales = intval($puntos_base + $puntos_extra);
	$puntos_actuales = (int) get_user_meta($user_id, 'mosqueira_puntos', true);
	$nuevo_total = $puntos_actuales + $puntos_totales;

	update_user_meta($user_id, 'mosqueira_puntos', $nuevo_total);

	// Guardar en historial
	$descripcion = $porcentaje_extra > 0
		? "<p>Incluye un " . ($porcentaje_extra * 100) . "% adicional por ser cliente {$categoria}.</p>"
		: '';

	mosqueira_agregar_evento_historial(
		$user_id,
		"Has ganado {$puntos_totales} puntos por una compra.",
		$descripcion,
		"+{$puntos_totales}",
		'puntos'
	);

	// Verificar cambio de categoría
	mosqueira_actualizar_categoria($user_id, $nuevo_total);
}


// otorgar 500 puntos al registrarse
add_action('user_register', 'mosqueira_otorgar_puntos_registro');
function mosqueira_otorgar_puntos_registro($user_id) {
	update_user_meta($user_id, 'mosqueira_puntos', 500);
	mosqueira_actualizar_categoria($user_id, 500);

	/*mosqueira_agregar_evento_historial($user_id, 'Felicidades, usted es un cliente Access. Sus beneficios incluyen:', '<ul><li>Beneficio 1</li><li>Beneficio 2</li></ul>', 'Access', 'categoria');*/
	mosqueira_agregar_evento_historial($user_id, '¡Bienvenido! Ha ganado 500 puntos por unirse.', '', '+500');

	$user = get_userdata($user_id);
	$email = $user->user_email;


	// Buscar pedidos realizados con ese correo sin usuario asignado
	$args_ = array(
		'limit'         => -1,
		'status'        => 'any',
		'billing_email' => $email,
		//'customer'      => 0,
	);

	$orders = wc_get_orders($args_);

	foreach ($orders as $order) {
		// Asignar el ID de usuario al pedido
		if ($order->get_user_id() === 0) {
			$order->set_customer_id($user_id);
			$order->save();

			// Opcional: actualizar los datos del perfil del usuario con la información del pedido
			actualizar_datos_usuario_desde_pedido($user_id, $order);
		}
	}

	
	// Marcar si hizo pedido como invitado antes de registrarse (una sola vez)
	if (!get_user_meta($user_id, 'primer_pedido_como_invitado', true)) {
		$args_check = array(
			'limit'         => 1,
			'status'        => 'any',
			'billing_email' => $email,
			//'customer_id'   => 0,
		);
		$guest_orders = wc_get_orders($args_check);
		if (!empty($guest_orders)) {
			update_user_meta($user_id, 'primer_pedido_como_invitado', '1');
		}
	}

	$subject = '¡Bienvenido a Mosqueira Social Club!';

	ob_start();
	include(get_stylesheet_directory() . '/woocommerce/emails/email-access-msc.php');
	$email_content = ob_get_clean();

	wp_mail($email, $subject, $email_content, [
		'Content-Type: text/html; charset=UTF-8',
		"From: Mosqueira <mosqueiraonline@mosqueira.com.pe>",
	]);


	// -------------------------------
	// Enviar notificación al administrador
	// -------------------------------
	
	$admin_email = get_option('admin_email');

	$first_name = get_user_meta($user_id, 'first_name', true);
	$last_name = get_user_meta($user_id, 'last_name', true);

	$subject_admin = 'Nuevo usuario registrado en tu sitio';

	$message_admin = "Se ha registrado un nuevo usuario en tu sitio web:\n\n";
	$message_admin .= "Nombre completo: " . trim($first_name . ' ' . $last_name) . "\n";
	$message_admin .= "Nombre de usuario: " . $user->user_login . "\n";
	$message_admin .= "Correo electrónico: " . $user->user_email . "\n";

	wp_mail($admin_email, $subject_admin, $message_admin, [
		'Content-Type: text/plain; charset=UTF-8',
		"From: Mosqueira <mosqueiraonline@mosqueira.com.pe>",
	]);
  
    
}

add_action('wp_login', 'mosqueira_asignar_pedidos_inv', 10, 2);
function mosqueira_asignar_pedidos_inv($user_login, $user) {
    $user_id = $user->ID;
    $email = $user->user_email;

    $args = array(
        'limit'         => -1,
        'status'        => 'any',
        'billing_email' => $email,
    );

    $orders = wc_get_orders($args);

    foreach ($orders as $order) {
        if ($order->get_user_id() == 0) {
            $order->set_customer_id($user_id);
            $order->save();
			actualizar_datos_usuario_desde_pedido($user_id, $order);
        }
    }
}



// Actualizar perfil del usuario con los datos del pedido (nombre, dirección, teléfono)
function actualizar_datos_usuario_desde_pedido($user_id, $order) {
    if (!$order instanceof WC_Order) return;

    // Obtener los datos del pedido
    $billing_first_name = $order->get_billing_first_name();
    $billing_last_name  = $order->get_billing_last_name();
    $billing_email      = $order->get_billing_email();
    $billing_company    = $order->get_billing_company();
    $billing_address_1  = $order->get_billing_address_1();
    $billing_address_2  = $order->get_billing_address_2();
    $billing_city       = $order->get_billing_city();
    $billing_postcode   = $order->get_billing_postcode();
    $billing_country    = $order->get_billing_country();
    $billing_state      = $order->get_billing_state();
    $billing_phone      = $order->get_billing_phone();

    // Actualizar metadatos del usuario (WooCommerce)
    update_user_meta($user_id, 'billing_first_name', $billing_first_name);
    update_user_meta($user_id, 'billing_last_name', $billing_last_name);
    update_user_meta($user_id, 'billing_email', $billing_email);
    update_user_meta($user_id, 'billing_company', $billing_company);
    update_user_meta($user_id, 'billing_address_1', $billing_address_1);
    update_user_meta($user_id, 'billing_address_2', $billing_address_2);
    update_user_meta($user_id, 'billing_city', $billing_city);
    update_user_meta($user_id, 'billing_postcode', $billing_postcode);
    update_user_meta($user_id, 'billing_country', $billing_country);
    update_user_meta($user_id, 'billing_state', $billing_state);
    update_user_meta($user_id, 'billing_phone', $billing_phone);

    // Actualizar nombre del perfil de usuario (WordPress)
    wp_update_user([
        'ID'         => $user_id,
        'first_name' => $billing_first_name,
        'last_name'  => $billing_last_name,
        //'user_email' => $billing_email, // Opción: solo si quieres actualizar el correo principal del perfil
    ]);
}


//Asignar categoría por puntos acumulados
function mosqueira_actualizar_categoria($user_id, $puntos) {
	$nueva_categoria = 'Access';

	if ($puntos >= 30000) {
		$nueva_categoria = 'Platinum';
	} elseif ($puntos >= 15000) {
		$nueva_categoria = 'Gold';
	} elseif ($puntos >= 5000) {
		$nueva_categoria = 'Silver';
	}

	$categoria_actual = get_user_meta($user_id, 'mosqueira_categoria', true);

	if ($nueva_categoria !== $categoria_actual) {
		update_user_meta($user_id, 'mosqueira_categoria', $nueva_categoria);

		// Enviar correo solo si no ha sido enviado antes
		mosqueira_enviar_correo_categoria($user_id, $nueva_categoria);

		$beneficios = [
			'Access' => '<ul><li>15% de descuento en su primera compra</li><li>500 puntos de regalo por unirse al club</li></ul>',
			'Silver' => '<ul><li>15% de descuento en su primera compra</li><li>500 puntos de regalo por unirse al club</li><li>Beneficios exclusivos cada mes (descuentos, precios especiales, etc.)</li><li>10% adicional de puntos por compra</li><li>Delivery gratis por compras mayores a S/310</li>
			</ul>',
			'Gold'   => '<ul><li>15% de descuento en su primera compra</li><li>500 puntos de regalo por unirse al club</li><li>Beneficios exclusivos cada mes (descuentos, precios especiales, etc.)</li><li>10% adicional de puntos por compra</li><li>Delivery gratis por compras mayores a S/310</li><li>Acceso a eventos exclusivos</li><li>Delivery gratis por compras mayores a S/ 200</li><li>Presentación de cortesía para obsequios (tarjeta de regalo)</li><li>15% adicional de puntos por compra</li></ul>',
			'Platinum' => '<ul><li>15% de descuento en su primera compra</li><li>500 puntos de regalo por unirse al club</li><li>Beneficios exclusivos cada mes (descuentos, precios especiales, etc.)</li><li>10% adicional de puntos por compra</li><li>Delivery gratis por compras mayores a S/310</li><li>Acceso a eventos exclusivos</li><li>Delivery gratis por compras mayores a S/ 200</li><li>Presentación de cortesía para obsequios (tarjeta de regalo)</li><li>15% adicional de puntos por compra</li><li>Delivery gratis sin mínimo de compra</li><li>Empaque exclusivo para obsequios</li><li>Regalo especial por cumpleaños</li><li>Experiencias VIP</li><li>Estilista privado</li></ul>',
		];

		mosqueira_agregar_evento_historial(
			$user_id,
			"Felicidades, usted es un cliente {$nueva_categoria}. Sus beneficios incluyen:",
			$beneficios[$nueva_categoria] ?? '',
			$nueva_categoria,
			'categoria'
		);
	}
}

function mosqueira_enviar_correo_categoria($user_id, $categoria) {
	// No enviar correo si la categoría es Access
	if ($categoria === 'Access') return;

	$meta_key = 'mosqueira_correo_enviado_' . strtolower($categoria);
	$ya_enviado = get_user_meta($user_id, $meta_key, true);

	if ($ya_enviado) return;

	$user = get_userdata($user_id);
	$email = $user->user_email;

	//$asunto = "Ahora forma parte del nivel {$categoria}";
	$asunto = "MSC: Bienvenido a {$categoria}";

	ob_start();
	include(get_stylesheet_directory() . '/woocommerce/emails/email-msc.php');
	$email_content = ob_get_clean();

	wp_mail($email, $asunto, $email_content, [
		'Content-Type: text/html; charset=UTF-8',
		"From: Mosqueira <mosqueiraonline@mosqueira.com.pe>",
	]);

	update_user_meta($user_id, $meta_key, 1); // Evitar reenvíos
}


function mosqueira_es_primera_compra($user_id) {
	$args = [
		'customer_id' => $user_id,
		//'status' => ['completed'],
		'status' => ['completed', 'processing'],
		'return' => 'ids',
	];

	$orders = wc_get_orders($args);
	return count($orders) === 0;
}

function mosqueira_has_sale_products() {
	$cart = WC()->cart;

	// Check if the cart is not initialized or is empty
	if ( ! $cart || $cart->is_empty() ) {
		return false;
	}

	foreach ( $cart->get_cart() as $cart_item ) {
		if ( $cart_item['data']->is_on_sale() ) {
			return true;
		}
	}

	return false;
}

/*add_action('woocommerce_cart_calculate_fees', 'mosqueira_descuento_primera_compra_access');
function mosqueira_descuento_primera_compra_access($cart) {
	if (is_admin() && !defined('DOING_AJAX')) return;

	$user_id = get_current_user_id();
	if (!$user_id) return;

	$categoria = get_user_meta($user_id, 'mosqueira_categoria', true);
	$ya_aplicado = get_user_meta($user_id, 'mosqueira_primera_compra_descuento_usado', true);
	$primer_pedido_como_invitado = get_user_meta($user_id, 'primer_pedido_como_invitado', true);

	// Verificar si hay productos con descuento en el carrito
	foreach ( $cart->get_cart() as $cart_item ) {
		$product = $cart_item['data'];
		$precio_regular = $product->get_regular_price();
		$precio_actual = $product->get_price();

		if ( $precio_actual < $precio_regular ) {
			// Si hay al menos un producto con descuento, salir
			return;
		}
	}
	//($categoria === 'Access' || $categoria === 'Silver') &&
	if (  (mosqueira_es_primera_compra($user_id) && !$ya_aplicado) || (!$ya_aplicado && $primer_pedido_como_invitado =="1" ) ) {
		$descuento = $cart->get_subtotal() * 0.15;
		$cart->add_fee('15% de descuento - Primera compra ('.$categoria.')', -$descuento);
	}
}*/

add_action('woocommerce_cart_calculate_fees', 'mosqueira_descuento_primera_compra_access');
function mosqueira_descuento_primera_compra_access($cart) {
    if (is_admin() && !defined('DOING_AJAX')) return;

    $user_id = get_current_user_id();
    if (!$user_id) return;

    $categoria = get_user_meta($user_id, 'mosqueira_categoria', true);
    $ya_aplicado = get_user_meta($user_id, 'mosqueira_primera_compra_descuento_usado', true);
    $primer_pedido_como_invitado = get_user_meta($user_id, 'primer_pedido_como_invitado', true);

    // Verificar condiciones para aplicar descuento
    if (!((mosqueira_es_primera_compra($user_id) && !$ya_aplicado) || (!$ya_aplicado && $primer_pedido_como_invitado == "1"))) {
        return;
    }

    $subtotal_precio_normal = 0;
    $has_normal_product = false;

    foreach ( $cart->get_cart() as $cart_item ) {
        $product = $cart_item['data'];
        $is_pack = get_post_meta( $product->get_id(), '_is_custom_pack', true );
        $precio_regular = floatval($product->get_regular_price());
        $precio_actual = floatval($product->get_price());

        // Solo productos normales (no pack) con precio actual igual o mayor al regular (sin oferta)
        if ( ! $is_pack && $precio_actual >= $precio_regular ) {
            $subtotal_precio_normal += $precio_actual * $cart_item['quantity'];
            $has_normal_product = true;
        }
    }

    // Aplicar descuento solo si hay al menos un producto normal y subtotal positivo
    if ( $has_normal_product && $subtotal_precio_normal > 0 ) {
        $descuento = $subtotal_precio_normal * 0.15;
        $cart->add_fee('15% de descuento - Primera compra (' . $categoria . ')', -$descuento);
    }
}




add_action('woocommerce_after_shipping_rate', 'mosqueira_mensaje_beneficio_envio_gratis', 10, 2);

function mosqueira_mensaje_beneficio_envio_gratis($method, $index) {
    // Solo para nuestro método personalizado
    if (strpos($method->id, 'custom_delivery_method') === false) return;

    $user_id = get_current_user_id();
    if (!$user_id) return;

    $categoria = get_user_meta($user_id, 'mosqueira_categoria', true);
    $subtotal = WC()->cart->get_subtotal();

    $mostrar = false;

    if ($categoria === 'Platinum') {
			$mostrar = true;
    } elseif ($categoria === 'Gold' && $subtotal >= 210) {
			$mostrar = true;
    } elseif ($categoria === 'Silver' && $subtotal >= 310) {
			$mostrar = true;
    }

    if ($mostrar) {
			echo '<p style="margin:5px 0; font-size: 13px;">';
			echo 'Envío gratis por ser nivel ' . esc_html($categoria);
			echo '</p>';
    }
}

add_filter( 'woocommerce_package_rates', 'mosqueira_aplicar_envio_gratis_por_nivel', 10, 2 );
function mosqueira_aplicar_envio_gratis_por_nivel( $rates, $package ) {
    $user_id = get_current_user_id();
    if ( ! $user_id ) return $rates;

    $categoria = get_user_meta( $user_id, 'mosqueira_categoria', true );
    $subtotal = WC()->cart->get_subtotal();

    $aplica_envio_gratis = false;

    if ( $categoria === 'Platinum' ) {
        $aplica_envio_gratis = true;
    } elseif ( $categoria === 'Gold' && $subtotal >= 210 ) {
        $aplica_envio_gratis = true;
    } elseif ( $categoria === 'Silver' && $subtotal >= 310 ) {
        $aplica_envio_gratis = true;
    }

    if ( $aplica_envio_gratis ) {
        foreach ( $rates as $rate_key => $rate ) {
            // Solo modificar el método personalizado si aplica
            if ( strpos( $rate->id, 'custom_delivery_method' ) !== false ) {
                $rates[ $rate_key ]->cost = 0;

                // Borrar impuestos del envío si existen
                if ( ! empty( $rates[ $rate_key ]->taxes ) ) {
                    foreach ( $rates[ $rate_key ]->taxes as $tax_id => $tax ) {
                        $rates[ $rate_key ]->taxes[ $tax_id ] = 0;
                    }
                }
            }
        }
    }

    return $rates;
}

//Marcar beneficio como usado al completar compra
//add_action('woocommerce_order_status_completed', 'mosqueira_marcar_descuento_usado');
/*function mosqueira_marcar_descuento_usado($order_id) {
	$order = wc_get_order($order_id);
	$user_id = $order->get_user_id();
	if (!$user_id) return;

	// Marcar que el beneficio ya fue aplicado
	if (!get_user_meta($user_id, 'mosqueira_primera_compra_descuento_usado', true)) {
		update_user_meta($user_id, 'mosqueira_primera_compra_descuento_usado', 1);

		// Registrar en historial
		mosqueira_agregar_evento_historial(
			$user_id,
			'Has usado tu 15% de descuento por primera compra (Access).',
			'',
			'-15%',
			'puntos'
		);
	}
}*/

add_action( 'wp_ajax_update_points_msc', 'mosqueria_update_points_manual' );
add_action( 'wp_ajax_nopriv_update_points_msc', 'mosqueria_update_points_manual' );
function mosqueria_update_points_manual() {
  $user_id = $_POST['id_user'];
  $puntos = (int) sanitize_text_field($_POST['puntos']);

  if(!empty($user_id) && isset($puntos) && is_numeric($puntos) && $puntos > 0) {
    update_user_meta($user_id, 'mosqueira_puntos', $puntos);
    mosqueira_actualizar_categoria($user_id, $puntos);
    wp_send_json_success([
      'message' => 'Puntos actualizados correctamente'
    ]);
  } else {
    wp_send_json_error([
      'message' => 'Error: Los puntos deben ser un número mayor que cero.',
    ]);
  }

  wp_die();
}

//Descuentos según categoría
/*add_action('woocommerce_cart_calculate_fees', 'mosqueira_aplicar_descuento_por_categoria');
function mosqueira_aplicar_descuento_por_categoria($cart) {
	if (is_admin() && !defined('DOING_AJAX')) return;

	$user_id = get_current_user_id();
	if (!$user_id) return;

	$categoria = get_user_meta($user_id, 'mosqueira_categoria', true);
	$descuento = 0;

	switch ($categoria) {
		case 'Silver':
			$descuento = 0.05; // 5%
			break;
		case 'Gold':
			$descuento = 0.10; // 10%
			break;
		case 'Platinum':
			$descuento = 0.15; // 15%
			break;
		default:
			$descuento = 0;
	}

	if ($descuento > 0) {
		$monto_descuento = $cart->get_subtotal() * $descuento;
		$cart->add_fee("Descuento por categoría ($categoria)", -$monto_descuento);
	}
}*/

//validar que el usuario tenga la categoría necesaria al aplicar un cupón
add_filter('woocommerce_coupon_is_valid', 'mosqueira_validar_cupon_categoria', 10, 2);
function mosqueira_validar_cupon_categoria($valid, $coupon) {
	if ($coupon->get_code() === 'peru2025' && !is_user_logged_in()) {
		throw new Exception(__('Este cupón solo está disponible para usuarios registrados.', 'mos'));
	}
	return $valid;
}

add_action('admin_menu', 'msc_by_user');
function msc_by_user() {
	add_submenu_page(
		'users.php',
		'MSC',
		'MSC',
		'manage_options',
		'msc',
		'msc_by_user_page_callback'
	);

	add_action("load-users_page_msc", 'msc_add_screen_options');
}

function msc_add_screen_options() {
	$option = 'msc_users_per_page';
	$args = [
		'label' => 'Usuarios por página',
		'default' => 10,
		'option' => $option
	];
	add_screen_option('per_page', $args);
}

add_filter('set-screen-option', function($status, $option, $value) {
	if ('msc_users_per_page' === $option) {
		return intval($value);
	}
	return $status;
}, 10, 3);

function msc_by_user_page_callback() {
	global $wpdb;
	$prefix = $wpdb->prefix;
	$url_admin = get_admin_url();

	if (isset($_GET['user'])) {
		// Vista individual
		$user = intval($_GET['user']);
		$data_user = get_userdata($user);
		$puntos = get_user_meta($user, 'mosqueira_puntos', true);
		$categoria = get_user_meta($user, 'mosqueira_categoria', true);
		?>
		<div class="wrap">
			<h2>Su nivel actual: <strong><?php echo esc_html($categoria); ?></strong></h2>
			<h3 style="font-weight:400">Subir puntos manualmente:</h3>
			<input id="mos-input-update-msc" type="number" value="<?php echo intval($puntos); ?>">
			<button type="button" id="mos-uptate-msc" class="button button-primary">Actualizar</button>
			<input type="hidden" id="urlajaxadm" value="<?php echo admin_url('admin-ajax.php'); ?>">
			<input type="hidden" id="mos-id-user" value="<?php echo esc_attr($user); ?>">
		</div>
		<script>
			jQuery('#mos-uptate-msc').click(function () {
				var number = jQuery('#mos-input-update-msc').val();
				var ajaxUrl = jQuery('#urlajaxadm').val();
				var idUser = jQuery('#mos-id-user').val();
				jQuery.post(ajaxUrl, {
					action: "update_points_msc",
					puntos: number,
					id_user: idUser
				}).success(function (response) {
					alert(response.data.message);
				});
			});
		</script>
		<?php
	} else {
		// Vista general (listado)
		$search_email = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

		$all_users = get_users([
			'meta_key' => 'mosqueira_puntos',
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			'role' => 'subscriber'
		]);

		// Filtrado por correo
		if ($search_email) {
			$all_users = array_filter($all_users, function ($user) use ($search_email) {
				return stripos($user->user_email, $search_email) !== false;
			});
		}

		// Paginación
		$per_page = get_user_option('msc_users_per_page', get_current_user_id());
		if (!$per_page || $per_page < 1) $per_page = 10;
		$current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
		$offset = ($current_page - 1) * $per_page;

		$total_users = count($all_users);
		$total_pages = ceil($total_users / $per_page);
		$usuarios = array_slice($all_users, $offset, $per_page);

		$base_url = remove_query_arg('paged', $_SERVER['REQUEST_URI']);
		?>
		<div class="wrap">
			<h2>Mosqueira Social Club</h2>
			<br>
			<a href="<?php echo admin_url('admin.php?exportar_msc=1'); ?>" class="button button-primary">Exportar Excel</a>
			<br><br>

			<!-- Buscador -->
			<form method="get">
				<input type="hidden" name="page" value="msc" />
				<input type="search" name="s" value="<?php echo esc_attr($search_email); ?>" placeholder="Buscar por correo..." />
				<input type="submit" class="button" value="Buscar" />
				<?php if ($search_email): ?>
					<a href="<?php echo esc_url(remove_query_arg('s')); ?>" class="button">Limpiar</a>
				<?php endif; ?>
			</form>
			<br>

			<table class="widefat fixed striped">
				<thead>
					<tr>
						<th>Nombre</th>
						<th>Email</th>
						<th>Teléfono</th>
						<th>Fecha de nacimiento</th>
						<th>Dirección</th>
						<th>Departamento</th>
						<th>Provincia</th>
						<th>Distrito</th>
						<th>Género</th>
						<th>Puntos</th>
						<th>Categoría</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($usuarios as $usuario) :
						$user_id = $usuario->ID;
						$puntos = get_user_meta($user_id, 'mosqueira_puntos', true);
						$categoria = get_user_meta($user_id, 'mosqueira_categoria', true);
						$genero = get_user_meta($user_id, 'mos_genero', true);
						$telefono = get_field('acf_user_phone', 'user_' . $user_id);
						$fecha_nacimiento = get_field('acf_user_fdn', 'user_' . $user_id);
						$first_name = get_user_meta($user_id, 'first_name', true);
						$last_name = get_user_meta($user_id, 'last_name', true);
						$direccion = get_user_meta($user_id, 'billing_address_1', true);
						$departamento_id = get_user_meta($user_id, 'billing_departamento', true);
						$provincia_id = get_user_meta($user_id, 'billing_provincia', true);
						$distrito_id = get_user_meta($user_id, 'billing_distrito', true);

						$departamento = $wpdb->get_var($wpdb->prepare("SELECT departamento FROM {$prefix}ubigeo_departamento WHERE idDepa = %d", $departamento_id));
						$provincia = $wpdb->get_var($wpdb->prepare("SELECT provincia FROM {$prefix}ubigeo_provincia WHERE idProv = %d", $provincia_id));
						$distrito = ($departamento && $provincia) ? $wpdb->get_var($wpdb->prepare("SELECT distrito FROM {$prefix}ubigeo_distrito WHERE idDist = %d", $distrito_id)) : '';
						?>
						<tr>
							<td><?php echo esc_html($first_name . ' ' . $last_name); ?></td>
							<td><?php echo esc_html($usuario->user_email); ?></td>
							<td><?php echo esc_html($telefono); ?></td>
							<td>
								<?php
								if ($fecha_nacimiento) {
									$meses = ['enero' => '01', 'febrero' => '02', 'marzo' => '03', 'abril' => '04', 'mayo' => '05', 'junio' => '06', 'julio' => '07', 'agosto' => '08', 'septiembre' => '09', 'octubre' => '10', 'noviembre' => '11', 'diciembre' => '12'];
									$dia = $fecha_nacimiento['acf_user_fdn_date'];
									$mes_nombre = strtolower($fecha_nacimiento['acf_user_fdn_mes']);
									$anio = $fecha_nacimiento['acf_user_fdn_ano'];
									$mes_num = $meses[$mes_nombre] ?? '00';
									echo str_pad($dia, 2, '0', STR_PAD_LEFT) . '/' . $mes_num . '/' . $anio;
								}
								?>
							</td>
							<td><?php echo esc_html($direccion); ?></td>
							<td><?php echo esc_html($departamento); ?></td>
							<td><?php echo esc_html($provincia); ?></td>
							<td><?php echo esc_html($distrito); ?></td>
							<td><?php echo esc_html($genero); ?></td>
							<td><?php echo intval($puntos); ?></td>
							<td><?php echo esc_html($categoria); ?></td>
							<td><a href="<?php echo esc_url(admin_url("users.php?page=msc&user={$user_id}")); ?>">Ver</a></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<?php if ($total_pages > 1): ?>
				<div class="tablenav">
					<div class="tablenav-pages">
						<span class="displaying-num"><?php echo $total_users; ?> usuarios</span>
						<span class="pagination-links">
							<?php
							$first_url = esc_url(add_query_arg(['paged' => 1], $base_url));
							$prev_url = esc_url(add_query_arg(['paged' => max(1, $current_page - 1)], $base_url));
							$next_url = esc_url(add_query_arg(['paged' => min($total_pages, $current_page + 1)], $base_url));
							$last_url = esc_url(add_query_arg(['paged' => $total_pages], $base_url));
							?>
							<a class="first-page button" href="<?php echo $first_url; ?>">«</a>
							<a class="prev-page button" href="<?php echo $prev_url; ?>">‹</a>
							<span class="paging-input"><?php echo $current_page; ?> de <span class="total-pages"><?php echo $total_pages; ?></span></span>
							<a class="next-page button" href="<?php echo $next_url; ?>">›</a>
							<a class="last-page button" href="<?php echo $last_url; ?>">»</a>
						</span>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}
