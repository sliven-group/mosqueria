<?php
add_action('admin_menu', function () {
    add_submenu_page(
        'woocommerce',
        'Reporte de Pedidos',
        'Reporte de Pedidos',
        'manage_options',
        'mos_reporte_pedidos',
        'mos_reporte_pedidos_woocommerce'
    );
    add_action('load-woocommerce_page_mos_reporte_pedidos', 'mos_reporte_pedidos_screen_options');
});

// Agrega opción de "elementos por página"
function mos_reporte_pedidos_screen_options() {
    add_screen_option('per_page', [
        'label' => 'Pedidos por página',
        'default' => 20,
        'option' => 'mos_pedidos_per_page'
    ]);
}

add_filter('set-screen-option', function ($status, $option, $value) {
    if ($option === 'mos_pedidos_per_page') {
        return (int)$value;
    }
    return $status;
}, 10, 3);

function mos_reporte_pedidos_woocommerce()
{
    if (!current_user_can('manage_options')) return;

    global $wpdb;
    $prefix = $wpdb->prefix;

    // Filtros por fechas
    $fecha_desde = isset($_GET['fecha_desde']) ? sanitize_text_field($_GET['fecha_desde']) : '';
    $fecha_hasta = isset($_GET['fecha_hasta']) ? sanitize_text_field($_GET['fecha_hasta']) : '';

    // Argumentos para obtener pedidos
    $args = [
        'limit'  => -1,
        'status' => ['completed', 'processing'],
    ];

    if ($fecha_desde && $fecha_hasta) {
        $args['date_after'] = $fecha_desde;
        $args['date_before'] = $fecha_hasta;
    } elseif ($fecha_desde) {
        $args['date_after'] = $fecha_desde;
        $args['date_before'] = $fecha_desde;
    } elseif ($fecha_hasta) {
        $args['date_after'] = $fecha_hasta;
        $args['date_before'] = $fecha_hasta;
    }

    // Obtener todos los pedidos que cumplen con los filtros
    $all_orders = wc_get_orders($args);

    // Paginación
    $per_page = get_user_option('mos_pedidos_per_page', get_current_user_id());
    $per_page = $per_page ?: 20;

    $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $total_orders = count($all_orders);
    $total_pages = ceil($total_orders / $per_page);
    $offset = ($current_page - 1) * $per_page;

    // Cortar pedidos para mostrar solo los de la página actual
    $orders = array_slice($all_orders, $offset, $per_page);

    $base_url = remove_query_arg('paged', $_SERVER['REQUEST_URI']);
    ?>
    <div class="wrap">
        <h1>Reporte de Pedidos</h1>

        <form method="GET" action="">
            <input type="hidden" name="page" value="mos_reporte_pedidos">
            <label>Desde: <input type="date" name="fecha_desde" value="<?php echo esc_attr($fecha_desde); ?>"></label>
            <label>Hasta: <input type="date" name="fecha_hasta" value="<?php echo esc_attr($fecha_hasta); ?>"></label>
            <button type="submit" class="button button-primary">Filtrar</button>
            <a href="<?php echo admin_url('admin.php?page=mos_reporte_pedidos'); ?>" class="button">Limpiar</a>
            <a href="<?php echo esc_url(add_query_arg(['export_excel' => '1'], admin_url('admin.php?page=mos_reporte_pedidos&fecha_desde=' . $fecha_desde . '&fecha_hasta=' . $fecha_hasta))); ?>" class="button button-secondary">Exportar a Excel</a>
        </form>

        <br>

        <table class="widefat striped">
            <thead>
                <tr>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>DNI</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Fecha de nacimiento</th>
                    <th>Dirección</th>
                    <th>Departamento</th>
                    <th>Provincia</th>
                    <th>Distrito</th>
                    <th>Códigos SKU</th>
                    <th>Producto</th>
                    <th>Ingresos Brutos</th>
                    <th>Delivery</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) :
                    $user_id = $order->get_user_id();
                    $first = $order->get_billing_first_name();
                    $last = $order->get_billing_last_name();
                    $email = $order->get_billing_email();
                    $dni = $order->get_meta('additional_dni');
                    $phone = $order->get_meta('additional_phone');
                    $fecha_nacimiento = get_field('acf_user_fdn', 'user_' . $user_id);
                    $direccion = $order->get_billing_address_1();

                    $departamento_id = $order->get_meta('_billing_departamento');
                    $provincia_id = $order->get_meta('_billing_provincia');
                    $distrito_id = $order->get_meta('_billing_distrito');

                    $departamento = $wpdb->get_var($wpdb->prepare("SELECT departamento FROM {$prefix}ubigeo_departamento WHERE idDepa = %d", $departamento_id));
                    $provincia = $wpdb->get_var($wpdb->prepare("SELECT provincia FROM {$prefix}ubigeo_provincia WHERE idProv = %d", $provincia_id));
                    $distrito = ($departamento && $provincia) ? $wpdb->get_var($wpdb->prepare("SELECT distrito FROM {$prefix}ubigeo_distrito WHERE idDist = %d", $distrito_id)) : '';

                    $skus = [];
                    $productos = [];

                    foreach ($order->get_items() as $item) {
                        if ($product = $item->get_product()) {
                            $skus[] = $product->get_sku();
                            $productos[] = $product->get_name();
                        }
                    }

                    $fecha = '';
                    if ($order->get_date_created()) {
                        $order->get_date_created()->setTimezone(new DateTimeZone(wp_timezone_string()));
                        $fecha = $order->get_date_created()->format('d-m-Y');
                    }

                    $meses = [
                        'enero' => '01', 'febrero' => '02', 'marzo' => '03',
                        'abril' => '04', 'mayo' => '05', 'junio' => '06',
                        'julio' => '07', 'agosto' => '08', 'septiembre' => '09',
                        'octubre' => '10', 'noviembre' => '11', 'diciembre' => '12'
                    ];
                    ?>
                    <tr>
                        <td><?php echo esc_html($first); ?></td>
                        <td><?php echo esc_html($last); ?></td>
                        <td><?php echo esc_html($dni); ?></td>
                        <td><?php echo esc_html($phone); ?></td>
                        <td><?php echo esc_html($email); ?></td>
                        <td>
                            <?php
                            if ($fecha_nacimiento) {
                                $dia = str_pad($fecha_nacimiento['acf_user_fdn_date'], 2, '0', STR_PAD_LEFT);
                                $mes = str_pad($meses[strtolower($fecha_nacimiento['acf_user_fdn_mes'])] ?? '00', 2, '0', STR_PAD_LEFT);
                                $anio = $fecha_nacimiento['acf_user_fdn_ano'];
                                echo "{$dia}/{$mes}/{$anio}";
                            }
                            ?>
                        </td>
                        <td><?php echo esc_html($direccion); ?></td>
                        <td><?php echo esc_html($departamento); ?></td>
                        <td><?php echo esc_html($provincia); ?></td>
                        <td><?php echo esc_html($distrito); ?></td>
                        <td><?php echo esc_html(implode(', ', $skus)); ?></td>
                        <td><?php echo esc_html(implode(', ', $productos)); ?></td>
                        <td><?php echo wc_price($order->get_subtotal()); ?></td>
                        <td><?php echo wc_price($order->get_shipping_total()); ?></td>
                        <td><?php echo esc_html($fecha); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($total_pages > 1): ?>
            <div class="tablenav">
                <div class="tablenav-pages">
                    <span class="displaying-num"><?php echo $total_orders; ?> pedidos</span>
                    <span class="pagination-links">
                        <?php
                        $base_url = remove_query_arg('paged');
                        $first_url = esc_url(add_query_arg(['paged' => 1], $base_url));
                        $prev_url = esc_url(add_query_arg(['paged' => max(1, $current_page - 1)], $base_url));
                        $next_url = esc_url(add_query_arg(['paged' => min($total_pages, $current_page + 1)], $base_url));
                        $last_url = esc_url(add_query_arg(['paged' => $total_pages], $base_url));
                        ?>
                        <a class="first-page button" href="<?php echo $first_url; ?>">«</a>
                        <a class="prev-page button" href="<?php echo $prev_url; ?>">‹</a>
                        <span class="paging-input"><?php echo $current_page; ?> de <span class="total-pages"><?php echo $total_pages; ?></span></span>
                        <a class="next-page button" href="<?php echo $next_url; ?>">›</a>
                        <a class="last-page button" href="<?php echo $last_url; ?>">»</a>
                    </span>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php
}


//*********************** Hook para añadir el menú admin newsletter
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
//***********************END  Hook para añadir el menú admin newsletter