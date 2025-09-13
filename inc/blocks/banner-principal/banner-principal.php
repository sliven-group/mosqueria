<?php
/**
 * Banner principal block template.
 *
 * @param array $block The block settings and attributes.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'mos__block__banner';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$image = get_field('acf_block_bp_img');
$video = get_field('acf_block_bp_video');
$content = get_field('acf_block_bp_content');
$link = get_field('acf_block_bp_btn');
$link2 = get_field('acf_block_bp_btn_2');
$validate = get_field('acf_block_bp_iv');
?>
<?php if( $content ) : ?>
	<section <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
		<?php if(!$validate) : ?>
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
		<?php else : ?>
			<?php if(!empty($video)): ?>
				<video autoplay loop playsinline muted>
					<source src="<?php echo esc_url($video); ?>" type="video/mp4">
				</video>
			<?php endif; ?>
		<?php endif; ?>
		<div class="mos__container">
			<div class="mos__block__banner__content">
				<?php echo $content; ?>
				<div class="ds-flex justify-center">
					<?php if( $link ):
						$link_url = $link['url'];
						$link_title = $link['title'];
						$link_target = $link['target'] ? $link['target'] : '_self';
					?>
						<a class="mos__btn mos__btn--light" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
					<?php endif; ?>
					<?php if( $link2 ):
						$link_url = $link2['url'];
						$link_title = $link2['title'];
						$link_target = $link2['target'] ? $link2['target'] : '_self';
					?>
						<a class="mos__btn mos__btn--light" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
