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

//***********************************ADDDDDDDDDD *******************************/
//CUPON MENSAJE
add_filter( 'woocommerce_coupon_error', function( $err, $err_code, $coupon ) {
    if ( $err_code === WC_Coupon::E_WC_COUPON_NOT_APPLICABLE && $coupon->get_exclude_sale_items() ) {
        $err = 'Este cupón no puede usarse con productos en oferta.';
    }
    return $err;
}, 10, 3 );



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

//REPORTE USUARIOS
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
function mos_exportar_excel_reporte_pedido(){
    if (!current_user_can('manage_options')) return;

    if (isset($_GET['export_excel']) && $_GET['export_excel'] === '1') {
        if (ob_get_length()) ob_end_clean();

        global $wpdb;
        $prefix = $wpdb->prefix;

        require_once __DIR__ . '/vendor/autoload.php'; // Ajusta esta ruta si usas Composer

          // Obtener fechas del formulario
        $fecha_desde = isset($_GET['fecha_desde']) ? sanitize_text_field($_GET['fecha_desde']) : '';
        $fecha_hasta = isset($_GET['fecha_hasta']) ? sanitize_text_field($_GET['fecha_hasta']) : '';


        // Preparar nombre del archivo
        $nombre_archivo = 'reporte_pedidos';
        if ($fecha_desde || $fecha_hasta ) {
            
            $fecha_desde_raw = date('d-m-Y', strtotime($fecha_desde));
            $fecha_hasta_raw = date('d-m-Y', strtotime($fecha_hasta));

            if($fecha_desde && $fecha_hasta==""){
                $nombre_archivo .= '_' . $fecha_desde_raw;
            }else if($fecha_hasta && $fecha_desde=="" ){
                $nombre_archivo .= '_' . $fecha_hasta_raw;
            }else{
                $nombre_archivo .= '_desde_' . $fecha_desde_raw . '_hasta_' . $fecha_hasta_raw;
            }
        } else {
            $nombre_archivo .= '_completo';
        }
        $nombre_archivo .= '.xlsx';
        // Argumentos para obtener pedidos
        $args = [
            'limit'  => -1,
            'status' => ['completed', 'processing'],
        ];

        if($fecha_desde && $fecha_hasta){
            $args['date_after'] = $fecha_desde;
            $args['date_before'] =  $fecha_hasta;
        }else if($fecha_desde){
            $args['date_after'] = $fecha_desde;
            $args['date_before'] =  $fecha_desde;
        }else if($fecha_hasta){
            $args['date_after'] = $fecha_hasta;
            $args['date_before'] =  $fecha_hasta;
        }

        $orders = wc_get_orders($args);

        // Crear documento Excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados
        $headers = [
            'Nombres', 'Apellidos', 'DNI', 'Teléfono', 'Correo', 'Fecha de nacimiento', 'Dirección',
            'Departamento', 'Provincia', 'Distrito', 'Códigos SKU', 'Producto', 'Ingresos Brutos', 'Delivery', 'Fecha'
        ];
        $sheet->fromArray($headers, null, 'A1');

        $row = 2;

        foreach ($orders as $order) {
            $user_id = $order->get_user_id();
            $first = $order->get_billing_first_name();
            $last = $order->get_billing_last_name();
            $email = $order->get_billing_email();
            $dni = $order->get_meta('additional_dni');
            $phone = $order->get_meta('additional_phone');
            $fecha_nacimiento = get_field('acf_user_fdn', 'user_' . $user_id);
            $fecha_nac_formateada = '';

            if ($fecha_nacimiento) {
                $meses = [
                    'enero' => '01', 'febrero' => '02', 'marzo' => '03', 'abril' => '04', 'mayo' => '05', 'junio' => '06',
                    'julio' => '07', 'agosto' => '08', 'septiembre' => '09', 'octubre' => '10', 'noviembre' => '11', 'diciembre' => '12'
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
            $provincia_id = $order->get_meta('_billing_provincia');
            $distrito_id = $order->get_meta('_billing_distrito');

            $departamento = $wpdb->get_var($wpdb->prepare("SELECT departamento FROM {$prefix}ubigeo_departamento WHERE idDepa = %d", $departamento_id));
            $provincia = $wpdb->get_var($wpdb->prepare("SELECT provincia FROM {$prefix}ubigeo_provincia WHERE idProv = %d", $provincia_id));
            $distrito = $wpdb->get_var($wpdb->prepare("SELECT distrito FROM {$prefix}ubigeo_distrito WHERE idDist = %d", $distrito_id));

            $skus = [];
            $productos = [];
            foreach ($order->get_items() as $item) {
                if ($product = $item->get_product()) {
                    $skus[] = $product->get_sku();
                    $productos[] = $product->get_name();
                }
            }
            $skus_str = implode(', ', $skus);
            $productos_str = implode(', ', $productos);

            $subtotal = $order->get_subtotal();
            $shippingCost = $order->get_shipping_total();

            $fecha_obj = $order->get_date_created();
            if ($fecha_obj) {
                $fecha_obj->setTimezone(new DateTimeZone(wp_timezone_string()));
                $fecha = $fecha_obj->format('d-m-Y');
            } else {
                $fecha = '';
            }

            $distrito_final = ($departamento && $provincia) ? $distrito : '';

            $sheet->fromArray([
                $first, $last, $dni, $phone, $email, $fecha_nac_formateada, $direccion,
                $departamento, $provincia, $distrito_final, $skus_str, $productos_str,
                $subtotal, $shippingCost, $fecha
            ], null, "A{$row}");

            $row++;
        }

        // Enviar archivo Excel al navegador
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $nombre_archivo . '"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
add_action('admin_init', 'mos_exportar_excel_reporte_pedido');

//NEWSLETTER

function mos_exportar_excel_newsletter() {
	if (!current_user_can('manage_options') || !isset($_GET['exportar_newsletter'])) {
		return;
	}

	require_once __DIR__ . '/vendor/autoload.php'; // Ajusta si es necesario

	global $wpdb;
	$prefix = $wpdb->prefix;
	$tabla_newsletter = "{$prefix}newsletter";

	// Obtener todos los registros
	$registros = $wpdb->get_results("SELECT id, fecha, email FROM $tabla_newsletter ORDER BY id ASC");

	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();

	// Encabezados
	$headers = ['ID', 'Fecha', 'Email'];
	$sheet->fromArray($headers, NULL, 'A1');

	// Cargar datos
	$row = 2;
	foreach ($registros as $registro) {
		$sheet->fromArray([
			$registro->id,
			$registro->fecha,
			$registro->email
		], NULL, "A{$row}");
		$row++;
	}

	// Nombre del archivo
	$filename = 'newsletter-suscriptores-' . date('Y-m-d') . '.xlsx';

	// Enviar encabezados
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header("Content-Disposition: attachment;filename=\"$filename\"");
	header('Cache-Control: max-age=0');

	$writer = new Xlsx($spreadsheet);
	$writer->save('php://output');
	exit;
}

add_action('admin_init', 'mos_exportar_excel_newsletter');



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
    if (empty($_POST['pack_items'])) {
        wp_send_json_error(['message' => 'No hay items en el pack']);
    }

    $pack_items = json_decode(stripslashes($_POST['pack_items']), true);
    if (empty($pack_items)) {
        wp_send_json_error(['message' => 'Pack vacío']);
    }

    // Calcular cantidad total de productos
    $total_quantity = array_sum(array_column($pack_items, 'quantity'));

    // Tabla de precios por cantidad
    $price_table = [
        2 => 180.00,
        3 => 255.00,
        4 => 320.00,
        5 => 390.00,
        6 => 450.00,
    ];

    // Validar cantidad válida
    if (!isset($price_table[$total_quantity])) {
        wp_send_json_error(['message' => 'Cantidad no válida para pack (debe ser entre 2 y 6 productos).']);
    }

    $price_total = $price_table[$total_quantity];
    $pack_title = "Pack Básicos Mosqueira – {$total_quantity} unidades";

    $description = '';
    $image_urls = [];

    foreach ($pack_items as $variation_id => $item) {
        $variation = new WC_Product_Variation($variation_id);
        if (!$variation || !$variation->exists()) continue;

        $description .= $item['title'] . ' - Talla: ' . $item['size'] . ' (x' . $item['quantity'] . ')' . PHP_EOL;

        // Imagen de la variación o del producto padre
        $image_id = $variation->get_image_id();
        if (!$image_id) {
            $parent_product = wc_get_product($variation->get_parent_id());
            if ($parent_product) {
                $image_id = $parent_product->get_image_id();
            }
        }

        if ($image_id) {
            $image_urls[] = wp_get_attachment_image_url($image_id, 'thumbnail');
        }
    }

    if ($price_total <= 0) {
        wp_send_json_error(['message' => 'Pack con precio inválido']);
    }

    // Crear producto tipo pack (virtual, oculto)
    $pack_product = new WC_Product();
    $pack_product->set_name($pack_title);
    $pack_product->set_status('publish');
    $pack_product->set_catalog_visibility('hidden');
    $pack_product->set_price($price_total);
    $pack_product->set_regular_price($price_total);
    $pack_product->set_description('');
    $pack_product->set_virtual(false);
    $pack_product->set_sold_individually(true);

    // Crear collage de imágenes
    $thumbnail_id = mosqueira_create_pack_collage($image_urls);
    if ($thumbnail_id) {
        $pack_product->set_image_id($thumbnail_id);
    }

    $pack_product->save();
    $pack_product_id = $pack_product->get_id();

    // Guardar como pack personalizado
    update_post_meta($pack_product_id, '_is_custom_pack', 'yes');
    update_post_meta($pack_product_id, '_custom_pack_items', $pack_items);
    update_post_meta($pack_product_id, '_custom_pack_images', $image_urls);
    update_post_meta($pack_product_id, '_visibility', 'hidden');

    // Asegurar carrito disponible
    if (WC()->cart === null) {
        WC()->cart = new WC_Cart();
    }

    // Agregar al carrito
    $added = WC()->cart->add_to_cart($pack_product_id, 1, 0, [], [
        '_custom_pack_items' => $pack_items,
    ]);

    if (!$added) {
        wp_send_json_error(['message' => 'Error al agregar el pack al carrito']);
    }

    wp_send_json_success([
        'message' => 'Pack creado y agregado al carrito',
        'product_id' => $pack_product_id,
        'total_items' => WC()->cart->get_cart_contents_count(),
    ]);
}

//AQUI SE AÑADE AL CART
add_action('wp_ajax_get_custom_mini_cart', 'get_custom_mini_cart_callback');
add_action('wp_ajax_nopriv_get_custom_mini_cart', 'get_custom_mini_cart_callback');

function get_custom_mini_cart_callback() {
    ob_start();
    include get_stylesheet_directory() . '/partials/cart/cart.php';
    $html = ob_get_clean();
    wp_send_json_success([
        'html' => $html,
    ]);
}
//END AQUI SE AÑADE AL CART


add_action('woocommerce_checkout_create_order_line_item', function($item, $cart_item_key, $values, $order) {
    if (isset($values['_custom_pack_items'])) {
        $item->add_meta_data('_custom_pack_items', $values['_custom_pack_items']);
    }
}, 10, 4);


add_filter('woocommerce_order_item_name', 'mostrar_pack_con_precio_y_detalles', 10, 3);
function mostrar_pack_con_precio_y_detalles($product_name, $item, $is_visible) {
    $pack_items = $item->get_meta('_custom_pack_items', true);

    if (!empty($pack_items) && is_array($pack_items)) {
        $pack_product = $item->get_product();

        // Nombre del pack (sin enlace para no envolver toda la tabla)
        $pack_name = $pack_product ? $pack_product->get_name() : $product_name;
        $pack_name = '<a style="color: #3c434a;">' . $pack_name . '</a>';

        $html = '<table style="width:100%; border-collapse: collapse; margin-top:10px;">';
        $html .= '<thead><tr><th colspan="2">Producto</th><th>Cantidad</th></tr></thead>';
        $html .= '<tbody>';

        foreach ($pack_items as $variation_id => $item_data) {
            $product = wc_get_product($variation_id);
            if ($product) {
                $image_id = $product->get_image_id();
                $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');

                $title = isset($item_data['title']) ? esc_html($item_data['title']) : $product->get_name();
                $quantity = isset($item_data['quantity']) ? intval($item_data['quantity']) : 1;

                // ID para editar (padre si es variación)
                $edit_id = $product->is_type('variation') ? $product->get_parent_id() : $product->get_id();
                $product_url = admin_url('post.php?post=' . $edit_id . '&action=edit');

                // SKU (variación o simple)
                $sku = $product->get_sku();

                // ID variación o producto
                $product_id = $product->get_id();

                // Obtener talla (para variación)
                $talla = '';
                if ($product->is_type('variation')) {
                    $variation_data = $product->get_variation_attributes();
                    foreach ($variation_data as $attr_name => $attr_value) {
                        if (strpos($attr_name, 'pa_talla') !== false || strpos($attr_name, 'pa_size') !== false) {
                            $talla = ucfirst($attr_value);
                            break;
                        }
                    }
                }

                // Nombre + talla en una línea
                $title_con_talla = $title;
                if (!empty($talla)) {
                    $title_con_talla .= ' - ' . $talla;
                }

                $html .= '<tr style="border-bottom: 1px solid #ddd;">';

                // Imagen
                $html .= '<td style="padding:5px; vertical-align: middle; width:60px;">';
                if ($image_url) {
                    $html .= '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($title) . '" style="max-width:50px; height:auto; vertical-align: middle;" />';
                }
                $html .= '</td>';

                // Producto con toda la info
                $html .= '<td style="padding:5px; vertical-align: middle; font-size: 14px; line-height: 1.3;">';
                $html .= '<a href="' . esc_url($product_url) . '">' . $title_con_talla . '</a><br>';
                $html .= '<div class="wc-order-item-sku"><strong>SKU:</strong> ' . esc_html($sku) . '</div>';
                $html .= '<div class="wc-order-item-variation"><strong> ID de la variación: </strong>' . esc_html($product_id) . '</div>';                
                if (!empty($talla)) {           
                    $html .= '<div class="view">
                        <table cellspacing="0" class="display_meta">
                            <tbody>
                                <tr>
                                    <th>Talla:</th>
                                    <td><p>'.esc_html($talla).'</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>';
                }
                $html .= '</td>';
                // Cantidad
                $html .= '<td style="padding:5px; text-align:center; vertical-align: middle; width:50px;">' . $quantity . '</td>';

                $html .= '</tr>';
            }
        }

        $html .= '</tbody></table>';

        return $pack_name . $html;
    }

    return $product_name;
}





add_filter( 'woocommerce_admin_order_item_class', 'mosqueira_agregar_clase_pack_a_fila_admin', 10, 2 );
function mosqueira_agregar_clase_pack_a_fila_admin( $class, $item ) {
    $product = $item->get_product();
    if ( ! $product ) {
        return $class;
    }
    $is_pack = $item->get_meta('_is_custom_pack', true);
    if ( $is_pack === 'yes' || $is_pack === true || $is_pack === '1' || $is_pack === 1 ) {
        $class .= ' pack-item';  // añade clase sin sobreescribir lo anterior
    }
    return $class;
}


//NO MUESTRA PACK REST API POST TYPE PRODUCT
add_filter('rest_product_query', function($args, $request) {
    if (!isset($args['meta_query']) || !is_array($args['meta_query'])) {
        $args['meta_query'] = [];
    }
    // Excluir productos con _is_custom_pack = true o 'yes'
    $args['meta_query'][] = [
        'relation' => 'OR',
        [
            'key'     => '_is_custom_pack',
            'compare' => 'NOT EXISTS',
        ],
        [
            'key'     => '_is_custom_pack',
            'value'   => 'yes',
            'compare' => '!=',
        ],
        // [
            //   'key'     => '_is_custom_pack',
            //  'value'   => 'true',
            // 'compare' => '!=',
        //],
    ];
    return $args;
}, 10, 2);

//NO MUESTRA PACK EN EL ADMIN POST TYPE PRODUCT
add_action('pre_get_posts', function($query) {
    // Aplica solo en el admin, en la lista de productos
    if (is_admin() && $query->is_main_query() && $query->get('post_type') === 'product') {
        $meta_query = $query->get('meta_query', []);

        $meta_query[] = [
            'relation' => 'OR',
            [
                'key'     => '_is_custom_pack',
                'compare' => 'NOT EXISTS',
            ],
            [
                'key'     => '_is_custom_pack',
                'value'   => 'yes',
                'compare' => '!=',
            ],
           // [
             //   'key'     => '_is_custom_pack',
              //  'value'   => 'true',
               // 'compare' => '!=',
            //],
        ];

        $query->set('meta_query', $meta_query);
    }
});

//GENERA COLLAGE DE PRODUCTO PARA EL PACK IMAGEN DESTACADO
function mosqueira_create_pack_collage($image_urls = []) {
    if (empty($image_urls)) return false;

    $image_urls = array_filter($image_urls, function($url) {
        return !empty($url) && filter_var($url, FILTER_VALIDATE_URL);
    });

    $count = count($image_urls);
    if ($count === 0) return false;

    $size = 400; // tamaño total del collage (px)
    
    // Calcular filas y columnas para acomodar todas las imágenes
    $cols = ceil(sqrt($count));
    $rows = ceil($count / $cols);

    $thumb_width = intval($size / $cols);
    $thumb_height = intval($size / $rows);

    // Crear lienzo en blanco
    $collage = imagecreatetruecolor($size, $size);
    $background = imagecolorallocate($collage, 255, 255, 255); // blanco
    imagefill($collage, 0, 0, $background);

    foreach ($image_urls as $index => $url) {
        if ($index >= $cols * $rows) break; // no dibujar más de la cantidad que cabe

        $img = mosqueira_load_image_from_url($url);
        if (!$img) continue;

        // Obtener tamaño original
        $orig_w = imagesx($img);
        $orig_h = imagesy($img);

        // Calcular escala para que quepa dentro del cuadro sin recortar
        $scale = min($thumb_width / $orig_w, $thumb_height / $orig_h);

        $new_w = intval($orig_w * $scale);
        $new_h = intval($orig_h * $scale);

        $resized = imagecreatetruecolor($new_w, $new_h);

        // Mantener transparencia si PNG/GIF
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
        imagefill($resized, 0, 0, $transparent);

        imagecopyresampled($resized, $img, 0, 0, 0, 0, $new_w, $new_h, $orig_w, $orig_h);

        // Calcular posición centrada en el espacio asignado
        $x = ($index % $cols) * $thumb_width + intval(($thumb_width - $new_w) / 2);
        $y = floor($index / $cols) * $thumb_height + intval(($thumb_height - $new_h) / 2);

        imagecopy($collage, $resized, $x, $y, 0, 0, $new_w, $new_h);

        imagedestroy($resized);
        imagedestroy($img);
    }

    // Guardar imagen como JPEG en uploads
    $upload_dir = wp_upload_dir();
    $filename = 'collage_pack_' . uniqid() . '.jpg';
    $filepath = trailingslashit($upload_dir['path']) . $filename;

    imagejpeg($collage, $filepath, 90); // Calidad 90
    imagedestroy($collage);

    // Añadir imagen a la biblioteca de medios
    $filetype = wp_check_filetype($filename, null);
    $attachment = [
        'post_mime_type' => $filetype['type'],
        'post_title'     => sanitize_file_name($filename),
        'post_content'   => '',
        'post_status'    => 'inherit',
    ];

    $attach_id = wp_insert_attachment($attachment, $filepath);
    require_once ABSPATH . 'wp-admin/includes/image.php';
    $attach_data = wp_generate_attachment_metadata($attach_id, $filepath);
    wp_update_attachment_metadata($attach_id, $attach_data);

    return $attach_id;
}
function mosqueira_load_image_from_url($url) {
    $image_data = @file_get_contents($url);
    if (!$image_data) {
        error_log("No se pudo descargar la imagen: $url");
        return false;
    }

    $image = @imagecreatefromstring($image_data);
    if (!$image) {
        error_log("No se pudo crear imagen desde datos binarios: $url");
        return false;
    }

    return $image;
}

//**********************************END PACK ******************************************

//**********************************GENERA URL AMIGABLE PARA PACK ******************************************
function reglas_rewrite_packs() {
    add_rewrite_rule(
        '^packs/([^/]+)/?$',
        'index.php?page_id=1317&filter=$matches[1]',
        'top'
    );
}
add_action('init', 'reglas_rewrite_packs');
function agregar_query_vars_packs($vars) {
    $vars[] = 'filter';
    return $vars;
}
add_filter('query_vars', 'agregar_query_vars_packs');

//**********************************END GENERA URL AMIGABLE PARA PACK ******************************************

// Redirige después del login según el rol
add_filter( 'login_redirect', 'redirect_after_login_by_role', 10, 3 );
function redirect_after_login_by_role( $redirect_to, $request, $user ) {
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        if ( in_array( 'administrator', $user->roles, true ) ) {
            return admin_url(); // Administradores al wp-admin
        } else {
            return home_url('mi-cuenta/perfil'); // Otros al panel de perfil
        }
    }
    return $redirect_to;
}

// Bloquea acceso a /wp-admin a quienes no son administradores
add_action( 'admin_init', 'restrict_wp_admin_access_to_admins' );
function restrict_wp_admin_access_to_admins() {
    if ( ! current_user_can( 'administrator' ) && ! wp_doing_ajax() ) {
        wp_redirect( home_url('mi-cuenta/perfil') );
        exit;
    }
}


//custom login
include_once 'inc/actions/login-custom.php';

//remove comments
include_once 'inc/actions/class-comments.php';
