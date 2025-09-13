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
	<table align="center" width="100%" bgcolor="#ffffff" style="max-width:600px;" border="0" cellspacing="0"
		cellpadding="0">
		<tr>
			<td align="center" valign="top">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#000"
					style="border-radius: 0px; padding:10px 40px;background: #000;">
					<tr>
						<td width="100%" align="left" style="padding: 20px 0;">
							<img src="<?php echo IMAGES . 'emails/logo-white-one.png'; ?>"
								alt="Logo" width="260" border="0" style="max-width:260px;height:auto;display:block;" />
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
							Confirmación de reclamo
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
				Estimado/a, <?php echo $libro_data['nombres']; ?>
			</td>
		</tr>
		<tr>
			<td align="center"
				style="padding: 0 20px 0 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:20px;">
				Hemos recibido su reclamo y lamentamos lo ocurrido.<br>
				Nos pondremos en contacto con usted a la brevedad
			</td>
		</tr>
		<tr>
			<td height="30" style="font-size:30px; line-height:30px;">&nbsp;</td>
		</tr>	
		<tr>
			<td>
				<table width="100%" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="4" style="padding: 0 20px 0 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:16px;line-height: 21px;">
					<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Nombres:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['nombres']; ?> 
						</td>					
					</tr>
					<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Apellidos:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['apellidos']; ?> 
						</td>
					</tr>
					<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Documento:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['tipo_doc']; ?> - <?php echo $libro_data['nro_documento']; ?> 
						</td>
					</tr>
					<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>celular:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['celular']; ?> 
						</td>
					</tr>

					<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Email:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['email']; ?> 
						</td>
					</tr>

					<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>direccion:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['direccion']; ?> 
						</td>
					</tr>

					<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Referencia:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['referencia']; ?> 
						</td>
					</tr>

					<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Departamento:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['departamento']; ?> 
						</td>
					</tr>

					<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Provincia:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['provincia']; ?> 
						</td>
					</tr>

					<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Distrito:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['distrito']; ?> 
						</td>
					</tr>

					
					<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							 <b>Eres menor de edad?:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['flag_menor']; ?> 
						</td>
					</tr>

					<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Nombre tutor:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['nombre_tutor']; ?> 
						</td>
					</tr>

					<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Email tutor:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['email_tutor']; ?> 
						</td>
					</tr>

					<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Documento tutor:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['tipo_doc_tutor']; ?> - <?php echo $libro_data['numero_documento_tutor']; ?>  
						</td>
					</tr>
					<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Tipo reclamación:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['tipo_reclamacion']; ?> 
						</td>
					</tr>


						<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Tipo consumo:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['tipo_consumo']; ?> 
						</td>
					</tr>


						<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Nro pedido:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['nro_pedido']; ?> 
						</td>
					</tr>


						<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Fecha reclamo:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['fch_reclamo']; ?> 
						</td>
					</tr>


					<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Descripción:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['descripcion']; ?> 
						</td>
					</tr>


					
						<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Proveedor:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['proveedor']; ?> 
						</td>
					</tr>


					
						<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Fecha compra:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['fch_compra']; ?> 
						</td>
					</tr>


						<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Fecha consumo:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['fch_consumo']; ?> 
						</td>
					</tr>


					
						<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Fecha vencimiento:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['fch_vencimiento']; ?> 
						</td>
					</tr>

							<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Detalle:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['detalle']; ?> 
						</td>
					</tr>


							<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Pedido cliente:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['pedido_cliente']; ?> 
						</td>
					</tr>


							<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Monto reclamado:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php echo $libro_data['monto_reclamado']; ?> 
						</td>
					</tr>

							<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b> Acepta contenido:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
						
							<?php if($libro_data['acepta_contenido']=="1"){ echo "Si"; }else{ echo "No"; } ?> 
						</td>
					</tr>


					<tr>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:left;font-size:16px;line-height: 21px;">
							<b>Acepta política:</b>
						</td>
						<td style="font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:right;font-size:16px;line-height: 21px;">
							<?php if($libro_data['acepta_politica']=="1"){ echo "Si"; }else{ echo "No"; } ?> 
						</td>
					</tr>
				</table>
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
							<a href="https://www.linkedin.com/in/alexia-villa-garc%C3%ADa-383aa8244?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=ios_app" target="_blank"
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
			<td align="center"
				style="padding: 10px 20px;font-family:Lato,Arial,sans-serif;font-weight:300;color:#000;text-align:center;font-size:16px;">
				MOSQUEIRA<br>Mosqueira & Villa García SAC<br>Av. Santo Toribio 143, San Isidro, Lima, Perú
			</td>
		</tr>
		<tr>
			<td align="center"
				style="padding: 10px 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:13px;">
				<a href="<?php echo home_url('politica-de-privacidad'); ?>" target="_blank"
					style="font-size: 13px; font-family: Lato, Arial, sans-serif;font-weight: 700; color: #000!important; text-decoration: none;">Políticas
					de privacidad</a>
			</td>
		</tr>
		<tr>
			<td align="center"
				style="padding: 10px 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:13px;">
				Si desea cancelar su suscripción, <a href="<?php echo home_url('unsubscribe'); ?>" target="_blank"
					style="font-size: 13px; font-family: Lato, Arial, sans-serif;font-weight: 700; color: #000!important;text-decoration: none;">haga
					click aquí</a>
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
