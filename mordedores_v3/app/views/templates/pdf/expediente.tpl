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

#calendar {
    font-family:Arial;
    font-size:12px;
}
#calendar caption {
    text-align:left;
    padding:5px 5px;
    background-color:#003366;
    color:#fff;
    font-weight:bold;
}
#calendar th {
    background-color:#006699;
    color:#fff;
    width:100%;
}
#calendar td {
    text-align:left;
    padding:2px 2px;
}
#calendar .hoy {
    background-color:LawnGreen;
}
</style>
</head>

<body style="font-size: 13px;font-family:Arial;">
    <table width="100%" border="0" >
        <tr>
            <td width="30%"><img src="static/images/logo_minsal.png" style="width:100px;margin:5px" ></td>
            <td width="35%" align="left">
                <h2>Documento Inicial</h2>
            </td>
            <td style="vertical-align:middle;padding-left:20px;">
                <table>
                    <tr>
                        <td>FOLIO</td>
                        <td>: {$arr->gl_folio}</td>
                    </tr>
                    <tr>
                        <td>Fecha</td>
                        <td>: {$arr->fc_crea}</td>
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
                        <td><strong>Fecha Atención</strong></td>
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
                <table width="100%" border="0" style="page-break-inside:avoid">
                    <tr>
                        <td>
                            <div class="titulo">Identificación de Mordedor</div>
                            <hr class="subrayado">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table border="0" width="100%">
                                <tr>
                                    <td width="40%"><strong>Grupo Animal Mordedor</strong></td>
                                    <td width="1%"><strong>:</strong></td>
                                    <td>{$gl_animal_grupo}</td>
                                </tr>
                            </table>
                            <br><br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" border="0">
                    <tr>
                        <td>
                            <table width="100%" border="1" style="page-break-inside:avoid">
                                <tbody>
                                    <tr>
                                        <th align="center" colspan="5"><b>MORDEDOR/ES</b></th>
                                    </tr>
                                    <tr>
                                        <th align="center"><b>ESPECIE</b></th>
                                        <th align="center"><b>RAZA</b></th>
                                        <th align="center"><b>COLOR</b></th>
                                        <th align="center"><b>TAMAÑO</b></th>
                                        <th align="center"><b>DIRECCIÓN</b></th>
                                    </tr>
                                    {foreach from=$arr_mordedor key=key item=itm}
                                        {assign var=item value=$itm.json_mordedor}
                                    <tr>
                                        <td align="left">{$item.gl_especie_animal}</td>
                                        <td align="left">{$item.gl_raza_animal}</td>
                                        <td align="left">{$item.gl_color_animal}</td>
                                        <td align="left">{$item.gl_tamano_animal}</td>
                                        <td align="left">
                                            {if $item.gl_direccion}
                                                {$item.gl_direccion}, {$item.gl_comuna}, {$item.gl_region}
                                            {else}
                                                Sin Direccion
                                            {/if}
                                        </td>
                                    </tr>
                                    {/foreach}
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    {if $arr_expediente.id_inicia_vacuna == 1}
        <br>
        <table width="100%" border="0" style="page-break-inside:avoid">
            <tr>
                <td>
                    <div class="titulo">Calendario de Vacunas</div>
                    <hr class="subrayado">
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" width="100%">
                        <tr>
                            <td width="40%"><strong>Inicia Vacunación</strong></td>
                            <td width="1%"><strong>:</strong></td>
                            <td>{$arr_expediente.gl_inicia_vacuna} ({$arr->fc_ingreso})</td>
                        </tr>
                        <tr>
                            <td width="40%"><strong>Folio</strong></td>
                            <td width="1%"><strong>:</strong></td>
                            <td>{$arr->gl_folio}</td>
                        </tr>
                        {foreach from=$arr_mordedor key=key item=itm}
                            <tr>
                                <td width="40%"><strong>Folio Mordedor {$key+1}</strong></td>
                                <td width="1%"><strong>:</strong></td>
                                <td>{$itm.gl_folio_mordedor}</td>
                            </tr>
                        {/foreach}
                    </table>
                    <br><br>
                    <table width="100%" border="0">
                        <tr>
                            <td>
                                {$calendario}
                                <br>
                                <h4>* Continuidad del Tratamiento sujeto a Modificación</h4>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    {/if}
    
</body>
</html>