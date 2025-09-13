<?php
function mos_reporte_pedidos_woocommerce() {
    if (!current_user_can('manage_options')) return;

    global $wpdb;
    $prefix = $wpdb->prefix;

    // Obtener fechas del formulario
    $fecha_desde = isset($_GET['fecha_desde']) ? sanitize_text_field($_GET['fecha_desde']) : '';
    $fecha_hasta = isset($_GET['fecha_hasta']) ? sanitize_text_field($_GET['fecha_hasta']) : '';

    // Argumentos para obtener pedidos
    $args = [
        'limit'  => -1,
        'status' => ['completed', 'processing'],
    ];

    if ($fecha_desde) {
        $args['date_after'] = $fecha_desde;
    }
    if ($fecha_hasta) {
        $args['date_before'] =  $fecha_hasta;
    }

    $orders = wc_get_orders($args);

    ?>
    <div class="wrap">
        <h1>Reporte de Pedidos</h1>

        <!-- Filtro por fechas -->
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
                $first  = $order->get_billing_first_name();
                $last   = $order->get_billing_last_name();
                $email  = $order->get_billing_email();
                $dni    = $order->get_meta('additional_dni');
                $phone  = $order->get_meta('additional_phone');
                $fecha_nacimiento = get_field('acf_user_fdn', 'user_' . $user_id);    
                $direccion = $order->get_billing_address_1();
                $departamento_id = $order->get_meta('_billing_departamento');
                $provincia_id    = $order->get_meta('_billing_provincia');
                $distrito_id     = $order->get_meta('_billing_distrito');
                $departamento = $wpdb->get_var($wpdb->prepare("SELECT departamento FROM {$prefix}ubigeo_departamento WHERE idDepa = %d", $departamento_id));
                $provincia    = $wpdb->get_var($wpdb->prepare("SELECT provincia FROM {$prefix}ubigeo_provincia WHERE idProv = %d", $provincia_id));
                $distrito     = $wpdb->get_var($wpdb->prepare("SELECT distrito FROM {$prefix}ubigeo_distrito WHERE idDist = %d", $distrito_id));
                $skus = [];
                $productos = [];
                foreach ($order->get_items() as $item) {
                    if ($product = $item->get_product()) {
                        $skus[] = $product->get_sku();
                        $productos[] = $product->get_name();
                    }
                }
                $skus_str      = implode(', ', $skus);
                $productos_str = implode(', ', $productos);
                $subtotal      = $order->get_subtotal();
                $shippingCost  = $order->get_shipping_total();

                // Ajustar fecha a zona horaria WP
                $fecha_obj = $order->get_date_created();
                if ($fecha_obj) {
                    $fecha_obj->setTimezone(new DateTimeZone(wp_timezone_string()));
                    $fecha = $fecha_obj->format('d-m-Y');
                } else {
                    $fecha = '';
                }
                ?>
                <tr>
                    <td><?php echo esc_html($first); ?></td>
                    <td><?php echo esc_html($last); ?></td>
                    <td><?php echo esc_html($dni); ?></td>
                    <td><?php echo esc_html($phone); ?></td>
                    <td><?php echo esc_html($email); ?></td>
                    <td><?php                    
                                if ($fecha_nacimiento) {
                                    $meses = [
                                        'enero' => '01',
                                        'febrero' => '02',
                                        'marzo' => '03',
                                        'abril' => '04',
                                        'mayo' => '05',
                                        'junio' => '06',
                                        'julio' => '07',
                                        'agosto' => '08',
                                        'septiembre' => '09',
                                        'octubre' => '10',
                                        'noviembre' => '11',
                                        'diciembre' => '12'
                                    ];
                                    $dia = $fecha_nacimiento['acf_user_fdn_date'];
                                    $mes_nombre = strtolower($fecha_nacimiento['acf_user_fdn_mes']);
                                    $anio = $fecha_nacimiento['acf_user_fdn_ano'];
                                    $mes_numero = isset($meses[$mes_nombre]) ? $meses[$mes_nombre] : '00';
                                    $dia_formateado = str_pad($dia, 2, '0', STR_PAD_LEFT);
                                    $mes_formateado = str_pad($mes_numero, 2, '0', STR_PAD_LEFT);
                                    echo $dia_formateado . '/' . $mes_formateado . '/' . $anio;
                                }
                            ?>        
                    </td>
                    <td><?php echo esc_html($direccion); ?></td>
                    <td><?php echo esc_html($departamento); ?></td>
                    <td><?php echo esc_html($provincia); ?></td>
                    <td><?php echo ($departamento && $provincia) ? esc_html($distrito) : ''; ?></td>
                    <td><?php echo esc_html($skus_str); ?></td>
                    <td><?php echo esc_html($productos_str); ?></td>
                    <td><?php echo wc_price($subtotal); ?></td>
                    <td><?php echo wc_price($shippingCost); ?></td>
                    <td><?php echo esc_html($fecha); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}

add_action('admin_menu', function() {
    add_submenu_page(
        'woocommerce',
        'Reporte de Pedidos',
        'Reporte de Pedidos',
        'manage_options',
        'mos_reporte_pedidos',
        'mos_reporte_pedidos_woocommerce'
    );
});
