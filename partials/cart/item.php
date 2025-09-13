<?php
	$product = $cart_item['data'];
	$product_id = $cart_item['product_id'];
	$quantity = $cart_item['quantity'];
	$variation_id = $cart_item['variation_id'];
	$talla = '';
	$color = '';
	if ( ! empty( $cart_item['variation'] ) ) {
		if ( isset( $cart_item['variation']['attribute_pa_talla'] ) ) {
			$talla = $cart_item['variation']['attribute_pa_talla'];
		}
	}

	// Color ahora viene desde cart_item_data personalizado
	if ( isset( $cart_item['pa_color'] ) ) {
		$color = $cart_item['pa_color'];
	} elseif ( $product->is_type( 'simple' ) ) {
		$attributes = $product->get_attributes();
		if ( isset( $attributes['pa_talla'] ) ) {
			$terms = wc_get_product_terms( $product_id, 'pa_talla', array( 'fields' => 'names' ) );
			$talla = ! empty( $terms ) ? $terms[0] : '';
		}
		if ( isset( $attributes['pa_color'] ) ) {
			$terms = wc_get_product_terms( $product_id, 'pa_color', array( 'fields' => 'names' ) );
			$color = ! empty( $terms ) ? $terms[0] : '';
		}
	}
	$name = $product->get_name();
	$sale = $product->get_sale_price();
	$regular = $product->get_regular_price();
	$currency = get_woocommerce_currency_symbol();
	$image = $product->get_image(array( 140, 140 ));
	$image_id  = $product->get_image_id();
	$image_url = wp_get_attachment_image_url( $image_id, 'full' );
	$product_link = get_permalink($product_id);
	//$product_cart_id = wc()->cart->generate_cart_id( $product_id );
	//$in_cart = $cart->find_product_in_cart( $product_cart_id );
?>
<li class="cart__item ds-flex justify-space-between">
	<a href="<?php echo esc_url($product_link); ?>" class="image">
		<?php echo '<img style="height: 180px;object-fit: cover;object-position: top;" src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $name ) . '" width="140" height="140" />'; ?>
	</a>
	<div class="info relative">
		<button data-key="<?php echo $cart_item_key; ?>" class="delete-cart-product">
			<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M7 7H5V13H7V7Z" fill="black"/>
				<path d="M11 7H9V13H11V7Z" fill="black"/>
				<path d="M12 1C12 0.4 11.6 0 11 0H5C4.4 0 4 0.4 4 1V3H0V5H1V15C1 15.6 1.4 16 2 16H14C14.6 16 15 15.6 15 15V5H16V3H12V1ZM6 2H10V3H6V2ZM13 5V14H3V5H13Z" fill="black"/>
			</svg>
		</button>
		<h3>
			<a href="<?php echo esc_url($product_link); ?>"><?php echo $name; ?></a>
		</h3>
		<?php if( $sale != null ) : ?>
			<div class="price">
				<?php if( !empty($sale) ) : ?>
					<span><?php echo $currency; ?><?php echo $sale; ?></span>
				<?php endif; ?>
				<?php if( !empty($regular) ) : ?>
					<del>
						<bdi><?php echo $currency; ?><?php echo $regular; ?></bdi>
					</del>
				<?php endif; ?>
			</div>
		<?php else : ?>
			<div class="price">
				<?php if( !empty($regular) ) : ?>
					<span><?php echo $currency; ?><?php echo $regular; ?></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<div class="ds-flex justify-space-between">
			<div class="info-col">
				<?php if(!empty($talla)) : ?>
					<p>Talla: <span class="upper"><?php echo $talla; ?></span></p>
				<?php endif; ?>
				<?php if(!empty($color)) : ?>
					<p>Color: <span class=""><?php echo $color; ?></span></p>
				<?php endif; ?>
				<?php if($quantity > 0) : ?>
					<p>Cantidad: <?php echo $quantity; ?></p>
				<?php endif; ?>
			</div>
			<div class="info-col">
				<?php echo woocommerce_quantity_input( array(
					'input_value'  => $quantity,
					'input_name'   => $cart_item_key,
					'min_value'    => '1',
				), $product, false ); ?>
			</div>
		</div>
	</div>
</li>
