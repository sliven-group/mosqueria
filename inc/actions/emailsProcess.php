<?php
function custom_send_email_on_order_status_change($order_id, $old_status, $new_status) {
	if(in_array($new_status, array('processing', 'wc-processing'))){
		$order = wc_get_order( $order_id );
		$to = $order->get_billing_email();
		$orderNumber = $order->get_order_number();
		$firstName = $order->get_billing_first_name();
		//$shipping_method = $order->get_shipping_method();

		/*if(strpos($shipping_method,'Express') != false) {
			$message = 'Se ha realizado un nuevo pedido express' . $orderNumber;
			wp_mail( 'alexiavillagarcia@mosqueira.com.pe', 'Nuevo pedido express', $message );
		}*/	

		$user_id = $order->get_user_id();
		$urlPedido = "";
		if($user_id && is_user_logged_in() ) {
			$urlPedido = home_url('mi-cuenta/pedidos/?pedido-id=' . $order->get_order_number());
		} else {
			// El pedido fue hecho por un invitado invitar a registrarse 
			$user = get_user_by('email', $to);
			
			if ($user) {
				$urlPedido = home_url('?modal_account=true');
			}else{
				$urlPedido = home_url('?modal_register=true');
			}
		}


		ob_start();
		include( get_stylesheet_directory() . '/woocommerce/emails/email-custom-processing-order.php' );
		$email_content = ob_get_contents();
		ob_end_clean();

		//$subject = '¡Muchas gracias por su elección! Su compra fue registrada';
		$subject = 'Pedido confirmado';
		wp_mail($to, $subject, $email_content, [
			'Content-Type: text/html; charset=UTF-8',
			'From: Mosqueira <mosqueiraonline@mosqueira.com.pe>',
		]);

	} elseif (in_array($new_status, array('completed'))) {

		global $wpdb;
		
		$order = wc_get_order( $order_id );
		$to = $order->get_billing_email();
		$orderNumber = $order->get_order_number();
		$firstName = $order->get_billing_first_name();
		$date = $order->get_date_created();
		$timezone = new DateTimeZone('America/Lima');
		$date->setTimezone($timezone);
		$dateFormatter = new IntlDateFormatter(
			'es_ES',
			IntlDateFormatter::LONG,
			IntlDateFormatter::NONE, // No time component
			$timezone->getName(),
			IntlDateFormatter::GREGORIAN,
			"d 'de' MMMM 'de' yyyy" // Format for date only
		);

		// Formatter for the time
		$timeFormatter = new IntlDateFormatter(
			'es_ES',
			IntlDateFormatter::NONE, // No date component
			IntlDateFormatter::MEDIUM,
			$timezone->getName(),
			IntlDateFormatter::GREGORIAN,
			"HH:mm:ss" // Format for time only
		);
		$formattedDate = $dateFormatter->format($date);
		$formattedTime = $timeFormatter->format($date);
		//$direccion_facturacion = $order->get_formatted_billing_address();
		$city       = $order->get_shipping_city();
		$state      = $order->get_shipping_state();
		$country    = $order->get_shipping_country();
		$billing_address_1 = $order->get_billing_address_1();
		
		$prefix = $wpdb->prefix;
		$departamento_id = $order->get_meta('_billing_departamento');
		$provincia_id = $order->get_meta('_billing_provincia');
		$distrito_id = $order->get_meta('_billing_distrito');
		$departamento = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT departamento FROM {$prefix}ubigeo_departamento WHERE idDepa = %d",
				$departamento_id
			)
		);
		$provincia = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT provincia FROM {$prefix}ubigeo_provincia WHERE idProv = %d",
				$provincia_id
			)
		);
		$distrito = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT distrito FROM {$prefix}ubigeo_distrito WHERE idDist = %d",
				$distrito_id
			)
		);

		$direccion_facturacion = $departamento . ', ' . $provincia . ', ' . $distrito;
		$text_delivery="";
		if($departamento=="LIMA" && $provincia!="CALLAO"){
			$text_delivery="2 días habiles";
		}else{
			$text_delivery="5 días habiles";
		}
		ob_start();
		include( get_stylesheet_directory() . '/woocommerce/emails/email-custom-completed-order.php' );
		$email_content = ob_get_contents();
		ob_end_clean();

		$subject = '¡Pedido en camino! ';
		//$subject = '¡Su pedido está en camino!';

		wp_mail($to, $subject, $email_content, [
			'Content-Type: text/html; charset=UTF-8',
			'From: Mosqueira <mosqueiraonline@mosqueira.com.pe>',
		]);

	} else {
		error_log("new status: ".$new_status);
	}
}
add_action('woocommerce_order_status_changed', 'custom_send_email_on_order_status_change', 10, 3);
