<?php
// ==== CONFIGURATION (CUSTOM) ==== //
function get_cache_key($key) {
	return wp_cache_get($key, 'mosqueira_wp');
}

function set_cache_key($key, $data) {
	wp_cache_set($key, $data, 'mosqueira_wp', 250000);
	//69.4 horas
}

if (!is_admin()) {
	function add_defer_to_script( $tag, $handle, $src ) {
		$scripts_with_defer = array( 'manifest', 'script-se' );

		if ( in_array( $handle, $scripts_with_defer, true ) ) {
			$tag = '<script type="text/javascript" src="' . esc_url( $src ) . '" defer id="' . $handle . '"></script>';
		}

		return $tag;
	}
	add_filter( 'script_loader_tag', 'add_defer_to_script', 10, 3 );

	function prefix_defer_css_rel_preload( $html, $handle, $href, $media ) {
		echo '<link id="' . $handle . '" rel="stylesheet preload" as="style" href="' . $href . '" media="all">';
	}
	add_filter( 'style_loader_tag', 'prefix_defer_css_rel_preload', 10, 4 );
}

function jquery_to_footer() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', false, ['jquery-core', 'jquery-migrate'], false, true );
	wp_enqueue_script( 'jquery-core', '/wp-includes/js/jquery/jquery.js', [], false, true);
	wp_enqueue_script( 'jquery-migrate', '/wp-includes/js/jquery/jquery-migrate.min.js', [], false, true);
}
add_action('wp_enqueue_scripts', 'jquery_to_footer');

function sdt_remove_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'style_loader_src', 'sdt_remove_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999 );

// Function to unregister the WordPress embed script.
function unregister_wp_embed_script() {
	// Check if the current context is not the admin area.
	if (!is_admin()) {
		// Deregister the 'wp-embed' script.
		wp_deregister_script('wp-embed');
	}
}
add_action('init', 'unregister_wp_embed_script');

add_action( 'wp_enqueue_scripts', 'remove_select2_from_frontend', 100 );
function remove_select2_from_frontend() {
	if ( ! is_admin() ) {
		wp_dequeue_script( 'select2' );
		wp_dequeue_script( 'selectWoo' );
		wp_dequeue_script( 'select2-js' );
		wp_dequeue_script( 'thwcfd-checkout-script' );

		wp_dequeue_style( 'select2' );
		wp_dequeue_style( 'selectWoo' );
    wp_dequeue_style('wc-blocks-style');
    wp_deregister_style('wc-blocks-style');
		wp_dequeue_style( 'brands-styles' );

		wp_dequeue_style( 'woocommerce-layout' );
		wp_dequeue_style( 'woocommerce-smallscreen' );
		wp_dequeue_style( 'woocommerce-general' );
	}
}

// Remove the WordPress generator meta tag from the <head> of WordPress.
remove_action('wp_head', 'wp_generator');

// Enhance security and reduce exposure by disabling the registration of the oEmbed-related REST API route.
remove_action( 'rest_api_init', 'wp_oembed_register_route' );

// Remove oEmbed-specific JavaScript from the front-end and back-end.
remove_action( 'wp_head', 'wp_oembed_add_host_js' );

// Remove the RSD (Really Simple Discovery) link from the <head> of WordPress.
remove_action( 'wp_head', 'rsd_link');

// Remove the WLW (Windows Live Writer) manifest link from the <head> of WordPress.
remove_action( 'wp_head', 'wlwmanifest_link');

//removes feed links.
remove_action( 'wp_head', 'feed_links', 2 );

//removes comments feed.
remove_action( 'wp_head', 'feed_links_extra', 3 );

// Filters for WP-API version 1.x
add_filter( 'json_enabled', '__return_false' );
add_filter( 'json_jsonp_enabled', '__return_false' );

// Filters for WP-API version 2.x
add_filter( 'rest_enabled', '__return_false' );
add_filter( 'rest_jsonp_enabled', '__return_false' );

// Remove REST API info from head and headers
remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'template_redirect', 'rest_output_link_header', 11 );

// Remove wp-json 404
add_filter('rest_endpoints', function( $endpoints ) {
	if (isset($endpoints['/wp/v2/users'])) {
		unset($endpoints['/wp/v2/users']);
	}
	return $endpoints;
});

//Remove everything related with emojis
function disable_wp_emojicons() {
	// all actions related to emojis
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
}
add_action( 'init', 'disable_wp_emojicons' );

//remove change language switcher in wp-admin
add_filter( 'login_display_language_dropdown', '__return_false' );

//CUPON MENSAJE
add_filter( 'woocommerce_coupon_error', function( $err, $err_code, $coupon ) {
    if ( $err_code === WC_Coupon::E_WC_COUPON_NOT_APPLICABLE && $coupon->get_exclude_sale_items() ) {
        $err = 'Este cupón no puede usarse con productos en oferta.';
    }
    return $err;
}, 10, 3 );

//***********************************ADDDDDDDDDD */

add_filter('woocommerce_checkout_get_value_additional_dni', function($input) {
    if ( is_user_logged_in() ) {
        $dni = get_user_meta(get_current_user_id(), 'additional_dni', true);
        if ( !empty($dni) ) {
            return $dni;
        }
    }
    return $input;
});

add_filter('woocommerce_checkout_get_value_additional_phone', function($input) {
    if ( is_user_logged_in() ) {
        $phone = get_user_meta(get_current_user_id(), 'additional_phone', true);
        if ( !empty($phone) ) {
            return $phone;
        }
    }
    return $input;
});



use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function mos_exportar_excel_usuarios() {
	if (!current_user_can('manage_options') || !isset($_GET['exportar_msc'])) {
		return;
	}

	require_once __DIR__ . '/vendor/autoload.php'; // Ajusta esta ruta si usas Composer

	global $wpdb;

	$usuarios = get_users([
		'meta_key' => 'mosqueira_puntos',
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
		'role' => 'subscriber', // Solo suscriptores
	]);

	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();

	// Encabezados
	$headers = [
		'Nombre',
		'Email',
		'Teléfono',
		'Fecha de nacimiento',
		'Dirección',
		'Departamento',
		'Provincia',
		'Distrito',
		'Género',
		'Puntos',
		'Categoría'
	];

	$sheet->fromArray($headers, NULL, 'A1');

	$row = 2;
	foreach ($usuarios as $usuario) {
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

		$prefix = $wpdb->prefix;

		$departamento = $wpdb->get_var(
			$wpdb->prepare("SELECT departamento FROM {$prefix}ubigeo_departamento WHERE idDepa = %d", $departamento_id)
		);
		$provincia = $wpdb->get_var(
			$wpdb->prepare("SELECT provincia FROM {$prefix}ubigeo_provincia WHERE idProv = %d", $provincia_id)
		);
		

		if($departamento && $provincia){
			$distrito = $wpdb->get_var(
				$wpdb->prepare("SELECT distrito FROM {$prefix}ubigeo_distrito WHERE idDist = %d", $distrito_id)
			);
		}else{
			$distrito = "";
		}

		$fecha_nac = '';
		if ($fecha_nacimiento) {
			$meses = [
				'enero' => '01', 'febrero' => '02', 'marzo' => '03',
				'abril' => '04', 'mayo' => '05', 'junio' => '06',
				'julio' => '07', 'agosto' => '08', 'septiembre' => '09',
				'octubre' => '10', 'noviembre' => '11', 'diciembre' => '12'
			];
			$dia = $fecha_nacimiento['acf_user_fdn_date'];
			$mes_nombre = strtolower($fecha_nacimiento['acf_user_fdn_mes']);
			$anio = $fecha_nacimiento['acf_user_fdn_ano'];
			$mes_num = $meses[$mes_nombre] ?? '00';
			$fecha_nac = str_pad($dia, 2, '0', STR_PAD_LEFT) . '/' . $mes_num . '/' . $anio;
		}

		$sheet->fromArray([
			"$first_name $last_name",
			$usuario->user_email,
			$telefono,
			$fecha_nac,
			$direccion,
			$departamento,
			$provincia,
			$distrito,
			$genero,
			$puntos,
			$categoria
		], NULL, "A{$row}");

		$row++;
	}

	$filename = 'usuarios-mosqueira-social-club-' . date('Y-m-d') . '.xlsx';

	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header("Content-Disposition: attachment;filename=\"$filename\"");
	header('Cache-Control: max-age=0');

	$writer = new Xlsx($spreadsheet);
	$writer->save('php://output');
	exit;
}
add_action('admin_init', 'mos_exportar_excel_usuarios');


//REPORTE PEDIDO 
add_action('admin_init', function() {
    if (!current_user_can('manage_options')) return;

    if (isset($_GET['export_excel']) && $_GET['export_excel'] === '1') {
        if (ob_get_length()) ob_end_clean();

        global $wpdb;
        $prefix = $wpdb->prefix;

        $fecha_desde_raw = isset($_GET['fecha_desde']) ? sanitize_text_field($_GET['fecha_desde']) : '';
        $fecha_hasta_raw = isset($_GET['fecha_hasta']) ? sanitize_text_field($_GET['fecha_hasta']) : '';

        // Si no se ingresan fechas, usar hoy
        if (!$fecha_desde_raw && !$fecha_hasta_raw) {
            $fecha_hoy = current_time('Y-m-d');
            $fecha_desde_raw = $fecha_hoy;
            $fecha_hasta_raw = $fecha_hoy;
        }

        // Si falta una de las dos, copiar de la otra
        if (!$fecha_desde_raw && $fecha_hasta_raw) {
            $fecha_desde_raw = $fecha_hasta_raw;
        }
        if ($fecha_desde_raw && !$fecha_hasta_raw) {
            $fecha_hasta_raw = $fecha_desde_raw;
        }

        // Formato de nombre de archivo: reporte_pedidos_d-m-Y.csv
        $fecha_desde = date('d-m-Y', strtotime($fecha_desde_raw));
        $fecha_hasta = date('d-m-Y', strtotime($fecha_hasta_raw));

        $nombre_archivo = 'reporte_pedidos';

        if ($fecha_desde === $fecha_hasta) {
            $nombre_archivo .= '_' . $fecha_desde;
        } else {
            $nombre_archivo .= '_desde_' . $fecha_desde . '_hasta_' . $fecha_hasta;
        }

        $nombre_archivo .= '.csv';

        $args = [
            'limit'  => -1,
            'status' => ['completed', 'processing'],
            'date_after'  => $fecha_desde_raw . ' 00:00:00',
            'date_before' => $fecha_hasta_raw . ' 23:59:59',
        ];

        $orders = wc_get_orders($args);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $nombre_archivo . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');

        // Añadir BOM para que Excel reconozca UTF-8
        fwrite($output, "\xEF\xBB\xBF");

        // Cabeceras
        fputcsv($output, [
            'Nombres', 'Apellidos', 'DNI', 'Teléfono', 'Correo', 'Fecha de nacimiento',
            'Dirección', 'Departamento', 'Provincia', 'Distrito', 'Códigos SKU',
            'Producto', 'Ingresos Brutos', 'Delivery', 'Fecha'
        ]);

        foreach ($orders as $order) {
            $user_id = $order->get_user_id();

            $first  = $order->get_billing_first_name();
            $last   = $order->get_billing_last_name();
            $email  = $order->get_billing_email();
            $dni    = $order->get_meta('additional_dni');
            $phone  = $order->get_meta('additional_phone');

            $fecha_nacimiento = get_field('acf_user_fdn', 'user_' . $user_id);

            $fecha_nac_formateada = '';
            if ($fecha_nacimiento) {
                $meses = [
                    'enero' => '01', 'febrero' => '02', 'marzo' => '03', 'abril' => '04',
                    'mayo' => '05', 'junio' => '06', 'julio' => '07', 'agosto' => '08',
                    'septiembre' => '09', 'octubre' => '10', 'noviembre' => '11', 'diciembre' => '12'
                ];
                $dia = $fecha_nacimiento['acf_user_fdn_date'] ?? '';
                $mes_nombre = strtolower($fecha_nacimiento['acf_user_fdn_mes'] ?? '');
                $anio = $fecha_nacimiento['acf_user_fdn_ano'] ?? '';
                $mes_numero = isset($meses[$mes_nombre]) ? $meses[$mes_nombre] : '00';
                $dia_formateado = str_pad($dia, 2, '0', STR_PAD_LEFT);
                $mes_formateado = str_pad($mes_numero, 2, '0', STR_PAD_LEFT);
                if ($dia && $anio && $mes_numero != '00') {
                    $fecha_nac_formateada = "{$dia_formateado}/{$mes_formateado}/{$anio}";
                }
            }

            $direccion = $order->get_billing_address_1();

            $departamento_id = $order->get_meta('_billing_departamento');
            $provincia_id    = $order->get_meta('_billing_provincia');
            $distrito_id     = $order->get_meta('_billing_distrito');

            $departamento = $wpdb->get_var($wpdb->prepare("SELECT departamento FROM {$prefix}ubigeo_departamento WHERE idDepa = %d", $departamento_id));
            $provincia    = $wpdb->get_var($wpdb->prepare("SELECT provincia FROM {$prefix}ubigeo_provincia WHERE idProv = %d", $provincia_id));
            $distrito     = $wpdb->get_var($wpdb->prepare("SELECT distrito FROM {$prefix}ubigeo_distrito WHERE idDist = %d", $distrito_id));

            $skus = [];
            $productos = [];
            foreach ($order->get_items() as $item) {
                if ($product = $item->get_product()) {
                    $skus[] = $product->get_sku();
                    $productos[] = $product->get_name();
                }
            }

            $skus_str      = implode(', ', $skus);
            $productos_str = implode(', ', $productos);
            $subtotal      = $order->get_subtotal();
            $shippingCost  = $order->get_shipping_total();

            // Ajustar a zona horaria de WordPress
            $fecha_obj = $order->get_date_created();
            $fecha_obj->setTimezone(new DateTimeZone(wp_timezone_string()));
            $fecha = $fecha_obj->format('d-m-Y');

            $distrito_final = ($departamento && $provincia) ? $distrito : '';

            fputcsv($output, [
                $first,
                $last,
                $dni,
                $phone,
                $email,
                $fecha_nac_formateada,
                $direccion,
                $departamento,
                $provincia,
                $distrito_final,
                $skus_str,
                $productos_str,
                $subtotal,
                $shippingCost,
                $fecha,
            ]);
        }

        fclose($output);
        exit;
    }
});


/*****************************************CUPON********************************* */
/*add_action('woocommerce_before_calculate_totals', 'eliminar_cupon_si_producto_en_oferta', 10, 1);
function eliminar_cupon_si_producto_en_oferta( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;

    if ( $cart->is_empty() ) return;

    // Verificar si algún producto está en oferta
    $hay_producto_en_oferta = false;
    foreach ( $cart->get_cart() as $cart_item ) {
        $producto = $cart_item['data'];
        if ( $producto->is_on_sale() ) {
            $hay_producto_en_oferta = true;
            break;
        }
    }

    // Si hay producto en oferta y existen cupones aplicados, removerlos
    if ( $hay_producto_en_oferta && !empty( $cart->get_applied_coupons() ) ) {
        foreach ( $cart->get_applied_coupons() as $coupon_code ) {
            $cart->remove_coupon( $coupon_code );
        }
        wc_add_notice( 'Los cupones han sido eliminados porque el carrito contiene productos en oferta.', 'notice' );
    }
}
*/

// 1. Aplica el descuento del cupón solo a productos con precio normal (no en oferta)
add_filter('woocommerce_coupon_get_discount_amount', 'descuento_solo_precio_normal', 10, 5);
function descuento_solo_precio_normal($discount, $discounting_amount, $cart_item, $single, $coupon) {
    // Cambia '15primera' por el código real de tu cupón
 //   if ($coupon->get_code() !== '15primera') {
   //     return $discount;
   // }

    $product = $cart_item['data'];
    $precio_regular = (float) $product->get_regular_price();
    $precio_actual = (float) $product->get_price();

    // No aplicar descuento si el producto está en oferta
    if ($precio_actual < $precio_regular) {
        return 0;
    }

    return $discount;
}

// 2. Elimina el cupón si todos los productos en el carrito están en oferta
add_action('woocommerce_before_calculate_totals', 'remover_cupon_si_todos_productos_en_oferta', 10, 1);
function remover_cupon_si_todos_productos_en_oferta( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
    if ( $cart->is_empty() ) return;

    $todos_en_oferta = true;

    foreach ( $cart->get_cart() as $cart_item ) {
        $producto = $cart_item['data'];
        if ( ! $producto->is_on_sale() ) {
            $todos_en_oferta = false;
            break;
        }
    }

    if ( $todos_en_oferta && !empty( $cart->get_applied_coupons() ) ) {
        foreach ( $cart->get_applied_coupons() as $coupon_code ) {
            $cart->remove_coupon( $coupon_code );
        }
        wc_add_notice( 'Los cupones han sido eliminados porque todos los productos están en oferta.', 'notice' );
    }
}

//SI NO HAY CARRITO CUPON SE ELIMINA
add_action('woocommerce_cart_updated', 'remover_cupon_si_carrito_vacio');
function remover_cupon_si_carrito_vacio() {
    $cart = WC()->cart;
    if ( $cart->is_empty() && !empty($cart->get_applied_coupons()) ) {
        foreach ( $cart->get_applied_coupons() as $coupon_code ) {
            $cart->remove_coupon($coupon_code);
        }
        //wc_add_notice('El cupón ha sido removido porque el carrito está vacío.', 'notice');
    }
}

//**********************************END CUPON ******************************************


//**********************************PACK ******************************************
add_action('wp_ajax_create_dynamic_pack', 'mosqueira_create_dynamic_pack');
add_action('wp_ajax_nopriv_create_dynamic_pack', 'mosqueira_create_dynamic_pack');
function mosqueira_create_dynamic_pack() {
    if (!isset($_POST['pack_items'])) {
        wp_send_json_error(['message' => 'No hay items.']);
    }

    $pack_items = json_decode(stripslashes($_POST['pack_items']), true);
    if (empty($pack_items)) {
        wp_send_json_error(['message' => 'Pack vacío.']);
    }

    $pack_title = 'Pack Básicos Mosqueira – ' . array_sum(array_column($pack_items, 'quantity')) . ' unidades';
    $price_total = 0;
    $description = '';

    foreach ($pack_items as $variation_id => $item) {
        $variation = new WC_Product_Variation($variation_id);
        if (!$variation || !$variation->exists()) continue;

        // Precio total por cantidad
        $price_total += floatval($variation->get_price()) * intval($item['quantity']);
        $description .= $item['title'] . ' - Talla: ' . $item['size'] . ' (x' . $item['quantity'] . ')' . PHP_EOL;
    }

    if ($price_total <= 0) {
        wp_send_json_error(['message' => 'Pack con precio inválido.']);
    }

    // Crear producto virtual pack
    $pack_product = new WC_Product();
    $pack_product->set_name($pack_title);
    $pack_product->set_status('publish');
    $pack_product->set_catalog_visibility('hidden');
    $pack_product->set_price($price_total);
    $pack_product->set_regular_price($price_total);
    $pack_product->set_description($description);
    $pack_product->set_virtual(true);
    $pack_product->set_sold_individually(true);
    $pack_product->save();

    // Guardar metadatos personalizados
    update_post_meta($pack_product->get_id(), '_is_custom_pack', true);
    update_post_meta($pack_product->get_id(), '_custom_pack_items', $pack_items);

    // Agregar al carrito
    WC()->cart->add_to_cart($pack_product->get_id());

    wp_send_json_success([
        'message' => 'Pack creado y agregado al carrito',
        'product_id' => $pack_product->get_id(),
        'total' => $price_total
    ]);
}
//**********************************END PACK ******************************************


//custom login
include_once 'inc/actions/login-custom.php';

//remove comments
include_once 'inc/actions/class-comments.php';
