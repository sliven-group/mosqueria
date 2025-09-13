<?php
/**
 * MSC benefits block template.
 *
 * @param array $block The block settings and attributes.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'mos__block__mscbenefits';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
?>
<section <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
	<div class="mos__container">
		<h2 class="text-center">GANE PUNTOS PARA SUBIR DE NIVEL</h2>
		<div class="items">
			<div class="item">
				<table>
					<thead>
						<tr>
							<th class="tableHeader" scope="col">
								<span class="title"><strong>Beneficios</strong><br><span>*Los puntos se renuevan cada año calendario</span></span>
							</th>
							<th class="tableHeader" scope="col">
								<span class="tiers">ACCESS<br><span>0 puntos</span></span>
							</th>
							<th class="tableHeader" scope="col">
								<span class="tiers">Silver<br><span>5000 puntos</span></span>
							</th>
							<th class="tableHeader" scope="col">
								<span class="tiers">Gold<br><span>15000 puntos</span></span>
							</th>
							<th class="tableHeader" scope="col">
								<span class="tiers">Platinum<br><span>30000 puntos</span></span>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th class="tableData" scope="row">
								15% de descuento en su primera compra
							</th>
							<td class="tableData">
								<span class="pointsEnabled"></span>
							</td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
						</tr>
						<tr>
							<th class="tableData" scope="row">
							500 puntos de regalo por unirse al club
							</th>
							<td class="tableData"><span class="pointsEnabled"></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
						</tr>
						<tr>
							<th class="tableData" scope="row">Beneficios exclusivos cada mes (descuentos, precios especiales, etc.)</th>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
						</tr>
						<tr>
							<th class="tableData" scope="row">10% adicional de puntos  por compra</th>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
						</tr>
						<tr>
							<th class="tableData" scope="row">Delivery gratis por compras mayores a S/310</th>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
						</tr>
						<tr>
							<th class="tableData" scope="row">Acceso a eventos exclusivos</th>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
						</tr>
						<tr>
							<th class="tableData" scope="row">Delivery gratis por compras mayores a S/210</th>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
						</tr>
						<tr>
							<th class="tableData">Presentación de cortesía para obsequios (tarjeta de regalo)</th>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
						</tr>
						<tr>
							<th class="tableData" scope="row">15% adicional de puntos por compra</th>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
						</tr>
						<tr>
							<th class="tableData" scope="row">Delivery gratis sin mínimo de compra</th>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
						</tr>
						<tr>
							<th class="tableData" scope="row">Empaque exclusivo para obsequios</th>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
						</tr>
						<tr>
							<th class="tableData" scope="row">Regalo especial por cumpleaños</th>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
						</tr>
						<tr>
							<th class="tableData" scope="row">Experiencias VIP</th>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
						</tr>
						<tr>
							<th class="tableData" scope="row">Estilista privado</th>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span></span></td>
							<td class="tableData"><span class="pointsEnabled"></span></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
