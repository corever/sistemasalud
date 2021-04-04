<div class="panel panel-primary">
    <div class="panel-heading">
        Identificación de Mordedor
    </div>
    <div class="panel-body">
        
        <legend>Datos Mordedor</legend>
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label>Estado</label>
                        {if $arr->id_animal_estado == 1}
                            <span class="form-control label label-success">{$arr->animal_estado}</span>
                        {else}
                            <span class="form-control label label-warning">{$arr->animal_estado}</span>
                        {/if}
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label for="mordedorhabitual" class="control-label">Mordedor Habitual</label>
                        {if $arr->bo_mordedor_habitual == 1}
                            <span class="form-control label label-danger">SI</span>
                        {else}
                            <span class="form-control label label-success">NO</span>
                        {/if}
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label for="bo_rabia" class="control-label">Con Rabia</label>
                        {if $arr->bo_rabia == 1}
                            <span class="form-control label label-danger">SI</span>
                        {else}
                            <span class="form-control label label-success">NO</span>
                        {/if}
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for="nr_cantidad_casos" class="control-label">Cantidad Notificaciones</label>
                        {if $arr->nr_cantidad_casos == 1}
                            <span class="form-control label label-success">{$arr->nr_cantidad_casos}</span>
                        {else if $arr->nr_cantidad_casos > 1 && $arr->nr_cantidad_casos < 4 }
                            <span class="form-control label label-warning">{$arr->nr_cantidad_casos}</span>
                        {else}
                            <span class="form-control label label-danger">{$arr->nr_cantidad_casos}</span>
                        {/if}
                    </div>
                    {if $arr->bo_eutanasiado == 1}
                        <div class='col-md-6 col-sm-12'>
                            <label for="fechaeutanasia" class="control-label">Fecha Eutanasia</label>
                            <input type='text' class="form-control" id='fechaeutanasia' name='fechaeutanasia' value="{($arr->fc_eutanasia != '00-00-0000') ? $arr->fc_eutanasia : '-'}" readonly>
                        </div>
                    {else}
                        <div class="col-md-6 col-sm-12">
                            <label for="fechamuerte" class="control-label">Fecha Muerte</label>
                            <input type='text' class="form-control" id='fechamuerte' name='fechamuerte' value="{($arr->fc_muerte != '') ? $arr->fc_muerte : '-'}" readonly>
                        </div>
                    {/if}
                </div>
                <div class="row">
                    <div class='col-sm-12'>
                        <label for="gl_direccion" class="control-label">Dirección</label>
                        <input type='text' class="form-control"
                               value="{$arr->direccion_mordedor.gl_direccion}, {$arr->gl_nombre_comuna}, {$arr->gl_nombre_region}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class='col-sm-12'>
                        <label for="gl_datos_referencia" class="control-label">Datos Referencia</label>
                        <input type='text' class="form-control"
                               value="{if $arr->arrDirMordedura.gl_datos_referencia}{$arr->arrDirMordedura.gl_datos_referencia}{else}-{/if}" readonly>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for="dueno" class="control-label">{if $arr->pasaporte_dueno != ""}Pasaporte{else}RUT{/if} Dueño</label>
                        <input type="text" name="dueno" id="dueno" class="form-control" readonly
                               value="{(!empty($arr->pasaporte_dueno))?$arr->pasaporte_dueno:$arr->rut_dueno}">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="dueno" class="control-label">Nombre Dueño</label>
                        <input type="text" name="dueno" id="dueno" class="form-control" readonly
                               value="{(!empty($arr->dueno))?$arr->dueno:'-'}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for="vivecondueno" class="control-label">Vive con Dueño</label>
                        <input type='text' class="form-control" id='vivecondueno' name='vivecondueno' value="{($arr->bo_vive_con_dueno == 1) ? 'SI' : 'NO'}" readonly>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="grupo_mordedor" class="control-label">Grupo Animal Mordedor</label>
                        <input type="text" name="grupo_mordedor" id="grupo_mordedor" class="form-control" readonly
                               value="{$arr->animal_grupo}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for="animal_sexo" class="control-label">Sexo Animal Mordedor</label>
                        <input type="text" name="animal_sexo" id="animal_sexo" class="form-control" readonly
                               value="{$arr->animal_sexo}">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="animal_estado_productivo" class="control-label">Estado Reproductivo</label>
                        <input type="text" name="animal_estado_productivo" id="animal_estado_productivo" class="form-control" readonly
                               value="{$arr->animal_estado_productivo}">
                    </div>
                </div>
                <div class="row">
                    <div class='col-md-6 col-sm-12'>
                        <label for="animal_tamano" class="control-label">Tamaño Animal Mordedor</label>
                        <input type='text' class="form-control" id='animal_tamano' name='animal_tamano' value="{$arr->animal_tamano}" readonly>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="animal_raza" class="control-label">Raza</label>
                        <input type="text" name="animal_raza" id="animal_raza" class="form-control" readonly
                               value="{if $arr->gl_otra_raza}{$arr->gl_otra_raza}{else}{$arr->animal_raza}{/if}">
                    </div>
                    
                </div>                
            </div>
        </div>

        <div class="top-spaced"></div>
        <legend>Datos Microchip</legend>
        <div class="row">
            {assign var=adj_token_microchip value=''}
            {assign var=adj_token_vacuna value=''}
            
            {if $arr->arrAdjuntos}
                {foreach $arr->arrAdjuntos as $adj}
                    {if $adj->id_adjunto_tipo == 5}
                        {assign var=adj_token_microchip value=$adj->gl_token}
                    {elseif $adj->id_adjunto_tipo == 6}
                        {assign var=adj_token_vacuna value=$adj->gl_token}
                    {/if}
                {/foreach}
            {/if}
            <div class="col-sm-6">
                <div class="row">
                    <div class='col-sm-6'>
                        <label for="gl_microchip" class="control-label">Microchip</label>
                        <input type="text" value="{$arr->gl_microchip}" id="gl_microchip" name="gl_microchip" class="form-control" readonly>
                    </div>
                    <div class="col-sm-6">
                        <label>Documento Microchip</label><br>
                        {if $adj_token_microchip != ''}
                        <button class="btn btn-xs btn-primary" id="btnDescarga"
                        onclick="window.open('{$smarty.const.BASE_URI}/Adjunto/verByToken/?token={$adj_token_microchip}')">
                         <i class="fa fa-file"></i></button>
                        {else}-
                        {/if}
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <label>Fecha Microchip</label>
                        <input type="text" class="form-control" value="{$arr->fc_microchip}" readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="top-spaced"></div>
        {if $arr->id_animal_vacuna > 0}
        <legend>Datos Vacuna</legend>
        <div class="row">
            <div class="col-sm-6">
                <div class='col-sm-6'>
                    <label for="vacunavigente" class="control-label">Vacuna Antirrabica Vigente</label>
                    {if $arr->bo_antirrabica_vigente == 1}
                        <span class="form-control label label-success">SI</span>
                    {else}
                        <span class="form-control label label-danger">NO</span>
                    {/if}
                </div>
                <div class="col-sm-6">
                    <label for="necesitavacuna" class="control-label">Necesita Vacuna</label>
                    {if bo_necesita_vacuna == 1}
                        <span class="form-control label label-warning">SI</span>
                    {else}
                        <span class="form-control label label-success">NO</span>
                    {/if}
                </div>
                <div class='col-sm-6'>
                    <label for="fechavacuna" class="control-label">Fecha Vacuna</label>
                    <input type='text' class="form-control" id='fechavacuna' name='fechavacuna' value="{($arr->fc_vacuna != '00-00-0000') ? $arr->fc_vacuna : '-'}" readonly>
                </div>
                <div class="col-sm-6">
                    <label for="fechavacunaexpira" class="control-label">Fecha Vacuna Expira</label>
                    <input type='text' class="form-control" id='fechavacunaexpira' name='fechavacunaexpira' value="{($arr->fc_vacuna_expira != '00-00-0000') ? $arr->fc_vacuna_expira : '-'}" readonly>
                </div>
            </div>
            <div class="col-sm-6">                
                <div class="row">
                    <div class="col-sm-6">
                        <label for="duracion_inmunidad" class="control-label">Duración Inmunidad Vacuna</label>
                        <input type='text' class="form-control" id='duracion_inmunidad' name='duracion_inmunidad' value="{$arr->duracion_inmunidad}" readonly>
                    </div>
                    <!--<div class='col-sm-6'>
                        <label for="callejero" class="control-label">Mordedor Callejero</label>
                        <input type='text' class="form-control" id='callejero' name='callejero' value="{($arr->bo_callejero == 1) ? 'SI' : 'NO'}" readonly>
                    </div>-->
                </div>
            </div>
        </div>
        {/if}
        <!--div class="col-sm-6">
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
        </div-->
        <div class="top-spaced"></div>
        <!-- 
        json_vacuna
        json_otros_datos
        -->
        <legend>Datos Visita</legend>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12 table-responsive" id="cabecera_grilla_mordedor">
                    {include file='bitacora_mordedor/cabecera_grilla_mordedor.tpl'}
                </div>
            </div>
        </div>
        <div class="top-spaced"></div>
    </div>
</div>

<div class="top-spaced"></div>