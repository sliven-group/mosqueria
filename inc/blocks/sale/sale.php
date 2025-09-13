<?php
/**
 * Sale block template.
 *
 * @param array $block The block settings and attributes.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'mos__block__sale';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}


// Load values and assign defaults.
$countItem = PER_PAGE;
$args = [
	'post_type'      => 'product',
	'posts_per_page' => $countItem,
	'post_status'	 => 'publish',
	'meta_query'     => [
		[
			'key'     => 'acf_ps_desc',
			'value'   => '1',
			'compare' => '=',
			'type'    => 'CHAR',
		]
	],
	'fields' => 'ids'
];

$query = new WP_Query($args);
$unique_ids = array_unique($query->posts); // Evitar duplicados por seguridad
$products = wc_get_products(['include' => $unique_ids]);

?>
<?php if ( $products ) : ?>
	<section <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
		<div class="mos__container">
			<div id="mos-sale-product" class="ds-grid ds-grid__col4 ds-grid__gap40">
				<?php foreach ( $products as $product ) : ?>
					<?php
						$pathContentProduct = get_stylesheet_directory() . '/partials/product/product-item.php';
						if ( file_exists($pathContentProduct) ) {
							include $pathContentProduct;
						}
					?>
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>
			</div>
			<button id="mos-load-more-sale" class="mos__btn mos__btn--primary <?php echo $query->found_posts < $countItem ? 'ds-none' : ''; ?>" data-page="1">MOSTRAR MÁS</button>
		</div>
	</section>
<?php endif; ?>
