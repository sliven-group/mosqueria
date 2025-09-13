<?php
/**
 * Quiz block template.
 *
 * @param array $block The block settings and attributes.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'mos__block__quiz';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}


// Load values and assign defaults.
$current_user = wp_get_current_user();
$userDisplayName = $current_user->user_login;
?>
<section <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
	<div class="mos__container">
		<form id="mos-form-quiz" action="">
			<div class="form-input mb-50">
				<label for="recommendation-quiz">¿Qué tan probable es que recomiende Mosqueira a personas que conoce (familiares, amigos, colegas, etc.)?</label>
				<div id="recommendation_quiz_radio_group" class="ds-flex align-center flex-wrap">
					<label for="recommendation-quiz-1">
						<input type="radio" id="recommendation-quiz-1" name="recommendation-quiz" value="1">
						<span>1</span>
					</label>
					<label for="recommendation-quiz-2">
						<input type="radio" id="recommendation-quiz-2" name="recommendation-quiz" value="2">
						<span>2</span>
					</label>
					<label for="recommendation-quiz-3">
						<input type="radio" id="recommendation-quiz-3" name="recommendation-quiz" value="3">
						<span>3</span>
					</label>
					<label for="recommendation-quiz-4">
						<input type="radio" id="recommendation-quiz-4" name="recommendation-quiz" value="4">
						<span>4</span>
					</label>
					<label for="recommendation-quiz-5">
						<input type="radio" id="recommendation-quiz-5" name="recommendation-quiz" value="5">
						<span>5</span>
					</label>
					<label for="recommendation-quiz-6">
						<input type="radio" id="recommendation-quiz-6" name="recommendation-quiz" value="6">
						<span>6</span>
					</label>
					<label for="recommendation-quiz-7">
						<input type="radio" id="recommendation-quiz-7" name="recommendation-quiz" value="7">
						<span>7</span>
					</label>
					<label for="recommendation-quiz-8">
						<input type="radio" id="recommendation-quiz-8" name="recommendation-quiz" value="8">
						<span>8</span>
					</label>
					<label for="recommendation-quiz-9">
						<input type="radio" id="recommendation-quiz-9" name="recommendation-quiz" value="9">
						<span>9</span>
					</label>
					<label for="recommendation-quiz-10">
						<input type="radio" id="recommendation-quiz-10" name="recommendation-quiz" value="10">
						<span>10</span>
					</label>
				</div>
			</div>
			<div class="form-input mb-50">
				<label>¿Cómo calificaría la calidad del producto que recibió?</label>
				<div id="qualification_quiz_radio_group">
					<label class="mos-checkbox mb-20">
						<span class="mos-checkbox__text">Excelente</span>
						<input type="radio" id="qualification-quiz-1" name="qualification-quiz" value="Excelente">
						<span class="mos-checkbox__checkmark"></span>
					</label>
					<label class="mos-checkbox mb-20">
						<span class="mos-checkbox__text">Buena</span>
						<input type="radio" id="qualification-quiz-2" name="qualification-quiz" value="Buena">
						<span class="mos-checkbox__checkmark"></span>
					</label>
					<label class="mos-checkbox mb-20">
						<span class="mos-checkbox__text">Regular</span>
						<input type="radio" id="qualification-quiz-3" name="qualification-quiz" value="Regular">
						<span class="mos-checkbox__checkmark"></span>
					</label>
					<label class="mos-checkbox">
						<span class="mos-checkbox__text">Mala</span>
						<input type="radio" id="qualification-quiz-4" name="qualification-quiz" value="Mala">
						<span class="mos-checkbox__checkmark"></span>
					</label>
				</div>
			</div>
			<div class="form-input mb-50">
				<label>¿Cómo calificaría la presentación y el empaque del producto?</label>
				<div id="presentation_quiz_radio_group">
					<label class="mos-checkbox mb-20">
						<span class="mos-checkbox__text">Excelente</span>
						<input type="radio" id="presentation-quiz-1" name="presentation-quiz" value="Excelente">
						<span class="mos-checkbox__checkmark"></span>
					</label>
					<label class="mos-checkbox mb-20">
						<span class="mos-checkbox__text">Buena</span>
						<input type="radio" id="presentation-quiz-2" name="presentation-quiz" value="Buena">
						<span class="mos-checkbox__checkmark"></span>
					</label>
					<label class="mos-checkbox mb-20">
						<span class="mos-checkbox__text">Regular</span>
						<input type="radio" id="presentation-quiz-3" name="presentation-quiz" value="Regular">
						<span class="mos-checkbox__checkmark"></span>
					</label>
					<label class="mos-checkbox">
						<span class="mos-checkbox__text">Mala</span>
						<input type="radio" id="presentation-quiz-4" name="presentation-quiz" value="Mala">
						<span class="mos-checkbox__checkmark"></span>
					</label>
				</div>
			</div>
			<div class="form-input mb-50">
				<label for="experience-quiz">¿Cómo describiría su experiencia general de compra en Mosqueira?</label>
				<div id="experience_quiz_radio_group" class="ds-flex align-center flex-wrap">
					<label for="experience-quiz-1">
						<input type="radio" id="experience-quiz-1" name="experience-quiz" value="1">
						<span>1</span>
					</label>
					<label for="experience-quiz-2">
						<input type="radio" id="experience-quiz-2" name="experience-quiz" value="2">
						<span>2</span>
					</label>
					<label for="experience-quiz-3">
						<input type="radio" id="experience-quiz-3" name="experience-quiz" value="3">
						<span>3</span>
					</label>
					<label for="experience-quiz-4">
						<input type="radio" id="experience-quiz-4" name="experience-quiz" value="4">
						<span>4</span>
					</label>
					<label for="experience-quiz-5">
						<input type="radio" id="experience-quiz-5" name="experience-quiz" value="5">
						<span>5</span>
					</label>
					<label for="experience-quiz-6">
						<input type="radio" id="experience-quiz-6" name="experience-quiz" value="6">
						<span>6</span>
					</label>
					<label for="experience-quiz-7">
						<input type="radio" id="experience-quiz-7" name="experience-quiz" value="7">
						<span>7</span>
					</label>
					<label for="experience-quiz-8">
						<input type="radio" id="experience-quiz-8" name="experience-quiz" value="8">
						<span>8</span>
					</label>
					<label for="experience-quiz-9">
						<input type="radio" id="experience-quiz-9" name="experience-quiz" value="9">
						<span>9</span>
					</label>
					<label for="experience-quiz-10">
						<input type="radio" id="experience-quiz-10" name="experience-quiz" value="10">
						<span>10</span>
					</label>
				</div>
			</div>
			<div class="form-input mb-50">
				<label>¿Qué fue lo que lo motivó a comprar en Mosqueira? (Opción múltiple)</label>
				<div id="reason_quiz_radio_group">
					<label class="mos-checkbox mb-20">
						<span class="mos-checkbox__text">La exclusividad de la marca</span>
						<input type="checkbox" id="reason-quiz-1" name="reason-quiz" value="La exclusividad de la marca">
						<span class="mos-checkbox__checkmark"></span>
					</label>
					<label class="mos-checkbox mb-20">
						<span class="mos-checkbox__text">La calidad de los productos</span>
						<input type="checkbox" id="reason-quiz-2" name="reason-quiz" value="La calidad de los productos">
						<span class="mos-checkbox__checkmark"></span>
					</label>
					<label class="mos-checkbox mb-20">
						<span class="mos-checkbox__text">La identidad de éxito que promueve la marca</span>
						<input type="checkbox" id="reason-quiz-3" name="reason-quiz" value="La identidad de éxito que promueve la marca">
						<span class="mos-checkbox__checkmark"></span>
					</label>
					<label class="mos-checkbox mb-20">
						<span class="mos-checkbox__text">El diseño sofisticado de las prendas</span>
						<input type="checkbox" id="reason-quiz-4" name="reason-quiz" value="El diseño sofisticado de las prendas">
						<span class="mos-checkbox__checkmark"></span>
					</label>
					<label class="mos-checkbox mb-20">
						<span class="mos-checkbox__text">Recomendación</span>
						<input type="checkbox" id="reason-quiz-5" name="reason-quiz" value="Recomendación">
						<span class="mos-checkbox__checkmark"></span>
					</label>
					<label class="mos-checkbox mb-20">
						<span class="mos-checkbox__text">Otro</span>
						<input type="checkbox" id="reason-quiz-6" name="reason-quiz" value="Otro">
						<span class="mos-checkbox__checkmark"></span>
					</label>
				</div>
				<div class="form-input-inside" style="display:none;">
					<input type="text" id="reason-quiz-other" placeholder="Ingresar respuesta" name="reason-quiz-other">
				</div>
			</div>
			<div class="form-input mb-50">
				<label>¿Por qué canal realizó su última compra?</label>
				<div id="canal_quiz_radio_group">
					<label class="mos-checkbox mb-20">
						<span class="mos-checkbox__text">Web</span>
						<input type="radio" id="canal-quiz-1" name="canal-quiz" value="Web">
						<span class="mos-checkbox__checkmark"></span>
					</label>
					<label class="mos-checkbox mb-20">
						<span class="mos-checkbox__text">WhatsApp</span>
						<input type="radio" id="canal-quiz-2" name="canal-quiz" value="WhatsApp">
						<span class="mos-checkbox__checkmark"></span>
					</label>
				</div>
			</div>
			<div id="yes_web_quiz_group" style="display: none;">
				<div class="form-input mb-50">
					<label>¿Cómo calificaría su experiencia de compra en el sitio web?</label>
					<div id="siteweb_1_quiz_radio_group">
						<label class="mos-checkbox mb-20">
							<span class="mos-checkbox__text">Excelente</span>
							<input type="radio" id="siteweb-quiz-1" name="siteweb-quiz" value="Excelente">
							<span class="mos-checkbox__checkmark"></span>
						</label>
						<label class="mos-checkbox mb-20">
							<span class="mos-checkbox__text">Buena</span>
							<input type="radio" id="siteweb-quiz-2" name="siteweb-quiz" value="Buena">
							<span class="mos-checkbox__checkmark"></span>
						</label>
						<label class="mos-checkbox mb-20">
							<span class="mos-checkbox__text">Regular</span>
							<input type="radio" id="siteweb-quiz-3" name="siteweb-quiz" value="Regular">
							<span class="mos-checkbox__checkmark"></span>
						</label>
						<label class="mos-checkbox">
							<span class="mos-checkbox__text">Mala</span>
							<input type="radio" id="siteweb-quiz-4" name="siteweb-quiz" value="Mala">
							<span class="mos-checkbox__checkmark"></span>
						</label>
					</div>
				</div>
				<div class="form-input mb-50">
					<label>¿Le resultó fácil navegar por el sitio y encontrar lo que buscaba?</label>
					<div id="siteweb_2_quiz_radio_group">
						<label class="mos-checkbox mb-20">
							<span class="mos-checkbox__text">Sí</span>
							<input type="radio" id="nav-siteweb-quiz-1" name="nav-siteweb-quiz" value="Si">
							<span class="mos-checkbox__checkmark"></span>
						</label>
						<label class="mos-checkbox mb-20">
							<span class="mos-checkbox__text">No</span>
							<input type="radio" id="nav-siteweb-quiz-2" name="nav-siteweb-quiz" value="No">
							<span class="mos-checkbox__checkmark"></span>
						</label>
					</div>
					<div class="form-input-inside" style="display:none;">
						<input type="text" id="nav-siteweb-no-quiz" placeholder="¿Qué mejoraría?" name="nav-siteweb-no-quiz">
					</div>
				</div>
			</div>
			<div id="yes_whats_quiz_group" style="display: none;">
				<div class="form-input mb-50">
					<label>¿Cómo calificaría la atención del asesor de ventas?</label>
					<div id="whats_1_quiz_radio_group">
						<label class="mos-checkbox mb-20">
							<span class="mos-checkbox__text">Excelente</span>
							<input type="radio" id="whats-quiz-1" name="whats-quiz" value="Excelente">
							<span class="mos-checkbox__checkmark"></span>
						</label>
						<label class="mos-checkbox mb-20">
							<span class="mos-checkbox__text">Buena</span>
							<input type="radio" id="whats-quiz-2" name="whats-quiz" value="Buena">
							<span class="mos-checkbox__checkmark"></span>
						</label>
						<label class="mos-checkbox mb-20">
							<span class="mos-checkbox__text">Regular</span>
							<input type="radio" id="whats-quiz-3" name="whats-quiz" value="Regular">
							<span class="mos-checkbox__checkmark"></span>
						</label>
						<label class="mos-checkbox mb-20">
							<span class="mos-checkbox__text">Mala</span>
							<input type="radio" id="whats-quiz-4" name="whats-quiz" value="Mala">
							<span class="mos-checkbox__checkmark"></span>
						</label>
					</div>
					<div class="form-input-inside" style="display:none;">
						<input type="text" id="whats-rema-quiz" placeholder="¿Qué mejoraría?" name="whats-rema-quiz">
					</div>
				</div>
				<div class="form-input mb-50">
					<label>¿Cómo calificaría el servicio de entrega?</label>
					<div id="whats_2_quiz_radio_group">
						<label class="mos-checkbox mb-20">
							<span class="mos-checkbox__text">Excelente</span>
							<input type="radio" id="calser-quiz-1" name="calser-quiz" value="Excelente">
							<span class="mos-checkbox__checkmark"></span>
						</label>
						<label class="mos-checkbox mb-20">
							<span class="mos-checkbox__text">Buena</span>
							<input type="radio" id="calser-quiz-2" name="calser-quiz" value="Buena">
							<span class="mos-checkbox__checkmark"></span>
						</label>
						<label class="mos-checkbox mb-20">
							<span class="mos-checkbox__text">Regular</span>
							<input type="radio" id="calser-quiz-3" name="calser-quiz" value="Regular">
							<span class="mos-checkbox__checkmark"></span>
						</label>
						<label class="mos-checkbox mb-20">
							<span class="mos-checkbox__text">Mala</span>
							<input type="radio" id="calser-quiz-4" name="calser-quiz" value="Mala">
							<span class="mos-checkbox__checkmark"></span>
						</label>
					</div>
					<div class="form-input-inside" style="display:none;">
						<input type="text" id="calser-rema-quiz" placeholder="¿Qué mejoraría?" name="calser-rema-quiz">
					</div>
				</div>
			</div>
			<div class="form-input mb-50">
				<label for="comment-quiz">¿Hay algo más que desee comentarnos o que podríamos mejorar?</label>
				<textarea id="comment-quiz" name="comment-quiz" placeholder="Ingresa tu comentario" autocomplete="off"></textarea>
			</div>
			<input id="user-name-quiz" name="user-name-quiz" type="hidden" value="<?php echo $userDisplayName; ?>">
			<button id="mos-form-quiz-btn" class="mos__btn mos__btn--primary ds-block m-auto">ENVIAR</button>
			<div id="mos-form-quiz-message"></div>
		</form>
	</div>
</section>
