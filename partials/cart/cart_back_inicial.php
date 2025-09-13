<?php
	$cart = wc()->cart;
	$items = $cart->get_cart();
	$subtotal = $cart->get_subtotal();
	$total = $cart->get_total();
	$currency_cart = get_woocommerce_currency_symbol();
	$checkout_url = wc_get_checkout_url();
	$cart_url = wc_get_cart_url(); 
	$desc = wc_price($cart->get_discount_total());
	$user_id = get_current_user_id();
?>
<?php if ( ! $cart->is_empty() ) : ?>
	<div class="mos__cart">
		<ul class="mos__cart__items">
			<?php foreach ( $items as $cart_item_key => $cart_item ) : ?>
				<?php
					$pathItem = get_stylesheet_directory() . '/partials/cart/item.php';
					if ( file_exists($pathItem) ) {
						include $pathItem;
					}
				?>
			<?php endforeach; ?>
		</ul>
		<div class="mos__cart__footer">
			<ul>
				<li class="ds-flex align-center justify-space-between">
					<span>Subtotal</span>
					<span class="pop-cart-subtotal"><?php echo $currency_cart; ?><?php echo $subtotal; ?></span>
				</li>
				<?php if($user_id) :
					$is_first_purchase = mosqueira_es_primera_compra($user_id);
					$descuento = $cart->get_subtotal() * 0.15;
					$newTotal = $cart->get_subtotal() - $descuento;
				?>
					<?php if($is_first_purchase) : ?>
						<li class="ds-flex align-center justify-space-between">
							<span>15% de descuento - Primera compra (Access)</span>
							<span>-S/<?php echo $descuento; ?></span>
						</li>
						<li class="ds-flex align-center justify-space-between">
							<span>Total</span>
							<span class="pop-cart-total">S/<?php echo $newTotal; ?></span>
						</li>
					<?php else : ?>
						<li class="ds-flex align-center justify-space-between">
							<span>Descuento</span>
							<span class="pop-cart-desc"><?php echo $desc; ?></span>
						</li>
						<li class="ds-flex align-center justify-space-between">
							<span>Total</span>
							<span class="pop-cart-total"><?php echo $total; ?></span>
						</li>
					<?php endif; ?>
				<?php else : ?>
					<li class="ds-flex align-center justify-space-between">
						<span>Descuento</span>
						<span class="pop-cart-desc"><?php echo $desc; ?></span>
					</li>
					<li class="ds-flex align-center justify-space-between">
						<span>Total</span>
						<span class="pop-cart-total"><?php echo $total; ?></span>
					</li>
				<?php endif; ?>
			</ul>
			<a href="<?php echo esc_url($cart_url); ?>" class="mos__btn mos__btn--primary">FINALIZAR COMPRA</a>
			<button class="modal__cart__close mos__modal__close">SEGUIR COMPRANDO</button>
		</div>
		<div class="mos__cart__loading">
			<img loading="lazy" width="50" height="50" src="<?php echo IMAGES . 'loading.svg' ?>" alt="loading">
		</div>
	</div>
<?php else : ?>
	<p>Su bolsa de compras está vacía</p>
<?php endif; ?>
