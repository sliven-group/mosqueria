<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
$user_id = get_current_user_id();
$categoria = get_user_meta($user_id, 'mosqueira_categoria', true);
$puntos = get_user_meta($user_id, 'mosqueira_puntos', true);
?>
<div class="shop_table woocommerce-checkout-review-order-table">
	<h3>Resumen de su compra</h3>
	<div class="price-total">
		<div class="ds-flex justify-space-between">
			<span><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></span>
			<span class="cart-sub-total"><?php wc_cart_totals_subtotal_html(); ?></span>
		</div>
		<br>
		<div class="cart-desc">
			<?php if ( WC()->cart->has_discount() ) : ?>
				<div class="ds-flex justify-space-between">
					<span>Descuento</span>
					<span><strong>-<?php echo wc_price( WC()->cart->get_discount_total() ); ?></strong></span>
				</div>
				<br>
			<?php endif; ?>
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
		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
			<div class="cart-shipping ds-flex justify-space-between">
				<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
				<?php wc_cart_totals_shipping_html(); ?>
				<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
			</div>
			<br>
		<?php endif; ?>
		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
					<div class="ds-flex justify-space-between tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<span><?php echo esc_html( $tax->label ); ?></span>
						<span><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="ds-flex justify-space-between">
					<span><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></span>
					<span><?php wc_cart_totals_taxes_total_html(); ?></span>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>
			<div class="ds-flex justify-space-between">
				<span>Total</span>
				<span class="cart-total"><?php wc_cart_totals_order_total_html(); ?></span>
			</div>
		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
	</div>
	<br>
	<br>
	<?php if($user_id) :
		$is_first_purchase = mosqueira_es_primera_compra($user_id);
		$primer_pedido_como_invitado = get_user_meta($user_id, 'primer_pedido_como_invitado', true);
	?>
		<?php if(!$is_first_purchase && ($categoria!="Access" && $categoria!="")  && $primer_pedido_como_invitado !="1" ) : ?>
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
					$coupon = new WC_Coupon( $code ); ?>
					<li class="ds-flex align-center justify-space-between" data-coupon="<?php echo esc_attr( $coupon->get_code() ); ?>">
						<span>
							<strong><?php echo esc_html( $coupon->get_code() ); ?></strong>
							- Descuento: <?php echo wc_price( $coupon->get_amount() ); ?>
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
	<button type="button" id="mos-checkout-next-step" class="mos__btn mos__btn--primary ds-block">CONTINUAR LA COMPRA</button>
	<button type="submit" class="mos__btn mos__btn--primary ds-none" name="woocommerce_checkout_place_order" id="place_order" value="REALIZAR EL PEDIDO" data-value="REALIZAR EL PEDIDO">REALIZAR EL PEDIDO</button>
	<div id="mos-message-erros-checkout"></div>
</div>
