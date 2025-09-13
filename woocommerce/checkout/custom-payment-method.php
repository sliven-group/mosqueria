<?php
/**
 * Output a single payment method
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment-method.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<li class="wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?>">
	<input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="mos__cart__payment__method input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />
	<label class="ds-flex justify-space-between align-center" for="payment_method_<?php echo esc_attr( $gateway->id ); ?>">
		<?php
			if($gateway->id === 'bacs' || $gateway->id === 'cod' ) {
				echo '<img loading="lazy" src="'. IMAGES . 'icon-transferencia-bancaria.svg" alt="transferencia">';
			} else if($gateway->id === 'micuentawebstd') {
				echo  '<img loading="lazy" src="'. IMAGES . 'icon-tarjeta.svg" alt="tarjetas">';
			}
			echo '<span>' . $gateway->get_title() . '</span>';
		?>
	</label>
	<?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
		<div class="payment_box payment_method_<?php echo esc_attr( $gateway->id ); ?>" <?php if ( ! $gateway->chosen ) : /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>style="display:none;"<?php endif; /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>>
			<?php if($gateway->id === 'micuentawebstd') : ?>
				<img loading="lazy" src="<?php echo IMAGES . 'tarjetas.png' ?>" alt="tarjetas" style="max-width:300px;">
			<?php else : ?>
				<?php echo $gateway->get_icon(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?>
			<?php endif; ?>
			<?php $gateway->payment_fields(); ?>
		</div>
	<?php endif; ?>
</li>
