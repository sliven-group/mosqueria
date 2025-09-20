<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<!--[if !mso]><!-->
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!--<![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		@import url('https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap');

		/* iOS BLUE LINKS */
		a[x-apple-data-detectors] {
			color: inherit !important;
			text-decoration: none !important;
			font-size: inherit !important;
			font-family: inherit !important;
			font-weight: inherit !important;
			line-height: inherit !important;
		}

		a:-webkit-any-link {
			text-decoration: none !important;
		}

		u+#body a,
		.ii a[href],
		.gt a {
			text-decoration: none !important;
		}

		a {
			color: inherit !important;
			text-decoration: none !important;
		}

		body,
		table,
		td,
		a {
			-webkit-text-size-adjust: 100%;
			-ms-text-size-adjust: 100%;
		}

		table,
		td {
			mso-table-lspace: 0pt;
			mso-table-rspace: 0pt;
		}

		img {
			-ms-interpolation-mode: bicubic;
		}

		@media all and (max-width:639px) {
			.hide {
				display: none !important;
			}

			.mobile {
				width: 100% !important;
				display: block !important;
				padding: 0 !important;
			}

			.img {
				width: 100% !important;
				height: auto !important;
			}

			/*.col-mb {
        display: block !important;
        width: 100% !important;
      }*/

			/*.border-mobile {
        border-right: 0 !important;
      }*/
		}
	</style>
	<!--[if (gte mso 9)|(IE)]>
	<style type="text/css">
		table {border-collapse: collapse !important;}
	</style>
	<![endif]-->
</head>
<body style="margin:0 auto;">
	<table align="center" width="100%" bgcolor="#ffffff" style="max-width:600px;margin:0 auto;" border="0" cellspacing="0" cellpadding="0">
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
				<p style="text-align:center;">Número de pedido: #<?php echo $orderNumber; ?></p>
				<p style="text-align:center;">Dirección de entrega:</p>
				<p style="text-align:center;"><?php echo $direccion_facturacion; ?></p>
				<p style="text-align:center;"><?php echo $billing_address_1; ?></p>
				<p style="text-align:center;">Horario:	09:00am - 07:00pm</p>
				<p style="text-align:center;">Fecha de Entrega: </p>
				<p style="text-align:center;">- <?php echo $text_delivery; ?></p>
			</td>
		</tr>
		<tr>
			<td height="30" style="font-size:30px; line-height:30px;">&nbsp;</td>
		</tr>
		<tr>
			<td align="center"	style="padding: 0 20px 0 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:16px;line-height: 21px;">
				<p style="text-align:center;">Si requiere información adicional o asistencia, no dude en contactarnos vía WhatsApp al +51 908 997 621. Nuestro
				equipo está a su disposición para garantizar que cada aspecto de su experiencia con Mosqueira sea prefecto.</p>
			</td>
		</tr>
		<tr>
			<td height="50" style="font-size:50px; line-height:50px;">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" style="padding: 0 20px 0 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:16px;line-height: 21px;">
				Gracias por elegir Mosqueira.
			</td>
		</tr>

		<tr>
			<td height="30" style="font-size:30px; line-height:30px;">&nbsp;</td>
		</tr>
		<tr>
		<td align="center" valign="top">
			<table width="160" cellpadding="0" cellspacing="0" border="0" bgcolor="#fff"
			style="border-radius: 0px; padding:10px 0px;">
				<tr>
					<td width="40" align="center" valign="center">
						<a href="https://wa.me/%2B51908997621" target="_blank" style="display:block;padding: 0 5px;">
							<img src="<?php echo IMAGES . 'emails/icon-wa.png'; ?>" alt="icon" width="21" border="0"
							style="max-width:21px;height:auto;display:block;">
						</a>
					</td>
					<td width="40" align="center" valign="center">
						<a href="https://www.instagram.com/mosqueira_brand/" target="_blank"
							style="display:block;padding: 0 5px;">
							<img src="<?php echo IMAGES . 'emails/icon-ig.png'; ?>" alt="icon" width="21" border="0"
							style="max-width:21px;height:auto;display:block;">
						</a>
					</td>
					<td width="40" align="center" valign="center">
						<a href="https://www.linkedin.com/company/mosqueirabrand/" target="_blank"
							style="display:block;padding: 0 5px;">
							<img src="<?php echo IMAGES . 'emails/icon-linkedin.png'; ?>" alt="icon" width="21" border="0"
							style="max-width:21px;height:auto;display:block;">
						</a>
					</td>
					<td width="40" align="center" valign="center">
						<a href="https://www.tiktok.com/@mosqueira_brand?is_from_webapp=1&sender_device=pc" target="_blank"
							style="display:block;padding: 0 5px;">
							<img src="<?php echo IMAGES . 'emails/icon-tiktok.png'; ?>" alt="icon" width="33" border="0"
							style="max-width:33px;height:auto;display:block;">
						</a>
					</td>
				</tr>
			</table>
		</td>
		</tr>
		<tr>
			<td align="center"	style="padding: 10px 20px;font-family:Lato,Arial,sans-serif;font-weight:300;color:#000;text-align:center;font-size:16px;">
				MOSQUEIRA<br>Mosqueira & Villa García SAC<br>Av. Santo Toribio 143, San Isidro, Lima, Perú
			</td>
		</tr>
		<tr>
			<td align="center" style="padding: 10px 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:13px;">
				<a href="<?php echo home_url('politica-de-privacidad'); ?>" target="_blank"	style="font-size: 13px; font-family: Lato, Arial, sans-serif;font-weight: 700; color: #000!important; text-decoration: none;">Políticas de privacidad</a>
			</td>
		</tr>
		<tr>
			<td align="center"
				style="padding: 10px 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:13px;">
				Si desea cancelar su suscripción, <a href="<?php echo home_url('unsubscribe'); ?>" target="_blank" style="font-size: 13px; font-family: Lato, Arial, sans-serif;font-weight: 700; color: #000!important;text-decoration: none;">haga click aquí</a>
			</td>
		</tr>
		<tr>
			<td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
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
  </table>
</body>
</html>
