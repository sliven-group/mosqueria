<?php
add_action('wp_ajax_search_product', 'search_product_handler');
add_action('wp_ajax_nopriv_search_product', 'search_product_handler');

function search_product_handler() {
    $result = [
        'status'   => false,
        'html'     => '',
        'page'     => 1,
        'message'  => '',
        'enabled'  => true,
        'has_more' => false,
    ];

    // Validar nonce
    $nonce = $_POST['nonce'] ?? '';
    if (!wp_verify_nonce($nonce, 'ws-nonce')) {
        wp_send_json_error('No se tiene permisos para acceder!', 401);
    }

    $original_search = sanitize_text_field($_POST['search'] ?? '');
    $corrected_search = corregir_palabra_clave($original_search);
    $search_term = $original_search ?: $corrected_search;

    $page = max(1, absint($_POST['page'] ?? 1));
    $limit = 5;
    $fetch_limit = $limit * 2;
    $offset = ($page - 1) * $limit;

    // Preparar argumentos base
    $base_args = [
        'orderby'    => 'date',
        'order'      => 'DESC',
        'visibility' => 'visible',
        'limit'      => $fetch_limit,
        'offset'     => $offset,
    ];

    // Obtener categorías relacionadas
    $slugs_hombre = obtener_subcategorias_por_like($search_term, 'hombres');
    $slugs_mujer  = obtener_subcategorias_por_like($search_term, 'mujeres');
    $slugs_padre  = obtener_categorias_padre_por_like($search_term);

    $usar_busqueda_textual = (empty($slugs_hombre) && empty($slugs_mujer) && empty($slugs_padre));

    // Preparar argumentos de consulta
    list($args_hombre, $args_mujer) = preparar_argumentos_consulta($slugs_hombre, $slugs_mujer, $slugs_padre, $usar_busqueda_textual, $corrected_search, $base_args);

    // Consultar productos
    $productos_hombre = !empty($args_hombre) ? (new WC_Product_Query($args_hombre))->get_products() : [];
    $productos_mujer  = !empty($args_mujer)  ? (new WC_Product_Query($args_mujer))->get_products()  : [];

    // Intercalar
    $productos_intercalados = intercalar_productos($productos_hombre, $productos_mujer);
    $productos_final = array_slice($productos_intercalados, 0, $limit);

    if (!empty($productos_final)) {
        ob_start();
        foreach ($productos_final as $product) {
            $template = get_stylesheet_directory() . '/partials/product/product-item.php';
            if (file_exists($template)) {
                include $template;
            }
        }
        $html = ob_get_clean();

        $result['status'] = true;
        $result['html'] = $html;
        $result['page'] = $page;
        $result['has_more'] = count($productos_intercalados) > $limit;
        $result['message'] = 'Resultados cargados.';
    } else {
        $result['message'] = 'No se encontraron productos.';
    }

    wp_send_json($result);
}


// ===============================
// FUNCIONES HELPER
// ===============================

function corregir_palabra_clave($search) {
    $correcciones = [
        'polad' => 'polo',
        'polanco' => 'polo',
        'plos' => 'polo',
        'camisetaa' => 'camiseta',
        'zapatoz' => 'zapato',
        'tejidoz' => 'tejido',
        // Agrega más si es necesario
    ];

    $search = strtolower(trim($search));
    foreach ($correcciones as $incorrecto => $correcto) {
        if (levenshtein($search, $incorrecto) <= 2) {
            return $correcto;
        }
    }
    return $search;
}

function obtener_subcategorias_por_like($search_term, $parent_slug) {
    $parent = get_term_by('slug', $parent_slug, 'product_cat');
    if (!$parent) return [];

    $terms = new WP_Term_Query([
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'parent'     => $parent->term_id,
        'name__like' => $search_term,
    ]);

    return wp_list_pluck($terms->terms ?? [], 'slug');
}

function obtener_categorias_padre_por_like($search_term) {
    $terms = new WP_Term_Query([
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'parent'     => 0,
        'name__like' => $search_term,
    ]);

    return wp_list_pluck($terms->terms ?? [], 'slug');
}

function preparar_argumentos_consulta($slugs_hombre, $slugs_mujer, $slugs_padre, $usar_busqueda_textual, $search_term, $base_args) {
    $args_hombre = [];
    $args_mujer = [];

    if (!empty($slugs_padre)) {
        $otras_categorias = array_diff($slugs_padre, ['hombres', 'mujeres']);

        if (in_array('hombres', $slugs_padre)) {
            $args_hombre = $base_args;
            $args_hombre['category'] = ['hombres'];
        }

        if (in_array('mujeres', $slugs_padre)) {
            $args_mujer = $base_args;
            $args_mujer['category'] = ['mujeres'];
        }

        if (!empty($otras_categorias)) {
            $args_hombre = $base_args;
            $args_hombre['category'] = $otras_categorias;
            $args_mujer = [];
        }

    } elseif ($usar_busqueda_textual) {
        $args_hombre = $base_args;
        $args_mujer  = $base_args;

        $args_hombre['s'] = $search_term;
        $args_hombre['category'] = ['hombres'];

        $args_mujer['s'] = $search_term;
        $args_mujer['category'] = ['mujeres'];

    } else {
        if (!empty($slugs_hombre)) {
            $args_hombre = $base_args;
            $args_hombre['category'] = $slugs_hombre;
        }

        if (!empty($slugs_mujer)) {
            $args_mujer = $base_args;
            $args_mujer['category'] = $slugs_mujer;
        }
    }

    return [$args_hombre, $args_mujer];
}

function intercalar_productos($arr1, $arr2) {
    $result = [];
    $len1 = count($arr1);
    $len2 = count($arr2);
    $max_len = max($len1, $len2);
    for ($i = 0; $i < $max_len; $i++) {
        if ($i < $len1) $result[] = $arr1[$i];
        if ($i < $len2) $result[] = $arr2[$i];
    }
    return $result;
}
