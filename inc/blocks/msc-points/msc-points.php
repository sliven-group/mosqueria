<?php
/**
 * MSC points block template.
 *
 * @param array $block The block settings and attributes.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'mos__block__mscpoints';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$title = get_field('acf_block_pmsc_title');
$desc = get_field('acf_block_pmsc_desc');
$items = get_field('acf_block_pmsc_items');
?>
<?php if( $desc ) : ?>
	<section <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
		<div class="mos__container">
			<div class="pointCals">
				<?php if(!empty($title)) : ?>
					<h2 class="text-center"><?php echo $title; ?></h2>
				<?php endif; ?>
				<div class="circlenumber"><span class="getPoints">S/1</span></div>
				<div class="equalSign"><span>=</span></div>
				<div class="circlenumber">
					<span class="getPoints"><span>10</span><span>Puntos</span></span>
				</div>
				<div class="desc"><?php echo $desc; ?></div>
			</div>
			<?php if(!empty($items)) : ?>
				<div class="items ds-flex justify-center flex-wrap">
					<?php foreach( $items as $item ):
						$content = $item['acf_block_pmsc_items_content'];
						$img = $item['acf_block_pmsc_items_img'];
					?>
						<div class="item">
							<?php if(!empty($img)) : ?>
								<img width="127" height="99" loading="lazy" src="<?php echo $img; ?>" alt="imagen">
							<?php endif; ?>
							<?php if(!empty($content)) : ?>
								<?php echo $content; ?>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
