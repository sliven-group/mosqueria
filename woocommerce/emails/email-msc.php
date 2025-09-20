<?php
	require_once trailingslashit(get_stylesheet_directory()) . 'woocommerce/emails/email-custom-header.php';
?>
<tr>
	<td align="center" style="padding:50px 40px;background: #000;color:#fff;text-align:center;font-size:26px;font-family:Lato,Arial,sans-serif;font-weight:400;">
		MOSQUEIRA SOCIAL CLUB<br><?php echo $categoria; ?>
	</td>
</tr>
<tr>
	<td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
</tr>
<tr>
	<td align="center"
		style="padding: 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:20px;">
		¡Felicidades! Usted alcanzó el nivel <?php echo $categoria; ?>
	</td>
</tr>
<tr>
	<td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
</tr>
<tr>
	<td align="center"
		style="padding: 0 20px 0 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:16px;line-height: 21px;">
		<?php if($categoria === 'Platinum') : ?>
			Alcanzar el nivel <?php echo $categoria; ?> en Mosqueira Social Club es un reconocimiento a su fidelidad y estilo.<br><br>Como agradecimiento, esta categoría le brinda acceso a privilegios exclusivos diseñados para quienes valoran la excelencia en cada detalle.
		<?php else : ?>
			Nos complace informarle que ha ascendido al nivel <?php echo $categoria; ?> en Mosqueira Social Club.
		<?php endif; ?>
	</td>
</tr>
<tr>
	<td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
</tr>
<tr>
	<td align="center"
		style="padding: 0 20px 0 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:16px;line-height: 21px;">
		A partir de ahora, podrá disfrutar de beneficios exclusivos cada mes, que incluyen:
	</td>
</tr>
<tr>
	<td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
</tr>
<tr>
	<td align="left"
		style="padding: 0 20px 0 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
		<ul style="margin:0; padding: 0 0 0 15px;">
			<?php if($categoria === 'Silver') : ?>
				<li style="margin:0 0 5px 0;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;">Descuentos y precios especiales</li>
				<li style="margin:0 0 5px 0;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;">10% adicional en puntos por cada compra</li>
				<li style="margin:0 0 5px 0;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;">Envío gratuito en pedidos mayores a S/310</li>
			<?php elseif($categoria === 'Gold') : ?>
				<li style="margin:0 0 5px 0;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;">Acceso a eventos exclusivos</li>
				<li style="margin:0 0 5px 0;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;">Envío gratuito por compras mayores a S/210</li>
				<li style="margin:0 0 5px 0;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;">Presentación de cortesía para obsequios</li>
				<li style="margin:0 0 5px 0;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;">15% adicional de puntos por cada compra</li>
			<?php else : ?>
				<li style="margin:0 0 5px 0;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;">Envío gratuito sin mínimo de compra</li>
				<li style="margin:0 0 5px 0;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;">Empaque exclusivo para obsequios</li>
				<li style="margin:0 0 5px 0;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;">Regalo especial por cumpleaños</li>
				<li style="margin:0 0 5px 0;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;">Experiencias VIP</li>
				<li style="margin:0 0 5px 0;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;">Estilista privado</li>
			<?php endif; ?>
		</ul>
	</td>
</tr>
<tr>
	<td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
</tr>
<tr>
	<td align="center"
		style="padding: 0 20px 0 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:16px;line-height: 21px;">
		<?php if($categoria === 'Silver') : ?>
			Gracias por seguir eligiendo Mosqueira. Es solo el comienzo de todo lo que podemos ofrecerle.
		<?php else : ?>
			Gracias por seguir eligiendo Mosqueira.
		<?php endif; ?>
	</td>
</tr>
<tr>
	<td height="30" style="font-size:30px; line-height:30px;">&nbsp;</td>
</tr>
<tr>
	<td align="center"
		style="padding: 0px 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:15px;">
		<a href="<?php echo home_url('mosqueira-social-club/#beneficios'); ?>" target="_blank"
			style="font-size: 16px; font-family: Lato, Arial, sans-serif;font-weight: 400; color: #fff!important; text-decoration: none;border-radius: 0px; padding: 10px 20px; border: 1px solid #000; display: inline-block;background-color: #000;">
			<span style="color: #fff!important;">Mosqueira Social CLub</span>
		</a>
	</td>
</tr>
<?php
	require_once trailingslashit(get_stylesheet_directory()) . 'woocommerce/emails/email-custom-footer.php';
?>
