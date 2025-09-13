<?php

function acr_guardar_carrito_abandonado($email, $cart, $user_id = null) {
	global $wpdb;
	$tabla = $wpdb->prefix . 'abandoned_carts';
	$existe = $wpdb->get_var($wpdb->prepare(
		"SELECT COUNT(*) FROM $tabla WHERE email = %s AND order_completed = 0",
		$email
	));
	if (!$existe) {
		$wpdb->insert($tabla, [
			'email'        => $email,
			'cart'         => maybe_serialize($cart),
			'user_id'      => $user_id,
			'abandoned_at' => current_time('mysql')
		]);
	}
}

// Capturar carrito para usuarios logueados
add_action('woocommerce_add_to_cart', function () {
	if (is_user_logged_in()) {
		$cart = WC()->cart->get_cart();
		if (!empty($cart)) {
			$user = wp_get_current_user();
			acr_guardar_carrito_abandonado($user->user_email, $cart, $user->ID);
		}
	}
}, 10, 1);

// Capturar email del visitante en el checkout
add_action('woocommerce_checkout_order_processed', function ($order_id) {
	global $wpdb;
	$tabla = $wpdb->prefix . 'abandoned_carts';
	$order = wc_get_order($order_id);
	$email = $order->get_billing_email();
	if ($email) {
		$wpdb->update(
			$tabla,
			['order_completed' => 1],
			['email' => $email, 'order_completed' => 0]
		);
	}
}, 10, 1);

// Cron job para enviar correos
add_action('acr_enviar_recordatorios', function () {
	global $wpdb;
	$tabla = $wpdb->prefix . 'abandoned_carts';
	$ahora = current_time('mysql');
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
		$abandoned_at = strtotime($c->abandoned_at);
		$first_sent   = $c->first_email_sent ? strtotime($c->first_email_sent) : null;
		$to = $c->email;
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
		// Primer correo
		if (!$first_sent && time() - $abandoned_at >= 2 * HOUR_IN_SECONDS) {
			ob_start();
			include( get_stylesheet_directory() . '/woocommerce/emails/email-abandoned-cart.php' );
			$email_content = ob_get_contents();
			ob_end_clean();

			wp_mail($to, $subject, $email_content, $headers);
			$wpdb->update($tabla, ['first_email_sent' => $ahora], ['id' => $c->id]);
		}

		// Segundo correo
		if ($first_sent && !$c->second_email_sent && time() - $first_sent >= 24 * HOUR_IN_SECONDS) {
			ob_start();
			include( get_stylesheet_directory() . '/woocommerce/emails/email-abandoned-cart.php' );
			$email_content_2 = ob_get_contents();
			ob_end_clean();

			wp_mail($to, $subject, $email_content_2, $headers);
			$wpdb->update($tabla, ['second_email_sent' => $ahora], ['id' => $c->id]);
		}
	}
});

// Registrar cron
if (!wp_next_scheduled('acr_enviar_recordatorios')) {
	wp_schedule_event(time(), 'hourly', 'acr_enviar_recordatorios');
}

// Registrar frecuencia personalizada (si quieres menos de 1h)
/*add_filter('cron_schedules', function ($schedules) {
	$schedules['15min'] = [
		'interval' => 900,
		'display' => __('Cada 15 minutos')
	];
	return $schedules;
});*/
