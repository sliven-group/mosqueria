<?php
/**
 * Template Name: Página Packs
 */
get_header();

$allowed_subcategories = ['polos-y-camisetas', 'polos-y-camisetas-mujer'];

$products_args = null;

$filter = get_query_var('filter');

if (isset($filter) && !empty($filter)) {  

    $products_args= [
        'post_type'      	=> 'product',
        'post_status'	 		=> 'publish',
        'posts_per_page' 	=> -1,
        /*'tax_query'      => [
            [
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($filter),
            ],
        ],*/
        'tax_query'       => [
            'relation' => 'AND',
            [
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($filter), // e.g. hombres or mujeres
            ],
            [
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $allowed_subcategories,
                'operator' => 'IN',
            ]
        ],
        'meta_query'     	=> [
            'relation' => 'OR',
            [
                'key'     => 'acf_ps_desc',
                'value'   => '0',
                'compare' => '=',
                'type'    => 'CHAR',
            ],
            [
                'key'     => 'acf_ps_desc',
                'compare' => 'NOT EXISTS',
            ]
        ],
        'fields' => 'ids'
    ];
}
?>
<section class="mos__pd mos_packs_page_wrap">
    <div class="mos__container">
        <?php 
        $query = new WP_Query($products_args);
        if ( $products_args && $query->have_posts() ) :          
            if ($query->have_posts()) : ?>
            <div class="mos_packs_page">      
                <h4 class="mos_packs_title">Packs Mosqueira <?php echo $filter; ?></h4>
                <div class="mos_packs_wrap">                    
                    <div class="mos_packs_grid">
                        <?php while ($query->have_posts()) : $query->the_post();
                            $product = wc_get_product(get_the_ID()); ?>

                            <?php
                                $id = $product->get_id();
                                $title = get_the_title($id);
                                $link = get_the_permalink($id);
                                $image_id = get_post_thumbnail_id($id);
                                $img = wp_get_attachment_image_src($image_id, 'large');
                                $product_test = get_field('acf_ps_test', $id);
                                $term = get_primary_product_category($id);

                                $sizes = array();
                                $max_discount = 0;
                                $regular = 0;
                                $sale = 0;

                                if ( $product instanceof WC_Product_Variable ) {
                                    $available_variations = $product->get_available_variations();

                                    foreach ($available_variations as $variation) {
                                        $size = $variation['attributes']['attribute_pa_talla'] ?? '';
                                        if (!$size) continue;

                                        $sizes[] = array(
                                            $size => $variation['variation_id'],
                                            'in_stock' => $variation['is_in_stock']
                                        );

                                        $regular_var = floatval($variation['display_regular_price']);
                                        $sale_var = floatval($variation['display_price']);

                                        if ($sale_var > 0 && $sale_var < $regular_var) {
                                            $discount = round((($regular_var - $sale_var) / $regular_var) * 100);
                                            if ($discount > $max_discount) {
                                                $max_discount = $discount;
                                            }
                                        }

                                        // Tomar el máximo precio regular y menor precio de venta
                                        if ($regular_var > $regular) {
                                            $regular = $regular_var;
                                        }
                                        if ($sale_var < $sale || $sale == 0) {
                                            $sale = $sale_var;
                                        }
                                    }
                                } else {
                                    // Producto simple
                                    $regular = floatval($product->get_regular_price());
                                    $sale = floatval($product->get_sale_price());

                                    if ($sale > 0 && $sale < $regular) {
                                        $max_discount = round((($regular - $sale) / $regular) * 100);
                                    }
                                }
                                ?>

                                <div class="product-card js-cart-product relative" data-product-id="<?php echo esc_attr($id); ?>">
                                    <div class="relative">
                                        <a href="<?php echo esc_url($link); ?>" class="product-card__img">
                                            <?php if($img): ?>
                                                <img width="1024" height="1024" loading="lazy" src="<?php echo esc_url($img[0]); ?>" alt="<?php echo esc_attr($title); ?>">
                                            <?php endif; ?>
                                        </a>

                                        <?php if(!empty($sizes)) : ?>
                                            <div class="product-card__attrs">
                                                <p><strong>Compra Rápida</strong> (Seleccione su talla)</p>
                                                <ul class="ds-flex flex-wrap justify-center size-selector">
                                                    <?php foreach ($sizes as $item): 
                                                        $size = array_keys($item)[0];
                                                        $variation_id = $item[$size];
                                                        $in_stock = $item['in_stock'];
                                                        $class = $in_stock ? 'in-stock' : 'out-of-stock';
                                                    ?>
                                                        <li class="size-option <?php echo $class; ?>" data-id="<?php echo esc_attr($variation_id); ?>" data-talla="<?php echo esc_attr($size); ?>">
                                                            <?php echo esc_html($size); ?>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ($max_discount > 0): ?>
                                        <div class="product-card__desc">
                                            <span>DESC <?php echo $max_discount; ?>%</span>
                                        </div>
                                    <?php endif; ?>

                                    <div class="product-card__info ds-flex direction-column justify-space-between">
                                        <div>
                                            <?php if ($term): ?>
                                                <small class="cat"><?php echo esc_html($term->name); ?></small>
                                            <?php endif; ?>
                                            <h2><a href="<?php echo esc_url($link); ?>"><?php echo esc_html($title); ?></a></h2>
                                        </div>

                                        <div class="ds-flex align-center">
                                            <?php if ($max_discount > 0): ?>
                                                <span class="regular-price" style="text-decoration: line-through;">
                                                    <?php echo wc_price($regular); ?>
                                                </span>
                                                <span class="sale-price ml-10">
                                                    <?php echo wc_price($sale); ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="price"><?php echo wc_price($regular); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>



                            
                           <?php  endwhile; wp_reset_postdata(); ?>
                    </div>

                    <aside class="mini-pack-cart-wrap">
                        <div class="mini-pack-cart">
                            <h3>Pack Básicos Mosqueira</h3>
                            <!--<p><small>Puedes mezclar colores y tallas</small></p> -->
                            <div id="mini-pack-cart"></div>
                            <button id="add-pack-to-cart" class="mos__btn mos__btn--primary upper" >Agregar Pack al carrito</button>
                        </div>                       
                    </aside>
                </div>
            </div>
            <?php else : ?>
                <p>No se encontraron productos para este filtro.</p>
            <?php endif;

        else : ?>
            <div class="mos_packs">
                <h4 class="mos_packs_title">Packs Mosqueira</h4>
                 <span class="mos_packs_min_text">Puede mezclar colores y tallas </span>
                <div class="mos_packs_wrap">
                    <div class="mos_packs_col">
                        <a href="<?php echo get_permalink(); ?>hombres">
                            <img src="<?php echo home_url('/wp-content/uploads/hombre_custom.jpg'); ?>" />
                        </a>
                    </div>
                    <div class="mos_packs_col">
                        <a href="<?php echo get_permalink(); ?>mujeres">
                            <img src="<?php echo home_url('/wp-content/uploads/mujer_custom.jpg'); ?>" />
                        </a>
                    </div>
                </div>               


               
            </div>
        <?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>
