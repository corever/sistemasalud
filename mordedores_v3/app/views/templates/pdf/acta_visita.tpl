<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <style>
            {literal}

            table{
                border-collapse:collapse;
            }
            
            .titulo{
                color:#256faf;
                font-weight: bold;
                font-size: 15px;
            }
            
            .td-subrayado{
                border-bottom:1px solid #b9c4ce;
            }
            
            .subrayado{
                margin-top:1px;
                margin-bottom:5px;
                size: 2px;
                color: #b9c4ce;
            }

            {/literal}
        </style>
    </head>

    <body style="font-size: 13px;font-family:Arial">
        <table width="100%" border="0" >
            <tr>
                <td width="30%"><img src="static/images/logo_minsal.png" style="width:100px;margin:5px" ></td>
                <td align="left">
                    <h2>ACTA DE VISITA</h2>
                </td>
                <td style="vertical-align:middle;padding-left:20px;">
                    <table>
                        <tr>
                            <td>FOLIO</td>
                            <td>: {$arr->gl_folio}</td>
                        </tr>
                        <tr>
                            <td>Fecha Mordedura</td>
                            <td>: {$arr->fc_mordedura}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
                        
        <br>
        
        <table width="100%" border="0" style="page-break-inside:avoid">
            <tr>
                <td>
                    <div class="titulo">Identificación de Establecimiento</div>
                    <hr class="subrayado">
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" width="100%">
                        <tr>
                            <td width="35%"><strong>Establecimiento de Salud</strong></td>
                            <td width="1%"><strong>:</strong></td>
                            <td>{$arr->gl_establecimiento}</td>
                        </tr>
                        <tr>
                            <td><strong>Comuna</strong></td>
                            <td><strong>:</strong></td>
                            <td>{$arr->gl_comuna_establecimiento}</td>
                        </tr>
                        <tr>
                            <td><strong>Región</strong></td>
                            <td><strong>:</strong></td>
                            <td>{$arr->gl_region_establecimiento}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha Ingreso</strong></td>
                            <td><strong>:</strong></td>
                            <td>{$arr->fc_ingreso} {$arr->gl_hora_ingreso}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>        

        <br>
        
        <table width="100%" border="0" style="page-break-inside:avoid">
            <tr>
                <td>
                    <div class="titulo">Identificación del Paciente</div>
                    <hr class="subrayado">
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" width="100%">
                        <tr>
                            <td width="35%"><strong>RUT</strong></td>
                            <td width="1%"><strong>:</strong></td>
                            <td>{if $arr->rut_paciente}{$arr->rut_paciente}{else if $arr_pasaporte.gl_pasaporte}{$arr_pasaporte.gl_pasaporte}{/if}</td>
                        </tr>
                        <tr>
                            <td><strong>Nombre</strong></td>
                            <td><strong>:</strong></td>
                            <td>{$arr->nombre_paciente} {$arr->apellidos_paciente}</td>
                        </tr>
                        <tr>
                            <td><strong>Región</strong></td>
                            <td><strong>:</strong></td>
                            <td>{$arr->region_paciente}</td>
                        </tr>
                        <tr>
                            <td><strong>Comuna</strong></td>
                            <td><strong>:</strong></td>
                            <td>{$arr->comuna_paciente}</td>
                        </tr>
                        <tr>
                            <td><strong>Previsión</strong></td>
                            <td><strong>:</strong></td>
                            <td>{$arr->nombre_prevision_paciente}</td>
                        </tr>
                        {foreach from=$arr_contacto_paciente key=key item=itm}
                            <tr>
                                <td><strong>{$itm.json_datos.gl_tipo_contacto}</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    {if $itm.id_tipo_contacto == 1}
                                        {$itm.json_datos.telefono_fijo}
                                    {else if $itm.id_tipo_contacto == 2}
                                        {$itm.json_datos.telefono_movil}
                                    {else if $itm.id_tipo_contacto == 3}
                                        {$itm.json_datos.gl_direccion}, {$itm.json_datos.gl_comuna}, {$itm.json_datos.gl_region}
                                    {else if $itm.id_tipo_contacto == 4}
                                        {$itm.json_datos.gl_email}
                                    {else if $itm.id_tipo_contacto == 5}
                                        {$itm.json_datos.gl_casilla_postal}
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                    </table>
                </td>
            </tr>
        </table>

        <br>
        
        <table width="100%" border="0" style="page-break-inside:avoid">
            <tr>
                <td>
                    <div class="titulo">Identificación de la Mordedura</div>
                    <hr class="subrayado">
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" width="100%">
                        <tr>
                            <td width="35%"><strong>Fecha Mordedura</strong></td>
                            <td width="1%"><strong>:</strong></td>
                            <td>{$arr->fc_mordedura}</td>
                        </tr>
                        <tr>
                            <td><strong>Inicia Vacunación</strong></td>
                            <td><strong>:</strong></td>
                            <td>{$arr_expediente.gl_inicia_vacuna}</td>
                        </tr>
                        <tr>
                            <td><strong>Tipo de Mordedura</strong></td>
                            <td><strong>:</strong></td>
                            <td>{$arr_expediente.gl_tipo_mordedura}</td>
                        </tr>
                        <tr>
                            <td><strong>Observaciones</strong></td>
                            <td><strong>:</strong></td>
                            <td>{$arr->gl_observacion}</td>
                        </tr>
                        <tr>
                            <td><strong>Dirección</strong></td>
                            <td><strong>:</strong></td>
                            <td>{$arr_dir_mordedura.gl_direccion}, {$arr->region_mordedura}, {$arr->comuna_mordedura}</td>
                        </tr>
                        <tr>
                            <td><strong>Datos de Referencia</strong></td>
                            <td><strong>:</strong></td>
                            <td>{$arr_dir_mordedura.gl_datos_referencia}</td>
                        </tr>
                    </table>
                    <table width="100%" cellpadding="0" style="border:none;border-collapse: collapse;font-size:13px" border="0">
                        <tr>
                            <td align="center" style="border:0px" border="0">
                                <img src='{$arr_dir_mordedura.img_direccion}' style="max-width: 600px; max-height: 400px">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        <br>
        
        <table width="100%" border="0" style="page-break-inside:avoid">
            <tr>
                <td>
                    <div class="titulo">Identificación de Mordedor</div>
                    <hr class="subrayado">
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" border="1" style="page-break-inside:avoid">
                        <tr>
                            <th align="center"><b>FOLIO</b></th>
                            <th align="center" width="30%"><b>ESPECIE</b></th>
                            <th align="center"><b>RAZA</b></th>
                            <th align="center"><b>COLOR</b></th>
                            <th align="center"><b>TAMAÑO</b></th>
                        </tr>
                        {assign var=cont_mordedor value=1}
                        {foreach from=$arr_mordedor key=key item=itm}
                            {assign var=item value=$itm.json_mordedor}
                            <tr>
                                <td align="center"><b>{$itm.gl_folio_mordedor}</b></td>
                                <td align="center">{$item.gl_especie_animal}</td>
                                <td align="center">{$item.gl_raza_animal}</td>
                                <td align="center">{$item.gl_color_animal}</td>
                                <td align="center">{$item.gl_tamano_animal}</td>
                            </tr>
                            {assign var=cont_mordedor value=$cont_mordedor+1}
                        {/foreach}
                    </table>
                </td>
            </tr>
        </table>
                
        <br>
        
        {assign var=cont_mordedor value=1}
        {foreach from=$arr_mordedor key=key item=itm}
            {assign var=item value=$itm.json_mordedor}
            <table width="100%" border="1" style="page-break-inside:avoid">
                <tr>
                    <td width="30%">
                        <b>MORDEDOR</b>
                    </td>
                    <td align="left">
                        <b>{$itm.gl_folio_mordedor}</b>
                    </td>
                </tr>
                <tr>
                    <td width="30%">
                        <b>FISCALIZADOR</b>
                    </td>
                    <td align="left">
                        <b>{$itm.nombre_fiscalizador}</b>
                    </td>
                </tr>
                <tr>
                    <td width="30%">
                        <b>DIRECCIÓN</b>
                    </td>
                    <td align="left">
                        {if $item.gl_direccion}
                            {$item.gl_direccion}, {$item.gl_comuna}, {$item.gl_region}
                        {else}
                            Sin Direccion
                        {/if}
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>DATOS DE REFERENCIA</b>
                    </td>
                    <td align="left">
                        {if $item.gl_direccion}
                            {if $item.gl_referencias_animal}{$item.gl_referencias_animal}{/if}
                        {/if}
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="2">
                        <img src='{$item.img_direccion}' style="max-width: 800px; max-height: 400px">
                    </td>
                </tr>
            </table>
            {assign var=cont_mordedor value=$cont_mordedor+1}
        {/foreach}
        
        <br>
        
        <table width="100%" border="0" style="page-break-inside:avoid">
            <tr>
                <td>
                    <div class="titulo">Datos de Propietario</div>
                    <hr class="subrayado">
                </td>
            </tr>
            <tr>
                <td>
                    <table border="1" width="100%">
                        <tr>
                            <td width="45%"><strong>¿Extranjero sin RUT emitido?</strong></td>
                            <td><input type="checkbox">&nbsp;Si</td>
                            <td><input type="checkbox">&nbsp;No</td>
                        </tr>
                        <tr>
                            <td><strong>RUT/Pasaporte</strong></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td><strong>Nombre</strong></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td><strong>Apellido</strong></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td><strong>Teléfono</strong></td>
                            <td colspan="2"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        <br>
        
        <table width="100%" border="0" style="page-break-inside:avoid">
            <tr>
                <td>
                    <div class="titulo">Animal Mordedor</div>
                    <hr class="subrayado">
                </td>
            </tr>
            <tr>
                <td>
                    <table border="1" width="100%">
                        <tr>
                            <td width="45%"><strong>¿Se encuentra vivo?</strong></td>
                            <td><input type="checkbox">&nbsp;Si</td>
                            <td><input type="checkbox">&nbsp;No</td>
                        </tr>
                        {*<tr>
                            <td width="45%"></td>
                            <td></td>
                            <td><input type="checkbox">&nbsp;Sospechoso de Rabia<br><input type="checkbox">&nbsp;No Sospechoso de Rabia</td>
                        </tr>*}
                        <tr>
                            <td><strong>Especie</strong></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td><strong>Nombre</strong></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td><strong>Color</strong></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td><strong>Raza</strong></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td><strong>Estado Reproductivo</strong></td>
                            <td><input type="checkbox">&nbsp;Castrado</td>
                            <td><input type="checkbox">&nbsp;Entero</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <br>
                    <div class="titulo">Microchip</div>
                    <hr class="subrayado">
                </td>
            </tr>
            <tr>
                <td>
                    <table border="1" width="100%">
                        <tr>
                            <td width="45%"><strong>N° de Microchip</strong></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>Fecha Microchip</strong></td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
            
        <br>
        
        <table width="100%" border="0" style="page-break-inside:avoid">
            <tr>
                <td>
                    <div class="titulo">Sintomatología</div>
                    <hr class="subrayado">
                </td>
            </tr>
            <tr>
                <td>
                    <table border="1" width="100%">
                        <tr>
                            <td width="45%"><strong>¿Presenta sintomatología asociada a rabia?</strong></td>
                            <td><input type="checkbox">&nbsp;Si</td>
                            <td><input type="checkbox">&nbsp;No</td>
                        </tr>

                        {assign var=cont_sintoma value=1}
                        {foreach $arrTipoSintoma as $sintoma}
                            {if $cont_sintoma==1}<tr>{/if}
                                <td><input type="checkbox">&nbsp;{$sintoma->gl_nombre}</td>
                            {if $cont_sintoma==3}</tr>{assign var=cont_sintoma value=0}{/if}
                            {assign var=cont_sintoma value=$cont_sintoma+1}
                        {/foreach}
                        {if $cont_sintoma == 2}
                            <td>&nbsp;</td><td>&nbsp;</td></tr>
                        {else if $cont_sintoma == 3}
                            <td>&nbsp;</td></tr>
                        {/if}
                        <tr>
                            <td><strong>Fecha de Eutanasia</strong></td>
                            <td colspan="2"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
            
        <br>
        
        <table width="100%" border="0" style="page-break-inside:avoid">
            <tr>
                <td>
                    <div class="titulo">Vacuna Antirrábica</div>
                    <hr class="subrayado">
                </td>
            </tr>
            <tr>
                <td>
                    <table border="1" width="100%">
                        <tr>
                            <td width="45%"><strong>¿Está vigente?</strong></td>
                            <td><input type="checkbox">&nbsp;Si</td>
                            <td><input type="checkbox">&nbsp;No</td>
                        </tr>
                        <tr>
                            <td><strong>N° de Certificado</strong></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td><strong>N° de Serie</strong></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td><strong>Laboratorio</strong></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td><strong>Fecha de Vacunación</strong></td>
                            <td colspan="2"></td>
                        </tr>
                    </table>
                    <table border="1" width="100%">
                        <tr>
                            <td width="45%"><strong>Duración de la inmunidad</strong></td>
                            <td><input type="checkbox">&nbsp;1 Año</td>
                            <td><input type="checkbox">&nbsp;2 Años</td>
                            <td><input type="checkbox">&nbsp;3 Años</td>
                            <td><input type="checkbox">&nbsp;Otra</td>
                        </tr>
                    </table>
                    <table border="1" width="100%">
                        <tr>
                            <td width="45%"><strong>Fecha próxima Vacuna</strong></td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
            
        <br>
        
        <table width="100%" border="0" style="page-break-inside:avoid">
            <tr>
                <td>
                    <div class="titulo">Resultado de Visita</div>
                    <hr class="subrayado">
                </td>
            </tr>
            <tr>
                <td>
                    <table border="1" width="100%">
                        <tr>
                            <td width="45%"><input type="checkbox">&nbsp;Realizada</td>
                            <td><input type="checkbox">&nbsp;Perdida</td>
                        </tr>
                    </table>
                    <table border="0" width="100%">
                        <tr>
                            <td>
                                <br><div class="titulo">Motivo Visita Perdida</div>
                                <hr class="subrayado">
                            </td>
                        </tr>
                    </table>
                    <table border="1" width="100%">
                        <tr>
                            <td width="45%"><input type="checkbox">&nbsp;Sin Moradores en domicilio</td>
                            <td><input type="checkbox">&nbsp;Dirección no existe</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox">&nbsp;Otros</td>
                            <td></td>
                        </tr>
                    </table>
                    <br>
                    <table border="0" width="100%">
                        <tr>
                            <td width="45%"><strong>Observaciones</strong></td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                    <table border="1" width="100%">
                        <tr>
                            <td>
                                <br><br><br><br>
                            </td>
                        </tr>		
                    </table>
                </td>
            </tr>
        </table>
        
    </body>
</html>