<?php
add_action( 'wp_ajax_login_user', 'login_user_callback' );
add_action( 'wp_ajax_nopriv_login_user', 'login_user_callback' );

function login_user_callback() {
	//$nonce = $_POST['nonce'];

	/*if (!wp_verify_nonce($nonce, 'ws-nonce')) {
		wp_send_json_error('No se tiene permisos para acceder!', 401);
		return;
	}*/

	//check_ajax_referer('ws-nonce', 'security');

	$user_email = isset($_POST["user_email"]) ? sanitize_email($_POST['user_email']) : '';
	$user_pass = isset($_POST['user_password']) ? $_POST['user_password'] : '';

	if (!is_email($user_email)) {
		$result['message'] = 'Correo electrónico inválido';
	} elseif (empty($user_pass)) {
		$result['message'] = 'Ingrese una contraseña';
	} elseif (strlen($user_pass) < 8) {
		$result['message'] = 'La contraseña debe tener minimo 8 caracteres';
	}

	// Send error if any issues with the input
	if (!empty($result['error'])) {
		wp_send_json_error($result);
		return;
	}

	$user = wp_signon([
		'user_login'    => $user_email,
		'user_password' => $user_pass,
		'remember'      => true,
	], false);

	if (is_wp_error($user)) {
		wp_send_json_error(['message' => 'Credenciales incorrectas.']);
	}

	wp_send_json_success(['message' => 'Inicio de sesión exitoso', 'redirect' => home_url()]);
}
