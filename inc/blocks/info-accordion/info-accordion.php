<?php
/**
 * Info accordion block template.
 *
 * @param array $block The block settings and attributes.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'mos__block__ia';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$title = get_field('acf_block_ic_title');
$items = get_field('acf_block_ic_items');
?>

<section <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
	<div class="mos__container">
		<?php if( $title ) : ?>
			<div class="content">
				<?php echo $title; ?>
			</div>
		<?php endif; ?>
		<?php if(!empty($items)) : ?>
			<div class="items">
				<?php foreach( $items as $item ) :
					$title = $item['acf_block_ic_items_title'];
					$content = $item['acf_block_ic_items_content'];
				?>
					<div class="item">
						<div class="item__header ds-flex align-start justify-space-between">
							<span><?php echo $title; ?></span>
							<svg width="19" height="11" viewBox="0 0 19 11" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M19 0L9.5 9.9L0 0V1.1L9.5 11L19 1.1V0Z" fill="black"/>
							</svg>
						</div>
						<div class="item__content">
							<?php echo $content; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
