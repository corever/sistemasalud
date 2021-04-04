<table style="height: 115px; width: 500px;">
    <tbody>
        <tr>
            <td style="text-align: center;"><br />
                <table style="height: 115px; width: 128px;" border="0" align="left">
                    <tbody>
                        <tr>
                            <td><img style="height: 129px; width: 145px; float: left;" src="pub/img/logo_minsal.jpeg" alt="" /></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td style="text-align: right;">&nbsp; &nbsp; &nbsp;
                <table style="height: 130px; width: 450px;" border="0" align="left">
                    <tbody>
                        <tr>
                            <td>
                                <p style="text-align: left;"><strong><span style="font-family: arial, helvetica, sans-serif; font-size: 12px;">N&deg; Venta ____________/</span></strong></p>
                                <?php
                                if ($Codigo_ASD != 0) { ?>
                                    <p style="text-align: left;"><strong><span style="font-family: arial, helvetica, sans-serif; font-size: 14px;">N&deg; Tr&aacute;mite <b> <?php echo $Codigo_ASD; ?></b></span></strong></p>
                                <?php
                                } ?>
                                <p style="text-align: left;"><span style="font-family: arial, helvetica, sans-serif; font-size: 12px;"><strong>Fecha <?php echo $Fecha_Venta; ?></strong>&nbsp;</span></p>
                                <p style="text-align: left;"><span style="font-family: arial, helvetica, sans-serif; font-size: 11px;"><strong>CIUDAD, <?php echo $Comuna_Nombre; ?></strong></span></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<br>
<table style="width: 100%;" border="1" cellspacing="0" cellpadding="11">
    <tbody>
        <tr>
            <td style="text-align: center;"><strong><span style="font-family: arial, helvetica, sans-serif; font-size: 12px;">COMPROBANTE DE VENTA</span></strong></td>
        </tr>
    </tbody>
</table>
<br>
<table style="width: 100%;" border="1" cellspacing="0" cellpadding="11">
    <tbody>
        <tr>
            <td>
                <table style="width: 100%;" border="1" cellspacing="0" cellpadding="3">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <p style="text-align: center;"><span style="font-family: arial, helvetica, sans-serif; font-size: 12px;"><strong>DETALLE INSTITUCI&Oacute;N</strong></span></p>
                                <p><strong><br /></strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td><span>Seremi &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></td>
                            <td><span><?php echo $Seremi_Autoridad; ?></span></td>
                        </tr>
                        <tr>
                            <td><span>Oficina</span></td>
                            <td><?php echo $Seremi_Direccion; ?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<br>
<table style="width: 100%;" border="1" cellspacing="0" cellpadding="11">
    <tbody>
        <tr>
            <td>
                <table style="width: 100%;" border="1" cellspacing="0" cellpadding="3">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <p style="text-align: center;"><span style="font-family: arial, helvetica, sans-serif; font-size: 12px;"><strong>DETALLE VENDEDOR</strong></span></p>
                                <p><strong><br /></strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td><span>Nombre &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></td>
                            <td><span><?php echo $Vendedor_Nombre." ".$Vendedor_Apellido_Paterno." ".$Vendedor_Apellido_Materno; ?></span></td>
                        </tr>
                        <tr>
                            <td><span>Rut&nbsp;</span></td>
                            <td><?php echo $Vendedor_RUT; ?></td>
                        </tr>
                        <tr>
                            <td><span>Local de Venta</span></td>
                            <td><?php echo $Nombre_bodega; ?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<br>
<table style="width: 100%;" border="1" cellspacing="0" cellpadding="11">
    <tbody>
        <tr>
            <td>
                <table style="width: 100%;" border="1" cellspacing="0" cellpadding="3">
                    <tbody>
                        <tr>
                            <td style="text-align: center;" colspan="2">
                                <p><strong style="font-family: arial, helvetica, sans-serif; font-size: 12px;">DETALLE M&Eacute;DICO CIRUJANO</strong></p>
                                <p><strong style="font-family: arial, helvetica, sans-serif; font-size: 12px;"><br /></strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td><span style="font-family: arial, helvetica, sans-serif; font-size: 11px;">Nombre</span></td>
                            <td><span style="font-family: arial, helvetica, sans-serif; font-size: 12px;"><?php echo $Medico_Nombre." ".$Medico_Apellido_Paterno." ".$Medico_Apellido_Materno; ?></span></td>
                        </tr>
                        <tr>
                            <td><span style="font-family: arial, helvetica, sans-serif; font-size: 11px;">Rut&nbsp;</span></td>
                            <td><span style="font-family: arial, helvetica, sans-serif; font-size: 12px;"><?php echo $Medico_RUT; ?></span></td>
                        </tr>
                        <tr>
                            <td><span style="font-family: arial, helvetica, sans-serif; font-size: 11px;">Especialidad</span></td>
                            <td><span style="font-family: arial, helvetica, sans-serif; font-size: 12px;"><?php echo $Especialidad; ?></span></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<br>
<table style="width: 100%;" border="1" cellspacing="0" cellpadding="11">
    <tbody>
        <tr>
            <td>
                <table style="width: 100%;" border="1" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td style="text-align: center;">
                                <p><strong><span style="font-family: arial, helvetica, sans-serif; font-size: 12px;">TALONARIOS VENDIDOS</span></strong></p>
                                <p><strong><span style="font-family: arial, helvetica, sans-serif; font-size: 12px;"><br /></span></strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>&nbsp;</p>
                                <ul><?php echo $Talonarios_Vendidos; ?></ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td style="text-align: center;">______________________________________</td>
            <td style="text-align: center;">______________________________________</td>
        </tr>
        <tr>
            <td style="text-align: center;">&nbsp;<strong><span style="font-family: arial, helvetica, sans-serif; font-size: 10px;">Firma Vendedor</span></strong></td>
            <td style="text-align: center;"><strong><span style="font-family: arial, helvetica, sans-serif; font-size: 10px;">Firma M&eacute;dico Cirujano</span></strong></td>
        </tr>
        <tr>
        </tr>
    </tbody>
</table>
<p>&nbsp;</p>
<p style="page-break-after: always;">&nbsp;</p>
<table style="height: 115px; width: 500px;">
    <tbody>
        <tr>
            <td style="text-align: center;"><br />
                <table style="height: 115px; width: 128px;" border="0" align="left">
                    <tbody>
                        <tr>
                            <td><img style="height: 129px; width: 145px; float: left;" src="pub/img/logo_minsal.jpeg" alt="" /></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td style="text-align: right;">&nbsp; &nbsp; &nbsp;
                <table style="height: 130px; width: 450px;" border="0" align="left">
                    <tbody>
                        <tr>
                            <td>
                                <p style="text-align: left;"><strong><span style="font-family: arial, helvetica, sans-serif; font-size: 12px;">N&deg; Venta ____________/</span></strong></p>
                                <?php
                                if ($Codigo_ASD != 0) { ?>
                                    <p style="text-align: left;"><strong><span style="font-family: arial, helvetica, sans-serif; font-size: 14px;">N&deg; Tr&aacute;mite <b> <?php echo $Codigo_ASD; ?></b></span></strong></p>
                                <?php
                                } ?>
                                <p style="text-align: left;"><span style="font-family: arial, helvetica, sans-serif; font-size: 12px;"><strong>Fecha <?php echo $Fecha_Venta; ?></strong>&nbsp;</span></p>
                                <p style="text-align: left;"><span style="font-family: arial, helvetica, sans-serif; font-size: 11px;"><strong>CIUDAD, <?php echo $Comuna_Nombre; ?></strong></span></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<br>
<table style="width: 100%;" border="1" cellspacing="0" cellpadding="11">
    <tbody>
        <tr>
            <td style="text-align: center;"><strong><span style="font-family: arial, helvetica, sans-serif; font-size: 12px;">DETALLE DE VENTA</span></strong></td>
        </tr>
    </tbody>
</table>
<br>
<table style="width: 100%;" border="1" cellspacing="0" cellpadding="11">
    <tbody>
        <tr>
            <td>
                <table style="width: 100%;" border="1" cellspacing="0" cellpadding="3">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <p style="text-align: center;"><span style="font-family: arial, helvetica, sans-serif; font-size: 12px;"><strong>DETALLE INSTITUCI&Oacute;N</strong></span></p>
                                <p><strong><br /></strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td><span>Seremi &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></td>
                            <td><span><?php echo $Seremi_Autoridad; ?></span></td>
                        </tr>
                        <tr>
                            <td><span>Oficina</span></td>
                            <td><?php echo $Seremi_Direccion; ?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<br>
<table style="width: 100%;" border="1" cellspacing="0" cellpadding="11">
    <tbody>
        <tr>
            <td>
                <table style="width: 100%;" border="1" cellspacing="0" cellpadding="3">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <p style="text-align: center;"><span style="font-family: arial, helvetica, sans-serif; font-size: 12px;"><strong>DETALLE VENDEDOR</strong></span></p>
                                <p><strong><br /></strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td><span>Nombre &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></td>
                            <td><span><?php echo $Vendedor_Nombre." ".$Vendedor_Apellido_Paterno." ".$Vendedor_Apellido_Materno; ?></span></td>
                        </tr>
                        <tr>
                            <td><span>Rut&nbsp;</span></td>
                            <td><?php echo $Vendedor_RUT; ?></td>
                        </tr>
                        <tr>
                            <td><span>Local de Venta</span></td>
                            <td><?php echo $Nombre_bodega; ?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<br>
<table style="width: 100%;" border="1" cellspacing="0" cellpadding="11">
    <tbody>
        <tr>
            <td>
                <table style="width: 100%;" border="1" cellspacing="0" cellpadding="3">
                    <tbody>
                        <tr>
                            <td style="text-align: center;" colspan="2">
                                <p><strong style="font-family: arial, helvetica, sans-serif; font-size: 12px;">DETALLE M&Eacute;DICO CIRUJANO</strong></p>
                                <p><strong style="font-family: arial, helvetica, sans-serif; font-size: 12px;"><br /></strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td><span style="font-family: arial, helvetica, sans-serif; font-size: 11px;">Nombre</span></td>
                            <td><span style="font-family: arial, helvetica, sans-serif; font-size: 12px;"><?php echo $Medico_Nombre." ".$Medico_Apellido_Paterno." ".$Medico_Apellido_Materno; ?></span></td>
                        </tr>
                        <tr>
                            <td><span style="font-family: arial, helvetica, sans-serif; font-size: 11px;">Rut&nbsp;</span></td>
                            <td><span style="font-family: arial, helvetica, sans-serif; font-size: 12px;"><?php echo $Medico_RUT; ?></span></td>
                        </tr>
                        <tr>
                            <td><span style="font-family: arial, helvetica, sans-serif; font-size: 11px;">Especialidad</span></td>
                            <td><span style="font-family: arial, helvetica, sans-serif; font-size: 12px;"><?php echo $Especialidad; ?></span></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<br>
<table style="width: 100%;" border="1" cellspacing="0" cellpadding="11">
    <tbody>
        <tr>
            <td>
                <table style="width: 100%;" border="1" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td style="text-align: center;">
                                <p><strong><span style="font-family: arial, helvetica, sans-serif; font-size: 12px;">TALONARIOS VENDIDOS</span></strong></p>
                                <p><strong><span style="font-family: arial, helvetica, sans-serif; font-size: 12px;"><br /></span></strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>&nbsp;</p>
                                <ul><?php echo $Talonarios_Vendidos; ?></ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td style="text-align: center;">______________________________________</td>
            <td style="text-align: center;">______________________________________</td>
        </tr>
        <tr>
            <td style="text-align: center;">&nbsp;<strong><span style="font-family: arial, helvetica, sans-serif; font-size: 10px;">Firma Vendedor</span></strong></td>
            <td style="text-align: center;"><strong><span style="font-family: arial, helvetica, sans-serif; font-size: 10px;">Firma M&eacute;dico Cirujano</span></strong></td>
        </tr>
        <tr>
        </tr>
    </tbody>
</table>
<p>&nbsp;</p>