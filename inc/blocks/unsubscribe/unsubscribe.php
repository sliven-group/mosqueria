<?php
/**
 * Unsubscribe block template.
 *
 * @param array $block The block settings and attributes.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'mos__block__uns';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$title = get_field('acf_block_uns_title');
?>
<section <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
	<div class="mos__container">
		<?php if(!empty($title )) : ?>
			<?php echo $title; ?>
		<?php endif; ?>
		<form id="mos-form-unsubscribe" action="">
			<div class="form-input mt-50">
				<label for="unsubscribe-email">CORREO ELECTRONICO</label>
				<input type="email" id="unsubscribe-email" name="unsubscribe-email" placeholder="Ingrese su correo electronico">
			</div>
			<button id="mos-form-unsubscribe-btn" class="mos__btn mos__btn--primary mt-20">DESUSCRIBIRSE</button>
			<div id="mos-form-unsubscribe-message"></div>
		</form>
	</div>
</section>
