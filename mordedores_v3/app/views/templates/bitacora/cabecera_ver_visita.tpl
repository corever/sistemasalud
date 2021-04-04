<div class="panel panel-default">
    <div class="panel-heading">
        Identificación de Mordedura
    </div>
    <div class="panel-body">
        <div class="row">
            <input type="text" name="gl_token_expediente" id="gl_token_expediente" value="{$arr->gl_token}" class="form-control hidden">
        <div class="col-sm-6">
            <div class="col-sm-12">
                <label for="gl_establecimiento" class="control-label">Establecimiento de Salud</label>
                <input type="text" value="{$arr->gl_establecimiento}" id="gl_establecimiento" name="gl_establecimiento" class="form-control" readonly>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="col-sm-6">
                <label for="horaingreso" class="control-label">Fecha Atención</label>
                <input type="text" name="horaingreso" id="horaingreso" value="{$arr->fc_ingreso} {$arr->gl_hora_ingreso}" class="form-control" readonly>
            </div>
            <div class='col-sm-6'>
                <label for="gl_nombre_supervisor" class="control-label">Supervisor</label>
                <input type='text' class="form-control" id='gl_nombre_supervisor' name='gl_nombre_supervisor' value="{$arr->gl_nombre_supervisor}" readonly>
            </div>
        </div>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-6">
                    <label for="fc_mordedura" class="control-label">Fecha Mordedura</label>
                    <input type="text" value="{$arr->fc_mordedura}" id="fc_mordedura" name="fc_mordedura" class="form-control" readonly>
                </div>
                <div class="col-sm-6">
                    <label for="fc_mordedura" class="control-label">Estado</label>
                    <div style="margin-top: 5px;">
                        <span class="{$arr->gl_class_estado}">{$arr->gl_nombre_estado}</span>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class='col-sm-12'>
                <label for="gl_direccion" class="control-label">Dirección de Mordedura</label>
                <input type='text' class="form-control"
                       value="{$arr->arrDirMordedura.gl_direccion}, {$arr->comuna_mordedura}, {$arr->region_mordedura}" readonly>
            </div>
            </div>
            <div class="row">
            <div class='col-sm-12'>
                <label for="gl_datos_referencia" class="control-label">Datos Referencia</label>
                <input type='text' class="form-control"
                       value="{if $arr->arrDirMordedura.gl_datos_referencia}{$arr->arrDirMordedura.gl_datos_referencia}{else}-{/if}" readonly>
            </div>
            </div>
            <div class="row">
            <div class="col-sm-6">
                <label for="gl_lugar_mordedura" class="control-label">Lugar Mordedura</label>
                <input type="text" name="gl_lugar_mordedura" id="gl_lugar_mordedura" class="form-control" readonly
                       value="{$arr->arrExpediente.gl_lugar_mordedura}">
            </div>
            {if $arr->arrExpediente.id_lugar_mordedura == 3}
            <div class="col-sm-6">
                <label for="gl_otro_lugar_mordedura" class="control-label">Otro (lugar)</label>
                <input type="text" name="gl_otro_lugar_mordedura" id="gl_otro_lugar_mordedura" class="form-control" readonly
                       value="{if $arr->arrExpediente.gl_otro_lugar_mordedura}{$arr->arrExpediente.gl_otro_lugar_mordedura}{else}-{/if}">
            </div>
            {/if}
            </div>
            <div class="row">
            <div class="col-sm-6">
                <label for="id_inicia_vacuna" class="control-label">Inicia Vacunación</label>
                <input type="text" name="id_inicia_vacuna" id="id_inicia_vacuna" class="form-control" readonly
                       value="{$arr->arrExpediente.gl_inicia_vacuna}">
            </div>
            <div class="col-sm-6">
                <label for="tipo_mordedura" class="control-label">Tipo de Mordedura</label>
                <input type="text" name="tipo_mordedura" id="tipo_mordedura" class="form-control" readonly
                       value="{if $arr->arrExpediente.gl_tipo_mordedura}{$arr->arrExpediente.gl_tipo_mordedura}{/if}">
            </div>
            </div>
            <div class="row">
            <div class="col-sm-12">
                <label for="grupo_mordedor" class="control-label">Grupo Animal Mordedor</label>
                <input type="text" name="grupo_mordedor" id="grupo_mordedor" class="form-control" readonly
                       value="{if $arr->gl_animal_grupo}{$arr->gl_animal_grupo}{else}-{/if}">
            </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="top-spaced"></div>
            <div class="col-sm-12">
                <div id="mapExp" data-editable="0" style="width:100%;height:200px;"></div>
                <div class="form-group">
                    <label for="gl_latitud_exp" class="control-label col-sm-1">Latitud</label>
                    <div class="col-sm-3">
                        <input type="text" name="gl_latitud_exp" id="gl_latitud_exp" readonly value="{$arr->arrDirMordedura.gl_latitud}" placeholder="Latitud" class="form-control"/>
                    </div>
                    <label for="gl_longitud_contacto" class="control-label col-sm-1">Longitud</label>
                    <div class="col-sm-3">
                        <input type="text" name="gl_longitud_exp"  id="gl_longitud_exp" readonly value="{$arr->arrDirMordedura.gl_longitud}" placeholder="Longitud" class="form-control"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        Datos de Visitas
    </div>
    <div class="panel-body">
        <div class="col-sm-12" id="cabecera_grilla_mordedor">
            {include file='bitacora/grillaVisitas.tpl'}
        </div>
	</div>
</div>

<div class="top-spaced"></div>