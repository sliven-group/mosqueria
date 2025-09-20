<?php
$cart = wc()->cart;
$cart->calculate_totals(); // Asegura que los totales estén actualizados
$items         = $cart->get_cart();
$subtotal      = $cart->get_subtotal();
$total         = (float) $cart->get_total('edit'); // Total sin formato
$currency_cart = get_woocommerce_currency_symbol();
$checkout_url  = wc_get_checkout_url();
$cart_url      = wc_get_cart_url();
$desc          = wc_price($cart->get_discount_total());
$user_id       = get_current_user_id();
?>

<?php if ( ! $cart->is_empty() ) : ?>
    <div class="mos__cart">
        <ul class="mos__cart__items ">
            <?php foreach ( $items as $cart_item_key => $cart_item ) : ?>
                <?php
                    $pathItem = get_stylesheet_directory() . '/partials/cart/item.php';
                    if ( file_exists($pathItem) ) {
                        include $pathItem;
                    }
                ?>
            <?php endforeach; ?>
        </ul>

        <div class="mos__cart__footer">
            <ul>
                <li class="ds-flex align-center justify-space-between">
                    <span>Subtotal</span>
                    <span class="pop-cart-subtotal"><?php echo wc_price($subtotal); ?></span>
                </li>

                <?php if ( $user_id ) :
                    $is_first_purchase = mosqueira_es_primera_compra($user_id);
                    $categoria = get_user_meta($user_id, 'mosqueira_categoria', true);
                    $primer_pedido_como_invitado = get_user_meta($user_id, 'primer_pedido_como_invitado', true);

                    // Calcular subtotal solo para productos normales (sin pack y sin oferta)
                    $subtotal_precio_normal = 0;
                    $has_normal_product = false;

                    foreach ( $items as $cart_item ) {
                        $product = $cart_item['data'];
                        $is_pack = get_post_meta( $product->get_id(), '_is_custom_pack', true );
                        $precio_regular = floatval($product->get_regular_price());
                        $precio_actual = floatval($product->get_price());

                        if ( ! $is_pack && $precio_actual >= $precio_regular ) {
                            $subtotal_precio_normal += $precio_actual * $cart_item['quantity'];
                            $has_normal_product = true;
                        }
                    }

                    // Aplicar 15% solo si existe al menos un producto normal con subtotal > 0 y es primera compra o primer pedido como invitado
                    if ( (($is_first_purchase) || ($primer_pedido_como_invitado == "1")) && $has_normal_product && $subtotal_precio_normal > 0 ) :
                        $descuento = $subtotal_precio_normal * 0.15;
                        $total_con_descuento = $subtotal - $descuento;
                ?>
                        <li class="ds-flex align-center justify-space-between">
                            <span>15% de descuento - Primera compra (<?php echo esc_html($categoria); ?>)</span>
                            <span>-<?php echo wc_price($descuento); ?></span>
                        </li>
                        <li class="ds-flex align-center justify-space-between">
                            <span>Total</span>
                            <span class="pop-cart-total"><?php echo wc_price($total_con_descuento); ?></span>
                        </li>
                    <?php else : ?>
                        <?php if ( WC()->cart->has_discount() || WC()->cart->get_fees() ) : ?>
                            <li class="ds-flex align-center justify-space-between data-cupon-custom data-cupon-custom-server">
                                <span>Descuento</span>
                                <span class="pop-cart-desc"><?php echo $desc; ?></span>
                            </li>

                            <li class="ds-flex align-center justify-space-between data-cupon-custom data-cupon-custom-server">
                                <span>Total</span>
                                <span class="pop-cart-total"><?php echo wc_price($total); ?></span>
                            </li>
                        <?php else : ?>
                            <li class="ds-flex align-center justify-space-between ds-none data-cupon-custom data-cupon-custom-temp">
                                <span>Descuento</span>
                                <span class="pop-cart-desc"></span>
                            </li>

                            <li class="ds-flex align-center justify-space-between ds-none data-cupon-custom data-cupon-custom-temp">
                                <span>Total</span>
                                <span class="pop-cart-total"></span>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php else : ?>
                    <?php if ( WC()->cart->has_discount() || WC()->cart->get_fees() ) : ?>
                        <li class="ds-flex align-center justify-space-between">
                            <span>Descuento</span>
                            <span class="pop-cart-desc"><?php echo $desc; ?></span>
                        </li>

                        <li class="ds-flex align-center justify-space-between">
                            <span>Total</span>
                            <span class="pop-cart-total"><?php echo wc_price($total); ?></span>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>

            <a href="<?php echo esc_url($cart_url); ?>" class="mos__btn mos__btn--primary">FINALIZAR COMPRA</a>
            <button class="modal__cart__close mos__modal__close">SEGUIR COMPRANDO</button>
        </div>

        <div class="mos__cart__loading">
            <img loading="lazy" width="50" height="50" src="<?php echo IMAGES . 'loading.svg' ?>" alt="loading">
        </div>
    </div>
<?php else : ?>
    <div class="mos__cart_temp"><p>Su bolsa de compras está vacía</p></div>
<?php endif; ?>
