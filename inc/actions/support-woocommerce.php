<?php
add_filter('loop_shop_per_page', 'custom_loop_shop_per_page', 20);
function custom_loop_shop_per_page($cols) {
	return PER_PAGE; // Cambia este número al que necesites
}

add_action( 'woocommerce_checkout_create_order_line_item', 'agregar_color_a_pedido', 10, 4 );
function agregar_color_a_pedido( $item, $cart_item_key, $values, $order ) {
	if ( isset( $values['pa_color'] ) ) {
		$item->add_meta_data( 'Color', $values['pa_color'], true );
	}
}

// Mostrar campo personalizado en el admin del pedido
add_action( 'woocommerce_admin_order_data_after_order_details', 'custom_checkout_status_email_fields' );
function custom_checkout_status_email_fields( $order ) {
    $subStatus = $order->get_meta( 'delivery_status' );
    woocommerce_wp_select( array(
        'id' => 'delivery_status',
        'label' => 'Estado de Entrega:',
        'value' => $subStatus,
        'options' => array(
					'' => 'Seleccionar...',
					'Pedido confirmado' => 'Pedido confirmado',
					'Pago aprobado' => 'Pago aprobado',
					'Pedido preparado' => 'Pedido preparado',
					'Enviando el pedido' => 'Enviando el pedido',
					'Entregar pedido' => 'Entregar pedido'
				),
				'wrapper_class' => 'form-field-wide'
    ));
}

// Guardar el valor del campo usando métodos compatibles con HPOS
add_action( 'woocommerce_process_shop_order_meta', 'save_admin_billing_field', 45, 2 );
function save_admin_billing_field( $order_id, $post ) {
	if ( isset( $_POST['delivery_status'] ) ) {
		$order = wc_get_order( $order_id );
		$order->update_meta_data( 'delivery_status', wc_clean( $_POST['delivery_status'] ) );
		$order->save();
	}
}

add_action( 'woocommerce_checkout_create_order', 'set_default_delivery_status_on_order_create', 20, 2 );
function set_default_delivery_status_on_order_create( $order, $data ) {
	$order->update_meta_data( 'delivery_status', 'Pedido confirmado' );
	//add
    $user_id = $order->get_user_id();
    if ( $user_id > 0 ) {
        update_user_meta( $user_id, 'primer_pedido_como_invitado', '0' );
    }
}

add_action( 'woocommerce_order_status_changed', 'update_delivery_status_on_order_status_change', 20, 4 );
function update_delivery_status_on_order_status_change( $order_id, $old_status, $new_status, $order ) {
	$map = [
		//'on-hold'    => 'Pedido confirmado',
		'processing' => 'Pedido confirmado',
		//'completed'  => 'Pedido preparado',
	];

	if ( isset( $map[ $new_status ] ) ) {
		$order->update_meta_data( 'delivery_status', $map[ $new_status ] );
		$order->save(); // Obligatorio aquí
	}
}

add_action( 'woocommerce_before_order_object_save', 'enviar_correo_entregar_pedido_hpos', 20, 2 );
function enviar_correo_entregar_pedido_hpos( $order, $data_store ) {
	if ( ! is_a( $order, WC_Order::class ) ) return;

	// Obtener estado anterior guardado en el meta personalizado
	$old_status = $order->get_meta( '_old_delivery_status' );
	$new_status = $order->get_meta( 'delivery_status' );
	$current_status = $order->get_status();

	//  Si cambió y ahora es 'Pago aprobado'
	if ( $old_status !== $new_status && $new_status === 'Enviando el pedido' ) {
		// Cambiar estado del pedido WooCommerce a "completed" si aún no lo está
		if ( $current_status !== 'completed' ) {
			$order->set_status( 'completed' ); // Esto dispara 'woocommerce_order_status_changed'
		}
	}

	// Si cambió y ahora es 'Entregar pedido'
	if ( $old_status !== $new_status && $new_status === 'Entregar pedido' ) {
		$to = $order->get_billing_email();
		$subject = 'Pedido entregado con éxito ';

		ob_start();
		include( get_stylesheet_directory() . '/woocommerce/emails/email-order-delivery.php' );
		$email_content = ob_get_contents();
		ob_end_clean();

		wp_mail($to, $subject, $email_content, [
			'Content-Type: text/html; charset=UTF-8',
			'From: Mosqueira <mosqueiraonline@mosqueira.com.pe>',
		]);
	}

	// Guardar nuevo estado como el actual para próxima comparación
	$order->update_meta_data( '_old_delivery_status', $new_status );
}

add_action('wp_ajax_mos_olva_email_ajax', 'mos_olva_email_ajax');
add_action('wp_ajax_nopriv_mos_olva_email_ajax', 'mos_olva_email_ajax');

function mos_olva_email_ajax() {
	if (!isset($_POST['email']) || empty($_POST['email'])) {
		wp_send_json_error(['message' => 'El correo es obligatorio.']);
	}

	if (!isset($_POST['code']) || empty($_POST['code'])) {
		wp_send_json_error(['message' => 'El codigo es obligatorio.']);
	}

	$email = sanitize_email($_POST['email']);
	$name = sanitize_email($_POST['name']);
	$code = sanitize_text_field($_POST['code']);

	if (!is_email($email)) {
		wp_send_json_error(['message' => 'Correo inválido.']);
	}

	$to = $email;
	$subject = '¡Pedido en camino!';
	$headers = [
		'Content-Type: text/html; charset=UTF-8',
		'From: Mosqueira <mosqueiraonline@mosqueira.com.pe>',
	];

	ob_start();
	include( get_stylesheet_directory() . '/woocommerce/emails/email-olva.php' );
	$email_content = ob_get_contents();
	ob_end_clean();

	$enviado = wp_mail($to, $subject, $email_content, $headers);

	if ($enviado) {
		wp_send_json_success();
	} else {
		wp_send_json_error(['message' => 'No se pudo enviar el correo.']);
	}
}

add_action('admin_footer', function () {
    // Solo carga en editor de pedidos de WooCommerce
    if (isset($_GET['page'], $_GET['action']) && $_GET['page'] === 'wc-orders' && $_GET['action'] === 'edit') {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Esperar a que React renderice
            const interval = setInterval(() => {
                const permisos = document.querySelector('#woocommerce-order-downloads');
                if (permisos) {
                    const div = document.createElement('div');
                    div.innerHTML = `
                        <div class="postbox">
													<div class="postbox-header">
														<h2 class="hndle ui-sortable-handle">Email Olva</h2>
													</div>
													<div class="inside">
														<div class="toolbar">
															<p>Ingresa el codigo de olva para enviar el email al cliente.</p>
															<input id="mos-olva-number" type="text" placeholder="" style="width:100%; margin-top:5px;" />
															<br><br>
															<button id="mos-olva-btn" type="button" class="button save_order button-primary">Enviar</button>
															<br><br><div id="mos-email-message"></div>
														</div>
													</div>
                        </div>
                    `;
                    permisos.parentNode.insertBefore(div, permisos.nextSibling);
                    clearInterval(interval);
										const btn = document.getElementById('mos-olva-btn');
										const numberOlva = document.getElementById('mos-olva-number');
										const messageBox = document.getElementById('mos-email-message');
										const email = document.getElementById('_billing_email');
										const name = document.getElementById('_billing_first_name');
										
										btn.addEventListener('click', function () {
											const value = numberOlva.value.trim();

											btn.textContent = 'Enviar';

											if (value === '') {
												alert('Por favor, ingrese un número de seguimiento.');
												return;
											}

											btn.textContent = 'cargando...';

											fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
												method: 'POST',
												headers: {
													'Content-Type': 'application/x-www-form-urlencoded'
												},
												body: new URLSearchParams({
													action: 'mos_olva_email_ajax',
													email: email.value,
													name: name.value,
													code: numberOlva.value
												})
											})
											.then(res => res.json())
											.then(data => {
												if (data.success) {
													messageBox.textContent = 'Correo enviado correctamente.';
													messageBox.style.color = 'green';
												} else {
													messageBox.textContent = data.message || 'Error al enviar el correo.';
													messageBox.style.color = 'red';
												}
												btn.textContent = 'Enviar';
											})
											.catch(() => {
												messageBox.textContent = 'Error del servidor.';
												messageBox.style.color = 'red';
											});
										});
                }
            }, 300);
        });
        </script>
        <?php
    }
});
