<?php
add_action('wp_ajax_get_related_atribute_products', 'get_related_atribute_products');
add_action('wp_ajax_nopriv_get_related_atribute_products', 'get_related_atribute_products');

add_action('wp_ajax_get_product_by_order', 'get_product_by_order');
add_action('wp_ajax_nopriv_get_product_by_order', 'get_product_by_order');

add_action('wp_ajax_load_more_product_post', 'load_more_product_post');
add_action('wp_ajax_nopriv_load_more_product_post', 'load_more_product_post');

function get_related_atribute_products() {
	$result = [
		'status' => false,
		'html' => '',
		'page' => 1,
		'message' => '',
		'enabled' => true
	];

	// Para arrays como colores y tallas, aplicamos strtolower a cada elemento
$colores = isset($_POST['colores']) ? array_map('strtolower', array_map('sanitize_text_field', $_POST['colores'])) : [];
$tallas  = isset($_POST['tallas']) ? array_map('strtolower', array_map('sanitize_text_field', $_POST['tallas'])) : [];

// Para textos simples como orden y category, solo usamos strtolower
$orden   = strtolower(sanitize_text_field($_POST['orden']));
$category = strtolower(sanitize_text_field($_POST['category']));
	$pagination = PER_PAGE;
	$page = 0;
	$nextPage = $page + 1;
	$offset = ($nextPage * $pagination) - $pagination;
	$tax_query = ['relation' => 'AND'];

	if (!empty($category)) {
		$tax_query[] = [
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => $category,
		];
	}
	if (!empty($colores)) {
		$tax_query[] = [
			'taxonomy' => 'pa_color',
			'field'    => 'slug',
			'terms'    => $colores,
		];
	}
	if (!empty($tallas)) {
		$tax_query[] = [
			'taxonomy' => 'pa_talla',
			'field'    => 'slug',
			'terms'    => $tallas,
		];
	}

	$args = [
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => $pagination,
		'offset'         => $offset,			
		//'orderby'				 => 'title',
		//'order'					 => !empty($orden) ? $orden : 'ASC',
		'meta_key'       => '_price',
		'orderby'        => 'meta_value_num',
		'order'          => $orden,
		'tax_query'      => $tax_query,
		'meta_query'     => [
			'relation' => 'OR',
			[
				'key'     => 'acf_ps_desc',
				'value'   => '0',
				'compare' => '=',
				'type'    => 'CHAR',
			],
			[
				'key'     => 'acf_ps_desc',
				'compare' => 'NOT EXISTS',
			]
		],
		'fields' => 'ids'
	];

	$query = new WP_Query($args);

	if ( $query ) {
		$products_found = false;
		while ( $query->have_posts() ) {
			$query->the_post();
			$product = wc_get_product( get_the_ID() );

			$has_stock = true;

			// Solo validar stock en tallas si hay filtro de tallas
			if ( $product->is_type('variable') && !empty($tallas) ) {
				$variations = $product->get_available_variations();
				$has_matching_talla = false;

				foreach ( $variations as $variation ) {
					$attributes = $variation['attributes'];
					$variation_stock = $variation['is_in_stock'];

					$matches_talla = in_array($attributes['attribute_pa_talla'] ?? '', $tallas);

					if ( $matches_talla && $variation_stock ) {
						$has_matching_talla = true;
						break;
					}
				}

				// Si no hay ninguna variación de la talla con stock, excluir
				if ( !$has_matching_talla ) {
					$has_stock = false;
				}
			}

			// Solo mostrar si pasa la validación
			if ( $has_stock ) {
				$path = get_stylesheet_directory() . '/partials/product/product-item.php';
				if (file_exists($path)) {
					ob_start();
					include $path;
					$result['html'] .= ob_get_clean();
					$products_found = true;
				}
			}
		}
		if ( $products_found ) {
			$result['status'] = true;
			$result['message'] = 'Realizado';
			$result['page'] = $nextPage;
			$result['enabled'] = $nextPage < $query->max_num_pages;
		} else {
			//$result['message'] = 'No se encontraron productos con stock disponible';
			$result['message'] = 'No se encontraron resultados';
			$result['enabled'] = false;
		}
	} else {
		$result['message'] = 'No se encontraron resultados';
		$result['enabled'] = false;
	}
	wp_reset_postdata();
	wp_send_json_success($result);
}

function get_product_by_order() {
	$result = [
		'status' => false,
		'html' => '',
		'page' => 1,
		'message' => '',
		'enabled' => true
	];

	$orden    = strtolower(sanitize_text_field($_POST['orden']));
    $category = strtolower(sanitize_text_field($_POST['category']));
	$pagination = PER_PAGE;
	$page = 0;
	$nextPage = $page + 1;
	$offset = ($nextPage * $pagination) - $pagination;

	if (!empty($category)) {
		$tax_query[] = [
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => $category,
		];
	}
	if($orden=="all"){
		$args = [
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => $pagination,
			'offset'         => $offset,
			'orderby'					=> 'title',
			'order'					 	=> 'ASC',
		//	'meta_key'       => '_price',
		//	'orderby'        => 'meta_value_num',
		//	'order'          => $orden,

			'tax_query'      => $tax_query,
			'meta_query'     => [
				'relation' => 'OR',
				[
					'key'     => 'acf_ps_desc',
					'value'   => '0',
					'compare' => '=',
					'type'    => 'CHAR',
				],
				[
					'key'     => 'acf_ps_desc',
					'compare' => 'NOT EXISTS',
				]
			],
			'fields' 				 => 'ids'
		];
	}else{
		$args = [
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => $pagination,
			'offset'         => $offset,

			'meta_key'       => '_price',
			'orderby'        => 'meta_value_num',
			'order'          => $orden,

			'tax_query'      => $tax_query,
			'meta_query'     => [
				'relation' => 'OR',
				[
					'key'     => 'acf_ps_desc',
					'value'   => '0',
					'compare' => '=',
					'type'    => 'CHAR',
				],
				[
					'key'     => 'acf_ps_desc',
					'compare' => 'NOT EXISTS',
				]
			],
			'fields' 				 => 'ids'
		];
	}
	$query = new WP_Query($args);

	//print_r($query);

	if ( $query ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$product = wc_get_product( get_the_ID() );
			$path = get_stylesheet_directory() . '/partials/product/product-item.php';
			if (file_exists($path)) {
				ob_start();
				include $path;
				$result['html'] .= ob_get_clean();
			}
		}
		$result['status'] = true;
		$result['message'] = 'Realizado';
		$result['page'] = $nextPage;
		$result['enabled'] = $nextPage < $query->max_num_pages;
	} else {
		$result['message'] = 'No se encontraron resultados';
		$result['enabled'] = false;
	}

	wp_reset_postdata();
	wp_send_json($result);
}

function load_more_product_post() {
	$result = [
		'status' => false,
		'html' => '',
		'page' => 1,
		'message' => '',
		'enabled' => true
	];

	$colores = isset($_POST['colores']) ? array_map('strtolower', array_map('sanitize_text_field', $_POST['colores'])) : [];
	$tallas  = isset($_POST['tallas']) ? array_map('strtolower', array_map('sanitize_text_field', $_POST['tallas'])) : [];
	$orden   = isset($_POST['orden']) ? strtolower(sanitize_text_field($_POST['orden'])) : 'all';
	$category = strtolower(sanitize_text_field($_POST['category_id']));
	$get_post = isset($_POST['get_post']) ? $_POST['get_post'] : '';

	$order = strtoupper($orden);
	$order = in_array($order, ['ASC', 'DESC']) ? $order : 'all';

	$pagination = PER_PAGE;
	$page = isset($_POST['page']) ? max(1, (int) sanitize_text_field($_POST['page'])) : 1;
	$nextPage = $page + 1;
	$offset = ($nextPage * $pagination) - $pagination;

	$alreadyDisplayeds_ = [];
	$explode_array = explode(",", $get_post);
	foreach ($explode_array as $value) {
		$alreadyDisplayeds_[] = intval($value);
	}

	$tax_query = ['relation' => 'AND'];

	if (!empty($category)) {
		$tax_query[] = [
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => $category,
		];
	}

	if (!empty($colores)) {
		$tax_query[] = [
			'taxonomy' => 'pa_color',
			'field'    => 'slug',
			'terms'    => $colores,
		];
	}

	if (!empty($tallas)) {
		$tax_query[] = [
			'taxonomy' => 'pa_talla',
			'field'    => 'slug',
			'terms'    => $tallas,
		];
	}
	if($order=="all"){
		
			
		$args = [
			'post_type'      => 'product',
			'posts_per_page' => $pagination,
			'offset'         => $offset,
			'post_status'    => 'publish',
			'orderby'					=> 'title',
			'order'					 	=> 'ASC',
			'tax_query'      => $tax_query,
			'meta_query'     => [
				'relation' => 'OR',
				[
					'key'     => 'acf_ps_desc',
					'value'   => '0',
					'compare' => '=',
					'type'    => 'CHAR',
				],
				[
					'key'     => 'acf_ps_desc',
					'compare' => 'NOT EXISTS',
				]
			],
			'fields' => 'ids'
		];


	}else{
		$args = [
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => $pagination,
			'offset'         => $offset,
			'meta_key'       => '_price',
			'orderby'        => 'meta_value_num',
			'order'          => $order,
			'tax_query'      => $tax_query,
			'meta_query'     => [
				'relation' => 'AND',
				[
					'relation' => 'OR',
					[
						'key'     => 'acf_ps_desc',
						'value'   => '0',
						'compare' => '=',
						'type'    => 'CHAR',
					],
					[
						'key'     => 'acf_ps_desc',
						'compare' => 'NOT EXISTS',
					]
				]
			],
			'post__not_in'   => $alreadyDisplayeds_,
			'fields'         => 'ids'
		];

	}

	$query = new WP_Query($args);

	if ( $query && $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$product = wc_get_product( get_the_ID() );
			$path = get_stylesheet_directory() . '/partials/product/product-item.php';
			if (file_exists($path)) {
				ob_start();
				include $path;
				$result['html'] .= ob_get_clean();
			}
		}
		$result['status'] = true;
		$result['message'] = 'Realizado';
		$result['page'] = $nextPage;
		$result['alreadyDisplayeds_'] = $alreadyDisplayeds_;
		$result['enabled'] = $nextPage < $query->max_num_pages;
		$result['order'] = $order;
		$result['arg'] = $args;
		$result['get_post'] = $get_post;
		$result['offset'] = $offset;
		//$get_post
		//$offset

	} else {
		$result['message'] = 'No se encontraron resultados';
		$result['enabled'] = false;
	}

	wp_reset_postdata();
	wp_send_json($result);
}
