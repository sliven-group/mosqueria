<?php
/*add_action( 'wp_ajax_mos_quiz', 'mos_quiz_callback' );
add_action( 'wp_ajax_nopriv_mos_quiz', 'mos_quiz_callback' );

function mos_quiz_callback() {

}*/

add_action( 'admin_menu', 'mos_quiz_options_page');

function mos_quiz_options_page() {
	add_menu_page(
		'Encuesta',
		'Encuesta de satisfacción',
		'manage_options',
		'mos_quiz_options_page',
		'mos_quiz_options_page_display',
		'dashicons-flag',
		'15'
	);
}

function mos_quiz_options_page_display() {
	require_once trailingslashit(get_stylesheet_directory()) . 'inc/admin/quiz-page.php';
}

add_action( 'admin_menu', 'mos_export_quiz');
function mos_export_quiz() {
	if (isset($_POST['export-report-quiz']) ) {
		global $wpdb;
    $table_name = $wpdb->prefix . 'quiz';

		$month = isset($_POST['export-mos-month-quiz']) ? (int) $_POST['export-mos-month-quiz'] : 0;
		$year = isset($_POST['export-mos-year-quiz']) ? (int) $_POST['export-mos-year-quiz'] : 0;

		// Si vienen valores inválidos, usamos el mes/año actual
    if ( $month < 1 || $month > 12 ) {
			$month = (int) wp_date('n');
    }
    if ( $year < 1970 || $year > 2100 ) {
			$year = (int) wp_date('Y');
    }

		// Calculamos primer y último día del mes
    $start = sprintf('%04d-%02d-01 00:00:00', $year, $month);
    // t = último día del mes
    $last_day = (new DateTime($start))->format('t');
    $end   = sprintf('%04d-%02d-%02d 23:59:59', $year, $month, $last_day);

		$query   = "SELECT * FROM {$table_name} WHERE fecha BETWEEN %s AND %s ORDER BY fecha DESC";
		$results = $wpdb->get_results( $wpdb->prepare($query, $start, $end), ARRAY_A );

    //$results = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY fecha DESC", ARRAY_A );

		// Export results
		ob_start();
		$date = wp_date('d-m-Y');
		//$filename = "reporte-encuesta-satisfaccion-{$date}.csv";
		$filename = "reporte-encuesta-satisfaccion-{$year}-" . sprintf('%02d', $month) . "-generado-{$date}.csv";

		$delimiter = ';';
		$data_rows = array();

		$header_row = array(
			0 => 'Usuario WP',
			1 => 'Fecha',
			2 => '¿Qué tan probable es que recomiende Mosqueira a personas que conoce (familiares, amigos, colegas, etc.)?',
			3 => '¿Cómo calificaría la calidad del producto que recibió?',
			4 => '¿Cómo calificaría la presentación y el empaque del producto?',
			5 => '¿Cómo describiría su experiencia general de compra en Mosqueira?',
			6 => '¿Qué fue lo que lo motivó a comprar en Mosqueira? (Opción múltiple)',
			7 => 'Otro',
			8 => '¿Por qué canal realizó su última compra?',
			9 => '¿Cómo calificaría su experiencia de compra en el sitio web?',
			10 => '¿Le resultó fácil navegar por el sitio y encontrar lo que buscaba?',
			11 => '¿Qué mejoraría? - Web',
			12 => '¿Cómo calificaría la atención del asesor de ventas?',
			13 => '¿Qué mejoraría? - WhatsApp',
			14 => '¿Cómo calificaría el servicio de entrega?',
			15 => '¿Qué mejoraría? - Entrega',
			16 => '¿Hay algo más que desee comentarnos o que podríamos mejorar?',
		);

		foreach( $results as $result ) {
			$userWp = $result['user_wp'];
			$date = $result['fecha'];
			$recommendation = $result['recommendation'];
			$qualification = $result['qualification'];
			$presentation = $result['presentation'];
			$experience = $result['experience'];
			$reasons = $result['reasons'];
			$other_reason = $result['other_reason'];
			$channel = $result['channel'];
			$site_experience = $result['site_experience'];
			$site_navigation = $result['site_navigation'];
			$site_improvement = $result['site_improvement'];
			$advisor_experience = $result['advisor_experience'];
			$advisor_improvement = $result['advisor_improvement'];
			$delivery_experience = $result['delivery_experience'];
			$delivery_improvement = $result['delivery_improvement'];
			$comment = $result['comment'];

			$row = array (
				0 => $userWp,
				1 => $date,
				2 => $recommendation,
				3 => $qualification,
				4 => $presentation,
				5 => $experience,
				6 => $reasons,
				7 => $other_reason,
				8 => $channel,
				9 => $site_experience,
				10 => $site_navigation,
				11 => $site_improvement,
				12 => $advisor_experience,
				13 => $advisor_improvement,
				14 => $delivery_experience,
				15 => $delivery_improvement,
				16 => $comment
			);
			$data_rows[] = $row;
		}

		$fh = @fopen( 'php://output', 'w' );
		fprintf( $fh, chr(0xEF) . chr(0xBB) . chr(0xBF) );
		header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		header( 'Content-Description: File Transfer' );
		header( 'Content-type: text/csv' );
		header( "Content-Disposition: attachment; filename={$filename}" );
		header( 'Expires: 0' );
		header( 'Pragma: public' );
		fputcsv( $fh, $header_row, $delimiter );
		foreach ( $data_rows as $data_row ) {
			fputcsv( $fh, $data_row, $delimiter );
		}
		fclose( $fh );
		ob_end_flush();
		die();
	}
}

add_action('wp_ajax_mos_submit_quiz', 'mos_handle_quiz_submission');
add_action('wp_ajax_nopriv_mos_submit_quiz', 'mos_handle_quiz_submission');

function mos_handle_quiz_submission() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'quiz';

	$user_wp      			  = sanitize_text_field($_POST['user_wp']);
	$recommendation       = intval($_POST['recommendation']);
	$qualification        = sanitize_text_field($_POST['qualification']);
	$presentation         = sanitize_text_field($_POST['presentation']);
	$experience           = intval($_POST['experience']);
	$reasons              = maybe_serialize($_POST['reasons']);
	$other_reason         = sanitize_text_field($_POST['other_reason']);
	$channel              = sanitize_text_field($_POST['channel']);
	$site_experience      = sanitize_text_field($_POST['site_experience']);
	$site_navigation      = sanitize_text_field($_POST['site_navigation']);
	$site_improvement     = sanitize_text_field($_POST['site_improvement']);
	$advisor_experience   = sanitize_text_field($_POST['advisor_experience']);
	$advisor_improvement  = sanitize_text_field($_POST['advisor_improvement']);
	$delivery_experience  = sanitize_text_field($_POST['delivery_experience']);
	$delivery_improvement = sanitize_text_field($_POST['delivery_improvement']);
	$comment              = sanitize_textarea_field($_POST['comment']);

	if (empty($user_wp)) {
		wp_send_json_error('El nombre de usuario es obligatorio.');
	}

	if (!username_exists($user_wp)) {
		wp_send_json_error('El usuario no existe.');
	}

	if ($recommendation < 1 || $recommendation > 10) {
		wp_send_json_error('La recomendación debe ser un número entre 1 y 10.');
	}

	if (empty($qualification)) {
		wp_send_json_error('La calificación es obligatoria.');
	}

	if (empty($presentation)) {
		wp_send_json_error('La presentación es obligatoria.');
	}

	if ($experience < 0) {
		wp_send_json_error('La experiencia debe ser un número positivo.');
	}

	$existe = $wpdb->get_var( $wpdb->prepare(
		"SELECT COUNT(*) FROM $table_name WHERE user_wp = %s",
		$user_wp
	));

	if ($existe > 0) {
		wp_send_json_error('Ya has completado la encuesta. Solo se permite una respuesta por usuario.');
	}

	$wpdb->insert(
		$table_name,
		[
		  'user_wp'      				=> $user_wp,
			'recommendation'      => $recommendation,
			'qualification'       => $qualification,
			'presentation'        => $presentation,
			'experience'          => $experience,
			'reasons'             => $reasons,
			'other_reason'        => $other_reason,
			'channel'             => $channel,
			'site_experience'     => $site_experience,
			'site_navigation'     => $site_navigation,
			'site_improvement'    => $site_improvement,
			'advisor_experience'  => $advisor_experience,
			'advisor_improvement' => $advisor_improvement,
			'delivery_experience' => $delivery_experience,
			'delivery_improvement'=> $delivery_improvement,
			'comment'             => $comment,
		]
	);

	if ($wpdb->insert_id) {
		$user = get_user_by('login', $user_wp);
		if ($user) {
			$user_id = $user->ID;
			$puntos_actuales = (int) get_user_meta($user_id, 'mosqueira_puntos', true);
			$nuevo_total = $puntos_actuales + 50;

			update_user_meta($user_id, 'mosqueira_puntos', $nuevo_total);

			// Registrar en el historial
			mosqueira_agregar_evento_historial(
				$user_id,
				'Ha ganado 50 puntos por completar un cuestionario',
				'<p>¡Gracias por su opinión!</p>',
				'+50',
				'puntos'
			);

			// Verificar si cambia de categoría
			mosqueira_actualizar_categoria($user_id, $nuevo_total);

			// Enviar email de confirmación
			$to = $user->user_email;
			$subject = 'Gracias por completar el cuestionario';
			$message = "Hola {$user->display_name},\n\nGracias por completar el cuestionario. Has ganado 50 puntos.\n\n¡Saludos!\nEquipo Mosqueira";
			$headers = ['Content-Type: text/plain; charset=UTF-8'];

			wp_mail($to, $subject, $message, $headers);
		}
		wp_send_json_success('Respuesta guardada correctamente.');

	} else {
		wp_send_json_error('Error al guardar la respuesta.');
	}
}

add_action('woocommerce_order_status_completed', function($order_id) {
	$order = wc_get_order($order_id);
	$user_id = $order->get_user_id();
	if ($user_id) {
		// Guardar la fecha actual de la compra
		update_user_meta($user_id, 'mos_last_purchase_date', current_time('mysql'));
	}
});

if (!wp_next_scheduled('mos_check_survey_email')) {
	wp_schedule_event(time(), 'daily', 'mos_check_survey_email');
}

add_action('mos_check_survey_email', function() {
	$users = get_users([
		'meta_key'     => 'mos_last_purchase_date',
		'meta_compare' => 'EXISTS',
	]);

	foreach ($users as $user) {
		$purchase_date = get_user_meta($user->ID, 'mos_last_purchase_date', true);
		if (!$purchase_date) {
			continue;
		}

		$purchase_timestamp = strtotime($purchase_date);
		$now = current_time('timestamp');
		$diff_in_days = ($now - $purchase_timestamp) / DAY_IN_SECONDS;

		//error_log("User ID: {$user->ID} | Días desde compra: {$diff_in_days}");

		if ($diff_in_days >= 5 && $diff_in_days <= 15) {
			$survey_sent = get_user_meta($user->ID, 'mos_survey_sent', true);
			if (!$survey_sent) {
				//error_log("Enviando correo a: {$user->user_email}");

				$url = home_url('encuesta');

				ob_start();
				include(get_stylesheet_directory() . '/woocommerce/emails/email-quiz.php');
				$email_content = ob_get_clean();

				wp_mail($user->user_email, "Su opinión es importante para nosotros", $email_content, [
					'Content-Type: text/html; charset=UTF-8',
					'From: Mosqueira <mosqueiraonline@mosqueira.com.pe>',
				]);

				update_user_meta($user->ID, 'mos_survey_sent', 1);
				update_user_meta($user->ID, 'mos_survey_start_time', current_time('mysql'));
			} else {
				//error_log("Encuesta ya enviada a: {$user->user_email}");
			}
		}
	}
});
