<?php

add_action('wp_ajax_mos_newsletter', 'mos_newsletter_callback');
add_action('wp_ajax_nopriv_mos_newsletter', 'mos_newsletter_callback');

function mos_newsletter_callback() {
	global $wpdb;

	$user_email = isset($_POST["user_email"]) ? sanitize_email($_POST['user_email']) : '';
	$result = [];

	if (!is_email($user_email)) {
		$result['error'] = 'Correo electrónico inválido';
	}

	if (!empty($result['error'])) {
		wp_send_json_error($result);
		return;
	}

	$table = $wpdb->prefix . 'newsletter';
	$existing_email = $wpdb->get_var($wpdb->prepare("SELECT email FROM $table WHERE email = %s", $user_email));

	if ($existing_email) {
		wp_send_json_error(['error' => 'Este correo electrónico ya está registrado.']);
		return;
	}

	$timezone = new DateTimeZone('America/Lima');
	$date = new DateTime('now', $timezone);
	$date = $date->format('Y-m-d H:i:s');

	$columns = [
		'fecha' => $date,
		'email' => $user_email,
	];

	$query = $wpdb->insert($table, $columns);

	if ($query == 1) {
		ob_start();
		include( get_stylesheet_directory() . '/woocommerce/emails/email-newsletter.php' );
		$email_content = ob_get_contents();
		ob_end_clean();

		$to = $user_email;
		$subject = "¡Gracias por su registro!";
		$headers = [
			'Content-Type: text/html; charset=UTF-8',
			'From: Mosqueira <newsletter@mosqueira.com.pe>',
		];
		wp_mail($to, $subject, $email_content, $headers);
		wp_send_json_success(['message' => 'Correo suscrito correctamente']);
	} else {
		wp_send_json_error(['error' => 'No se pudo registrar el email'], 404);
	}
}

add_action('wp_ajax_mos_unsubscribe', 'mos_unsubscribe_callback');
add_action('wp_ajax_nopriv_mos_unsubscribe', 'mos_unsubscribe_callback');

function mos_unsubscribe_callback() {
	global $wpdb;

	$user_email = isset($_POST["user_email"]) ? sanitize_email($_POST['user_email']) : '';

	if (!is_email($user_email)) {
		wp_send_json_error(['error' => 'Correo electrónico inválido']);
		return;
	}

	$table = $wpdb->prefix . 'newsletter';
	$existing_email = $wpdb->get_var($wpdb->prepare("SELECT email FROM $table WHERE email = %s", $user_email));

	if (!$existing_email) {
		wp_send_json_error(['error' => 'Este correo electrónico no está registrado.']);
		return;
	}

	$deleted = $wpdb->delete($table, ['email' => $user_email], ['%s']);

	if ($deleted) {
		wp_send_json_success(['message' => 'La cancelación de la suscripción se ha completado con éxito.']);
	} else {
		wp_send_json_error(['error' => 'No se pudo eliminar el correo.']);
	}
}

add_action('woocommerce_checkout_update_order_meta', 'mos_check_newsletter_checkbox');
function mos_check_newsletter_checkbox($order_id) {
    if (isset($_POST['additional_newsletter']) && $_POST['additional_newsletter'] == '1') {
        $order = wc_get_order($order_id);
        $user_email = $order->get_billing_email();

        if (!is_email($user_email)) return;

        global $wpdb;
        $table = $wpdb->prefix . 'newsletter';
        $existing_email = $wpdb->get_var($wpdb->prepare("SELECT email FROM $table WHERE email = %s", $user_email));

        if (!$existing_email) {
            $timezone = new DateTimeZone('America/Lima');
            $date = (new DateTime('now', $timezone))->format('Y-m-d H:i:s');
            $wpdb->insert($table, [
                'fecha' => $date,
                'email' => $user_email,
            ]);

            // Enviar correo (opcional)      
			ob_start();
			include( get_stylesheet_directory() . '/woocommerce/emails/email-newsletter.php' );
			$email_content = ob_get_contents();
			ob_end_clean();


            wp_mail($user_email, "¡Gracias por su registro!", $email_content, [
                'Content-Type: text/html; charset=UTF-8',
                'From: Mosqueira <newsletter@mosqueira.com.pe>',
            ]);
        }
    }
}


