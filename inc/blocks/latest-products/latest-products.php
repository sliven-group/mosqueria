<?php
/**
 * Latest products block template.
 *
 * @param array $block The block settings and attributes.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'mos__block__lp';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$title = get_field('acf_block_lp_title');
$products = get_field('acf_block_lp_products');
?>
<?php if( $title ) : ?>
	<section <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
		<div class="mos__container">
			<h2 class="text-center upper"><?php echo $title; ?></h2>
			<div class="mos__wrap">
				<?php if( $products ): ?>
					<div class="ds-grid ds-grid__col4 ds-grid__gap40">
						<?php foreach( $products as $product ): ?>
						<?php
							$pathContentProduct = get_stylesheet_directory() . '/partials/product/product-item.php';
							if ( file_exists($pathContentProduct) ) {
								setup_postdata($product);
								$product = wc_get_product($product->ID);
								include $pathContentProduct;
							}
						?>
						<?php endforeach; ?>
					</div>
				<?php wp_reset_postdata(); ?>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
