<?php
add_action( 'wp_ajax_libro_lrq', 'libro_lrq_callback' );
add_action( 'wp_ajax_nopriv_libro_lrq', 'libro_lrq_callback' );

function libro_lrq_callback() {
	global $wpdb;
	$table_name = $wpdb->prefix . "mos_libro_lrq";

	$timezone = new DateTimeZone('America/Lima');
	$date = new DateTime('now', $timezone);
	$date = $date->format('Y-m-d H:i:s');

	$libro_data = array(
		'nombres' => sanitize_text_field($_POST['nombres']),
		'apellidos' => sanitize_text_field($_POST['apellidos']),
		'tipo_doc' => sanitize_text_field($_POST['tipo_doc']),
		'nro_documento' => sanitize_text_field($_POST['nro_documento']),
		'celular' => sanitize_text_field($_POST['celular']),
		'email' => sanitize_email($_POST['email']),
		'direccion' => sanitize_text_field($_POST['direccion']),
		'referencia' => sanitize_text_field($_POST['referencia']),
		'departamento' => sanitize_text_field($_POST['departamento']),
		'provincia' => sanitize_text_field($_POST['provincia']),
		'distrito' => sanitize_text_field($_POST['distrito']),
		'flag_menor' => sanitize_text_field($_POST['flag_menor']),
		'nombre_tutor' => sanitize_text_field($_POST['nombre_tutor']),
		'email_tutor' => sanitize_text_field($_POST['email_tutor']),
		'tipo_doc_tutor' => sanitize_text_field($_POST['tipo_doc_tutor']),
		'numero_documento_tutor' => sanitize_text_field($_POST['numero_documento_tutor']),
		'tipo_reclamacion' => sanitize_text_field($_POST['tipo_reclamacion']),
		'tipo_consumo' => sanitize_text_field($_POST['tipo_consumo']),
		'nro_pedido' => sanitize_text_field($_POST['nro_pedido']),
		'fch_reclamo' => sanitize_text_field($date),
		'descripcion' => sanitize_text_field($_POST['descripcion']),
		'proveedor' => sanitize_text_field($_POST['proveedor']),
		'fch_compra' => sanitize_text_field($_POST['fch_compra']),
		'fch_consumo' => sanitize_text_field($_POST['fch_consumo']),
		'fch_vencimiento' => sanitize_text_field($_POST['fch_vencimiento']),
		'detalle' => sanitize_text_field($_POST['detalle']),
		'pedido_cliente' => sanitize_text_field($_POST['pedido_cliente']),
		'monto_reclamado' => sanitize_text_field($_POST['monto_reclamado']),
		'acepta_contenido' => sanitize_text_field($_POST['acepta_contenido']),
		'acepta_politica' => (isset($_POST['acepta_politica'])) ? sanitize_text_field($_POST['acepta_politica']) : '0',
		'estado' => 1,
	);
	$inserted = $wpdb->insert( $table_name, $libro_data );

	if ( $inserted ) {
		$user_email = $libro_data['email'];
		$admin_email = get_option('admin_email');

		// Correo al usuario
		$user_subject = 'Confirmación de recepción de reclamo';
		$user_message = "Hola " . $libro_data['nombres'] . ",\n\nHemos recibido su reclamo con éxito. Nos pondremos en contacto a la brevedad.\n\nGracias.";
		$headers = array('Content-Type: text/plain; charset=UTF-8');

		// Correo al administrador
		$admin_subject = 'Nuevo reclamo recibido en el Libro de Reclamaciones';
		$admin_message = "Se ha registrado un nuevo reclamo:\n\n" .
						"Nombre: " . $libro_data['nombres'] . " " . $libro_data['apellidos'] . "\n" .
						"Email: " . $libro_data['email'] . "\n" .
						"Teléfono: " . $libro_data['celular'] . "\n" .
						"Tipo de reclamo: " . $libro_data['tipo_reclamacion'] . "\n" .
						"Descripción: " . $libro_data['descripcion'] . "\n" .
						"Fecha: " . $libro_data['fch_reclamo'];
		
		
		ob_start();
		include(get_stylesheet_directory() . '/woocommerce/emails/email-complaints-book.php');
		$email_content = ob_get_clean();
		
		// Correo al usuario
		wp_mail( $user_email, $user_subject, $email_content, [
			'Content-Type: text/html; charset=UTF-8',
			'From: Mosqueira <noreply@mosqueira.com.pe>',
		]);

		// Correo al administrador
		wp_mail( $admin_email, $admin_subject, $email_content, [
			'Content-Type: text/html; charset=UTF-8',
			'From: Mosqueira <noreply@mosqueira.com.pe>',
		]);

		wp_send_json_success( 'Reclamo registrado correctamente.' );
	} else {
		wp_send_json_error( 'Error al registrar el reclamo.');
	}

	wp_die();
}
