<?php

// Guardar carrito abandonado
function acr_guardar_carrito_abandonado($email, $cart, $user_id = null) {
	global $wpdb;
	$tabla = $wpdb->prefix . 'abandoned_carts';

	if (!is_email($email) || empty($cart)) return;

	$existe = $wpdb->get_var($wpdb->prepare(
		"SELECT COUNT(*) FROM $tabla WHERE email = %s AND order_completed = 0",
		$email
	));

	if (!$existe) {
		$wpdb->insert($tabla, [
			'email'           => sanitize_email($email),
			'cart'            => maybe_serialize($cart),
			'user_id'         => $user_id,
			'abandoned_at'    => current_time('mysql'),
			'last_updated'    => current_time('mysql'),
			'order_completed' => 0
		]);
	} else {
		$wpdb->update($tabla, [
			'cart'         => maybe_serialize($cart),
			'last_updated' => current_time('mysql')
		], [
			'email' => sanitize_email($email),
			'order_completed' => 0
		]);
	}
}

// Capturar carrito de usuarios logueados
add_action('woocommerce_add_to_cart', function () {
	if (is_user_logged_in()) {
		$cart = WC()->cart->get_cart();
		if (!empty($cart)) {
			$user = wp_get_current_user();
			acr_guardar_carrito_abandonado($user->user_email, $cart, $user->ID);
		}
	}
}, 10, 1);

// Capturar carrito de visitantes cuando introducen su email en el checkout
add_action('woocommerce_checkout_update_customer', function($customer) {
	if (!is_user_logged_in()) {
		$email = $customer->get_billing_email();
		if ($email) {
			$cart = WC()->cart->get_cart();
			acr_guardar_carrito_abandonado($email, $cart, null);
		}
	}
});

// Marcar como completado al finalizar la compra
add_action('woocommerce_checkout_order_processed', function ($order_id) {
	global $wpdb;
	$tabla = $wpdb->prefix . 'abandoned_carts';
	$order = wc_get_order($order_id);
	$email = $order->get_billing_email();

	if ($email) {
		$wpdb->update(
			$tabla,
			['order_completed' => 1],
			['email' => sanitize_email($email), 'order_completed' => 0]
		);
	}
}, 10, 1);

// Envío de correos recordatorios
add_action('acr_enviar_recordatorios', function () {
	global $wpdb;
	error_log('[ACR] Ejecutando cron: ' . current_time('mysql'));
	$tabla = $wpdb->prefix . 'abandoned_carts';
	$ahora = current_time('mysql');
	$now_ts = current_time('timestamp'); // Hora local del sitio como timestamp

	$carritos = $wpdb->get_results("
		SELECT * FROM $tabla
		WHERE order_completed = 0
	");

	$headers = [
		'Content-Type: text/html; charset=UTF-8',
		'From: Mosqueira <mosqueiraonline@mosqueira.com.pe>',
	];

	$subject = '¿Olvidaste tu carrito?';

	foreach ($carritos as $c) {
		$abandoned_at_ts = strtotime($c->abandoned_at);
		$first_sent_ts   = $c->first_email_sent ? strtotime($c->first_email_sent) : null;
		$second_sent_ts  = $c->second_email_sent ? strtotime($c->second_email_sent) : null;

		$to = sanitize_email($c->email);
		$cart = maybe_unserialize($c->cart);

		if (empty($cart) || !is_array($cart)) continue;

		$user_id = $c->user_id;
		
		$name= "";
		if ( $user_id ) {			
			if(get_user_meta($user_id, 'billing_first_name', true)){
				$name=get_user_meta($user_id, 'billing_first_name', true);
			}else{
				$user = get_userdata( $user_id ); // Objeto WP_User
				$name=$user->first_name;				
			}
		}

		// Primer correo (a las 2 horas del abandono)
		if (!$first_sent_ts && ($now_ts - $abandoned_at_ts >= 2 * HOUR_IN_SECONDS)) {
			ob_start();
			include get_stylesheet_directory() . '/woocommerce/emails/email-abandoned-cart.php';
			$email_content = ob_get_clean();

			wp_mail($to, $subject, $email_content, $headers);

			$wpdb->update($tabla, [
				'first_email_sent' => $ahora
			], [
				'id' => $c->id
			]);
		}

		// Segundo correo (24 horas después del primero)
		if ($first_sent_ts && !$second_sent_ts && ($now_ts - $first_sent_ts >= 24 * HOUR_IN_SECONDS)) {
			ob_start();
			include get_stylesheet_directory() . '/woocommerce/emails/email-abandoned-cart.php';
			$email_content = ob_get_clean();

			wp_mail($to, $subject, $email_content, $headers);

			$wpdb->update($tabla, [
				'second_email_sent' => $ahora
			], [
				'id' => $c->id
			]);
		}
	}
});

// Programar cron si no existe
if (!wp_next_scheduled('acr_enviar_recordatorios')) {
	wp_schedule_event(time(), 'hourly', 'acr_enviar_recordatorios');
}

// (Opcional) Frecuencia personalizada cada 15 minutos
/*
add_filter('cron_schedules', function ($schedules) {
	$schedules['15min'] = [
		'interval' => 900,
		'display'  => __('Cada 15 minutos')
	];
	return $schedules;
});
*/
