<?php
add_action( 'wp_ajax_update_address', 'update_address' );
add_action( 'wp_ajax_nopriv_update_address', 'update_address' );

add_action('wp_ajax_get_provincias', 'get_provincias_by_departamento');
add_action('wp_ajax_nopriv_get_provincias', 'get_provincias_by_departamento');

add_action('wp_ajax_get_distritos', 'get_distritos_by_provincia');
add_action('wp_ajax_nopriv_get_distritos', 'get_distritos_by_provincia');

function update_address() {
	$user_id 			= sanitize_text_field($_POST['user_id']);
	$nombre       = sanitize_text_field($_POST['billing_first_name']);
	$apellidos    = sanitize_text_field($_POST['billing_last_name']);
	$direccion    = sanitize_text_field($_POST['billing_adresss']);
	$departamento = sanitize_text_field($_POST['billing_departamento']);
	$provincia    = sanitize_text_field($_POST['billing_provincia']);
	$distrito     = sanitize_text_field($_POST['billing_distrito']);

	$user_id = get_current_user_id();
	if (!$user_id) {
		wp_send_json_error(['message' => 'Usuario no autenticado']);
		wp_die();
	}

	update_user_meta($user_id, 'billing_first_name', $nombre);
	update_user_meta($user_id, 'billing_last_name', $apellidos);
	update_user_meta($user_id, 'billing_address_1', $direccion);

	update_user_meta($user_id, 'billing_departamento', $departamento);
	update_user_meta($user_id, 'billing_provincia', $provincia);
	update_user_meta($user_id, 'billing_distrito', $distrito);

	$user_info = get_userdata($user_id);
	$email = $user_info->user_email;
	ob_start();
	include(get_stylesheet_directory() . '/woocommerce/emails/email-direction-success.php');
	$email_content = ob_get_clean();

	
	$subject = 'Dirección guardada';
	//$subject = 'Datos actualizados satisfactoriamente';

	wp_mail($email,$subject, $email_content, [
		'Content-Type: text/html; charset=UTF-8',
		'From: Mosqueira <mosqueiraonline@mosqueira.com.pe>',
	]);

	wp_send_json_success(['message' => 'Dirección guardada correctamente']);
	wp_die();
}

function get_cached_locations($table, $cache_key, $id_column, $name_column, $cache_time = 168 * HOUR_IN_SECONDS) {
	global $wpdb;

	// Intentar obtener desde caché
	$locations = get_transient($cache_key);

	if (empty($locations)) {
		// Consulta segura con nombre de tabla dinámico
		$results = $wpdb->get_results("SELECT `$id_column`, `$name_column` FROM `" . $wpdb->prefix . $table . "`");

		// Verificar errores en la consulta
		if ( ! empty($wpdb->last_error) ) {
			//error_log('Error en consulta SQL: ' . $wpdb->last_error);
			return []; // Devuelve array vacío si hay error
		}

		// Procesar resultados
		$locations = [];
		if ($results) {
			foreach ($results as $item) {
				$locations[$item->$id_column] = $item->$name_column;
			}
		}

		// Guardar en caché (incluso si está vacío, para evitar repetir la consulta)
		set_transient($cache_key, $locations, $cache_time);

		// Logging opcional
		// error_log("Se guardó el resultado en caché para la clave: $cache_key");
	} else {
		// Logging opcional
		// error_log("Se obtuvo desde caché la clave: $cache_key");
	}

	return $locations;
}


function get_provincias_by_departamento() {
	global $wpdb;

	$id_depa = isset($_POST['id_depa']) ? intval($_POST['id_depa']) : 0;

	if ($id_depa <= 0) {
		wp_send_json_error(['message' => 'Departamento inválido']);
	}

	$table = $wpdb->prefix . 'ubigeo_provincia';
	$results = $wpdb->get_results($wpdb->prepare(
		"SELECT idProv, provincia FROM {$table} WHERE idDepa = %d",
			$id_depa
	));

	$provincias = [];
	foreach ($results as $prov) {
    $provincias[] = [
			'idProv' => $prov->idProv,
			'nombre' => $prov->provincia
    ];
	}

	wp_send_json_success($provincias);
}

function get_distritos_by_provincia() {
	global $wpdb;

	$id_prov = isset($_POST['id_prov']) ? intval($_POST['id_prov']) : 0;

	if ($id_prov <= 0) {
		wp_send_json_error(['message' => 'Provincia inválida']);
	}

	$table = $wpdb->prefix . 'ubigeo_distrito';
	$results = $wpdb->get_results($wpdb->prepare(
		"SELECT idDist, distrito FROM {$table} WHERE idProv = %d",
			$id_prov
	));

	$distritos = [];
	foreach ($results as $dist) {
		$distritos[] = [
			'idDist' => $dist->idDist,
			'nombre' => $dist->distrito
    ];
	}

	wp_send_json_success($distritos);
}
