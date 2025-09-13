<?php
add_action( 'wp_ajax_register_user', 'register_user_callback' );
add_action( 'wp_ajax_nopriv_register_user', 'register_user_callback' );

function register_user_callback() {
	global $wpdb;
	$result = [
		'status' => false,
		'error' => ''
	];

	/*$nonce = $_POST['nonce'];

	if (!wp_verify_nonce($nonce, 'ws-nonce')) {
		wp_send_json_error('No se tiene permisos para acceder!', 401);
		return;
	}*/

	$user_login = sanitize_text_field($_POST["user_nickname_register"]);
	$user_first = sanitize_text_field($_POST["user_name_register"]);
	$user_last = sanitize_text_field($_POST["user_lastname_register"]);
	$user_email = sanitize_email($_POST["user_email_register"]);
	$user_pass = isset($_POST['user_password_register']) ? wp_unslash($_POST['user_password_register']) : '';
	$user_subscribe = sanitize_text_field($_POST["user_subscribe_register"]);
	$user_gender = sanitize_text_field($_POST["user_genero_register"]);

	//$user_confirm_pass   	= $_POST["user_confirm_password_register"];

	if (username_exists($user_login)) {
		$result['error'] = 'El nombre de usuario ya existe';
	} elseif (!validate_username($user_login)) {
		$result['error'] = 'Nombre de usuario no válido';
	} elseif (empty($user_login)) {
		$result['error'] = 'Ingrese un nombre de usuario';
	} elseif (!is_email($user_email)) {
		$result['error'] = 'Correo electrónico inválido';
	} elseif (email_exists($user_email)) {
		$result['error'] = 'Correo ya registrado';
	} elseif (empty($user_pass)) {
		$result['error'] = 'Ingrese una contraseña';
	} elseif (strlen($user_pass) < 8) {
		$result['error'] = 'La contraseña debe tener minimo 8 caracteres';
	} elseif (empty($user_gender)) {
		$result['error'] = 'Ingrese un género';
	}/* elseif ($user_confirm_pass != $user_pass) {
		$result['error'] = 'Las contraseñas no coinciden';
	}*/

	// Send error if any issues with the input
	if (!empty($result['error'])) {
		wp_send_json_error($result);
		return;
	}

	$new_user_id = wp_insert_user(array(
		'user_login'        => $user_login,
		'first_name'        => $user_first,
		'last_name'         => $user_last,
		'user_email'        => $user_email,
		'user_pass'         => $user_pass,
		'user_registered'   => date('Y-m-d H:i:s'),
		'role'              => 'subscriber'
	));

	// Check for wp_insert_user failure
	if (is_wp_error($new_user_id)) {
		$result['error'] = $new_user_id->get_error_message();
		wp_send_json_error($result);
		return;
	}

	if (!empty($user_gender)) {
		update_user_meta($new_user_id, 'mos_genero', $user_gender);
	}

	// send an email to the admin
	//wp_new_user_notification($new_user_id);

	// Log the new user in
	wp_set_current_user($new_user_id);

	try {
		wp_set_auth_cookie($new_user_id, true);
	} catch (Exception $e) {
		$result['error'] = 'Error al autenticar al usuario.';
		wp_send_json_error($result);
		return;
	}

	// Enviar correo
	ob_start();
	include(get_stylesheet_directory() . '/woocommerce/emails/email-custom-new-account.php');
	$email_content_init = ob_get_clean();

	wp_mail($user_email, "Cuenta creada exitosamente", $email_content_init, [
		'Content-Type: text/html; charset=UTF-8',
		'From: Mosqueira <mosqueiraonline@mosqueira.com.pe>',
	]);

	if($user_subscribe === 'true') {
		$table = $wpdb->prefix . 'newsletter';
		$existing_email = $wpdb->get_var($wpdb->prepare("SELECT email FROM $table WHERE email = %s", $user_email));

		if (!$existing_email) {
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
				$result['suscribio'] = 'Se suscribio';
			}
		}
	}

	// Set success status and return
	$result['status'] = true;
	$result['redirect'] = home_url('mi-cuenta');
	wp_send_json_success($result);
}
