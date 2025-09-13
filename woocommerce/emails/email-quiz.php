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
							Encuesta de satisfacción
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
				Queremos conocer su opinión
			</td>
		</tr>
		<tr>
			<td align="center"
				style="padding: 0 20px 0 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:16px;line-height: 21px;">
				Le invitamos a completar la encuesta de satisfacción sobre su última compra. Su experiencia es muy importante
				para nosotros, y como agradecimiento, recibirá 50 puntos adicionales en su cuenta.
			</td>
		</tr>
		<tr>
			<td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
		</tr>
		<tr>
			<td align="center"
				style="padding: 0 20px 0 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:16px;line-height: 21px;">
				Cuenta con un plazo de 7 días, a partir de la fecha de este correo, para completarla.
			</td>
		</tr>
		<tr>
			<td height="30" style="font-size:30px; line-height:30px;">&nbsp;</td>
		</tr>
		<tr>
			<td align="center"
				style="padding: 0px 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:15px;">
				<a href="<?php echo $url; ?>" target="_blank"
					style="font-size: 16px; font-family: Lato, Arial, sans-serif;font-weight: 400; color: #fff!important; text-decoration: none;border-radius: 0px; padding: 10px 20px; border: 1px solid #000; display: inline-block;background-color: #000;">
					<span style="color: #fff!important;">Completar encuesta</span>
				</a>
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
