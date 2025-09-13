<?php
	require_once trailingslashit(get_stylesheet_directory()) . 'woocommerce/emails/email-custom-header.php';
?>
<tr>
	<td align="center" style="padding:0;background: #fff;">
		<img src="<?php echo IMAGES . 'emails/foto-email-10.png'; ?>" alt="placeholder" width="100%" border="0"
			style="width:100%;height:auto;display:block;" />
	</td>
</tr>
<tr>
	<td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
</tr>
<tr>
	<td align="center"
		style="padding: 0 20px 0 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:16px;line-height: 21px;">
		Nos complace informarle que su pedido ha sido enviado.<br><br>Muy pronto, un miembro de
		nuestro equipo logístico se comunicará con usted para la entrega.
	</td>
</tr>
<tr>
	<td height="30" style="font-size:30px; line-height:30px;">&nbsp;</td>
</tr>
<tr>
	<td align="center"
		style="padding: 0 20px 0 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:16px;line-height: 21px;">
		<p> Número de pedido: #<?php echo $orderNumber; ?></p>
		<p>Dirección de entrega:</p>
		<p><?php echo $direccion_facturacion; ?><br></p>
		<p><?php echo $billing_address_1; ?><br>	</p>
		<p>Horario:	<?php echo $formattedTime; ?></p>
		<p>Fecha de Entrega: </p>
		<p>- 2 días hábiles para los envíos en Lima</p>
		<p>- 5 días hábiles para provincia</p>
	</td>
</tr>
<tr>
	<td height="30" style="font-size:30px; line-height:30px;">&nbsp;</td>
</tr>
<tr>
	<td align="center"
		style="padding: 0 20px 0 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:16px;line-height: 21px;">
		Si requiere información adicional o asistencia, no dude en contactarnos vía WhatsApp al +51 908 997 621. Nuestro
		equipo está a su disposición para garantizar que cada aspecto de su experiencia con Mosqueira sea prefecto.
	</td>
</tr>
<tr>
	<td height="50" style="font-size:50px; line-height:50px;">&nbsp;</td>
</tr>
<tr>
	<td align="center"
		style="padding: 0 20px 0 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:16px;line-height: 21px;">
		Gracias por elegir Mosqueira.
	</td>
</tr>
<tr>
	<td>
		<table width="600" bgcolor="#F5FDE8" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
					<img src="http://imgfz.com/i/OG9eRdQ.jpeg" width="600" height="1" style="vertical-align:bottom; display:block; border:none"/>
				</td>
			</tr>
		</table>
	</td>
</tr>
<?php
	require_once trailingslashit(get_stylesheet_directory()) . 'woocommerce/emails/email-custom-footer.php';
?>
