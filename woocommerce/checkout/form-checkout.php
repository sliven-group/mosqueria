<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*
do_action( 'woocommerce_before_checkout_form', $checkout );*/

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}
?>
<section class="mos__carts">
	<div class="mos__container">
		<?php do_action( 'woocommerce_before_cart' ); ?>
		<ul class="mos__steps ds-flex justify-space-between align-center">
			<li data-step="step-1" class="mos__steps__item">
				<a href="<?php echo wc_get_cart_url(); ?>">
					<img src="<?php echo IMAGES . 'icon-carrito.svg'; ?>" alt="carrito">
					<span>Carrito</span>
				</a>
			</li>
			<li data-step="step-2" class="mos__steps__item active">
				<img src="<?php echo IMAGES . 'icon-user.svg'; ?>" alt="user">
				<span>Información</span>
			</li>
			<li data-step="step-3" class="mos__steps__item">
				<img src="<?php echo IMAGES . 'icon-delivery.svg'; ?>" alt="delivery">
				<span>Envio</span>
			</li>
			<li data-step="step-4" class="mos__steps__item">
				<img src="<?php echo IMAGES . 'icon-pay.svg'; ?>" alt="pay">
				<span>Pago</span>
			</li>
		</ul>
		<div class="mos__steps__content">
			<div class="mos__steps__content__items">
				<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__( 'Checkout', 'woocommerce' ); ?>">
					<div class="ds-flex justify-space-between align-start flex-wrap">
						<div id="step-2" class="mos__steps__content__item active">
							<h3>Información</h3>
							<?php include THEME_PATH . '/partials/checkout/step-information.php'; ?>
						</div>
						<div id="step-3" class="mos__steps__content__item">
							<button type="button" class="ds-flex align-center mb-25 mos__step__back">
								<img src="<?php echo IMAGES . 'icon-prev.svg'; ?>" alt="prev">
								<span class="ds-block ml-10">Regresar</span>
							</button>
							<h3>Envio</h3>
							<?php if ( $checkout->get_checkout_fields() ) : ?>
								<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
								<?php include THEME_PATH . '/partials/checkout/step-delivery.php'; ?>
								<?php /*
								<div class="col2-set" id="customer_details">
									<div class="col-1">
										<?php do_action( 'woocommerce_checkout_billing' ); ?>
									</div>
									<div class="col-2">
										<?php do_action( 'woocommerce_checkout_shipping' ); ?>
									</div>
								</div> */?>
								<?php //do_action( 'woocommerce_checkout_after_customer_details' ); ?>
							<?php endif; ?>
							<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
						</div>
						<div id="step-4" class="mos__steps__content__item">
							<button type="button" class="ds-flex align-center mb-25 mos__step__back">
								<img src="<?php echo IMAGES . 'icon-prev.svg'; ?>" alt="prev">
								<span class="ds-block ml-10">Regresar</span>
							</button>
							<?php
								custom_woocommerce_checkout_payment();
							?>
						</div>
						<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
						<div id="order_review" class="mos__carts__resume woocommerce-checkout-review-order">
							<?php do_action( 'woocommerce_checkout_order_review' ); ?>
						</div>
						<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
					</div>
				</form>
				<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
			</div>
		</div>
		<?php do_action( 'woocommerce_after_cart' ); ?>
	</div>
</section>
<?php /*
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__( 'Checkout', 'woocommerce' ); ?>">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col2-set" id="customer_details">
			<div class="col-1">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			<div class="col-2">
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>

	<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

	<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
*/ ?>
