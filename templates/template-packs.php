<?php
/**
 * Template Name: Página Packs
 */
get_header();

$productos_hombre = wc_get_products([
    'limit' => -1,
    'status' => 'publish',
    'category' => ['hombres']
]);

$productos_mujer = wc_get_products([
    'limit' => -1,
    'status' => 'publish',
    'category' => ['mujeres']
]);

// Intercalar productos
$intercalados = [];
$max = max(count($productos_hombre), count($productos_mujer));
for ($i = 0; $i < $max; $i++) {
    if (isset($productos_hombre[$i])) $intercalados[] = $productos_hombre[$i];
    if (isset($productos_mujer[$i])) $intercalados[] = $productos_mujer[$i];
}
?>

<section class="mos__pd">
    <div class="mos__container">
        <div class="packs-page">
            <div class="packs-grid">
                <?php foreach ($intercalados as $product):
                    $id = $product->get_id();
                    $title = get_the_title($id);
                    $link = get_the_permalink($id);
                    $img = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'large');
                    $term = get_primary_product_category($id);

                    // ✅ Validación para evitar error con productos simples
                    $variations = [];
                    if ($product instanceof WC_Product_Variable) {
                        $variations = $product->get_available_variations();
                    }
                ?>
                <div class="product-card <?= empty($variations) ? 'simple-product' : 'variable-product' ?>" data-product-id="<?= esc_attr($id) ?>">
                    <a href="<?= esc_url($link) ?>">
                        <img src="<?= esc_url($img[0]) ?>" alt="<?= esc_attr($title) ?>" loading="lazy">
                    </a>
                    <div class="product-card__info">
                        <small><?= $term ? esc_html($term->name) : '' ?></small>
                        <h3><?= esc_html($title) ?></h3>

                        <?php if (!empty($variations)): ?>
                        <div class="product-card__attrs">
                            <p><strong>Compra Rápida</strong> (Seleccione su talla)</p>
                            <ul class="size-selector" data-product-title="<?= esc_attr($title) ?>">
                                <?php foreach ($variations as $var):
                                    $size = $var['attributes']['attribute_pa_talla'] ?? '';
                                    $var_id = $var['variation_id'];
                                    $stock = $var['is_in_stock'];
                                ?>
                                    <li class="size-option <?= $stock ? 'in-stock' : 'out-of-stock' ?>"
                                        data-variation-id="<?= esc_attr($var_id) ?>"
                                        data-size="<?= esc_attr($size) ?>">
                                        <?= esc_html($size) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <aside class="mini-pack-cart">
                <h3>Pack Básicos Mosqueira</h3>
                <p><small>Puedes mezclar colores y tallas</small></p>
                <div id="mini-pack-cart"></div>
                <button id="add-pack-to-cart" style="display:none;">Agregar Pack al carrito</button>
            </aside>
        </div>
    </div>
</section>

<style>
.packs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 20px;
}
.product-card {
    border: 1px solid #eee;
    padding: 10px;
    position: relative;
}
.product-card__attrs ul {
    list-style: none;
    padding: 0;
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}
.product-card__attrs li {
    padding: 5px 10px;
    border: 1px solid #000;
    cursor: pointer;
}
.product-card__attrs li.out-of-stock {
    opacity: 0.4;
    pointer-events: none;
}
.mini-pack-cart {
    margin-top: 40px;
    padding: 20px;
    border: 2px solid #333;
}
.packs-page {
    display: flex;
    gap: 10px;
}
.mini-cart-item {
    margin-bottom: 8px;
}
</style>

<?php get_footer(); ?>
