<?php
/**
 * Subscribe block template.
 *
 * @param array $block The block settings and attributes.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'mos__block__sub';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$title = get_field('acf_block_sub_title');
$link = get_field('acf_block_sub_btn');
?>
<?php if( $title ) : ?>
	<section <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
		<div class="mos__container">
			<div class="mos__block__sub__content">
				<?php echo $title; ?>
				<?php if( $link ):
					$link_title = $link['title'];
				?>
					<button
						class="mos__btn mos__btn--light js-modal-trigger"
						data-modal-target="mos-modal-subscribe"
						aria-label="<?php echo esc_html( $link_title ); ?>"
					>
						<?php echo esc_html( $link_title ); ?>
					</button>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
