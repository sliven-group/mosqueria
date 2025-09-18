<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="mos__thanks">
    <div class="mos__container">
        <div class="mos__thanks__container">
            <?php if ( $order->has_status( 'failed' ) ) : ?>
                <!-- Mensaje de error -->
                <svg class="mos__thanks__error" width="77" height="77" viewBox="0 0 77 77" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- SVG omitido para brevedad -->
                </svg>
                <h1 class="text-center">¡Error!</h1>
                <p class="text-center woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed">
                    <?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?>
                </p>
                <p class="text-center woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                    <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="mos__btn mos__btn--primary"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="mos__btn mos__btn--primary"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
                    <?php endif; ?>
                </p>
            <?php else : ?>
                <!-- Mensaje éxito -->
                <svg class="mos__thanks__success" width="77" height="77" viewBox="0 0 77 77" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- SVG omitido para brevedad -->
                </svg>
                <h1 class="text-center">¡GRACIAS POR LA COMPRA!</h1>
                <p class="text-justify">Ha dado un nuevo paso hacia el éxito. Muy pronto tendrá en sus manos una prenda creada para acompañarle en cada logro, confeccionada con la excelencia y el detalle que distinguen a Mosqueira. Le mantendremos informado sobre el avance de su pedido.</p>

                <div class="mos__thanks__order ds-flex justify-space-between align-start">
                    <div class="mos__thanks__order__col">
                        <h2>Orden #<?php echo $order->get_order_number(); ?></h2>
                        <p>Hecho el <?php echo wc_format_datetime( $order->get_date_created() ); ?></p>
                        <p><?php echo esc_html( $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() ); ?></p>
                        <p><?php echo esc_html( $order->get_billing_email() ); ?></p>
                        <p>PERÚ</p>
                        <p><?php echo wp_kses_post( $order->get_formatted_billing_address() ); ?></p>
                    </div>
                    <div class="mos__thanks__order__col">
                        <?php if ( is_user_logged_in() ) : ?>
                            <a href="<?php echo home_url('mi-cuenta/pedidos/#') . $order->get_order_number(); ?>" class="mos__btn mos__btn--primary">MIS ORDENES</a>
                        <?php else: $user = get_user_by('email', $order->get_billing_email()); ?>
                            <?php if ($user) { ?>
                                <a href="<?php echo home_url('?modal_account=true'); ?>" class="mos__btn mos__btn--primary">MIS ORDENES</a>
                            <?php } else { ?>
                                <a href="<?php echo home_url('?modal_register=true&nombre=' . urlencode($order->get_billing_first_name()) . '&apellido=' . urlencode($order->get_billing_last_name()) . '&correo=' . urlencode($order->get_billing_email()) . '&url_account=' . urlencode(home_url('mi-cuenta/pedidos/'))); ?>" class="mos__btn mos__btn--primary">MIS ORDENES</a>
                            <?php } ?>
                        <?php endif; ?>
                    </div>
                </div>

                <?php $items = $order->get_items(); ?>
                <?php if(!empty($items)) : ?>
                    <div class="mos__thanks__order__items">
                        <?php foreach ($items as $item_id => $item) : ?>
                            <?php
                            $product = $item->get_product();
                            if (!$product) continue;

                            $product_name = $product->get_name();
                            $product_price = wc_price($product->get_price());
                            $quantity = $item->get_quantity();
                            $product_image = $product->get_image('medium');
                            ?>
                            <div class="ds-flex align-start justify-space-between">
                                <?php echo $product_image; ?>
                                <div class="info">
                                    <h4><?php echo esc_html($product_name); ?></h4>
                                    <p><?php echo $product_price; ?></p>
                                    <p>Cantidad: <?php echo esc_html($quantity); ?></p>

                                    <?php
                                    // Mostrar productos del pack si existen
                                    $pack_items = $item->get_meta('_custom_pack_items');
                                    if (!empty($pack_items) && is_array($pack_items)) :
                                        echo '<strong>Contenido del pack:</strong><ul>';
                                        foreach ($pack_items as $variation_id => $pack_item) :
                                            $pack_product = wc_get_product($variation_id);
                                            if (!$pack_product) continue;

                                            $pack_title = isset($pack_item['title']) ? $pack_item['title'] : $pack_product->get_name();
                                            $pack_qty = isset($pack_item['quantity']) ? intval($pack_item['quantity']) : 1;
                                            $pack_size = isset($pack_item['size']) ? $pack_item['size'] : '';

                                            echo '<li>';
                                            echo esc_html($pack_title);
                                            if ($pack_size) {
                                                echo ' - Talla: <span class="upper">' . esc_html($pack_size) . '</span>';
                                            }
                                            echo ' (x' . esc_html($pack_qty) . ')';
                                            echo '</li>';
                                        endforeach;
                                        echo '</ul>';
                                    endif;
                                    ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="mos__thanks__order__footer">
                    <?php
                    foreach ( $order->get_order_item_totals() as $key => $total ) {
                        ?>
                        <div class="ds-flex justify-space-between">
                            <span><?php echo esc_html( $total['label'] ); ?></span>
                            <span><?php echo wp_kses_post( $total['value'] ); ?></span>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
