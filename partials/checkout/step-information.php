<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>
	<div class="woocommerce-additional-fields__field-wrapper">
		<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
			<?php if( $key === 'additional_newsletter' ) : ?>
				<?php if (is_user_logged_in()) :
					$existing_email = validate_email_newsletter();
				?>
					<?php if (!$existing_email) : ?>
						<p class="form-row thwcfd-field-wrapper thwcfd-field-checkbox woocommerce-validated" id="additional_newsletter_field" data-priority="60">
							<span class="woocommerce-input-wrapper">
								<label class="mos-checkbox">
									<span class="mos-checkbox__text">Quiero recibir el newsletter con promociones.</span>
									<input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="additional_newsletter" id="additional_newsletter" value="0">
									<span class="mos-checkbox__checkmark"></span>
								</label>
							</span>
						</p>
					<?php endif; ?>
				<?php endif; ?>
			<?php else: ?>
				<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
