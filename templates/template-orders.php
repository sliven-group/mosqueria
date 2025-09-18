<?php
	/* Template Name: Pedidos */

	if (!is_user_logged_in()) {
	    wp_redirect(home_url());
	    exit;
	}

	function add_css_js() {
		wp_register_style( 'style-pedidos', mix('assets/css/template-pedidos.css'), [], false );
		wp_enqueue_style( 'style-pedidos' );

		/*wp_register_script( 'script-pedidos', mix('assets/js/template-pedidos.js'), [], false, true );
		wp_enqueue_script( 'script-pedidos' );*/
	}
	add_action('wp_enqueue_scripts', 'add_css_js');
	get_header();

	global $wpdb;
	$prefix = $wpdb->prefix;
	$current_user_id = get_current_user_id();

	$user = get_userdata($current_user_id);
	$email = $user->user_email;

	$args = array(
	    'customer_id' => $current_user_id,
	    'status'      => array('wc-completed', 'wc-processing', 'wc-on-hold'), // puedes agregar más estados
	    'limit'       => -1, // sin límite
	);
	$orders = wc_get_orders($args);
	$pedido_id = sanitize_text_field(get_query_var('pedido-id'));
	$statuses = [
	    'Pedido confirmado',
	    'Pago aprobado',
	    'Pedido preparado',
	    'Enviando el pedido',
	    'Entregar pedido',
	];
	$found = false;
?>

<section class="mos__account">
	<div class="mos__container">
		<ul class="mos__account__nav ds-flex align-center justify-center">
			<li>
				<a href="<?php echo home_url('mi-cuenta/perfil'); ?>">Perfil</a>
			</li>
			<li>
				<a class="active" href="<?php echo home_url('mi-cuenta/pedidos'); ?>">Pedidos</a>
			</li>
			<li>
				<a href="<?php echo home_url('mi-cuenta/mosqueira-social-club'); ?>">Mosqueira Social Club</a>
			</li>
		</ul>
	</div>
</section>

<section class="mos__orders">
	<div class="mos__container">
		<?php if (!empty($pedido_id) && is_numeric($pedido_id)) :
			$order = wc_get_order($pedido_id);
			$delivery_status = $order->get_meta( 'delivery_status' );
		?>
			<?php if(($order)) :
				$id = $order->get_id();
                $date = $order->get_date_created();
                $departamento_id = $order->get_meta('_billing_departamento');
                $provincia_id = $order->get_meta('_billing_provincia');
                $distrito_id = $order->get_meta('_billing_distrito');
				$direccion = $order->get_meta('_billing_address_1');
				$direccion_nro = $order->get_meta('_billing_address_2');
                $departamento = $wpdb->get_var(
					$wpdb->prepare("SELECT departamento FROM {$prefix}ubigeo_departamento WHERE idDepa = %d", $departamento_id)
                );
                $provincia = $wpdb->get_var(
					$wpdb->prepare("SELECT provincia FROM {$prefix}ubigeo_provincia WHERE idProv = %d", $provincia_id)
                );
                $distrito = $wpdb->get_var(
					$wpdb->prepare("SELECT distrito FROM {$prefix}ubigeo_distrito WHERE idDist = %d", $distrito_id)
                );

                $pay = $order->get_payment_method_title();
                $sub_total = wc_price($order->get_subtotal());
                $costo_de_envio = wc_price($order->get_shipping_total());
				$fees = $order->get_fees();
                $desc = wc_price($order->get_discount_total());
                $total = wc_price($order->get_total());
			?>
				<div class="woo__products">
					<div id="<?php echo $id; ?>" class="woo__products__item">
						<div class="ds-flex justify-space-between flex-wrap align-start">
							<div class="woo__products__header">
								<h2>Pedido #<?php echo $id; ?></h2>
								<p>Fecha del pedido: <?php echo date_i18n('j \d\e F \d\e Y', $date->getTimestamp()); ?></p>
								<p>Si su pedido es para provincia, recibirá el enlace y el código de rastreo en su correo antes de las 9:00 p. m.</p>
							</div>
							<div class="woo__products__status"><?php echo esc_html($delivery_status); ?></div>
						</div>
						<div class="ds-grid ds-grid__col3">
							<div class="item">
								<h3>Dirección</h3>
								<p>PERÚ</p>
								<?php if(!empty($departamento)) : ?>
									<p><?php echo esc_html($departamento); ?></p>
								<?php endif; ?>
								<?php if(!empty($provincia)) : ?>
									<p><?php echo esc_html($provincia); ?></p>
								<?php endif; ?>
								<?php if(!empty($distrito)) : ?>
									<p><?php echo esc_html($distrito); ?></p>
								<?php endif; ?>
								<p><?php echo esc_html($direccion); ?></p>
								<p><?php echo esc_html($direccion_nro); ?></p>
							</div>
							<div class="item">
								<h3>Forma de pago</h3>
								<?php echo esc_html($pay); ?>
							</div>
							<div class="item">
								<h3>Resumen</h3>
								<ul>
									<li class="ds-flex align-center justify-space-between">
										<span>Subtotal</span>
										<span><?php echo $sub_total; ?></span>
									</li>
									<?php if($order->get_coupon_codes()) : ?>
										<li class="ds-flex align-center justify-space-between">
											<span>Descuentos</span>
											<span>-<?php echo $desc; ?></span>
										</li>
									<?php endif; ?>
									<li class="ds-flex align-center justify-space-between">
										<span>Costo de envío</span>
										<span><?php echo $costo_de_envio; ?></span>
									</li>
									<?php foreach ( $fees as $fee ) : ?>
										<li class="ds-flex align-center justify-space-between">
											<span><?php echo esc_html( $fee->get_name() ); ?></span>
											<span><?php echo wc_price( $fee->get_total() ); ?></span>
										</li>
									<?php endforeach; ?>
									<li class="ds-flex align-center justify-space-between">
										<span><strong>Total</strong></span>
										<span><strong><?php echo $total; ?></strong></span>
									</li>
								</ul>
							</div>
						</div>
						<div class="woo__products__state">
							<h3>Estado del pedido</h3>
							<div class="woo__products__state__container">
								<div class="woo__products__state__inner ds-flex justify-space-between">
								<?php foreach ( $statuses as $status ) : ?>
                					<?php
										$active_class = '';
										if ( ! $found ) {
											$active_class = 'active';
											if ( $status === $delivery_status ) {
												$found = true;
											}
										}
									?>
									<div class="woo__products__state__line <?php echo esc_attr($active_class); ?>">
										<span><?php echo esc_html( $status ); ?></span>
									</div>
								<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		<?php else : ?>
			<?php if( !empty($orders) ) : ?>
				<div class="woo__products">
					<?php foreach ($orders as $order) :
						$id = $order->get_id();
						$date = $order->get_date_created();
						$items = $order->get_items();
						$delivery_status = $order->get_meta( 'delivery_status' );
					?>
						<div id="<?php echo esc_attr($id); ?>" class="woo__products__item">
							<div class="ds-flex justify-space-between flex-wrap align-start">
								<div class="woo__products__header">
									<h2>Pedido #<?php echo esc_html($id); ?></h2>
									<p>Fecha del pedido: <?php echo date_i18n('j \d\e F \d\e Y', $date->getTimestamp()); ?></p>
								</div>
								<div class="woo__products__status"><?php echo esc_html($delivery_status); ?></div>
							</div>
							<div class="item-big ds-flex align-start justify-space-between">
								<div>
								<?php foreach ($items as $item_id => $item) :
									/** @var WC_Order_Item_Product $item */
									$product = $item->get_product();
									$pack_items = $item->get_meta('_custom_pack_items', true);
								?>
									<div class="item-big__element ds-flex align-start justify-space-between">
										<?php if (!empty($pack_items) && is_array($pack_items)) : 
											// Mostrar pack personalizado ?>
											<div class="pack-items">
												<h4><?php echo esc_html($product ? $product->get_name() : 'Pack personalizado'); ?></h4>
												<ul>
													<?php foreach ($pack_items as $variation_id => $pack_item_data) :
														$pack_product = wc_get_product($variation_id);
														if (!$pack_product) continue;
														$image = wp_get_attachment_image_url($pack_product->get_image_id(), 'thumbnail');
														$title = isset($pack_item_data['title']) ? $pack_item_data['title'] : $pack_product->get_name();
														$quantity = isset($pack_item_data['quantity']) ? intval($pack_item_data['quantity']) : 1;
														$size = isset($pack_item_data['size']) ? $pack_item_data['size'] : '';
													?>
														<li class="ds-flex align-center" style="margin-bottom:8px;">
															<?php if ($image) : ?>
																<img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" style="max-width:60px; margin-right:10px;">
															<?php endif; ?>
															<span>
																<?php echo esc_html($title); ?>
																<?php if ($size) : ?>
																	- Talla: <strong><?php echo esc_html($size); ?></strong>
																<?php endif; ?>
																(x<?php echo $quantity; ?>)
															</span>
														</li>
													<?php endforeach; ?>
												</ul>
											</div>
										<?php elseif ($product) : 
											// Producto normal ?>
											<?php
												$product_name = $product->get_name();
												$product_price = wc_price($product->get_price());
												$quantity = $item->get_quantity();
												$product_image = $product->get_image('thumbnail');
												$attributes = $product->get_attributes();
												$talla = isset($attributes['pa_talla']) ? $attributes['pa_talla'] : '';
												$color = $item->get_meta( 'Color' );
											?>
											<?php echo $product_image; ?>
											<div class="info">
												<h4><?php echo esc_html($product_name); ?></h4>
												<p><?php echo $product_price; ?></p>
												<p>Cantidad: <?php echo esc_html($quantity); ?></p>
												<?php if(!empty($talla)) : ?>
													<p>Talla: <span class="upper"><?php echo esc_html($talla); ?></span></p>
												<?php endif; ?>
												<?php if(!empty($color)) : ?>
													<p>Color: <?php echo esc_html($color); ?></p>
												<?php endif; ?>
											</div>
										<?php endif; ?>
									</div>
								<?php endforeach; ?>
								</div>
								<a href="<?php echo home_url('mi-cuenta/pedidos/?pedido-id=') . esc_attr($id); ?>" class="mos__btn mos__btn--primary">VER DETALLES DEL PEDIDO</a>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<h3 class="title-notlist"><?php _e("Aún no tiene pedidos","mos") ?></h3>
				<a href="<?php echo home_url();?>" class="mos__btn mos__btn--primary">Volver a la tienda</a>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</section>

<?php
	get_footer();
?>
