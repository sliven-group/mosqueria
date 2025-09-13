<?php
add_action( 'wp_ajax_update_user', 'update_user' );
add_action( 'wp_ajax_nopriv_update_user', 'update_user' );

function update_user() {
	//$nonce = $_POST['nonce'];
	$user_id = sanitize_text_field($_POST['user_id']);
	$display_name = sanitize_text_field($_POST['account_display_name']);
	$name = sanitize_text_field($_POST['account_first_name']);
	$last_name = sanitize_text_field($_POST['account_last_name']);
	$email = sanitize_email($_POST['account_email']);

	$day = sanitize_text_field($_POST['account_day']);
	$month = sanitize_text_field($_POST['account_month']);
	$year = sanitize_text_field($_POST['account_year']);
	//$code_phone = sanitize_text_field($_POST['account_code_phone']);
	$phone = sanitize_text_field($_POST['account_phone']);
	$confirm_age = $_POST['account_confirm_age'];

	$password = $_POST['password_current'];
	$confirm_password = $_POST['password_confirm'];
	$user_data = get_userdata( $user_id );

	/*if (!wp_verify_nonce($nonce, 'mos')) {
		wp_send_json_error('No se tiene permisos para acceder!', 401);
	}*/

	if (empty($display_name)) {
		wp_send_json_error('El nombre de usuario no existe', 422);
	}

	if (empty($name)) {
		wp_send_json_error('El nombre no existe', 422);
	}

	if (empty($last_name)) {
		wp_send_json_error('El apellido no existe', 422);
	}

	if (empty($email)) {
		wp_send_json_error('El email no existe', 422);
	}

	if(!is_email($email)) {
		wp_send_json_error('Email invalido', 422);
	}

	if(empty($day) || empty($month) || empty($year)) {
		wp_send_json_error('El día, la fecha o la hora no existe', 422);
	}

	/*if(empty($code_phone)) {
		wp_send_json_error('Codigo de telefono no existe', 422);
	}*/

	if(empty($phone)) {
		wp_send_json_error('El telefono no existe', 422);
	}

	if ( empty($user_data) ) {
		wp_send_json_error('No existe el usuario', 422);
	}

	if(!$confirm_age) {
		wp_send_json_error('Confirma tu edad', 422);
	}

	$userId = wp_update_user([
		'ID' => $user_id,
		'first_name' => $name,
		'last_name' => $last_name,
		'display_name' => $display_name,
		'user_email' => $email
	]);

	$birthdate_data = [
		'acf_user_fdn_date'	=> $day,
		'acf_user_fdn_mes' 	=> $month,
		'acf_user_fdn_ano'  => $year,
	];

	if (function_exists('update_field')) {
		update_field('acf_user_fdn_date', $day, 'user_' . $user_id);
		update_field('acf_user_fdn_mes', $month, 'user_' . $user_id);
		update_field('acf_user_fdn_ano', $year, 'user_' . $user_id);
		update_field('acf_user_fdn', $birthdate_data, 'user_' . $user_id);
		//update_field('acf_user_phone_code', $code_phone, 'user_' . $user_id);
		update_field('acf_user_phone', $phone, 'user_' . $user_id);
		update_field('acf_user_mayor_edad', $confirm_age, 'user_' . $user_id);
	}

	ob_start();
	include(get_stylesheet_directory() . '/woocommerce/emails/email-updated-data.php');
	$email_content_first = ob_get_clean();

	$subject = 'Datos actualizados satisfactoriamente';
	//$subject = 'Solicitud para restablecer contraseña';

	wp_mail($email, $subject , $email_content_first, [
		'Content-Type: text/html; charset=UTF-8',
		'From: Mosqueira <mosqueiraonline@mosqueira.com.pe>',
	]);

	if(!empty($password)) {
		if( wp_check_password( $password, $user_data->data->user_pass, $user_data->ID ) ) {
			if ($password === $confirm_password) {
				wp_set_password( $password, $userId );

				ob_start();
				include(get_stylesheet_directory() . '/woocommerce/emails/email-update-password-success.php');
				$email_content = ob_get_clean();

				$subject = 'Contraseña actualizada';

				wp_mail($email, $subject , $email_content, [
					'Content-Type: text/html; charset=UTF-8',
					'From: Mosqueira <mosqueiraonline@mosqueira.com.pe>',
				]);
			}
		}
	}

	$data = [
		'status' => true,
		'message' => __('Actualización exitosa', 'mos'),
	];

	wp_send_json($data);
}
