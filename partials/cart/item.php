<?php
$product = $cart_item['data'];
$product_id = $cart_item['product_id'];
$quantity = $cart_item['quantity'];
$variation_id = $cart_item['variation_id'];
$talla = '';
$color = '';

// Obtener atributos talla y color
if ( ! empty( $cart_item['variation'] ) ) {
    if ( isset( $cart_item['variation']['attribute_pa_talla'] ) ) {
        $talla = $cart_item['variation']['attribute_pa_talla'];
    }
}
if ( isset( $cart_item['pa_color'] ) ) {
    $color = $cart_item['pa_color'];
} elseif ( $product->is_type( 'simple' ) ) {
    $attributes = $product->get_attributes();
    if ( isset( $attributes['pa_talla'] ) ) {
        $terms = wc_get_product_terms( $product_id, 'pa_talla', array( 'fields' => 'names' ) );
        $talla = ! empty( $terms ) ? $terms[0] : '';
    }
    if ( isset( $attributes['pa_color'] ) ) {
        $terms = wc_get_product_terms( $product_id, 'pa_color', array( 'fields' => 'names' ) );
        $color = ! empty( $terms ) ? $terms[0] : '';
    }
}

$name         = $product->get_name();
$sale         = $product->get_sale_price();
$regular      = $product->get_regular_price();
$currency     = get_woocommerce_currency_symbol();
$image_id     = $product->get_image_id();
$image_url    = wp_get_attachment_image_url( $image_id, 'full' );
$product_link = get_permalink($product_id);
?>

<li class="cart__item ds-flex justify-space-between">
    <?php if ( ! get_post_meta($product_id, '_is_custom_pack', true) ) : ?>
        <a href="<?php echo esc_url($product_link); ?>" class="image">
            <img style="height: 180px;object-fit: cover;object-position: top;" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($name); ?>" width="140" height="140" />
        </a>
    <?php endif; ?>

    <div class="info <?php echo get_post_meta($product_id, '_is_custom_pack', true) ? 'info-custom-pack' : ''; ?> relative">
        <button data-key="<?php echo esc_attr($cart_item_key); ?>" class="delete-cart-product" aria-label="Eliminar producto del carrito">
            <!-- icono delete -->
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                <path d="M7 7H5V13H7V7Z" fill="black"/>
                <path d="M11 7H9V13H11V7Z" fill="black"/>
                <path d="M12 1C12 0.4 11.6 0 11 0H5C4.4 0 4 0.4 4 1V3H0V5H1V15C1 15.6 1.4 16 2 16H14C14.6 16 15 15.6 15 15V5H16V3H12V1ZM6 2H10V3H6V2ZM13 5V14H3V5H13Z" fill="black"/>
            </svg>
        </button>

        <h3><a href="<?php echo esc_url($product_link); ?>"><?php echo esc_html($name); ?></a></h3>

        <div class="price">
            <?php if( $sale ) : ?>
                <span><?php echo $currency . $sale; ?></span>
                <del><bdi><?php echo $currency . $regular; ?></bdi></del>
            <?php else : ?>
                <span><?php echo $currency . $regular; ?></span>
            <?php endif; ?>
        </div>

        <div class="ds-flex justify-space-between">
            <div class="info-col">
                <?php if ( $talla ) : ?>
                    <p>Talla: <span class="upper"><?php echo esc_html($talla); ?></span></p>
                <?php endif; ?>
                <?php if ( $color ) : ?>
                    <p>Color: <span><?php echo esc_html($color); ?></span></p>
                <?php endif; ?>
                <?php if ( ! get_post_meta($product_id, '_is_custom_pack', true) ) : ?>
                    <p>Cantidad: <?php echo intval($quantity); ?></p>
                <?php endif; ?>
            </div>
            <?php if ( ! get_post_meta($product_id, '_is_custom_pack', true) ) : ?>
                <div class="info-col">
                    <?php echo woocommerce_quantity_input([
                        'input_value' => intval($quantity),
                        'input_name'  => esc_attr($cart_item_key),
                        'min_value'   => 1,
                    ], $product, false); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php
        // Mostrar detalle si es un pack personalizado
        $is_custom_pack = get_post_meta( $product_id, '_is_custom_pack', true );

        if ( $is_custom_pack ) {
            $pack_items = get_post_meta( $product_id, '_custom_pack_items', true );
            if ( ! empty( $pack_items ) ) {
                echo '<div class="pack-details">';
                echo '<strong>Este pack contiene:</strong>';
                echo '<ul class="pack-items-list" style="margin-top: 10px;">';
                foreach ( $pack_items as $variation_id => $pack_item ) {
                    $variation = new WC_Product_Variation( $variation_id );
                    if ( ! $variation || ! $variation->exists() ) continue;

                    $item_title = $pack_item['title'] ?? 'Producto';
                    $item_size  = $pack_item['size'] ?? '';
                    $item_qty   = intval($pack_item['quantity'] ?? 1);
                    $item_price = wc_price($variation->get_price());
                    $item_img   = wp_get_attachment_image_url($variation->get_image_id(), 'thumbnail');

                    echo '<li class="pack-item" data-variation-id="' . esc_attr($variation_id) . '" style="margin-bottom: 10px; display: flex; align-items: center; gap: 10px;">';

					echo '<img src="' . esc_url($item_img) . '" alt="' . esc_attr($item_title) . '" width="40" height="40" style="border-radius: 4px;">';

					echo '<span>' . esc_html($item_title) . ' - Talla: ' . esc_html($item_size) . ' (x' . $item_qty . ') — ' . $item_price . '</span>';

					echo '</li>';

                }
                echo '</ul>';
                echo '</div>';
            }
        }
        ?>
    </div>
</li>
