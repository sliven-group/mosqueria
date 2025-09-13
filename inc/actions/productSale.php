<?php
add_action('wp_ajax_load_more_product_sale', 'load_more_product_sale');
add_action('wp_ajax_nopriv_load_more_product_sale', 'load_more_product_sale');

function load_more_product_sale() {
	$result = [
		'status' => false,
		'html' => '',
		'page' => 1,
		'message' => '',
		'enabled' => true
	];

	$pagination = PER_PAGE;
	$page = isset($_POST['page']) ? max(1, (int) sanitize_text_field($_POST['page'])) : 1;
	$nextPage = $page + 1;
	$offset = ($nextPage * $pagination) - $pagination;

$args = array(
	'post_type'      => 'product',
	'posts_per_page' => $pagination,
	'offset'         => $offset,
	'post_status'    => 'publish',
	'meta_query'     => [
		[
			'key'     => 'acf_ps_desc',
			'value'   => '1',
			'compare' => '=',
			'type'    => 'CHAR',
		]
	],
	'fields' => 'ids'
);

$query = new WP_Query($args);
$unique_ids = array_unique($query->posts); // Evitar duplicados por seguridad
$products = wc_get_products(['include' => $unique_ids]);

if ( $products ) {
	foreach ( $products as $product ) {
		$path = get_stylesheet_directory() . '/partials/product/product-item.php';
		if (file_exists($path)) {
			ob_start();
			include $path;
			$result['html'] .= ob_get_clean();
		}
	}
	wp_reset_postdata();

	$result['status']  = true;
	$result['message'] = 'Realizado';
	$result['page']    = $nextPage;
	$result['enabled'] = $nextPage < $query->max_num_pages;
} else {
	$result['message'] = 'No se encontraron productos';
	$result['enabled'] = false;
}

wp_send_json( $result );
}
