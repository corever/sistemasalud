<div class="form-group">
    <div class="clearfix col-md-6">
        <div class="col-md-4">
            <label class="control-label">RUT/Pasaporte : </label>
        </div>
        <div class="col-md-8">
            <input type="text" value="{if $arr->rut_paciente}{$arr->rut_paciente}{else if $arr->arrPasaporte.gl_pasaporte}{$arr->arrPasaporte.gl_pasaporte}{else}-{/if}" class="form-control" readonly>
        </div>
    </div>

    <div class="clearfix col-md-6">
        <div class="col-md-4">
            <label class="control-label">Nombre Completo : </label>
        </div>
        <div class="col-md-8">
            <input type="text" value="{$arr->nombre_paciente} {$arr->apellidos_paciente}" class="form-control" readonly>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="clearfix col-md-6">
        <div class="col-md-4">
            <label class="control-label">Fecha Nacimiento : </label>
        </div>
        <div class="col-md-8">
            <input type="text" value="{$arr->fc_nacimiento_paciente}" class="form-control" readonly>
        </div>
    </div>

    <div class="clearfix col-md-6">
        <div class="col-md-4">
            <label class="control-label">Edad : </label>
        </div>
        <div class="col-md-8">
            <input type="text" value="{$arr->nr_edad_paciente}" class="form-control" readonly>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="clearfix col-md-6">
        <div class="col-md-4">
            <label class="control-label">Sexo : </label>
        </div>
        <div class="col-md-8">
            <input type="text" value="{$arr->gl_tipo_sexo}" class="form-control" readonly>
        </div>
    </div>

    <div class="clearfix col-md-6">
        <div class="col-md-4">
            <label class="control-label">Previsi&oacute;n : </label>
        </div>
        <div class="col-md-8">
            <input type="text" value="{$arr->nombre_prevision_paciente}" class="form-control" readonly>
        </div>
    </div>
</div>
		
<div class="form-group">
    <div class="clearfix col-md-6">
        <div class="col-md-4">
            <label class="control-label">País de Origen : </label>
        </div>
        <div class="col-md-8">
            <input type="text" value="{$arr->gl_pais_paciente}" class="form-control" readonly>
        </div>
    </div>

    <div class="clearfix col-md-6">
        <div class="col-md-4">
            <label class="control-label">Nacionalidad : </label>
        </div>
        <div class="col-md-8">
            <input type="text" value="{$arr->gl_nacionalidad_paciente}" class="form-control" readonly>
        </div>
    </div>
</div>
        
    <div class="col-md-12">
        <div class="top-spaced"></div>
    </div>

<div class="form-group">
    <div class="clearfix col-md-12">
        <table class="table table-hover table-striped table-bordered dataTable no-footer" width="100%" border="1">
            <thead>
                <tr>
                    <th align="center" width="20%"><b>TIPO DE CONTACTO</b></th>
                    <th align="center" width="80%"><b>DATOS</b></th>
                </tr>
            </thead>
            <tbody>
                {if $arr->arrContactoPac}
                    {foreach from=$arr->arrContactoPac key=key item=itm}
                        <tr>
                            <td align="center">{$itm.json_datos.gl_tipo_contacto}</td>
                            <td align="center">
                                {if $itm.id_tipo_contacto == 1}
                                    {$itm.json_datos.telefono_fijo}
                                {else if $itm.id_tipo_contacto == 2}
                                    {$itm.json_datos.telefono_movil}
                                {else if $itm.id_tipo_contacto == 3}
                                    {if $itm.json_datos.chkNoInforma}
                                        No Tiene
                                    {else}
                                        {$itm.json_datos.gl_direccion}, {$itm.json_datos.gl_comuna}, {$itm.json_datos.gl_region}
                                    {/if}
                                {else if $itm.id_tipo_contacto == 4}
                                    {$itm.json_datos.gl_email}
                                {else if $itm.id_tipo_contacto == 5}
                                    {$itm.json_datos.gl_casilla_postal}
                                {/if}
                            </td>
                        </tr>
                    {/foreach}
                {else}
                    <tr><td colspan="2" align="center">Sin Contactos</td></tr>
                {/if}
            </tbody>
        </table>
    </div>
        
    <div class="col-md-12">
        <div class="top-spaced"></div>
    </div>
</div>