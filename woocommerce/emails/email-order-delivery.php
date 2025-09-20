<?php
	require_once trailingslashit(get_stylesheet_directory()) . 'woocommerce/emails/email-custom-header.php';
?>
<tr>
	<td align="center" style="padding:20px 40px;background: #fff;">
		<img src="<?php echo IMAGES . 'emails/logo.png'; ?>" alt="Logo" width="260" border="0"
			style="max-width:260px;height:auto;display:block;" />
	</td>
</tr>
<tr>
	<td align="center" style="padding:0;background: #fff;">
		<img src="<?php echo IMAGES . 'emails/foto-email-7.jpg'; ?>" alt="placeholder" width="100%" border="0" style="width:100%;height:auto;display:block;" />
	</td>
</tr>
<tr>
	<td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
</tr>
<tr>
	<td align="center"
		style="padding: 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:20px;">
		¡Su pedido ha sido entregado!
	</td>
</tr>
<tr>
	<td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
</tr>
<tr>
	<td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
</tr>
<tr>
	<td align="center"
		style="padding: 0 20px 0 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:16px;line-height: 21px;">
		Esperamos que disfrute su experiencia Mosqueira y cada detalle de la pieza que ha recibido.
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

<?php
	require_once trailingslashit(get_stylesheet_directory()) . 'woocommerce/emails/email-custom-footer.php';
?>
