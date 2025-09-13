<?php
/**
 * MSC interesting block template.
 *
 * @param array $block The block settings and attributes.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'mos__block__mscinteresting';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$title = get_field('acf_block_mscint_title');
$items = get_field('acf_block_mscint_items');
$link = get_field('acf_block_mscint_btn');
?>
<?php if( $items ) : ?>
	<section <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
		<div class="mos__container">
			<?php if(!empty($title)) : ?>
				<h2 class="text-center"><?php echo $title; ?></h2>
			<?php endif; ?>
			<div class="ds-grid ds-grid__gap50 ds-grid__col3">
				<?php foreach( $items as $item ):
					$title = $item['acf_block_mscint_items_title'];
					$image = $item['acf_block_mscint_items_img'];
				?>
					<div class="item relative">
						<?php if(!empty($image)) : ?>
							<img loading="lazy" width="430" header="253" src="<?php echo esc_url($image); ?>" alt="image">
						<?php endif; ?>
						<?php if(!empty($title)) : ?>
							<h3 class="text-center"><?php echo $title; ?></h3>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
			<?php if( $link ):
				$link_url = $link['url'];
				$link_title = $link['title'];
				$link_target = $link['target'] ? $link['target'] : '_self';
			?>
				<a class="mos__btn mos__btn--primary upper ds-block m-auto" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
