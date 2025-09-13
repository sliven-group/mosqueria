<?php
/**
 * MSC Banner block template.
 *
 * @param array $block The block settings and attributes.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'mos__block__mscbanner';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$image = get_field('acf_block_bmsc_img');
$content = get_field('acf_block_bmsc_content');
$link = get_field('acf_block_bmsc_btn');
?>
<?php if( $content ) : ?>
	<section <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
		<?php if( !empty( $image ) ):
			$image = wp_get_attachment_image(
				$image['id'],
				'full',
				false,
				array(
					'class' => 'image m-auto',
					'alt' => get_post_meta($image['id'], '_wp_attachment_image_alt', true),
					'fetchPriority' => 'high'
				)
			);
		?>
			<?php echo $image; ?>
		<?php endif; ?>
		<div class="mos__block__mscbanner__content">
			<?php echo $content; ?>
			<?php if(!get_current_user_id()): ?>
				<div class="ds-flex justify-center">
					<?php if( $link ):
						//$link_url = $link['url'];
						$link_title = $link['title'];
						//$link_target = $link['target'] ? $link['target'] : '_self';
					?>
						<button aria-label="mi cuenta" class="mos__btn mos__btn--primary upper js-modal-trigger" data-modal-target="mos-modal-account-create"><?php echo esc_html( $link_title ); ?></button>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
