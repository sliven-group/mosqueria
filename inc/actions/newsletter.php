<?php
// Hook para añadir el menú admin
add_action('admin_menu', 'mos_newsletter_options_page');
function mos_newsletter_options_page() {
    $hook = add_menu_page(
        'Newsletter',                   // Título de la página
        'Newsletter',                   // Texto del menú
        'manage_options',               // Capacidad necesaria
        'mos_newsletter_options_page', // Slug único
        'mos_newsletter_options_page_display', // Función que renderiza la página
        'dashicons-email',              // Icono del menú
        15                             // Posición en el menú
    );

    // Añadimos la opción de pantalla para número de items por página
    add_action("load-$hook", 'mos_newsletter_add_screen_options');
}

function mos_newsletter_add_screen_options() {
    $option = 'newsletter_per_page';
    $args = [
        'label' => 'Número de elementos por página',
        'default' => 20,
        'option' => $option
    ];
    add_screen_option('per_page', $args);
}

// Guardamos el valor de items por página personalizado
add_filter('set-screen-option', 'mos_newsletter_set_screen_option', 10, 3);
function mos_newsletter_set_screen_option($status, $option, $value) {
    if ('newsletter_per_page' === $option) return intval($value);
    return $status;
}

// Página admin que muestra la tabla
function mos_newsletter_options_page_display() {
    if (!current_user_can('manage_options')) return;

    global $wpdb;
    $prefix = $wpdb->prefix;

    // Parámetro paginación (page actual)
    $paged = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;

    // Obtener el número de items por página de la opción guardada
    $per_page = get_user_option('newsletter_per_page', get_current_user_id());
    if (!$per_page || $per_page < 1) $per_page = 10;

    // Parámetro búsqueda
    $search_email = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

    // Construimos WHERE si hay búsqueda
    $where = '';
    $params = [];
    if ($search_email) {
        $where = "WHERE email LIKE %s";
        $params[] = '%' . $wpdb->esc_like($search_email) . '%';
    }

    // Total de registros
    $sql_count = "SELECT COUNT(*) FROM {$prefix}newsletter $where";
    $total_items = $params ? $wpdb->get_var($wpdb->prepare($sql_count, $params)) : $wpdb->get_var($sql_count);

    // Total páginas
    $total_pages = ceil($total_items / $per_page);

    // Offset para la consulta
    $offset = ($paged - 1) * $per_page;

    // Consulta con límite y búsqueda
    $sql = "SELECT * FROM {$prefix}newsletter $where ORDER BY id ASC LIMIT %d OFFSET %d";

    if ($params) {
        $params[] = $per_page;
        $params[] = $offset;
        $newsletter = $wpdb->get_results($wpdb->prepare($sql, $params));
    } else {
        $newsletter = $wpdb->get_results($wpdb->prepare($sql, $per_page, $offset));
    }

    // URL base para paginación y búsqueda (sin paged), asegurando que 'page' esté presente
    $base_url = remove_query_arg('paged', admin_url('admin.php?page=mos_newsletter_options_page'));

    ?>
    <div class="wrap">
        <h1>Newsletter</h1>

        <!-- Exportar Excel -->
        <div>
            <a href="<?php echo admin_url('admin.php?exportar_newsletter=1'); ?>" class="button button-primary">Exportar Excel</a>
        </div>

        <!-- Buscador -->
        <form method="get" style="margin-top: 15px; margin-bottom: 15px;">
            <input type="hidden" name="page" value="mos_newsletter_options_page" />
            <input type="search" name="s" value="<?php echo esc_attr($search_email); ?>" placeholder="Buscar por correo..." />
            <input type="submit" class="button" value="Buscar" />
            <?php if ($search_email): ?>
                <a href="<?php echo esc_url(remove_query_arg('s')); ?>" class="button">Limpiar</a>
            <?php endif; ?>
        </form>

        <!-- Tabla -->
        <table class="widefat striped">
            <thead>
                <tr>
                    <th>ID</th>
					 <th>Email</th>
                    <th>Fecha</th>                   
                </tr>
            </thead>
            <tbody>
                <?php if ($newsletter): ?>
                    <?php foreach ($newsletter as $row): ?>
                        <tr>
                            <td><?php echo esc_html($row->id); ?></td>
							 <td><?php echo esc_html($row->email); ?></td>
                            <td><?php echo esc_html($row->fecha); ?></td>                           
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No hay registros que coincidan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Paginación -->
        <?php if ($total_pages > 1): ?>
            <div class="tablenav">
                <div class="tablenav-pages">
                    <span class="displaying-num"><?php echo $total_items; ?> elementos</span>
                    <span class="pagination-links">

                        <?php if ($paged > 1): ?>
                            <a class="first-page button" href="<?php echo esc_url(add_query_arg(['paged' => 1, 's' => $search_email, 'page' => 'mos_newsletter_options_page'], $base_url)); ?>">
                                <span aria-hidden="true">«</span>
                                <span class="screen-reader-text">Primera página</span>
                            </a>
                            <a class="prev-page button" href="<?php echo esc_url(add_query_arg(['paged' => $paged - 1, 's' => $search_email, 'page' => 'mos_newsletter_options_page'], $base_url)); ?>">
                                <span aria-hidden="true">‹</span>
                                <span class="screen-reader-text">Página anterior</span>
                            </a>
                        <?php else: ?>
                            <span class="first-page button disabled" aria-hidden="true">«</span>
                            <span class="prev-page button disabled" aria-hidden="true">‹</span>
                        <?php endif; ?>

                        <span class="screen-reader-text">Página actual</span>
                        <span id="table-paging" class="paging-input">
                            <span class="tablenav-paging-text"><?php echo $paged; ?> de <span class="total-pages"><?php echo $total_pages; ?></span></span>
                        </span>

                        <?php if ($paged < $total_pages): ?>
                            <a class="next-page button" href="<?php echo esc_url(add_query_arg(['paged' => $paged + 1, 's' => $search_email, 'page' => 'mos_newsletter_options_page'], $base_url)); ?>">
                                <span class="screen-reader-text">Página siguiente</span>
                                <span aria-hidden="true">›</span>
                            </a>
                            <a class="last-page button" href="<?php echo esc_url(add_query_arg(['paged' => $total_pages, 's' => $search_email, 'page' => 'mos_newsletter_options_page'], $base_url)); ?>">
                                <span class="screen-reader-text">Última página</span>
                                <span aria-hidden="true">»</span>
                            </a>
                        <?php else: ?>
                            <span class="next-page button disabled" aria-hidden="true">›</span>
                            <span class="last-page button disabled" aria-hidden="true">»</span>
                        <?php endif; ?>

                    </span>
                </div>
            </div>
        <?php endif; ?>

    </div>
    <?php
}
















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
            include(get_stylesheet_directory() . '/woocommerce/emails/email-newsletter.php');
            $email_content = ob_get_clean();

            wp_mail($user_email, "¡Gracias por su registro!", $email_content, [
                'Content-Type: text/html; charset=UTF-8',
                'From: Mosqueira <newsletter@mosqueira.com.pe>',
            ]);
        }
    }
}
