<?php
	require_once trailingslashit(get_stylesheet_directory()) . 'woocommerce/emails/email-custom-header.php';
?>
    <tr>
      <td align="center" style="padding:50px 30px;background: #000;color:#fff;text-align:center;">
        <img src="<?php echo IMAGES . 'emails/logo-white-one.png'; ?>" alt="logo"
          width="282" border="0" style="width:282px;height:auto;display:block; margin: 0 auto;" />
      </td>
    </tr>
    <tr>
      <td align="center" style="padding:0;background: #000;">
        <img src="<?php echo IMAGES . 'emails/placeholder.png'; ?>" alt="imagen"
          width="282" border="0" style="width:282px;height:auto;display:block;margin: 0 auto;" />
      </td>
    </tr>
    <tr>
      <td height="20" style="font-size:20px; line-height:20px;background: #000;">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"
        style="padding: 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#fff;background:#000;text-align:center;font-size:20px;">
        ¿SU CARRITO ESTÁ COMPLETO?
      </td>
    </tr>
    <tr>
      <td height="30" style="font-size:30px; line-height:30px;background: #000;">&nbsp;</td>
    </tr>
    <tr>
      <td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"
        style="padding: 0 20px 0 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:16px;line-height: 21px;">
        Estimado/a <?php echo $name; ?>,
      </td>
    </tr>
    <tr>
      <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"
        style="padding: 0 20px 0 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:16px;line-height: 21px;">
        Los productos que ha elegido siguen aquí, esperando ser lucidos.<br>No espere demasiado, estas exclusivas piezas podrían no estar disponibles por mucho tiempo. Finalice su compra o incorpore lo que falte para perfeccionar su conjunto.
      </td>
    </tr>
    <tr>
      <td height="30" style="font-size:30px; line-height:30px;">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"
        style="padding: 0px 20px;font-family:Lato,Arial,sans-serif;font-weight:400;color:#000;text-align:center;font-size:15px;">
        <a href="<?php echo home_url('carrito'); ?>" target="_blank"
          style="font-size: 16px; font-family: Lato, Arial, sans-serif;font-weight: 400; color: #fff!important; text-decoration: none;border-radius: 0px; padding: 10px 20px; border: 1px solid #000; display: inline-block;background-color: #000;">
          <span style="color: #fff!important;">Volver al carrito</span>
        </a>
      </td>
    </tr>
  <?php
	require_once trailingslashit(get_stylesheet_directory()) . 'woocommerce/emails/email-custom-footer.php';
?>
