<?php
add_action('woocommerce_checkout_update_order_meta', 'save_custom_delivery_method');
function save_custom_delivery_method($order_id) {
	if (!empty($_POST['billing_delivery_methods'])) {
		update_post_meta($order_id, '_billing_delivery_methods', sanitize_text_field($_POST['billing_delivery_methods']));
	}
}

// 3. Crear el método de envío personalizado
add_action('woocommerce_shipping_init', 'custom_delivery_method_init');
function custom_delivery_method_init() {
	class WC_Custom_Delivery_Method extends WC_Shipping_Method {
		public function __construct() {
			$this->id                 = 'custom_delivery_method';
			$this->method_title       = 'Método de Entrega Personalizado';
			$this->method_description = 'Entrega según selección del checkout';
			$this->enabled            = 'yes';
			$this->title              = 'Método de Entrega';
			$this->init();
		}

		public function init() {
			$this->instance_form_fields = array();
			$this->init_settings();
		}

		public function calculate_shipping($package = array()) {
			$selected = WC()->session->get('selected_delivery_method');
			$city     = isset($package['destination']['city']) ? strtoupper(trim($package['destination']['city'])) : '';
			$base_path = get_template_directory() . '/assets/json/';
			$user_id = get_current_user_id();
			$subtotal = WC()->cart->get_subtotal();
			$categoria = get_user_meta($user_id, 'mosqueira_categoria', true);

			// Lógica para determinar si aplica delivery gratis
			$delivery_gratis = false;
			$minimos_envio_gratis = [
				'Platinum' => 200,
				'Gold'     => 200,
				'Silver'   => 350
			];

			if (isset($minimos_envio_gratis[$categoria]) && $subtotal >= $minimos_envio_gratis[$categoria]) {
    		$delivery_gratis = true;
			}

			// Cargar archivo JSON correspondiente
			if (in_array($selected, ['regular', 'express', 'provincia'])) {
				$json_path = $base_path . $selected . '.json';

				if (file_exists($json_path)) {
					$json_data = json_decode(file_get_contents($json_path), true);

					foreach ($json_data as $item) {
						if (strtoupper($item['distrito']) === $city) {
							$precio_envio = $delivery_gratis ? 0 : floatval($item['precio_final']);

							$this->add_rate(array(
								'id'    => $this->id . '_' . $selected . '_' . sanitize_title($city),
								'label' => ucfirst($selected) . ' - ' . $city,
								'cost'  => $precio_envio,
							));
							return;
						}
					}
				}
			}
	}

	}
}

// 4. Registrar el método de envío
add_filter('woocommerce_shipping_methods', 'register_custom_delivery_method');
function register_custom_delivery_method($methods) {
	$methods['custom_delivery_method'] = 'WC_Custom_Delivery_Method';
	return $methods;
}

// 5. Guardar el método seleccionado en sesión para calcular el envío
add_action('woocommerce_checkout_update_order_review', 'store_delivery_method_in_session');
function store_delivery_method_in_session($post_data) {
	parse_str($post_data, $data);
	$selected_method = $data['billing_delivery_methods'] ?? '';
	WC()->session->set('selected_delivery_method', sanitize_text_field($selected_method));
}

// 6. Actualizar checkout al cambiar el campo
add_action('wp_footer', 'refresh_checkout_on_delivery_change');
function refresh_checkout_on_delivery_change() {
	if (is_checkout()) :
	?>
	<script>
		document.addEventListener('change', function(event) {
			if (event.target && event.target.id === 'billing_delivery_methods') {
				//const billingMethodElement = document.getElementById('billing_delivery_methods');
				//const btn = document.getElementById('mos-checkout-next-step');
				//if (billingMethodElement.value !== 'regular') {
					//document.getElementById('cod').style.display = 'none';
				//} else {
					//document.getElementById('cod').style.display = 'block';
				//}
				/*if(billingMethodElement || billingMethodElement.value == '') {
					btn.style.pointerEvents = 'none';
				}*/
				document.body.dispatchEvent(new CustomEvent('update_checkout'));
			}
		});
	</script>
	<?php
	endif;
}

add_filter('woocommerce_checkout_get_value', 'resetear_valor_billing_delivery_methods', 20, 2);

function resetear_valor_billing_delivery_methods($value, $input) {
	if ($input === 'billing_delivery_methods') {
		return ''; // fuerza que no haya valor preseleccionado
	}
	return $value;
}

add_action('wp_ajax_calcular_envio_dinamico', 'calcular_envio_dinamico');
add_action('wp_ajax_nopriv_calcular_envio_dinamico', 'calcular_envio_dinamico');
function calcular_envio_dinamico() {
	$distrito = strtoupper(trim($_POST['distrito'] ?? ''));
	$metodo   = trim($_POST['metodo'] ?? '');

	if (!$distrito || !$metodo) {
		wp_send_json_error(['message' => 'Faltan datos.']);
	}

	// Cargar archivo JSON correspondiente
	$base_path = get_template_directory() . '/assets/json/';
	$json_path = $base_path . $metodo . '.json';

	if (!file_exists($json_path)) {
		wp_send_json_error(['message' => 'Archivo JSON no encontrado para el método.']);
	}

	$json_data = json_decode(file_get_contents($json_path), true);
	if (!is_array($json_data)) {
		wp_send_json_error(['message' => 'Error al leer los datos del JSON.']);
	}

	// Obtener datos del usuario actual para calcular delivery gratis
	$user_id = get_current_user_id();
	$categoria = get_user_meta($user_id, 'mosqueira_categoria', true);
	$subtotal = WC()->cart ? WC()->cart->get_subtotal() : 0;

	$delivery_gratis = false;

	$minimos_envio_gratis = [
		'Platinum' => 200,
		'Gold'     => 200,
		'Silver'   => 350
	];

	if (isset($minimos_envio_gratis[$categoria]) && $subtotal >= $minimos_envio_gratis[$categoria]) {
		$delivery_gratis = true;
	}

	foreach ($json_data as $item) {
		if (strtoupper(trim($item['distrito'])) === $distrito) {
			$precio = $delivery_gratis ? 0 : floatval($item['precio_final']);
			wp_send_json_success([
				'metodo' => ucfirst($metodo) . ' - ' . $distrito,
				'precio' => $precio,
				'gratis' => $delivery_gratis,
			]);
		}
	}

	wp_send_json_error(['message' => 'No se encontró el distrito en el archivo JSON.']);
}
