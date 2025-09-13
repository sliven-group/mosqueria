<?php
/**
 * Complaints book block template.
 *
 * @param array $block The block settings and attributes.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'mos__block__cb';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

$departamento_billing = get_user_meta($user_id, 'billing_departamento', true) ?? '';
$provincia_billing = '';
$distrito_billing =  '';
$data_departamento_billing = get_cached_locations('ubigeo_departamento', 'mos_departamentos', 'idDepa', 'departamento');

$date_current = new DateTime("now", new DateTimeZone('America/Lima') );
// Load values and assign defaults.
?>
<section <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
	<div class="mos__container">
		<form id="mos-form-cb" action="">
			<h2>Identificación del Consumidor Reclamante</h2>
			<div class="form-input mt-30">
				<label for="name-cb">NOMBRES</label>
				<input type="text" id="name-cb" name="name-cb" placeholder="Ingrese tu nombre">
			</div>
			<div class="form-input mt-30">
				<label for="lastname-cb">APELLIDOS</label>
				<input type="text" id="lastname-cb" name="lastname-cb" placeholder="Ingrese tu apellido">
			</div>
			<div class="ds-flex ds-flex-2 justify-space-between mt-30">
				<div class="form-input">
					<label for="tipo-doc-cb">TIPO DE DOCUMENTACIÓN</label>
					<select id="tipo-doc-cb" name="tipo-doc-cb">
						<option value="">Selección de documentación</option>
						<option value="">Seleccionar</option>
						<option value="DNI">DNI</option>
						<option value="CE">CE</option>
						<option value="Pasaporte">Pasaporte</option>
						<option value="RUC">RUC</option>
					</select>
				</div>
				<div class="form-input">
					<label for="nro-doc-cb">NÚMERO DE DOCUMENTACIÓN</label>
					<input type="text" id="nro-doc-cb" name="nro-doc-cb" placeholder="Número de documentación">
				</div>
			</div>
			<div class="form-input mt-30">
				<label for="cel-cb">CELULAR</label>
				<input type="text" id="cel-cb" name="cel-cb" placeholder="Ingrese su celular"">
			</div>
			<div class="ds-grid ds-grid__col3 ds-grid__gap20">
				<div class="form-input mt-30">
					<label for="departamento-cb">DEPARTAMENTO</label>
					<select name="departamento-cb" id="departamento-cb">
						<option value="">Seleccione departamento</option>
						<?php foreach ($data_departamento_billing as $key => $dep ) : ?>
							<option value="<?php echo $key; ?>" <?php selected( $key, $departamento_billing ); ?>>
								<?php echo $dep; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-input mt-30">
					<label for="provincia-cb">PROVINCIA</label>
					<select name="provincia-cb" id="provincia-cb" data-provincia="<?php echo esc_attr($provincia_billing); ?>">
						<option value="">Seleccione provincia</option>
					</select>
				</div>
				<div class="form-input mt-30">
					<label for="distrito-cb">DISTRITO</label>
					<select name="distrito-cb" id="distrito-cb" data-distrito="<?php echo esc_attr($distrito_billing); ?>">
						<option value="">Seleccione distrito</option>
					</select>
				</div>
			</div>
			<div class="form-input mt-30">
				<label for="dir-cb">DIRECCIÓN</label>
				<input type="text" id="dir-cb" name="dir-cb" placeholder="Dirección"">
			</div>
			<div class="form-input mt-30">
				<label for="ref-cb">REFERENCIA</label>
				<input type="text" id="ref-cb" name="ref-cb" placeholder="Referencia"">
			</div>
			<div class="form-input mt-30">
				<label for="email-cb">CORREO ELECTRÓNICO</label>
				<input type="email" id="email-cb" name="email-cb" placeholder="Correo electrónico"">
			</div>
			<div class="form-input mt-30">
				<label for="your-age-cb">ERES MENOR DE EDAD?</label>
				<div id="yourage_cb_radio_group">
					<label class="mos-checkbox mt-10" for="your-age-cb-1">
						<span class="mos-checkbox__text">Si</span>
						<input type="radio" class="input-checkbox" name="your-age-cb" id="your-age-cb-1" value="Si">
						<span class="mos-checkbox__checkmark"></span>
					</label>
					<label class="mos-checkbox mt-20" for="your-age-cb-2">
						<span class="mos-checkbox__text">No</span>
						<input type="radio" class="input-checkbox" name="your-age-cb" id="your-age-cb-2" value="No">
						<span class="mos-checkbox__checkmark"></span>
					</label>
				</div>
			</div>
			<div id="pamatu-cb" class="ds-none">
				<h2 class="mt-30">Padre / Madre / Tutor</h2>
				<div class="form-input mt-30">
					<label for="padmatu-name-cb">NOMBRES</label>
					<input type="text" id="padmatu-name-cb" name="padmatu-name-cb" placeholder="Ingrese tu nombre">
				</div>
				<div class="form-input mt-30">
					<label for="padmatu-email-cb">CORREO ELECTRÓNICO</label>
					<input type="email" id="padmatu-email-cb" name="padmatu-email-cb" placeholder="Correo electrónico"">
				</div>
				<div class="ds-flex ds-flex-2 justify-space-between mt-30">
					<div class="form-input">
						<label for="padmatu-tipo-doc-cb">TIPO DE DOCUMENTACIÓN</label>
						<select id="padmatu-tipo-doc-cb" name="padmatu-tipo-doc-cb">
							<option value="">Selección de documentación</option>
							<option value="DNI">DNI</option>
							<option value="CE">CE</option>
							<option value="Pasaporte">Pasaporte</option>
							<option value="RUC">RUC</option>
						</select>
					</div>
					<div class="form-input">
						<label for="padmatu-nro-doc-cb">NÚMERO DE DOCUMENTACIÓN</label>
						<input type="text" id="padmatu-nro-doc-cb" name="padmatu-nro-doc-cb" placeholder="Número de documentación">
					</div>
				</div>
			</div>
			<h2 class="mt-30">Detalle del reclamo y orden del consumidor</h2>
			<div class="form-input mt-30">
				<label for="tipo-rec-cb">TIPO DE RECLAMO</label>
				<select id="tipo-rec-cb" name="tipo-rec-cb">
					<option value="">Seleccióna el tipo de documento</option>
					<option value="Reclamación (1)">Reclamación (1)</option>
					<option value="Queja(2)">Queja(2)</option>
				</select>
			</div>
			<div class="form-input mt-30">
				<label for="tipo-con-cb">TIPO DE CONSUMO</label>
				<select id="tipo-con-cb" name="tipo-con-cb">
					<option value="">Seleccióna el tipo de consumo</option>
					<option value="Producto">Producto</option>
					<option value="Servicio">Servicio</option>
				</select>
			</div>
			<div class="form-input mt-30">
				<label for="npedido-cb">N° DE PEDIDO</label>
				<input type="text" id="npedido-cb" name="npedido-cb" placeholder="N° de pedido">
			</div>
			<div class="form-input mt-30">
				<label for="daterac-cb">FECHA DE RECLAMACIÓN / QUEJA</label>
				<input type="text" id="daterac-cb" name="daterac-cb" value="<?php echo $date_current->format('d/m/Y'); ?>" disabled>
			</div>
			<div class="form-input mt-30">
				<label for="prov-cb">PROVEEDOR</label>
				<input type="text" id="prov-cb" name="prov-cb" placeholder="Proveedor">
			</div>
			<div class="form-input mt-30">
				<label for="mont-cb">MONTO RECLAMADO (S/.)</label>
				<input type="text" id="mont-cb" name="mont-cb" placeholder="Monto reclamado">
			</div>
			<div class="form-input mt-30">
				<label for="desc-cb">DESCRIPCIÓN DEL PRODUCTO O SERVICIO</label>
				<textarea id="desc-cb" name="desc-cb" placeholder="Ingresa descripción del producto o servicio" autocomplete="off"></textarea>
			</div>
			<div class="ds-grid ds-grid__col3 ds-grid__gap20">
				<div class="form-input mt-30">
					<label for="datec-cb">FECHA DE COMPRA</label>
					<input type="date" name="datec-cb" id="datec-cb" size="40" placeholder="00/00/0000">
				</div>
				<div class="form-input mt-30">
					<label for="dated-cb">FECHA DE CONSUMO</label>
					<input type="date" name="dated-cb" id="dated-cb" size="40" placeholder="00/00/0000">
				</div>
				<div class="form-input mt-30">
					<label for="datea-cb">FECHA DE CADUCIDAD</label>
					<input type="date" name="datea-cb" id="datea-cb" size="40" placeholder="00/00/0000">
				</div>
			</div>
			<div class="form-input mt-30">
				<label for="det-cb">DETALLE DE LA RECLAMACIÓN / QUEJA, SEGÚN LO INDICADO POR EL CLIENTE</label>
				<textarea id="det-cb" name="det-cb" placeholder="Ingresa detalle de la reclamación / queja" autocomplete="off"></textarea>
			</div>
			<div class="form-input mt-30">
				<label for="ped-cb">PEDIDO DEL CLIENTE</label>
				<textarea id="ped-cb" name="ped-cb" placeholder="pedido del cliente" autocomplete="off"></textarea>
			</div>
			<br>
			<p><strong>(1) Reclamación:</strong> Desacuerdo relacionado con productos y / o servicios.</p>
			<p><strong>(2) Queja:</strong> Desacuerdo no relacionado con productos y / o servicios; o, malestar o insatisfacción con la atención al público.</p>
			<div class="form-input mt-30">
				<label class="mos-checkbox" for="acepto-cb">
					<span class="mos-checkbox__text">Declaro que soy el dueño del servicio y acepto el contenido de este formulario al declarar bajo Declaración Jurada la veracidad de los hechos descritos.</span>
					<input type="checkbox" class="input-checkbox" name="acepto-cb" id="acepto-cb" value="1">
					<span class="mos-checkbox__checkmark"></span>
				</label>
			</div>
			<br>
			<small>* La formulación del reclamo no excluye el recurso a otros medios de resolución de controversias ni es un requisito previo para presentar una denuncia ante el Indecopi.</small><br>
			<small>* El proveedor debe responder a la reclamación en un plazo no superior a quince (15) días naturales, pudiendo ampliar el plazo hasta quince días.</small><br>
			<small>* Con la firma de este documento, el cliente autoriza a ser contactado después de la tramitación de la reclamación para evaluar la calidad y satisfacción del proceso de atención de reclamaciones.</small>
			<div class="form-input mt-20">
				<label class="mos-checkbox" for="temr-cb">
					<span class="mos-checkbox__text">He leído y acepto la <a href="<?php echo home_url('politica-de-privacidad'); ?>" target="_blank">Política de privacidad y seguridad</a> y <a href="<?php echo home_url('politica-de-cookies'); ?>" target="_blank">la Política de cookies.</a></span>
					<input type="checkbox" class="input-checkbox" name="temr-cb" id="temr-cb" value="1">
					<span class="mos-checkbox__checkmark"></span>
				</label>
			</div><br><br>
			<button id="mos-form-cb-btn" class="mos__btn mos__btn--primary ds-block m-auto">ENVIAR</button>
			<div id="mos-form-cb-message"></div>
		</form>
	</div>
</section>
