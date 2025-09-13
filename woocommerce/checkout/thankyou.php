<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;

?>

<section class="mos__thanks">
	<div class="mos__container">
		<div class="mos__thanks__container">
			<?php if ( $order->has_status( 'failed' ) ) : ?>
				<svg class="mos__thanks__error" width="77" height="77" viewBox="0 0 77 77" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M38.5 7.21875C46.7963 7.21875 54.7528 10.5144 60.6192 16.3808C66.4856 22.2472 69.7812 30.2037 69.7812 38.5C69.7812 46.7963 66.4856 54.7528 60.6192 60.6192C54.7528 66.4856 46.7963 69.7812 38.5 69.7812C30.2037 69.7812 22.2472 66.4856 16.3808 60.6192C10.5144 54.7528 7.21875 46.7963 7.21875 38.5C7.21875 30.2037 10.5144 22.2472 16.3808 16.3808C22.2472 10.5144 30.2037 7.21875 38.5 7.21875ZM38.5 77C48.7108 77 58.5035 72.9438 65.7236 65.7236C72.9438 58.5035 77 48.7108 77 38.5C77 28.2892 72.9438 18.4965 65.7236 11.2764C58.5035 4.05624 48.7108 0 38.5 0C28.2892 0 18.4965 4.05624 11.2764 11.2764C4.05624 18.4965 0 28.2892 0 38.5C0 48.7108 4.05624 58.5035 11.2764 65.7236C18.4965 72.9438 28.2892 77 38.5 77ZM26.3184 26.3184C24.9047 27.732 24.9047 30.018 26.3184 31.4166L33.3867 38.485L26.3184 45.5533C24.9047 46.967 24.9047 49.2529 26.3184 50.6516C27.732 52.0502 30.018 52.0652 31.4166 50.6516L38.485 43.5832L45.5533 50.6516C46.967 52.0652 49.2529 52.0652 50.6516 50.6516C52.0502 49.2379 52.0652 46.952 50.6516 45.5533L43.5832 38.485L50.6516 31.4166C52.0652 30.0029 52.0652 27.717 50.6516 26.3184C49.2379 24.9197 46.952 24.9047 45.5533 26.3184L38.485 33.3867L31.4166 26.3184C30.0029 24.9047 27.717 24.9047 26.3184 26.3184Z" fill="#FF0707"/>
				</svg>
				<h1 class="text-center">¡Error!</h1>
				<p class="text-center woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>
				<p class="text-center woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
					<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="mos__btn mos__btn--primary"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="mos__btn mos__btn--primary"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
					<?php endif; ?>
				</p>
			<?php else : ?>
				<svg class="mos__thanks__success" width="77" height="77" viewBox="0 0 77 77" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M38.5 7.21875C46.7963 7.21875 54.7528 10.5144 60.6192 16.3808C66.4856 22.2472 69.7812 30.2037 69.7812 38.5C69.7812 46.7963 66.4856 54.7528 60.6192 60.6192C54.7528 66.4856 46.7963 69.7812 38.5 69.7812C30.2037 69.7812 22.2472 66.4856 16.3808 60.6192C10.5144 54.7528 7.21875 46.7963 7.21875 38.5C7.21875 30.2037 10.5144 22.2472 16.3808 16.3808C22.2472 10.5144 30.2037 7.21875 38.5 7.21875ZM38.5 77C48.7108 77 58.5035 72.9438 65.7236 65.7236C72.9438 58.5035 77 48.7108 77 38.5C77 28.2892 72.9438 18.4965 65.7236 11.2764C58.5035 4.05624 48.7108 0 38.5 0C28.2892 0 18.4965 4.05624 11.2764 11.2764C4.05624 18.4965 0 28.2892 0 38.5C0 48.7108 4.05624 58.5035 11.2764 65.7236C18.4965 72.9438 28.2892 77 38.5 77ZM55.4941 31.4316C56.9078 30.018 56.9078 27.732 55.4941 26.3334C54.0805 24.9348 51.7945 24.9197 50.3959 26.3334L33.7025 43.0268L26.6342 35.9584C25.2205 34.5447 22.9346 34.5447 21.5359 35.9584C20.1373 37.3721 20.1223 39.658 21.5359 41.0566L31.1609 50.6816C32.5746 52.0953 34.8605 52.0953 36.2592 50.6816L55.4941 31.4316Z" fill="#8CE40F" fill-opacity="0.98"/>
				</svg>
				<h1 class="text-center">¡GRACIAS POR LA COMPRA!</h1>
				<p class="text-justify">Ha dado un nuevo paso hacia el éxito. Muy pronto tendrá en sus manos una prenda creada para acompañarle en cada logro, confeccionada con la excelencia y el detalle que distinguen a Mosqueira. Le mantendremos informado sobre el avance de su pedido.</p>
				<div class="mos__thanks__order ds-flex justify-space-between align-start">
					<div class="mos__thanks__order__col">
						<h2>Orden #<?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
						<?php
							global $wpdb;
							$prefix = $wpdb->prefix;
							$date = $order->get_date_created();
							$nombre = $order->get_billing_first_name();
							$apellido = $order->get_billing_last_name();
							$email = $order->get_billing_email();
							$direccion_facturacion = $order->get_formatted_billing_address();
							$departamento_id = $order->get_meta('_billing_departamento');
							$provincia_id = $order->get_meta('_billing_provincia');
							$distrito_id = $order->get_meta('_billing_distrito');
							$user_id = $order->get_user_id();
							
							$departamento = $wpdb->get_var(
								$wpdb->prepare(
									"SELECT departamento FROM {$prefix}ubigeo_departamento WHERE idDepa = %d",
									$departamento_id
								)
							);
							$provincia = $wpdb->get_var(
								$wpdb->prepare(
									"SELECT provincia FROM {$prefix}ubigeo_provincia WHERE idProv = %d",
									$provincia_id
								)
							);
							$distrito = $wpdb->get_var(
								$wpdb->prepare(
									"SELECT distrito FROM {$prefix}ubigeo_distrito WHERE idDist = %d",
									$distrito_id
								)
							);
							//$pay = $order->get_payment_method_title();
							$items = $order->get_items();

							$timezone = new DateTimeZone('America/Lima');
							$date->setTimezone($timezone);
							$formatter = new IntlDateFormatter(
								'es_ES',
								IntlDateFormatter::LONG,
								IntlDateFormatter::MEDIUM,
								$timezone->getName(),
								IntlDateFormatter::GREGORIAN,
								"d 'de' MMMM 'de' yyyy HH:mm:ss"
							);
						?>
						<p>Hecho el <?php echo $formatter->format($date); ?></p>
						<p><?php echo $nombre; ?> <?php echo $apellido; ?></p>
						<p><?php echo $email; ?></p>
						<p>PERÚ</p>
						<?php if(!empty($departamento)) : ?>
							<p><?php echo $departamento; ?></p>
						<?php endif; ?>
						<?php if(!empty($provincia)) : ?>
							<p><?php echo $provincia; ?></p>
						<?php endif; ?>
						<?php if(!empty($distrito)) : ?>
							<p><?php echo $distrito; ?></p>
						<?php endif; ?>
						<?php /*
						<p>Pago con <?php echo $pay; ?></p> */?>
					</div>
					<div class="mos__thanks__order__col">
						<?php if ( is_user_logged_in() ) : ?>
							<a href="<?php echo home_url('mi-cuenta/pedidos/#') . $order->get_order_number(); ?>" class="mos__btn mos__btn--primary">MIS ORDENES</a>
						<?php else: $user = get_user_by('email', $email); ?>
							<?php if ($user) { ?>
								<a href="<?php echo home_url('?modal_account=true'); ?>">MIS ORDENES</a>
							<?php }else{ ?>
								<a href="<?php echo home_url('?modal_register=true&nombre=' . urlencode($nombre) . '&apellido=' . urlencode($apellido) . '&correo=' . urlencode($email) . '&url_account=' . urlencode(home_url('mi-cuenta/pedidos/'))); ?>" class="mos__btn mos__btn--primary">MIS ORDENES</a>
							<?php } ?>	
						<?php endif; ?>
					</div>
				</div>
				<?php if(!empty($items )) : ?>
					<div class="mos__thanks__order__items">
						<?php foreach ($items as $item_id => $item) :
							/** @var WC_Order_Item_Product $item */
							$product = $item->get_product();
						?>
							<?php if ($product) :
								$product_name = $product->get_name();
								$product_price = wc_price($product->get_price());
								$quantity = $item->get_quantity();
								$product_image = $product->get_image('medium');
								$attributes = $product->get_attributes();
								$talla = isset($attributes['pa_talla']) ? $attributes['pa_talla'] : '';
								//$color = isset($attributes['pa_color']) ? $attributes['pa_color']->get_terms()[0]->name : '';
								$color = $item->get_meta( 'Color' );
							?>
								<div class="ds-flex align-start justify-space-between">
									<?php echo $product_image; ?>
									<div class="info">
										<h4><?php echo $product_name; ?></h4>
										<p><?php echo $product_price; ?></p>
										<p>Cantidad: <?php echo $quantity; ?></p>
										<?php if(!empty($talla)) : ?>
											<p>Talla: <span class="upper"><?php echo $talla; ?></span></p>
										<?php endif; ?>
										<?php if(!empty($color)) : ?>
											<p>Color: <?php echo $color; ?></p>
										<?php endif; ?>
									</div>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				<div class="mos__thanks__order__footer">
					<?php
						foreach ( $order->get_order_item_totals() as $key => $total ) {
							?>
								<div class="ds-flex justify-space-between">
									<span><?php echo esc_html( $total['label'] ); ?></span>
									<span><?php echo wp_kses_post( $total['value'] ); ?></span>
								</div>
							<?php
						}
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php /*
<div class="woocommerce-order">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<?php wc_get_template( 'checkout/order-received.php', array( 'order' => $order ) ); ?>

			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

				<li class="woocommerce-order-overview__order order">
					<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date">
					<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
					<strong><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email">
						<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</li>
				<?php endif; ?>

				<li class="woocommerce-order-overview__total total">
					<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method">
						<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
						<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>

			</ul>

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>

	<?php endif; ?>

</div>
*/ ?>
