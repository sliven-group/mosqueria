<?php
add_action( 'wp_ajax_login_password', 'login_password_callback' );
add_action( 'wp_ajax_nopriv_login_password', 'login_password_callback' );

function login_password_callback() {

	$user_email = isset($_POST["user_email"]) ? sanitize_email($_POST['user_email']) : '';

	if (!is_email($user_email)) {
		wp_send_json_error(['message' => 'Correo electrónico no válido.']);
	}

	$user = get_user_by('email', $user_email);
	if (!$user) {
		wp_send_json_error(['message' => 'No se encontró ningún usuario con ese correo.']);
	}

	$key = get_password_reset_key($user);
	if (is_wp_error($key)) {
		wp_send_json_error(['message' => 'Error al generar clave de recuperación.']);
	}

	$reset_url = home_url('/restablecer-contrasena/?key=' . rawurlencode($key) . '&login=' . rawurlencode($user->user_login));

	$first_name = get_user_meta($user->ID, 'first_name', true);

	ob_start();
	include(get_stylesheet_directory() . '/woocommerce/emails/email-update-password.php');
	$email_content = ob_get_clean();

	$subject = 'Solicitud para restablecer contraseña';
	//$subject = 'Restablecer contraseña';

	wp_mail($user_email,$subject, $email_content, [
		'Content-Type: text/html; charset=UTF-8',
		'From: Mosqueira <mosqueiraonline@mosqueira.com.pe>',
	]);

	wp_send_json_success(['message' => 'Revisa tu correo para restablecer la contraseña.']);
}

add_action( 'wp_ajax_reset_password', 'reset_password_callback' );
add_action( 'wp_ajax_nopriv_reset_password', 'reset_password_callback' );

function reset_password_callback() {
	$user_email = isset($_POST["user_email"]) ? sanitize_email($_POST['user_email']) : '';
	$user_pass = isset($_POST['user_pass_1']) ? wp_unslash($_POST['user_pass_1']) : '';
	$user_pass_2 = isset($_POST['user_pass_2']) ? wp_unslash($_POST['user_pass_2']) : '';
	$user_login = sanitize_text_field($_POST['user_login']);
	$rp_key = sanitize_text_field($_POST['rp_key']);

	if ($user_pass !== $user_pass_2) {
		wp_send_json_error(['message' => 'Las contraseñas no coinciden.']);
	} elseif (strlen($user_pass) < 8) {
		wp_send_json_error(['message' => 'La contraseña debe tener al menos 8 caracteres.']);
	} else {
		$user = check_password_reset_key($rp_key, $user_login);
		if (!is_wp_error($user)) {
			reset_password($user, $user_pass);

			$user = get_user_by('email', $user_email);
			$name = get_user_meta($user->ID, 'first_name', true);
			
			ob_start();
			include(get_stylesheet_directory() . '/woocommerce/emails/email-update-password-success.php');
			$email_content = ob_get_clean();

			$subject = 'Contraseña actualizada';
			//$subject = 'Solicitud para restablecer contraseña';
			wp_mail($user_email, $subject , $email_content, [
				'Content-Type: text/html; charset=UTF-8',
				'From: Mosqueira <mosqueiraonline@mosqueira.com.pe>',
			]);
			wp_send_json_success(['message' => 'Contraseña actualizada correctamente.']);
		} else {
			wp_send_json_error(['message' => 'Error al validar el enlace.']);
		}
	}
}

function mos_add_custom_rewrite_endpoint() {
	add_rewrite_rule(
		'^restablecer-contrasena/?',
		'index.php?mos_reset_password=1',
		'top'
	);
}
add_action('init', 'mos_add_custom_rewrite_endpoint');

function mos_add_query_vars($vars) {
	$vars[] = 'mos_reset_password';
	$vars[] = 'key';
	$vars[] = 'login';
	return $vars;
}
add_filter('query_vars', 'mos_add_query_vars');

function mos_template_redirect() {
	if (get_query_var('mos_reset_password') == 1) {
		include get_template_directory() . '/templates/template-reset-password.php';
		exit;
	}
}
add_action('template_redirect', 'mos_template_redirect');

