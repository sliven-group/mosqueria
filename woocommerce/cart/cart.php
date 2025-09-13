<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined( 'ABSPATH' ) || exit;
$product_ids_related = [];
$data_departamento_billing = get_cached_locations('ubigeo_departamento', 'mos_departamentos', 'idDepa', 'departamento');
$user_id = get_current_user_id();
$categoria = get_user_meta($user_id, 'mosqueira_categoria', true);
$puntos = get_user_meta($user_id, 'mosqueira_puntos', true);
?>

<section class="mos__carts">
	<div class="mos__container">
		<?php do_action( 'woocommerce_before_cart' ); ?>
		<ul class="mos__steps ds-flex justify-space-between align-center">
			<li data-step="step-1" class="mos__steps__item active">
				<img src="<?php echo IMAGES . 'icon-carrito.svg'; ?>" alt="carrito">
				<span>Carrito</span>
			</li>
			<li data-step="step-2" class="mos__steps__item">
				<a href="<?php echo wc_get_checkout_url(); ?>">
					<img src="<?php echo IMAGES . 'icon-user.svg'; ?>" alt="user">
					<span>Información</span>
				</a>
			</li>
			<li data-step="step-3" class="mos__steps__item">
				<img src="<?php echo IMAGES . 'icon-delivery.svg'; ?>" alt="delivery">
				<span>Envio</span>
			</li>
			<li data-step="step-3" class="mos__steps__item">
				<img src="<?php echo IMAGES . 'icon-pay.svg'; ?>" alt="pay">
				<span>Pago</span>
			</li>
		</ul>
		<div class="mos__steps__content">
			<div id="step-1" class="mos__steps__content__item active">
				<div class="ds-flex justify-space-between flex-wrap align-start">
					<div class="mos__carts__info">
						<h3>Carrito</h3>
						<ul class="mos__cart__items">
							<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
								$product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
								$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

								$related_products = wc_get_related_products( $product_id, 4 );
								$product_ids_related = array_merge(
									$related_products,
									$product_ids_related
								);
							?>
								<?php
									if ( $product && $product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
								?>
									<?php
										$pathItem = get_stylesheet_directory() . '/partials/cart/item.php';
										if ( file_exists($pathItem) ) {
											include $pathItem;
										}
									?>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
						<h3>Aproximado de tu delivery</h3>
						<div class="form-input mb-30">
							<label for="billing_departamento">DEPARTAMENTO</label>
							<select name="billing_departamento" id="billing_departamento">
								<option value="">Seleccione departamento</option>
								<?php foreach ($data_departamento_billing as $key => $dep ) : ?>
									<option value="<?php echo $key; ?>" <?php selected( $key, $departamento_billing ); ?>>
										<?php echo $dep; ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-input mb-30">
							<label for="billing_provincia">PROVINCIA</label>
							<select name="billing_provincia" id="billing_provincia">
								<option value="">Seleccione provincia</option>
							</select>
						</div>
						<div class="form-input mb-30">
							<label for="billing_distrito">DISTRITO</label>
							<select name="billing_distrito" id="billing_distrito">
								<option value="">Seleccione distrito</option>
							</select>
						</div>
						<div class="form-input mb-30">
							<label for="billing_delivery_methods">Método de entrega</label>
							<div id="billing_delivery_methods_wrapper">
								<select name="billing_delivery_methods" id="billing_delivery_methods">
									<option value="">Selecciona un método</option>
								</select>
							</div>
						</div>
						<button id="mos-form-billing-btn" type="button" class="mos__btn mos__btn--primary ds-block">CALCULAR</button>
						<div id="message-cart-shipping"></div>
					</div>
					<div class="mos__carts__resume">
						<h3>Resumen de su compra</h3>
						<div class="price-total">
							<div class="ds-flex justify-space-between">
								<span>Subtotal</span>
								<span class="cart-sub-total"><strong><?php echo wc_price(WC()->cart->get_subtotal()); ?></strong></span>
							</div>
							<br>
							
							<div class="cart-desc">		
								<?php if ( WC()->cart->has_discount() ) : ?>					
									<div class="ds-flex justify-space-between">
										<span>Descuento</span>
										<span><strong>-<?php echo wc_price( WC()->cart->get_discount_total() ); ?></strong></span>
									</div>
								<?php endif; ?>
								<br>								
							</div>
							
							<?php if(WC()->cart->get_fees()) : ?>
								<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
									<div class="ds-flex justify-space-between">
										<span><?php echo esc_html( $fee->name ); ?></span>
										<span><?php wc_cart_totals_fee_html( $fee ); ?></span>
									</div>
								<?php endforeach; ?>
								<br>
							<?php endif; ?>
							<?php if ( WC()->cart->has_discount() || WC()->cart->get_fees() ) : ?>
								<div class="ds-flex justify-space-between data-cupon-custom data-cupon-custom-server">
									<span>Total</span>
									<span class="cart-total"><strong><?php echo WC()->cart->get_total(); ?></strong></span>
								</div>
							<?php endif; ?>
							
							<div class="ds-flex justify-space-between ds-none data-cupon-custom data-cupon-custom-temp">
								<span>Total</span>
								<span class="cart-total"><strong></strong></span>
							</div>

						</div>
						<br>
						<small>El envío se calculará al siguiente paso</small>
						<br>
						<br>
						<?php if($user_id) :
							$is_first_purchase = mosqueira_es_primera_compra($user_id);
							
							$primer_pedido_como_invitado = get_user_meta($user_id, 'primer_pedido_como_invitado', true);

						?>
							<?php if(!$is_first_purchase && ($categoria!="Access" && $categoria!="" ) && $primer_pedido_como_invitado !="1"   ) : ?>
								<div class="form-input mb-30">
									<div class="ds-flex align-end form-input-desc">
										<input id="promo_code" type="text" placeholder="Añadir código promocional" value="">
										<button id="apply_coupon_btn" type="button" class="mos__btn mos__btn--transparent">Aplicar</button>
									</div>
									<div id="promo_code_message"></div>
								</div>
							<?php endif; ?>
						<?php else : if($categoria!="Access" && $categoria!="" ) : ?>
							<div class="form-input mb-30">
								<div class="ds-flex align-end form-input-desc">
									<input id="promo_code" type="text" placeholder="Añadir código promocional" value="">
									<button id="apply_coupon_btn" type="button" class="mos__btn mos__btn--transparent">Aplicar</button>
								</div>
								<div id="promo_code_message"></div>
							</div>
						<?php endif; endif; ?>
						<div class="cart-coupons">
							<?php if ( WC()->cart->has_discount() ) : ?>
								<ul>
									<?php foreach ( WC()->cart->get_applied_coupons() as $code ) :
										$coupon = new WC_Coupon( $code );
										
										// Obtener tipo de descuento
										$discount_type = $coupon->get_discount_type();
										switch ( $discount_type ) {
											case 'percent':
												$tipo_descuento = 'Porcentaje';
												break;
											case 'fixed_cart':
												$tipo_descuento = 'Monto fijo en carrito';
												break;
											case 'fixed_product':
												$tipo_descuento = 'Monto fijo por producto';
												break;
											default:
												$tipo_descuento = ucfirst( $discount_type );
												break;
										}

										// Obtener monto del descuento (puede ser un porcentaje o monto fijo)
										$amount = $coupon->get_amount();
										// Si el descuento es porcentaje, mostrar con % 
										if ( $discount_type === 'percent' ) {
											$importe = $amount . '%';
										} else {
											$importe = wc_price( $amount );
										}
									?>
										<li class="ds-flex align-center justify-space-between" data-coupon="<?php echo esc_attr( $coupon->get_code() ); ?>">
											<span>
												<strong><?php echo esc_html( $coupon->get_code() ); ?></strong>												
												Descuento : <?php echo esc_html( $importe ); ?>
											</span>
											<button type="button" class="remove-coupon-btn">
												<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M7 7H5V13H7V7Z" fill="black"/>
													<path d="M11 7H9V13H11V7Z" fill="black"/>
													<path d="M12 1C12 0.4 11.6 0 11 0H5C4.4 0 4 0.4 4 1V3H0V5H1V15C1 15.6 1.4 16 2 16H14C14.6 16 15 15.6 15 15V5H16V3H12V1ZM6 2H10V3H6V2ZM13 5V14H3V5H13Z" fill="black"/>
												</svg>
											</button>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>

						</div>
						<a href="<?php echo wc_get_checkout_url(); ?>" class="mos__btn mos__btn--primary ds-block">CONTINUAR LA COMPRA</a>
					</div>
				</div>
			</div>
		</div>
		<?php do_action( 'woocommerce_after_cart' ); ?>
	</div>
</section>
<section class="mos__prod-detail__recommend ptb-50">
	<div class="mos__container">
		<h2 class="text-center">QUIZÁS TAMBIÉN LE GUSTE</h2>
		<div class="ds-grid ds-grid__col4 ds-grid__gap30">
		<?php
			$items = [];
			foreach ($related_products as $related_product ) {
				$items[] = new WC_product($related_product);
			}
			$args['related_products'] = $items;
			wc_get_template( 'single-product/related.php', $args );
		?>
		</div>
	</div>
</section>
