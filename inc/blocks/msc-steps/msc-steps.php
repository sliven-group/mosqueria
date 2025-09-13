<?php
/**
 * MSC Steps block template.
 *
 * @param array $block The block settings and attributes.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'mos__block__mscsteps';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$steps = get_field('acf_block_bmsc_steps');
?>
<?php if( $steps ) : ?>
	<section <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
		<div class="mos__container">
			<div class="ds-grid ds-grid__gap50 ds-grid__col3">
				<?php foreach( $steps as $step ):
					$title = $step['acf_block_bmsc_steps_step'];
					$content = $step['acf_block_bmsc_steps_content'];
				?>
					<div class="item">
						<?php if(!empty($title)) : ?>
							<span class="item-title"><?php echo $title; ?></span>
						<?php endif; ?>
						<?php if(!empty($content)) : ?>
							<?php echo $content; ?>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
