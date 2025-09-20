<?php
	require_once trailingslashit(get_stylesheet_directory()) . 'woocommerce/emails/email-custom-header.php';
?>
		<tr>
			<td align="center" valign="top">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#000"
					style="border-radius: 0px; padding:10px 40px;background: #000;">
					<tr>
						<td width="100%" align="left" style="padding: 20px 0;">
							<img src="<?php echo IMAGES . 'emails/logo-white-one.png'; ?>" alt="Logo" width="260" border="0"
								style="max-width:260px;height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
					</tr>
					<tr>
						<td height="2" style="font-size:2px; line-height:2px;background: #fff;">&nbsp;</td>
					</tr>
					<tr>
						<td align="left" width="100%"
							style="padding: 15px 0;font-family:Lato,Arial,sans-serif;font-weight:400;color:#fff;background: #000;text-align:left;font-size:20px;">
							Envío a provincia
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
		</tr>
		<tr>
			<td align="center"
				style="padding: 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:20px;">
				Estimado/a <?php echo $name; ?>,
			</td>
		</tr>
		<tr>
			<td align="center"
				style="padding: 0 20px 0 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:16px;line-height: 21px;">
				Su pedido llegará en un plazo máximo de 5 días hábiles, entre las 9:00 a.m. y las 7:00 p.m. La empresa de logística se se comunicará con usted al número proporcionado para realizar la entrega.
			</td>
		</tr>
		<tr>
			<td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
		</tr>
		<tr>
			<td align="center"
				style="padding: 0 20px 0 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:16px;line-height: 21px;">
				Si desea conocer el estado de su envío, por favor, haga clic en el siguiente enlace e ingrese el código correspondiente:
			</td>
		</tr>
		<tr>
			<td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
		</tr>
		<tr>
			<td align="center"
				style="padding: 0 20px 0 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:16px;line-height: 21px;">
				Código: <?php echo $code; ?>
			</td>
		</tr>
		<tr>
			<td height="30" style="font-size:30px; line-height:30px;">&nbsp;</td>
		</tr>
		<tr>
			<td align="center"
				style="padding: 0px 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:15px;">
				<a href="https://tracking.olvaexpress.pe/" target="_blank"
					style="font-size: 16px; font-family: Lato, Arial, sans-serif;font-weight: 400; color: #fff!important; text-decoration: none;border-radius: 0px; padding: 10px 20px; border: 1px solid #000; display: inline-block;background-color: #000;">
					<span style="color: #fff!important;">Rastrear mi pedido</span>
				</a>
			</td>
		</tr>
		<tr>
			<td height="50" style="font-size:50px; line-height:50px;">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" valign="top" style="border-top: 1px solid #000;border-bottom: 1px solid #000;">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#fff"
					style="border-radius: 0px; padding: 6px 0px;">
					<tr>
						<td width="200" align="center" valign="center">
							<a href="https://wa.me/%2B51908997621" target="_blank" style="display:block;padding: 0 5px;font-size: 13px;color: #000 !important;font-weight: 400;font-family: Lato, Arial, sans-serif">
								<span>Contactar con un asesor</span>
							</a>
						</td>
						<td width="200" align="center" valign="center"
							style="border-left: 1px solid #000;border-right: 1px solid #000;">
							<a href="<?php echo home_url('?modal_login=true'); ?>" target="_blank"
								style="display:block;padding: 0 5px;font-size: 13px;color: #000 !important;font-weight: 400;font-family: Lato, Arial, sans-serif">
								<span>Ingresar a mi cuenta</span>
							</a>
						</td>
						<td width="200" align="center" valign="center">
							<a href="<?php echo home_url('politica-de-privacidad'); ?>" target="_blank"
								style="display:block;padding: 0 5px;font-size: 13px;color: #000 !important;font-weight: 400;font-family: Lato, Arial, sans-serif">
								<span>Envíos y devoluciones</span>
							</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		
<?php
	require_once trailingslashit(get_stylesheet_directory()) . 'woocommerce/emails/email-custom-footer.php';
?>
