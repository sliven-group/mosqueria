<?php
/**
 * Promotion block template.
 *
 * @param array $block The block settings and attributes.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'mos__block__promo';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$title = get_field('acf_block_promo_title');
$image = get_field('acf_block_promo_img');
$link = get_field('acf_block_promo_btn');
?>
<?php if( $title ) : ?>
	<section <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
		<div class="mos__container relative">
			<?php if(!empty($image)): ?>
				<img class="image" src="<?php echo $image; ?>" alt="image" loading="lazy" width="1516" height="711"/>
			<?php endif; ?>
			<div class="mos__block__promo__content">
				<?php if(!empty($title)) : ?>
					<h2><?php echo $title; ?></h2>
				<?php endif; ?>
				<?php if( $link ):
					$link_url = $link['url'];
					$link_title = $link['title'];
					$link_target = $link['target'] ? $link['target'] : '_self';
				?>
					<a class="mos__btn mos__btn--light" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
